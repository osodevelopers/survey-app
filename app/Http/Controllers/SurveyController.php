<?php

namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
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
    	return Survey::where('creator_id', $request->user()->id)->get;
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
        return Survey::find($id);
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
}
