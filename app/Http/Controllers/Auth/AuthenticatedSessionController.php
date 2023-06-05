<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use GuzzleHttp\Client;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use mysql_xdevapi\Exception;
use PHPUnit\Framework\Error;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $response = Http::asForm()->post(env('LOGIN_URL') . 'login', [
                'user' => $request['email'],
                'pass' => $request['password']
            ]);
        } catch (Exception) {
            return redirect()->route('login')->withErrors([
                'email' => 'Autentificarea a esuat.',
            ]);
        }

        if ($response->getStatusCode() == 200) {
            $user_resp = json_decode($response->getBody(), true);
            if ($user_resp && $user_resp[0]) {
                $user_resp = $user_resp[0];

                $user = User::where('email', $user_resp['email'])->first();

                if ($user) {
                    // User already exists, update their record
                    $user->id = $user_resp['id'] ?? '';
                    $user->name = $user_resp['name'] ?? '';
                    $user->password = Hash::make($user_resp['password'] ?? '');
                    $user->role = $user_resp['userType'] ?? '';
                    $user->save();

                } else {
                    // User does not exist, create a new record
                    $user = new User;
                    $user->id = $user_resp['id'];
                    $user->name = $user_resp['name'];
                    $user->email = $user_resp['email'];
                    $user->password = Hash::make($user_resp['password']);
                    $user->role = $user_resp['userType'];
                    $user->save();
                }

                Auth::login($user);

                return redirect('/');
            } else {

                return redirect()->route('login')->withErrors([
                    'email' => 'Numele sau parola sunt gresite',
                ]);
            }
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Autentificarea a esuat.',
            ]);

        }
    }

}
