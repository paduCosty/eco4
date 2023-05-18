<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.

        $email = $request->input('email');

        $response = Http::asForm()->post(env('LOGIN_URL') . 'reset', [
            'email' => $email,
        ]);

        $user_resp = json_decode($response->getBody(), true);

        if ($user_resp == 1) {
            return redirect()
                ->back()
                ->with('status', 'Un email cu noile date de logare a fost trimis.');
//            $user = User::where('email', $request->email)->first();
//            if (!$user) {
//                $create_user = new User;
//                $create_user->name = 'user';
//                $create_user->email = $request->email;
//                $create_user->password = Hash::make(Str::random(8));
//                $create_user->save();
//            }
        } else {
            //if email no exist
            return redirect()
                ->back()
                ->withErrors(['email' => "Nu putem găsi un utilizator cu acea adresă de e-mail."]);
        }

//        $status = Password::sendResetLink(
//            $request->only('email')
//        );
//
//        return $status == Password::RESET_LINK_SENT
//            ? back()->with('status', __($status))
//            : back()->withInput($request->only('email'))
//                ->withErrors(['email' => __($status)]);
    }
}
