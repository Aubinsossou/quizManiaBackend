<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Question\Question;



class QuestionsController extends Controller
{
         public function index()
    {
        $questions = Questions::all();
        if(count($questions)!== 0){
            return response()->json([
                "status" => "Success",
                "message" => "listes des Questions trouver",
                "data" => $questions,
            ]);
        }
         return response()->json([
                "status" => "Echec",
                "message" => "listes des Questions non trouver",
            ]);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "question" => "required|string|max:1000",
            "theme_id" => "required|integer|exists:themes,id",
        ]);

        if ($validate->fails()) {
            return response()->json([
                "status" => "Echec",
                "message" => $validate->errors(),
            ], 400);
        }
        $question = Questions::create([
            //dd($request->question),
            "question" => $request->question,
            "theme_id" => $request->theme_id,
        ]);

        return response()->json([
            "status" => "Success",
            "message" => "Question creer avec success",
            "data" => $question,
        ]);
    }
    public function edit($id)
    {
        $question = Questions::find($id);
        $questionReponse = Questions::with("reponses")->find($id);

        if ($question) {
            return response()->json([
                "status" => "Success",
                "message" => "Question retrouver",
                "data" => $question,
                "questionReponse" => $questionReponse
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => "Question non retrouver",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
           "question" => "required|string|max:1000",
            "theme_id" => "required|integer",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "Echoué",
                "message" => $validate->errors(),
            ]);
        }

        $questionUpdate = Questions::where("id", "=", $id)->get()->first();

        if (!$questionUpdate) {
            return response()->json([
                "status" => "Echoué",
                "message" => "Aucune Question trouver avec cet id",
            ], 400);
        }

        if ($questionUpdate) {
            $questionUpdate->update([
                "question" => $request->name,
                "theme_id" => $request->theme_id,
            ]);

            return response()->json([
                "status" => "Success",
                "message" => " Question modifier avec success",
                "data" => $questionUpdate,
            ]);
        }
    }
    public function destroy($id)
    {
        $geste = Questions::find($id);
        if ($id) {
            $geste->delete();

            return response()->json([
                "status" => "Success",
                "message" => " Question supprimer avec success",
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => " Aucune Question trouver avec cet id pour suppression",
        ]);
    }

}
