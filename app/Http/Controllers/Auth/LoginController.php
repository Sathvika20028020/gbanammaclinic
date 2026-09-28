<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

   
    public function username()
    {
        return 'phone';
    }

    /**
     *  Validate phone-based login
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'phone'    => ['required', 'digits:10'],
            'password' => ['required', 'string'],
        ]);
    }

    /**
     *  Allow login only for active users
     */
    protected function credentials(Request $request)
    {
        return [
            'phone'           => $request->phone,
            'password'        => $request->password,
            'internet_status' => 'active',
        ];
    }

    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();

        if ($user && $user->internet_status === 'inactive') {
            return back()->withErrors([
                'phone' => 'Your account is disabled by the admin.',
            ]);
        }

        return back()->withErrors([
            'phone' => 'Invalid login credentials.',
        ]);
    }

    
    protected function authenticated(Request $request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.index');
        }

        return redirect()->route('admin.users.show', $user->id);
    }

  
    protected function loggedOut(Request $request)
    {
        return redirect('/login');
    }
}
