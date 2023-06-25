<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

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
        /*check if user exists*/
        try {
            $user_resp = Http::asForm()->post(env('LOGIN_URL') . 'login', [
                'user' => $request['email'],
                'pass' => $request['password']
            ]);
        } catch (Exception) {
            return redirect()->route('login')->withErrors([
                'email' => 'Autentificarea a esuat.',
            ]);
        }

        $user_data = json_decode($user_resp->getBody(), true);
//        dd($user_data);
        if ($user_data) {
            $user_data = $user_data[0];
        } else {
            return redirect()->route('login')->withErrors([
                'email' => 'Au aparut probleme la authentificare!',
            ]);
        }
        /*check user if is partner*/
        if ($user_data['id']) {
            try {
                $partner_resp = Http::post(env('LOGIN_URL') . '/get_partners/' . $user_data['id'] . '/' . 0 . '/' . 0);
            } catch (Exception) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Autentificarea a esuat.',
                ]);
            }
        }
//        dd($partner_data);
        if ($partner_resp->getStatusCode() == 200 && json_decode($partner_resp->getBody(), true)) {
            $user_data['userType'] = 'partner';
        } else if ($user_data['userType'] != 'admin') {
            $user_data['userType'] = 'coordinator';

        }

        if ($user_resp->getStatusCode() == 200) {
            if ($user_data) {
                $user = User::where('email', $user_data['email'])->first();

                if ($user) {
                    // User already exists, update their record
                    $user->id = $user_data['id'] ?? '';
                    $user->name = $user_data['name'] ?? '';
                    $user->password = Hash::make($user_data['password'] ?? '');
                    $user->role = $user_data['userType'] ?? 'coordinator';
                    $user->save();

                } else {
                    // User does not exist, create a new record
                    $user = new User;
                    $user->id = $user_data['id'];
                    $user->name = $user_data['name'];
                    $user->email = $user_data['email'];
                    $user->password = Hash::make($user_data['password']);
                    $role = $user_resp['userType'];
                    if($user_resp['userType'] == "User" || $user_resp['userType'] == "user") {
                        $role = 'coordinator';
                    }
                    $user->role = $role;
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
