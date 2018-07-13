<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
	 * Store or Save New Question
	 * @return Survey | Object
	 */
	public function store(QuestionRequest $request)
	{
		$request->merge(['creator_id' => $request->user()->id]);
		$question = Question::create($request->all());
		foreach ($request->get('options') as $option) {
			// Need Change
			$question->options()->create(['title' => $option,'description'=>'']);
		}
		return  $request->user();
	}

	/**
	 * Update Question
	 * @param id | Question id
	 * @param Request
	 * @return Response | JSON
	 */
	public function update($id,Request $request)
	{
		$data = collect($request->get('data'));
		$_question = Question::find($data->get('id'));
		$_question->update($data->only(['title','question_type','require'])->toArray());
		$_options = $data->get('options');
		$_question->options()->delete();
		foreach ($_options as $option) {
			Option::create(['question_id' => $data->get('id'), 'title' => $option['title'], 'description' => '']);
		}
		return response()->json(['message' => 'Successfully Updated!','options'=>$_options]);
	}
	
	/**
	 * Delete Question
	 * @param id
	 * @return Response JSON 
	 */
	public function delete($id)
	{
		try {
			Question::destroy($id);
			return response()->json(['message'=>'Question Deleted Successfully!']);
		} catch (Exception $e) {
			return response()->json(['message'=>'Something went Wrong!'],500);
		}
	}
	
}
