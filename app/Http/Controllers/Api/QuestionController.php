<?php

namespace App\Http\Controllers\Api;

use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\UserNotDefinedException;

class QuestionController extends Controller
{
    public function getQuestionsByUser(){

        try{
            $user = auth()->userOrFail();

            $question = Question::select("id","question")
                ->where("user_id",$user->id)
                ->orderByDesc("id")
                ->limit(1)
                ->get();

            if(!count($question)){
                throw new \UnexpectedValueException();
            }
            $question = $question[0];
            $question = $question->toArray();


            return response()->json([
                "status"=>1,
                "data"=>[
                    "question"=>$question
                ]
            ]);

        }catch (UserNotDefinedException $userNotDefinedException){

            return response()->json([
                "status"=>0,
                "error"=>$userNotDefinedException->getMessage()
            ]);

        }catch (\UnexpectedValueException $unexpectedValueException){

            return response()->json([
                "status"=>1,
                "data"=>[
                    "question"=>false
                ]
            ]);

        }catch (\Exception $exception){

            return response()->json([
                "status"=>0,
                "error"=>"Something went wrong"
            ]);

        }

    }

    public function setAnswer(Request $request){

        try{
            $user = auth()->userOrFail();

            $validator = Validator::make($request->all(), [
                'answer' => ['required','max:255'],
                'question_id' => ['required','exists:'.Question::class.',id'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status"=>0,
                    "error"=>$validator->messages()->first()
                ]);
            }

            $questionId = $request->get("question_id");
            $answer = $request->get("answer");

            $question = Question::where("id",$questionId)
                ->where("user_id",$user->id)
                ->limit(1)
                ->get();

            if(!count($question)){
                throw new \Exception("no question available to set answer");
            }

            $question = $question[0];

            $question->update(["answer"=>$answer]);

            return response()->json([
                "status"=>1,
                "data"=>[],
                "message"=>"answer submitted"
            ]);

        }catch (UserNotDefinedException $userNotDefinedException){

            return response()->json([
                "status"=>0,
                "error"=>$userNotDefinedException->getMessage()
            ]);

        }catch (\Exception $exception){

            return response()->json([
                "status"=>0,
                "error"=>"Something went wrong."
            ]);

        }


    }

}
