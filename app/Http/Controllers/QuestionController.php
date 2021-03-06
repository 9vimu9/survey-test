<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuestionController extends Controller
{
    public function addQuestion()
    {
        $users = User::all();
        $data = compact("users");
        return view('add_question',$data);
    }

    public function storeQuestion(Request $request){

        try{
            $request->validate([
                'survey_name' => ['required','max:255'],
                'question' => ['required','max:255'],
                'user_id' => ['required','exists:'.User::class.',id'],
            ]);

            Question::create($request->all());

            $notification = array(
                'message' => 'Question successfully added',
                'alert-type' => 'success'
            );
            return Redirect::back()->with($notification);

        }catch(\Exception $exception){
            $notification = array(
                'message' => 'Something Went Wrong',
                'alert-type' => 'error'
            );
            return Redirect::back()->with($notification);
        }



    }

    public function index(){

        $users = User::all();
        $questions = [];

        $questionCollection = Question::all();
        foreach ($questionCollection as $questionObject){
            $answer = $questionObject->answer;
            $question = [];
            $question["id"] = $questionObject->id;
            $question["question"] = $questionObject->question;
            $question["answer"] = is_null($answer) ? "-" : $answer;
            $question["user"] = $questionObject->user->name;
            $question["answered_at"] = is_null($answer) ? "-" : $questionObject->updated_at->format('d-m-Y H:i:s');
            $question["survey_name"] = $questionObject->survey_name;
            $questions[] = (object)$question;
        }

        $data = compact("questions");
        return view('index',$data);
    }
}
