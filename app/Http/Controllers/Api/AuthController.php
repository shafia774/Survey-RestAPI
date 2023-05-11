<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Enums\Gender;
use Illuminate\Validation\Rules\Enum;

class AuthController extends Controller
{
    //

    public function customers(){
        $customers = Customer::all();
        return response()->json([
            $customers
        ], 201);
    }

    public function signup(Request $request)
    {
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'gender' => [new Enum(Gender::class)],
            'age' => 'required|numeric',
            'password' => 'required|string|min:6|confirmed'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {

            //Create user
            $user = new User;
            $user->name = $validator->safe()->name;
            $user->email = $validator->safe()->email;
            $user->role = 0;
            $user->password = bcrypt($validator->safe()->password);
            $user->save();
            //Create Customer
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->name = $validator->safe()->name;
            $customer->gender = $validator->safe()->gender;
            $customer->age = $validator->safe()->age;
            return response()->json([
                'message' => 'Successfully Created Respondent user!',
                'user' => $user,
                'customer' => $customer
            ], 201);
        } else {
            $errors = $validator->messages();
            return response()->json([
                'message' => 'invalid params',
                'errors' => $errors,
            ], 400);
        }

    }

    public function login(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed'
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $user = User::where('email', $validator->safe()->email)->first();
                if (Hash::check($validator->safe()->password, $user->password)) {
                        $tokenResult = $user->createToken('Personal Access Token');
                        $token = $tokenResult->token;
                        if ($request->remember_me)
                        $token->expires_at = Carbon::now()->addWeeks(1);
                        $token->save();
                } else {
                    $response = ["message" => "Password mismatch"];
                    return response($response, 401);
                }
            return response()->json([
                'status' => 'Success',
                'user' => $user,
                'access_token' => $tokenResult->accessToken,
                'token_type' => 'Bearer',
                'expires_at' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString()
            ]);
        }
        else{
            $errors = $validator->messages();
            return response()->json([
                'message' => 'Invalid username or password',
                'errors' => $errors,
            ], 400);
        }
       
    }
    
}
