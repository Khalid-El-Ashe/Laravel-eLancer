<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected $guard = 'web';
    /**
     * Summary of __construct
     * @param Request $request
     * need check the request url is admin or not
     */
    public function __construct(Request $request)
    {
        if ($request->is('admin/*')) {
            $this->guard = 'admin';
        }
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view($this->guard === 'admin' ? 'auth.login' : 'auth.login', [
            'routePrefix' => $this->guard === 'admin' ? 'admin.' : '',
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate($this->guard);

        /**
         * @var mixed
         * now the user can login by email or username or phone number
         * so we need to check the request data
         */
        // $user = User::where('email', '=', $request->post('email'))
        //     ->orWhere('username', '=', $request->post('username'))
        //     ->orWhere('phone_number', '=', $request->post('phone_number'))
        //     // ->where('password', '=', Hash::make($request->post('password')))
        //     ->first();

        /**
         * now if the data is not matched then login the user
         *  otherwise redirect back with error message
         */
        // if (!$user || !Hash::check($request->post('password'), $user->password)) {
        //     throw ValidationException::withMessages([
        //         'email' => 'The provided credentials are incorrect.',
        //         'password' => 'The provided credentials are incorrect.'
        //     ]);
        // }

        /**
         * when need make a login for user we need using a session
         * so we can use Auth facade for that
         */
        // Auth::login($user); //todo now the use is authenticated

        $request->session()->regenerate();

        return redirect()->intended($this->guard === 'admin' ? route('dashboard') : RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard($this->guard)->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
