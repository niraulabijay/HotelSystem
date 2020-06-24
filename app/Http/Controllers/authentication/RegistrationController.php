<?php

namespace App\Http\Controllers\authentication;

use App\Mail\ActivationMail;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Illuminate\Support\Facades\Mail;
use App\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use UxWeb\SweetAlert\SweetAlert;

class RegistrationController extends Controller
{
    public function register(){
        return view('authentication.register');
    }

    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }

    public function store(Request $request)
    {
//        dd($request);
        $validatedData = $request->validate([
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'password' => 'required|string|min:6|confirmed',
            'email' => 'required|unique:users',
//            'terms' => 'required',
            'prof_pic' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $db_filename = "";
        if($request->hasFile('prof_pic')){
            $image=$request->file('prof_pic');

            $fullName=$image->getClientOriginalName();
            $name=explode('.',$fullName)[0];

            $filename=$name."-profile".".".$image->getClientOriginalExtension();
            $location="/images/profiles/";
            $image->move(public_path() . $location,$filename);
            $db_filename=$location.$filename;
        }

        $user=User::create([
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'first_name'=>$request->first_name,
            'last_name'=>$request->last_name,
            'dob'=>$request->dob,
            'profile_image'=>$db_filename,
        ]);
//        dd($user);
        $sentinel_user=Sentinel::findById($user->id);
        $activation=Activation::create($sentinel_user);
        $role=Sentinel::findRoleBySlug('user');
        $role->users()->attach($user);
        $data=['email'=>$request->email,'code'=>$activation->code];
        SweetAlert::success('Account Created', 'Check your E-Mail to Activate your Account');
//        Mail::to($user->email)->send(new ActivationMail($data));
//        $this->sendEmail($user, $activation->code);
        return redirect('/');
    }

    public function createAdmin($email){
        $credentials = [
            'email'    => $email,
            'password' => 'password',
        ];
        $user = Sentinel::registerAndActivate($credentials);
        $sentinel_user=Sentinel::findById($user->id);
        $activation=Activation::create($sentinel_user);
        $role=Sentinel::findRoleBySlug('developer');
        $role->users()->attach($user);
        // SweetAlert::success('Admin Account Created', 'Email : '.$email."/n Password : password");
        // return redirect('/');
        return 'SuperAdmin Account Created.  '. 'Email : '.$email. "Password : password";
    }
}
