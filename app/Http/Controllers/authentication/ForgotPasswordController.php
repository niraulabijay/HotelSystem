<?php

namespace App\Http\Controllers\authentication;

use App\Mail\ForgotPasswordMail;
use App\User;
use Cartalyst\Sentinel\Laravel\Facades\Reminder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function forgot_password(){
        return view('authentication.forgot_password');
    }

    public function post_forgot_password(Request $request){
//        dd($request);
        $user=User::whereEmail($request->email)->first();

        $reminder = Reminder::exists($user) ?: Reminder:: create($user);
        $data=['email'=>$request->email, 'code'=>$reminder->code];
        Mail::to($request->email)->send(new ForgotPasswordMail($data));
        return redirect()->back()->with(['success'=>'Reset Code sent to your email']);
    }

    public function reset($email, $code){
        $user=User::whereEmail($email)->first();
//        if(count($user)==0){
//            abort(404);
//        }
//        $sentinelUser=Sentinel::findById($user->id);
        if($reminder=Reminder::exists($user)){
            if($code==$reminder->code){
                return view('authentication.reset_password');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect('/');
        }
    }

    public function post_reset(Request $request, $email, $code){
        $user=User::whereEmail($email)->first();
//        if(count($user)==0){
//            abort(404);
//        }
//        $sentinelUser=Sentinel::findById($user->id);
        if($reminder=Reminder::exists($user)){
            if($code==$reminder->code){
                Reminder::complete($user, $code, $request->password);
                return redirect('/login')->with('success','Your password has been reset.');
            }
            else{
                return redirect('/');
            }
        }
        else{
            return redirect('/');
        }
    }
}
