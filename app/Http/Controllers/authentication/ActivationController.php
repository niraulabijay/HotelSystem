<?php

namespace App\Http\Controllers\authentication;

use Cartalyst\Sentinel\Laravel\Facades\Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

class ActivationController extends Controller
{
    public function activate($email, $activationCode){
        $user=User::whereEmail($email)->first();
        if(Activation::complete($user, $activationCode))
        {
            return redirect('/');
        }
        else
        {
            return redirect('/activation_failed')->with('error','Activation Failed');
        }
    }

}
