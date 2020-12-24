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

        foreach ($users as $user){

            $questionCollection = Question::where("user_id",$user->id)
                ->orderByDesc("id")
                ->limit(1)
                ->get();

            if(!count($questionCollection)){
                continue;
            }

            $questionObject = $questionCollection[0];
            $answer = $questionObject->answer;

            $question = [];
            $question["id"] = $questionObject->id;
            $question["question"] = $questionObject->question;
            $question["answer"] = is_null($answer) ? "-" : $answer;
            $question["user"] = $user->name;
            $question["answered_at"] = is_null($answer) ? "-" : $questionObject->updated_at->format('d-m-Y H:i:s');
            $questions[] = (object)$question;

        }


        $data = compact("questions");
        return view('index',$data);
    }
}
