<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     *  Register
     */
    public function register(Request $request)
    {
      try{
        $validatedData = Validator::make( $request->all(),[
            "name" => 'required',
            "email" => 'email||required||unique:users',
            "password" => 'required||min:8'
        ]);

        if($validatedData->fails()){
            return response()->json([
                'status' => false ,
                'message' => "Validation error",
                "errors" => $validatedData->errors()
            ],422);
        } ;

        $validatedUser = $validatedData->validate();

        $user = User::create([
            "name" => $validatedUser['name'],
            "email" => $validatedUser['email'],
            "password" => $validatedUser['password']
        ]);


        return response()->json([
            "status" => true,
            "message" => "User Created Seccessfully",
            "user" => $user,
        ],200) ;
      } catch (\Throwable $th){
        return response()->json([
            'status' => false ,
            "errors" => $th->getMessage()
        ],500);
      }

        
    }

    /**
     * Login
     */
    public function login(Request $request)
    {
        try {
            $validatedData = Validator::make($request->all(),[
                "email" => "required||email",
                "password" => "required"
            ]);

            if ($validatedData->fails()) {
                return response()->json([
                    "status" => false,
                    "errors" => $validatedData->errors()
                ],422);
            }

            $user = User::where('email',$request->email)->first();

            if(!$user || !Hash::check($request->password ,$user->password)){
                return response()->json([
                    "status" => false,
                    "message" => "The email or The password is incorrecte"
                ],401);
            }

            $token = $user->createToken("auth-token")->plainTextToken ;

            return response()->json([
                "status" => true ,
                "user" => $user,
                "token" => $token
            ],200);

        } catch (\Throwable $th) {

            return response()->json([
                "status" => false ,
                "errors" => $th->getMessage(),
            ],500);
        }
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        try {
            if($request->has('id')){
                if (User::find($request->id)) {
                    $user = User::find($request->id);
                    $user->tokens()->delete();
                    return response()->json([
                    'status' => true,
                    "message" => "Logout Successfully"
                    ]);
                } else {
                    return "the ID doesnt match any user" ;
                }
                
            }else{
                return "Request must have the ID field" ;
            }
        } catch (\Throwable $th) {
            return response()->json([
                "status" => false ,
                "errors" => $th->getMessage(),
            ],500);
        }
    }

}
