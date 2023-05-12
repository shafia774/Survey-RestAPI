<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey;
use App\Models\Customer;
use App\Models\Questions;
use App\Models\Reports;
use App\Models\ReportItems;

class SurveyController extends Controller
{
    public function create(Request $request)
    {
        $survey = new Survey;
        $survey->name =$request->name;
        $survey->age =$request->age;
        $survey->gender =$request->gender;
        $survey->save();
        $surveyItems = $request->questions;
        
        foreach($surveyItems as $item){

            $questions = new Questions;
            $questions->survey_id =$survey->id;
            $questions->question =$item['question'];
            $questions->option_a =$item['option_a'];
            $questions->option_b =$item['option_b'];
            $questions->option_c =$item['option_c'];
            $questions->option_d =$item['option_d'];
            $questions->save();
        }
        
        return response()->json([
            'survey'=> $survey,
        ], 201);        
    }

    public function list(Request $request)
    {
        $user = $request->user();
        $customer = Customer::where('user_id', $user->id)->first();
        $survey = Survey::where('gender', $customer->gender)->get();
        return response()->json([
            'survey'=> $survey
        ], 200);        
    }

    public function view(Request $request)
    {
        $survey = Survey::find($request->id);
        $questions = Questions::where('survey_id', $survey->id)->get();
        return response()->json([
            'survey'=> $survey,
            'questions'=> $questions
        ], 200);        
    }

    public function edit(Request $request)
    {
        $survey = Survey::find($request->id);
        $survey->name =$request->name;
        $survey->age =$request->age;
        $survey->gender =$request->gender;
        $survey->save();
        return response()->json([
            'survey'=> $survey,
        ], 200);  
               
    }

    public function editQuestion(Request $request)
    {
        $questions = Questions::find($request->id);
        $questions->question =$request->question;
        $questions->option_a =$request->option_a;
        $questions->option_b =$request->option_b;
        $questions->option_c =$request->option_c;
        $questions->option_d =$request->option_d;
        $questions->save();
        return response()->json([
            'questions'=> $questions
        ], 200);   
               
    }

    public function delete(Request $request)
    {
        $survey = Survey::find($request->id);
        $survey->delete();
        return response()->json([
            'survey'=> $survey
        ], 200);  
               
    }

    public function deleteQuestion(Request $request)
    {
        $survey = Questions::find($request->id);
        $survey->delete();
        return response()->json([
            'survey'=> $survey
        ], 200);  
               
    }

    public function report(Request $request)
    {
        $survey = Survey::find($request->id);
        $user = $request->user();

        $report = new Reports;
        $report->user_id =$user->id;
        $report->survey_id =$survey->id;
        $report->save();
        $reportItems = $request->report_items;
        
        foreach($reportItems as $item){

            $questions = new ReportItems;
            $questions->report_id =$report->id;
            $questions->question_id =$item['question_id'];
            $questions->answer =$item['answer'];
            $questions->save();
        }
        
        return response()->json([
            'report'=> $report,
        ], 201);         
    }
    
}
