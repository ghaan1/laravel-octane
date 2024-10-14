<?php

namespace App\Http\Controllers;

use App\StoreClass\LogAktivitas;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;



class AuthController extends Controller implements HasMiddleware
{
    /**
     * Constructor to apply middleware.
     */
    public static function middleware(): array
    {
        return [
            new Middleware('guest', except: ['logout']),
        ];
    }

    /**
     * Display the login form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Alamat email tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');
        try {
            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();

                if (!$remember) {
                    config(['session.expire_on_close' => true]);
                }
                LogAktivitas::log('Login', $request->path(), null, null, Auth::user()->id);
                return redirect()->intended($this->redirectPath(Auth::user()))->with('success', 'Login berhasil.');
            }

            return back()->withErrors(['error' => 'Email atau kata sandi yang Anda masukkan salah.']);
        } catch (Exception $e) {
            return back()->withErrors(['error' => 'Terjadi kesalahan saat mencoba untuk login. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Determine the post-login redirect path.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    protected function redirectPath($user): string
    {
        $roleRoutes = [
            'admin' => '/dashboard',
            'user' => '/dashboard',
        ];

        foreach ($roleRoutes as $role => $route) {
            if ($user->hasRole($role)) {
                return $route;
            }
        }

        return '/';
    }


    /**
     * Handle logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request): RedirectResponse
    {
        try {
            $user = Auth::user();

            // Logout user
            Auth::logout();

            // Invalidate the current session
            $request->session()->invalidate();

            // Regenerate CSRF token
            $request->session()->regenerateToken();

            // Forget the remember me token in the cookie
            $rememberMeCookie = Auth::getRecallerName();
            if ($request->hasCookie($rememberMeCookie)) {
                Cookie::queue(Cookie::forget($rememberMeCookie));
            }

            // Update the remember_token in the database to null
            if ($user) {
                $user->remember_token = null;
                $user->save();
            }
            LogAktivitas::log('Logout', $request->path(), null, null, $user->id);
            // Redirect to home page
            return redirect('/');
        } catch (Exception $e) {
            // Handle any exceptions during logout
            return back()->withErrors([
                'logout_error' => 'Terjadi kesalahan saat mencoba untuk logout. Silakan coba lagi nanti.',
            ]);
        }
    }
}