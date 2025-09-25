<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Upload;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username' => 'required|string|max:255',
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'phoneNum' => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:255',
        ]);

        $user->name     = $request->username;
        $user->email    = $request->email;
        $user->phoneNum = $request->phoneNum;
        $user->address  = $request->address;
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }
    public function updateSkills(Request $request)
    {
        $request->validate([
            'skills' => 'nullable|string|max:5000', // flexible limit
        ]);

        $user = Auth::user();
        $user->skills = $request->skills; // store as comma-separated
        $user->save();

        return redirect()->back()->with('success', 'Skills updated successfully!');
    }
    public function updatePicture(Request $request)
    {
        $request->validate([
            'profile_pic' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile_pic')) {
            // store file inside storage/app/public/profile_pics
            $path = $request->file('profile_pic')->store('profile_pics', 'public');

            // save path in DB
            $user->profile_pic = $path;
            $user->save();
        }

        return redirect()->back()->with('success', 'Profile picture updated!');
    }

    public function uploadFiles(Request $request)
    {
        $user = Auth::user();

        // Validate files
        $request->validate([
            'files.*' => 'nullable|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle general files
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('uploads/files', 'public');
                $user->uploads()->create([
                    'type' => 'file',
                    'path' => $path,
                    'original_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Handle images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads/images', 'public');
                $user->uploads()->create([
                    'type' => 'image',
                    'path' => $path,
                    'original_name' => $image->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Files uploaded successfully!');
    }
    public function destroyUpload($id)
    {
        $upload = Upload::findOrFail($id);

        // Make sure it’s the user’s file
        if ($upload->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        // Delete file from storage
        \Storage::delete($upload->path);

        // Delete record from DB
        $upload->delete();

        return back()->with('success', 'File deleted successfully.');
    }



}
