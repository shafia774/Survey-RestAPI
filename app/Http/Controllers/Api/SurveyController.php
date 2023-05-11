<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Customer;

class SurveyController extends Controller
{
    public function create(Request $request)
    {
        // $rules = [
        //     'name' => 'required|string',
        //     'gender' => [new Enum(Gender::class)],
        //     'age' => 'required|numeric',
        // ];
        $survey = new Survey;
        $survey->name =$request->name;
        $survey->age =$request->age;
        $survey->gender =$request->gender;
        $survey->save();
        return response()->json([
            'survey'=> $survey
        ], 201);        
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $customer = Customer::where('user_id', $user->id)->first();
        $survey = Survey::where('gender', $customer->gender)->get();
        return response()->json([
            'survey'=> $survey
        ], 201);        
    }
    
}
