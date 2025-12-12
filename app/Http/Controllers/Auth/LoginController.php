<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\HistoryLog;
use Carbon\Carbon;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        switch ($user->user_type) {
            case 'admin':
                return '/admin';
            case 'employee':
                return '/employee';
            case 'client':
                return '/client';
            default:
                return '/';
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        // Set user online
        $user->update(['status' => 'online']);

        // Create login history record
        HistoryLog::create([
            'user_id'   => $user->id,
            'user_type' => $user->user_type,
            'details'   => 'Logged in around ' . Carbon::now()->format('g:i A - F d, Y'),
        ]);

        // Redirect based on role
        switch ($user->user_type) {
            case 'admin':
                return redirect('/admin');
            case 'employee':
                return redirect('/employee');
            case 'client':
                return redirect('/client');
            default:
                return redirect('/');
        }
    }


    public function logout(Request $request)
    {
        $user = auth()->user();

        // Log history before logging out
        HistoryLog::create([
            'user_id'   => $user->id,
            'user_type' => $user->user_type,
            'details'   => 'Logged out around ' . Carbon::now()->format('g:i A - F d, Y'),
        ]);

        // Set user offline
        $user->update(['status' => 'offline']);

        // Default Laravel logout process
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }


    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()
            ->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => __('The provided credentials do not match our records.'),
            ]);
    }


}
