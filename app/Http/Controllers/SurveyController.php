<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Models\Answer;
use App\Models\Survey;
use Auth;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * List of Surveys for Admin
     * @return Colletion | JSON
     */
    public function list(Request $request)
    {
    	return $request->user()->surveys;
    }

    /**
     * Get Available Surveys
     * @param Request
     * @return Cpllection | JSON
     */
    public function available(Request $request)
    {
        return Survey::where('active','=',true)->where('anonymous','=',true)->where('creator_id','!=', $request->user()->id)->get();
        // return Survey::where('creator_id','!=', $request->user()->id)->get();
    }

    /**
     * Get Survey
     * @param $id
     * @return return JSON
     */
    public function getSurvey($id, Request $request)
    {
        $answer = Answer::where('survey_id',$id)->where('answered_by',$request->user()->id)->count();
        if($answer)
        {
            return response()->json(['message'=> 'You Have already taken this survey!'],422);
        }else{
            $survey = Survey::with('questions','questions.options')->find($id);
            $survey_ret = $survey->questions->map(function($ques){
                if($ques->question_type == 'radio'){
                    $ques->answer = '';
                    return $ques;
                }else if($ques->question_type == 'checkbox'){
                    $ques->answer = [];
                    return $ques;
                }else if($ques->question_type == 'text'){
                    $ques->answer = '';
                    return $ques;
                }
            });
            $survey->questions = $survey_ret;
            return $survey;
        }
    }

    /**
     * Get Survey Questions
     * @param survey_id
     * @return Collection | JSON
     */
    public function getQuestions($id)
    {
        $survey = Survey::with('questions','questions.options')->find($id);
        $survey_ret = $survey->questions->map(function($ques){
            if($ques->question_type == 'radio'){
                $ques->answer = '';
                return $ques;
            }else if($ques->question_type == 'checkbox'){
                $ques->answer = [];
                return $ques;
            }else if($ques->question_type == 'text'){
                $ques->answer = '';
                return $ques;
            }
        });
        $survey->questions = $survey_ret;
        return $survey;
    }
    
    /**
     * Store or Save New Survey
     * @return Survey | Object
     */
    public function store(SurveyRequest $request)
    {
    	$request->merge(['creator_id' => $request->user()->id]);
    	Survey::create($request->all());
    	return  $request->user();
    }
    /**
     * Survey Edit 
     * @param id
     * @return Json Survey Object
     */
    public function edit($id)
    {
        $survey = Survey::with('questions','questions.options')->find($id);
        $survey_ret = $survey->questions->map(function($ques){
            if($ques->question_type == 'radio'){
                $ques->answer = '';
                return $ques;
            }else if($ques->question_type == 'checkbox'){
                $ques->answer = [];
                return $ques;
            }else if($ques->question_type == 'text'){
                $ques->answer = '';
                return $ques;
            }
        });
        $survey->questions = $survey_ret;
        return $survey;

    }

    /**
     * Servey Update
     * @param id | int
     * @return json Response
     */
    public function update($id, SurveyRequest $request)
    {
        try {
            $survey = Survey::find($id);
            $survey->update($request->all());
            return response()->json(['message' => 'Updated Sucessfully!!']);
        } catch (Exception $e) {
            return response()->json(['message' => 'Something went Wrong!'],500);
        }
    }

    /**
     * Delete Survey
     * @param Id
     * @return JSON response
     */
    public function destroy($id)
    {
        try {
            Survey::destroy($id);
            return response()->json(['message' => 'Survey has been Deleted Successfully!']);
        } catch (Exception $e) {
            return response()->json(['message'=> 'Something went Wrong!'],500);
        }
    }
    /**
     * Take Survey
     * @return JSON
     */
    public function take(Request $request)
    {
        $questions = $request->all();
        foreach ($questions as $question) {
            // return $question['answer'];
            $data = [
                'title'=>'',
                'atext'=> json_encode($question['answer']),
                'answered_by' => $request->user()->id,
                'question_id' => $question['id'],
                'survey_id' => $question['survey_id']
                ];

            $answer = Answer::firstOrCreate($data, ['answered_by' => $request->user()->id, 'question_id' => $question['id'], $question['survey_id']]);
        }
        return $questions;
    }

    /**
     * Get Result of the Survey
     * @param id | Survey id
     * @param request | user info
     * @return response | JSON
     */
    public function getResult($id, Request $request)
    {
        $questions = Survey::find($id)->questions()->with('answers','options')->get();
        return $questions = $questions->map(function($item){
            $item['total_answers'] = $item->answers->count();
            if($item->question_type == 'checkbox'){
                $bgcolors = [];
                $data = [];
                $labels = [];
                foreach ($item->options as $option) {
                    $flag = 0;
                    $item[$option->title] = $item->answers->filter(function($answer) use($option){
                        if(in_array($option->title,json_decode($answer->atext,true))){
                            return $answer;
                        }
                    })->count();
                    array_push($data, $item[$option->title]);
                    array_push($labels,$option->title);
                $color= substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
                    array_push($bgcolors,'#'.$color);
                }
                $item['chart'] = ['labels' => $labels, 'datasets' => [collect(['backgroundColor' => $bgcolors, 'data' => $data])]];
            }
            if($item->question_type == 'radio'){
                $bgcolors = [];
                $data = [];
                $labels = [];
                foreach ($item->options as $option) {
                    $flag = 0;
                    $item[$option->title] = $item->answers->filter(function($answer) use($option){
                        // dd($option->title);
                        if($option->title == json_decode($answer->atext,true)){
                            return $answer;
                        }
                    })->count();
                    array_push($data, $item[$option->title]);
                    array_push($labels,$option->title);
                $color= substr(str_shuffle('AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899AABBCCDDEEFF00112233445566778899'), 0, 6);
                    array_push($bgcolors,'#'.$color);
                }
                $item['chart'] = ['labels' => $labels, 'datasets' => [collect(['backgroundColor' => $bgcolors, 'data' => $data])]];
            }
            return $item;
        });
        return $request->user();
    }
    
}
