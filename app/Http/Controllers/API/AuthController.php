<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\UserInfo;
use Illuminate\Http\Request;
use Validator;
use App\User;
use JWTAuth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',  //password_confirmation field name
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);
        return $this->respondWithToken($token);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        if(request()->email == '' || request()->password == ''){
            return ('Missing Credentials');
        }
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'msg' => 'Unauthorized'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserByToken()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }

    public function userInfoStore(Request $request){

        try{
            $user = auth()->user();
            $inputs = $request->only(
                'country',
                'city',
                'postal_code',
                'phone_number'

            );

            foreach ($inputs as $inputKey => $inputValue) {
                UserInfo::updateOrCreate(['user_id'=> $user->id, 'key'=> $inputKey],[
                    'user_id'=> $user->id,
                    'key'=> $inputKey,
                    'value' => $inputValue,
                ] );
            }

            return response()->json([
                'message' => "Successfully Updated..",
                'status' => 'success',
            ]);
        }catch (\Exception $e){
            return response()->json([
                'message' => "Errors!!",
                'status' => 'error',
            ]);
        }


    }

    public function getUserInfo(Request $request){

        try{
            $user = auth()->user();
            $userInfos = $user->userInfos;
            return response()->json($userInfos);

        }catch (\Exception $e){
            return response()->json([
                'message' => "Errors!!",
                'status' => 'error',
            ]);
        }


    }

    public function getUserInfoByKey(Request $request){

        try{
            $user = auth()->user();
            $key = $request->key;
            $userInfos = $user->userInfos()->where('key', $key)->first();
            return response()->json($userInfos);

        }catch (\Exception $e){
            return response()->json([
                'message' => "Errors!!",
                'status' => 'error',
            ]);
        }


    }
}
