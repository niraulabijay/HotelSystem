<?php

namespace App\Http\Controllers\authentication;

use Cartalyst\Sentinel\Checkpoints\NotActivatedException;
use Cartalyst\Sentinel\Checkpoints\ThrottlingException;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function login()
    {
        return view('authentication.login');
    }

    public function check(Request $request)
    {
//        dd($request);
        try {
            $rememberMe=false;
            if($request->rememberMe == 1){
                $rememberMe=true;
            }
            if (Sentinel::authenticate($request->all(), $rememberMe)) {
                return response()->json(['redirect' => route('admin.dashboard')]);
            } else {
                return response()->json(['error' => 'Wrong Credentials'], 500);
            }
        } catch (ThrottlingException $e) {
            $delay = $e->getDelay();
            return response()->json(['error' => 'You have been banned for ' . $delay . ' seconds'],500);
        } catch (NotActivatedException $e) {
            return response()->json(['error' => 'Account Not activated'],500);
        }

    }

    public function logout()
    {
        Sentinel::logout();
        return redirect('/');
    }

}
