<?php



namespace App\Http\Controllers;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;



class UserController extends Controller
{
    
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

    
        $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed']
        ]);

        $user = User::create($request->all());
        event(new Registered($user));
        Auth::login($user);
        
        return redirect()->route('verification.notice');
        
    }

    public function login()
    {
        return view('user.login');
    }

    public function loginAuth(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if(Auth::attempt($credentials, $request->boolean('remember'))){
            $request->session()->regenerate();

            return redirect()->intended('dashboard')->with('success', 'Welcome ' . Auth::user()->name . '!');
        }

       return redirect()->back()->withErrors([
        'email '=> 'Wrong Email or Password'
        ]);

      //  dump($request->boolean('remember'));
       // dd($request->all());
 
    }

    public function logout()
    {
        Auth::logout();

        return redirect('login');
    }

    public function dashboard()
    {
        return view('user.dashboard');
    }


    public function forgotPasswordStore(Request $request)
    {
         $request->validate(['email' => 'required|email']);
 
        $status = Password::sendResetLink($request->only('email'));

 
    return $status === Password::ResetLinkSent
        ? back()->with(['success' => __($status)])
        : back()->withErrors(['email' => __($status)]);
    }


    public function resetPasswordUpdate(Request $request)
    {
         $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);
 
        $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => $password
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('success', __($status))
        : back()->withErrors(['email' => [__($status)]]);
    }
}
