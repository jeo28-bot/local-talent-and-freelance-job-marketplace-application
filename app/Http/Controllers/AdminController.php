<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Upload;
use App\Models\JobPost;
use App\Models\JobApplication;
use Illuminate\Support\Facades\Response;
use App\Models\Message;
use App\Models\Report;
use App\Models\HistoryLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        // Count employees/freelancers
        $employeeCount = User::whereIn('user_type', ['employee', 'freelancer'])->count();

        // Count clients/companies
        $clientCount = User::where('user_type', 'client')->count();

        // Total jobs
        $totalJobs = JobPost::count();

        // Jobs grouped by month (current year)
        $jobsByMonth = JobPost::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month'); // key: month number, value: count

        // Ensure all months exist (fill 0 if no jobs)
        $monthlyJobs = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyJobs[$i] = $jobsByMonth[$i] ?? 0;
        }

        return view('admin.index', compact('employeeCount', 'clientCount', 'totalJobs', 'monthlyJobs'));
    }

    public function applications(Request $request)
    {
        $query = JobApplication::withTrashed() // 👈 include archived
        ->with(['user', 'job'])
        ->orderBy('created_at', 'desc');

        $search = $request->input('search'); // define $search upfront, even if null

        if ($search) {
            $query->where(function ($q) use ($search) {

                // Search within JobApplication table
                $q->where('id', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone_num', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");

                // Try to parse search as a date
                try {
                    $date = \Carbon\Carbon::parse($search)->toDateString(); // converts to YYYY-MM-DD
                    $q->orWhereDate('created_at', $date);
                } catch (\Exception $e) {
                    // Not a valid date, ignore
                }
            })
            // Search related user
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            // Search related job
            ->orWhereHas('job', function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%");
            });
        }

        $applications = $query->paginate(10)->appends(['search' => $search]); // keep search term for pagination

        return view('admin.applications', compact('applications'));
    }


     public function jobs() {

        return view('admin.jobs');
    }
    public function announcements(Request $request)
    {
        $search = $request->query('search', '');

        // Call Express API
        $url = 'http://127.0.0.1:3001/api/announcements';
        $response = Http::get($url, ['search' => $search]);

        $announcements = $response->ok() ? $response->json() : [];

        return view('admin.announcements', compact('announcements', 'search'));
    }
   public function transactions(Request $request)
    {
        $query = \App\Models\Transaction::with(['employee', 'client']);

        $search = $request->input('search'); // define upfront

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Search numeric or string fields
                $q->where('id', 'like', str_replace('2025', '', $search)) // keep your existing "2025xxx" logic
                ->orWhere('job_title', 'like', "%{$search}%")
                ->orWhere('amount', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%")
                ->orWhere('payment_method', 'like', "%{$search}%")
                ->orWhere('reference_no', 'like', "%{$search}%")
                ->orWhere('transaction_ref_no', 'like', "%{$search}%")
                ->orWhereHas('employee', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('client', function ($sub) use ($search) {
                    $sub->where('name', 'like', "%{$search}%");
                });

                // Try parsing search as a date for payment_date
                try {
                    $date = \Carbon\Carbon::parse($search)->toDateString(); // YYYY-MM-DD
                    $q->orWhereDate('payment_date', $date);
                } catch (\Exception $e) {
                    // Not a valid date, ignore
                }
            });
        }

        $transactions = $query->latest()->paginate(10)->appends(['search' => $search]);

        return view('admin.transactions', compact('transactions'));
    }


    public function updateTransactionStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,requested,completed',
        ]);

        $transaction = Transaction::findOrFail($id);
        $transaction->status = $request->status;
        $transaction->save();

        return redirect()->back()->with('success', 'Transaction status updated successfully!');
    }
    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->back()->with('success', 'Transaction deleted successfully!');
    }
   public function history_log(Request $request)
    {
        $search = $request->input('search');

        $historyLogs = \App\Models\HistoryLog::with('user')
            ->when($search, function($query, $search) {
                $query->where('user_id', 'like', "%{$search}%")
                    ->orWhere('user_type', 'like', "%{$search}%")
                    ->orWhere('details', 'like', "%{$search}%")
                    ->orWhereHas('user', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    // Search by date and time formatted like your Blade display
                    ->orWhereRaw("DATE_FORMAT(created_at, '%b %d, %Y - %h:%i %p') LIKE ?", ["%{$search}%"]);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.history_log', compact('historyLogs'));
    }



    public function destroy_log($id)
    {
        $log = \App\Models\HistoryLog::findOrFail($id);
        $log->delete();

        return redirect()->back()->with('success', 'History log deleted successfully.');
    }




    public function showJob($title)
    {
        // decode + to spaces
        $decodedTitle = str_replace('+', ' ', $title);

        // find the job by title
        $job = JobPost::where('job_title', $decodedTitle)->first();

        if (!$job) {
            abort(404, 'Job not found.');
        }

        // pass it to the view
        return view('admin.jobs', compact('job'));
    }
    public function job_post(Request $request)
    {
        $search = $request->input('search');

        $query = \App\Models\JobPost::withTrashed() // 👈 include archived
            ->with('client')
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%{$search}%")
                ->orWhere('job_title', 'LIKE', "%{$search}%")
                ->orWhere('job_location', 'LIKE', "%{$search}%")
                ->orWhere('job_pay', 'LIKE', "%{$search}%")
                ->orWhere('salary_release', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('name', 'LIKE', "%{$search}%");
                });

                // date search
                try {
                    $date = \Carbon\Carbon::parse($search)->toDateString();
                    $q->orWhereDate('created_at', $date);
                } catch (\Exception $e) {
                    // ignore invalid date
                }
            });
        }

        $jobPosts = $query
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.job_post', compact('jobPosts'));
    }


    public function updateJobStatus(Request $request, $id)
    {
        $job = \App\Models\JobPost::findOrFail($id);
        $job->status = $request->input('status');
        $job->save();

        return redirect()->back()->with('success', 'Job status updated successfully!');
    }


    
    public function users(Request $request)
    {
        $query = User::query();

    if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phoneNum', 'LIKE', "%{$search}%")
                ->orWhere('user_type', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");

                // Try to parse search as date
                try {
                    $date = \Carbon\Carbon::parse($search)->toDateString(); // YYYY-MM-DD
                    $q->orWhereDate('created_at', $date);
                } catch (\Exception $e) {
                    // Not a date, skip
                }
            });
        }


        $users = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        return view('admin.users', compact('users'));
    }

     public function profile() {

        return view('admin.profile');
    }
    public function public_profile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();

        return view('admin.public_profile', compact('user'));
    }
    public function edit_profile($name)
    {
        $decodedName = urldecode($name);
        $user = \App\Models\User::where('name', $decodedName)->firstOrFail();

        return view('admin.edit_profile', compact('user'));
    }

    // edit profile functions
    public function update_profile(Request $request, $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        // Handle suspend toggle
        if ($request->has('toggle_suspend')) {
            $user->suspended = ! $user->suspended; // toggle true/false
            $user->save();

            return back()->with(
                'success',
                $user->suspended ? 'User has been suspended.' : 'User has been unsuspended.'
            );
        }

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phoneNum' => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
        ]);

        $user->update([
            'name'     => $request->username,
            'email'    => $request->email,
            'phoneNum' => $request->phoneNum,
            'address'  => $request->address,
        ]);

        return back()->with('success', 'User details updated successfully!');
    }


    public function update_profile_picture(Request $request, $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        $request->validate([
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        if ($request->hasFile('profile_pic')) {
            // store the uploaded image
            $path = $request->file('profile_pic')->store('profile_pics', 'public');

            // delete old one if it exists
            if ($user->profile_pic && \Storage::disk('public')->exists($user->profile_pic)) {
                \Storage::disk('public')->delete($user->profile_pic);
            }

            // update path in DB
            $user->profile_pic = $path;
            $user->save();
        }

        return back()->with('success', 'Profile picture updated successfully!');
    }
    public function update_about(Request $request, $name)
    {
        $user = User::where('name', $name)->firstOrFail();

        $request->validate([
            'about_details' => 'nullable|string|max:1000',
        ]);

        $user->about_details = $request->input('about_details');
        $user->save();

        return back()->with('success', 'About details updated successfully!');
    }
    public function update_skills(Request $request, $name)
    {
        $request->validate([
            'skills' => 'nullable|string|max:5000',
        ]);

        $user = User::where('name', $name)->firstOrFail();
        $user->skills = $request->skills;
        $user->save();

        return back()->with('success', 'Skills updated successfully!');
    }
    public function upload_files(Request $request, $name)
    {
        $request->validate([
            'files.*'  => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $user = User::where('name', $name)->firstOrFail();

        // General files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads/files', 'public');
                $user->uploads()->create([
                    'type'           => 'file',
                    'path'           => $path,
                    'original_name'  => $file->getClientOriginalName(),
                ]);
            }
        }

        // Image files
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/images', 'public');
                $user->uploads()->create([
                    'type'           => 'image',
                    'path'           => $path,
                    'original_name'  => $image->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Files uploaded successfully!');
    }
    public function destroy_upload($name, $id)
    {
        $user = User::where('name', $name)->firstOrFail();
        $upload = Upload::where('id', $id)
                        ->where('user_id', $user->id)
                        ->firstOrFail();

        // Delete file from storage (make sure the path includes 'public/')
        \Storage::disk('public')->delete($upload->path);

        // Delete record
        $upload->delete();

        return back()->with('success', 'File deleted successfully.');
    }
    public function delete_user($name)
    {
        $user = User::where('name', urldecode($name))->firstOrFail();
        $user->delete();

        // redirect to admin users listing
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }
    public function destroyJobPost($id)
    {
        $job = JobPost::withTrashed()->findOrFail($id);
        $job->forceDelete();

        return redirect()->route('admin.job_post')->with('success', 'Job post deleted successfully!');
    }
    public function reports(Request $request)
    {
        $search = $request->input('search');

        $query = Report::with(['reportable', 'reporter'])
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                // Text & numeric search
                $q->where('message', 'LIKE', "%{$search}%")
                ->orWhere('id', 'LIKE', "%{$search}%")
                ->orWhere('reportable_id', 'LIKE', "%{$search}%")
                ->orWhere('reportable_type', 'LIKE', "%{$search}%")
                ->orWhereHas('reporter', function ($r) use ($search) {
                    $r->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHasMorph(
                    'reportable',
                    [User::class, JobPost::class],
                    function ($related, $type) use ($search) {
                        if ($type === User::class) {
                            $related->where('name', 'LIKE', "%{$search}%");
                        } elseif ($type === JobPost::class) {
                            $related->where('job_title', 'LIKE', "%{$search}%");
                        }
                    }
                );

                // Date search
                try {
                    $date = \Carbon\Carbon::parse($search)->toDateString(); // YYYY-MM-DD
                    $q->orWhereDate('created_at', $date);
                } catch (\Exception $e) {
                    // Ignore if not a valid date
                }
            });
        }

        $reports = $query->paginate(10)->appends(['search' => $search]);

        return view('admin.reports', compact('reports'));
    }



    public function destroyReport($id)
    {
        $report = Report::findOrFail($id);
        $report->delete();

        return response()->json(['success' => true]);
    }


    
    public function messages(Request $request)
    {
        $search = $request->input('search');

        $messages = \App\Models\Message::with(['sender', 'receiver'])
            ->when($search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhereHas('sender', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('receiver', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('content', 'like', "%{$search}%")
                    // ✅ Match the same display format as shown in table
                    ->orWhereRaw(
                        "DATE_FORMAT(created_at, '%b %d, %Y - %h:%i%p') LIKE ?",
                        ["%{$search}%"]
                    );
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('admin.messages', compact('messages', 'search'));
    }
    public function users_chat() {

        return view('admin.users_chat');
    }
    public function deleteChat($id)
    {
        $message = \App\Models\Message::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Chat deleted successfully!');
    }
    public function deleteConversation($name)
    {
        $receiver = \App\Models\User::where('name', $name)->firstOrFail();

        // Delete all messages that belong to this user (either sent or received)
        \App\Models\Message::where('sender_id', $receiver->id)
            ->orWhere('receiver_id', $receiver->id)
            ->delete();

        return redirect()->route('admin.users_chat', ['name' => $receiver->name])
                        ->with('success', 'Chat deleted successfully!');
    }
   public function chat($name)
    {
        $admin = auth()->user();
        $receiver = \App\Models\User::where('name', $name)->firstOrFail();

        // ✅ Mark all messages from this receiver to admin as seen
        \App\Models\Message::where('sender_id', $receiver->id)
            ->where('receiver_id', $admin->id)
            ->where('seen', false)
            ->update(['seen' => true]);

        // ✅ Fetch all messages between admin and receiver
        $messages = \App\Models\Message::where(function ($q) use ($admin, $receiver) {
                $q->where('sender_id', $admin->id)
                ->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($q) use ($admin, $receiver) {
                $q->where('sender_id', $receiver->id)
                ->where('receiver_id', $admin->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        // ✅ Fetch users admin has chatted with, ordered by latest message
        $chatUsers = \App\Models\User::where('id', '!=', $admin->id)
            ->where(function ($q) use ($admin) {
                $q->whereHas('messagesSent', function ($query) use ($admin) {
                        $query->where('receiver_id', $admin->id);
                    })
                ->orWhereHas('messagesReceived', function ($query) use ($admin) {
                        $query->where('sender_id', $admin->id);
                    });
            })
            ->get()
            ->sortByDesc(function ($user) use ($admin) {
                return \App\Models\Message::where(function ($query) use ($admin, $user) {
                        $query->where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->orWhere(function ($query) use ($admin, $user) {
                        $query->where('sender_id', $user->id)
                            ->where('receiver_id', $admin->id);
                    })
                    ->latest('created_at')
                    ->value('created_at');
            });

        return view('admin.chat', compact('receiver', 'messages', 'chatUsers', 'admin'));
    }




    public function adminChat($name)
    {
        $admin = auth()->user(); // assuming logged-in admin
        $receiver = User::where('name', $name)->firstOrFail();

        $messages = Message::where(function ($query) use ($admin, $receiver) {
            $query->where('sender_id', $admin->id)->where('receiver_id', $receiver->id);
        })->orWhere(function ($query) use ($admin, $receiver) {
            $query->where('sender_id', $receiver->id)->where('receiver_id', $admin->id);
        })->orderBy('created_at')->get();

        return view('admin.chat', compact('receiver', 'messages'));
    }
    public function sendMessage(Request $request, $name)
    {
        $receiver = User::where('name', $name)->firstOrFail();

        $data = [
            'sender_id' => auth()->id(),
            'receiver_id' => $receiver->id,
            'content' => $request->content,
        ];

        // 🔥 If user uploaded a file
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Store file to storage/app/public/chat_files/
            $path = $file->store('chat_files', 'public');

            // Determine file type
            $mime = $file->getMimeType();

            if (str_starts_with($mime, 'image/')) {
                $data['file_type'] = 'image';
            } else {
                $data['file_type'] = 'file'; // pdf, docx, zip, etc.
            }

            $data['file'] = $path;
        }

        Message::create($data);

        return redirect()->back();
    }

    public function usersChat($name)
    {
        // Find the user whose convo we want to view
        $user = User::where('name', $name)->firstOrFail();

        // Get all messages where this user is either the sender or receiver
        $messages = Message::where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->orderBy('created_at', 'asc')
            ->get();

        // Return the view
        return view('admin.users_chat', compact('user', 'messages'));
    }
    
    // Return messages between admin and specific user as JSON
    public function chatMessages($name)
    {
        $admin = auth()->user();
        $receiver = \App\Models\User::where('name', $name)->firstOrFail();

        $messages = \App\Models\Message::where(function ($q) use ($admin, $receiver) {
                $q->where('sender_id', $admin->id)
                ->where('receiver_id', $receiver->id);
            })
            ->orWhere(function ($q) use ($admin, $receiver) {
                $q->where('sender_id', $receiver->id)
                ->where('receiver_id', $admin->id);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // Return chat list (menu) HTML snippet only
    public function chatList()
    {
        $admin = auth()->user();

        $chatUsers = \App\Models\User::where('id', '!=', $admin->id)
            ->where(function ($q) use ($admin) {
                $q->whereHas('messagesSent', function ($query) use ($admin) {
                        $query->where('receiver_id', $admin->id);
                    })
                ->orWhereHas('messagesReceived', function ($query) use ($admin) {
                        $query->where('sender_id', $admin->id);
                    });
            })
            ->get()
            ->sortByDesc(function ($user) use ($admin) {
                return \App\Models\Message::where(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $admin->id)
                        ->where('receiver_id', $user->id);
                    })
                    ->orWhere(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $user->id)
                        ->where('receiver_id', $admin->id);
                    })
                    ->latest('created_at')
                    ->value('created_at');
            });

        return view('admin.chat_menu_partial', compact('chatUsers', 'admin'))->render();
    }
    public function deleteUserChat($name)
    {
        $admin = auth()->user();
        $receiver = \App\Models\User::where('name', $name)->firstOrFail();

        \App\Models\Message::where(function ($q) use ($admin, $receiver) {
            $q->where('sender_id', $admin->id)
            ->where('receiver_id', $receiver->id);
        })->orWhere(function ($q) use ($admin, $receiver) {
            $q->where('sender_id', $receiver->id)
            ->where('receiver_id', $admin->id);
        })->delete();

        return redirect()->back();
    }
    public function inbox()
    {
        $admin = auth()->user();

        // Get all users that have chatted with admin
        $chatUsers = \App\Models\User::where('id', '!=', $admin->id)
            ->where(function ($q) use ($admin) {
                $q->whereHas('messagesSent', function ($query) use ($admin) {
                        $query->where('receiver_id', $admin->id);
                    })
                ->orWhereHas('messagesReceived', function ($query) use ($admin) {
                        $query->where('sender_id', $admin->id);
                    });
            })
            ->get()
            ->sortByDesc(function ($user) use ($admin) {
                return \App\Models\Message::where(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->orWhere(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $user->id)
                            ->where('receiver_id', $admin->id);
                    })
                    ->latest('created_at')
                    ->value('created_at');
            });

        // Convert to paginator manually
        $perPage = 7; // adjust this
        $page = request()->get('page', 1);
        $paginatedUsers = new \Illuminate\Pagination\LengthAwarePaginator(
            $chatUsers->forPage($page, $perPage),
            $chatUsers->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('admin.inbox', [
            'chatUsers' => $paginatedUsers,
            'admin' => $admin
        ]);
    }

    public function unreadCount()
    {
        $admin = auth()->user();

        $unreadCount = \App\Models\Message::where('receiver_id', $admin->id)
            ->where('seen', false)
            ->count();

        return response()->json(['unreadCount' => $unreadCount]);
    }
    public function fetchAdminMessages()
    {
        $admin = auth()->user();

        $chatUsers = \App\Models\User::where('id', '!=', $admin->id)
            ->where(function ($q) use ($admin) {
                $q->whereHas('messagesSent', function ($query) use ($admin) {
                        $query->where('receiver_id', $admin->id);
                    })
                ->orWhereHas('messagesReceived', function ($query) use ($admin) {
                        $query->where('sender_id', $admin->id);
                    });
            })
            ->get()
            ->sortByDesc(function ($user) use ($admin) {
                return \App\Models\Message::where(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->orWhere(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $user->id)
                            ->where('receiver_id', $admin->id);
                    })
                    ->latest('created_at')
                    ->value('created_at');
            })
            ->map(function ($user) use ($admin) {
                $latestMessage = \App\Models\Message::where(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $admin->id)
                            ->where('receiver_id', $user->id);
                    })
                    ->orWhere(function ($q) use ($admin, $user) {
                        $q->where('sender_id', $user->id)
                            ->where('receiver_id', $admin->id);
                    })
                    ->latest('created_at')
                    ->first();

                $hasUnseen = \App\Models\Message::where('sender_id', $user->id)
                    ->where('receiver_id', $admin->id)
                    ->where('seen', false)
                    ->exists();

                return [
                    'name' => $user->name,
                    'profile_pic' => $user->profile_pic 
                        ? asset('storage/' . $user->profile_pic) 
                        : asset('assets/defaultUserPic.png'),
                    'latest_message' => $latestMessage?->content ?? 'No messages yet',
                    'sender_label' => $latestMessage && $latestMessage->sender_id == $admin->id ? 'You: ' : '',
                    'time' => $latestMessage?->created_at?->diffForHumans() ?? '',
                    'has_unseen' => $hasUnseen,
                ];
            })
            ->values();

        return response()->json($chatUsers);
    }

    


    





    // export for chats table to CSV
    public function exportMessages(Request $request)
    {
        $search = $request->input('search');

        $messages = \App\Models\Message::with(['sender', 'receiver'])
            ->when($search, function ($query, $search) {
                $query->where('id', 'like', "%{$search}%")
                    ->orWhereHas('sender', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('receiver', fn($q) => $q->where('name', 'like', "%{$search}%"))
                    ->orWhere('content', 'like', "%{$search}%")
                    ->orWhereRaw("DATE_FORMAT(created_at, '%b %d, %Y - %h:%i%p') LIKE ?", ["%{$search}%"]);
            })
            ->orderBy('created_at', 'desc')
            ->get(); // 👈 no pagination, we export all filtered data

        // ✅ CSV header
        $csvData = [
            ['ID', 'Sender', 'Receiver', 'Content', 'Created At', 'Updated At', 'Seen']
        ];

        foreach ($messages as $message) {
            $csvData[] = [
                $message->id,
                $message->sender->name ?? 'Unknown',
                $message->receiver->name ?? 'Unknown',
                $message->content,
                $message->created_at,
                $message->updated_at,
                $message->seen ? 'Seen' : 'Not Seen',
            ];
        }

        // ✅ Create CSV string
        $output = fopen('php://temp', 'r+');
        foreach ($csvData as $row) {
            fputcsv($output, $row);
        }
        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        // ✅ Download response
        return Response::make($csvContent, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="messages_export.csv"',
        ]);
    }



    // export applications to CSV
    public function exportApplications(Request $request)
    {
        $query = JobApplication::with(['user', 'job'])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone_num', 'like', "%{$search}%")
                ->orWhere('status', 'like', "%{$search}%");
            })
            ->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
            })
            ->orWhereHas('job', function ($q) use ($search) {
                $q->where('job_title', 'like', "%{$search}%");
            });
        }

        $applications = $query->get(); // 👈 no pagination — export all filtered

        $response = new StreamedResponse(function () use ($applications) {
            $handle = fopen('php://output', 'w');

            // CSV Header
            fputcsv($handle, [
                '#',
                'Client Name',
                'Job Title',
                'Full Name',
                'Email',
                'Phone Number',
                'Message',
                'Status',
                'Date Created',
            ]);

            // CSV Data Rows
            foreach ($applications as $index => $app) {
                fputcsv($handle, [
                    $index + 1,
                    optional($app->user)->name ?? 'Unknown User (ID: ' . $app->user_id . ')',
                    optional($app->job)->job_title ?? 'Unknown Job (ID: ' . $app->job_id . ')',
                    $app->full_name,
                    $app->email,
                    $app->phone_num,
                    $app->message ?? 'No message provided',
                    $app->status,
                    $app->created_at->format('M d, Y'),
                ]);
            }

            fclose($handle);
        });

        $filename = 'job_applications_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }

    // export job posts to CSV
    public function exportJobPosts(Request $request)
    {
        $search = $request->input('search');

        $query = JobPost::with('client')->orderBy('created_at', 'desc');

        // 🔍 Apply search filters if search is provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('job_title', 'LIKE', "%{$search}%")
                ->orWhere('job_location', 'LIKE', "%{$search}%")
                ->orWhere('job_pay', 'LIKE', "%{$search}%")
                ->orWhere('salary_release', 'LIKE', "%{$search}%")
                ->orWhere('job_type', 'LIKE', "%{$search}%")
                ->orWhere('skills_required', 'LIKE', "%{$search}%")
                ->orWhere('short_description', 'LIKE', "%{$search}%")
                ->orWhere('full_description', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%")
                ->orWhereDate('created_at', $search)
                ->orWhereHas('client', function ($clientQuery) use ($search) {
                    $clientQuery->where('name', 'LIKE', "%{$search}%");
                });
            });
        }

        // ✅ Get all matching results (not paginated)
        $jobPosts = $query->get();

        $response = new StreamedResponse(function () use ($jobPosts) {
            $handle = fopen('php://output', 'w');

            // 🧾 CSV Header
            fputcsv($handle, [
                'Job Title',
                'Client Name',
                'Location',
                'Pay',
                'Salary Release',
                'Job Type',
                'Skills Required',
                'Short Description',
                'Full Description',
                'Status',
                'Created At',
                'Updated At'
            ]);

            // 🧩 Write data rows
            foreach ($jobPosts as $job) {
                fputcsv($handle, [
                    $job->job_title,
                    $job->client->name ?? 'N/A',
                    $job->job_location,
                    $job->job_pay,
                    $job->salary_release,
                    $job->job_type,
                    $job->skills_required,
                    $job->short_description,
                    $job->full_description,
                    $job->status,
                    $job->created_at ? $job->created_at->format('Y-m-d H:i:s') : '',
                    $job->updated_at ? $job->updated_at->format('Y-m-d H:i:s') : '',
                ]);
            }

            fclose($handle);
        });

        // 🧠 Filename logic
        $filename = $search
            ? 'filtered_job_posts_' . now()->format('Y-m-d_H-i-s') . '.csv'
            : 'all_job_posts_' . now()->format('Y-m-d_H-i-s') . '.csv';

        // 🧾 Headers
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }


    // export users to CSV
    public function export(Request $request): StreamedResponse
    {
        $search = $request->input('search');

        // Build query same as your index logic
        $query = User::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('phoneNum', 'LIKE', "%{$search}%")
                ->orWhere('user_type', 'LIKE', "%{$search}%")
                ->orWhere('status', 'LIKE', "%{$search}%");
            });
        }

        // fetch all results (no pagination)
        $users = $query->get(['id',
        'name',
        'email',
        'phoneNum',
        'address',
        'about_details',
        'skills',
        'user_type',
        'status',
        'created_at',]);

        // Stream CSV response
        $response = new StreamedResponse(function () use ($users) {
            $handle = fopen('php://output', 'w');

            // CSV headers
            fputcsv($handle, ['ID',
            'Name',
            'Email',
            'Phone Number',
            'Address',
            'About Details',
            'Skills',
            'User Type',
            'Status',
            'Created At',]);

            foreach ($users as $user) {
                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phoneNum,
                    $user->address,
                    $user->about_details,
                    $user->skills,
                    $user->user_type,
                    $user->status,
                    $user->created_at,
                ]);
            }

            fclose($handle);
        });

        $filename = $search ? "users_filtered_{$search}.csv" : "users_all.csv";

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }

    // exrpot transactions to CSV
    public function exportTransactions(Request $request)
    {
        $query = Transaction::with(['employee', 'client']);

        // Apply search filter if present
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'like', str_replace('2025', '', $search))
                    ->orWhereHas('employee', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('client', function ($sub) use ($search) {
                        $sub->where('name', 'like', "%{$search}%");
                    })
                    ->orWhere('job_title', 'like', "%{$search}%")
                    ->orWhere('amount', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%")
                    ->orWhere('payment_method', 'like', "%{$search}%")
                    ->orWhere('reference_no', 'like', "%{$search}%")
                    ->orWhere('transaction_ref_no', 'like', "%{$search}%");
            });
        }

        $transactions = $query->latest()->get();

        // Stream CSV response
        $response = new StreamedResponse(function () use ($transactions) {
            $handle = fopen('php://output', 'w');

            // CSV Header
            fputcsv($handle, [
                'Transaction ID',
                'Employee Name',
                'Client Name',
                'Job Title',
                'Amount',
                'Status',
                'Payment Method',
                'Account No', // renamed from reference_no
                'Transaction Ref No',
                'Payment Date',
            ]);

            // CSV Rows
            foreach ($transactions as $transaction) {
                fputcsv($handle, [
                    '2025' . $transaction->id,
                    optional($transaction->employee)->name ?? 'N/A',
                    optional($transaction->client)->name ?? 'N/A',
                    $transaction->job_title ?? 'N/A',
                    $transaction->amount ?? 'N/A',
                    $transaction->status ?? 'N/A',
                    $transaction->payment_method ?? 'N/A',
                    $transaction->reference_no ?? 'N/A',
                    $transaction->transaction_ref_no ?? 'N/A',
                    $transaction->payment_date ?? 'N/A',
                ]);
            }

            fclose($handle);
        });

        $filename = 'transactions_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename={$filename}");

        return $response;
    }

    // export reports to CSV
    public function exportReports(Request $request)
    {
        $search = $request->input('search');

        // Base query
        $query = Report::with(['reportable', 'reporter'])->orderBy('created_at', 'desc');

        // Apply same search logic as your reports() function
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('message', 'LIKE', "%{$search}%")
                ->orWhere('reportable_id', 'LIKE', "%{$search}%")
                ->orWhere('reportable_type', 'LIKE', "%{$search}%")
                ->orWhereHas('reporter', function ($r) use ($search) {
                    $r->where('name', 'LIKE', "%{$search}%");
                })
                ->orWhereHasMorph(
                    'reportable',
                    [User::class, JobPost::class],
                    function ($related, $type) use ($search) {
                        if ($type === User::class) {
                            $related->where('name', 'LIKE', "%{$search}%");
                        } elseif ($type === JobPost::class) {
                            $related->where('job_title', 'LIKE', "%{$search}%");
                        }
                    }
                );
            });
        }

        $reports = $query->get(); // Get all results (no pagination)

        // CSV stream response
        $response = new StreamedResponse(function () use ($reports) {
            $handle = fopen('php://output', 'w');

            // CSV header row
            fputcsv($handle, [
                'Report ID',
                'Type',
                'Reported Entity',
                'Reported By',
                'Message',
                'Created At'
            ]);

            // CSV data rows
            foreach ($reports as $report) {
                $type = class_basename($report->reportable_type);
                $reportedEntity = $report->reportable
                    ? ($type === 'User'
                        ? $report->reportable->name
                        : ($report->reportable->job_title ?? 'Job #' . $report->reportable_id))
                    : 'N/A';

                fputcsv($handle, [
                    '2025' . $report->id,
                    $type,
                    $reportedEntity,
                    $report->reporter->name ?? 'N/A',
                    $report->message,
                    $report->created_at->format('M d, Y - h:ia')
                ]);
            }

            fclose($handle);
        });

        // CSV headers
        $date = now()->format('Y-m-d');
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', "attachment; filename=\"reports_export_{$date}.csv\"");

        return $response;
    }

      // hustory log export
    public function exportLogs(Request $request)
    {
        $search = $request->input('search');

        $logs = HistoryLog::query()
            ->when($search, function($q) use ($search) {
                $q->where('details', 'like', "%{$search}%")
                ->orWhereHas('user', function($q2) use ($search) {
                    $q2->where('name', 'like', "%{$search}%");
                })
                ->orWhere('user_type', 'like', "%{$search}%")
                ->orWhere('user_id', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get(); // get all filtered logs

        $filename = 'history_logs_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $columns = ['ID', 'User ID', 'Username', 'User Type', 'Details', 'Created At', 'Updated At'];

        $callback = function() use ($logs, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->id,
                    $log->user_id,
                    $log->user?->name ?? 'Deleted User',
                    ucfirst($log->user_type),
                    $log->details,
                    $log->created_at->format('m-d-Y h:i A'),
                    $log->updated_at->format('m-d-Y h:i A'),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}

  

