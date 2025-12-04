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

    /**
     * ✔ Allow login ONLY if user is active
     */
    protected function credentials(Request $request)
    {
        return [
            'email'            => $request->email,
            'password'         => $request->password,
            'internet_status'  => 'active'
        ];
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        // User found but disabled
        if ($user && $user->internet_status === 'inactive') {
            return back()->withErrors([
                'email' => 'Your account is disabled by the admin.',
            ]);
        }

        // Default wrong credentials message
        return back()->withErrors([
            'email' => 'Invalid login credentials.',
        ]);
    }

    /**
     * ✔ Redirect after login
     */
    protected function authenticated($request, $user)
    {
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.users.index'); // admin route
        }

        // normal user route
        return redirect()->route('admin.users.show', $user->id);
    }

    /**
     * ✔ After logout redirect to login screen
     */
    protected function loggedOut($request)
    {
        return redirect('/login');
    }
}
