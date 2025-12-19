<?php

namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Reponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ReponsesController extends Controller
{
    public function index()
    {
        $reponses = Reponses::all();
        if (count($reponses) !== 0) {
            return response()->json([
                "status" => "Success",
                "message" => "listes des Reponses trouver",
                "data" => $reponses,
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => "listes des Reponses non trouver",
        ]);
    }

public function store(Request $request)
{
    $lastQuestion = Questions::orderBy('created_at', 'desc')->first();

    $validate = Validator::make($request->all(), [
        "listReponse" => 'required|array',
        "listReponse.*.name" => 'required|string',
        "listReponse.*.status" => 'required|string',
    ]);

    if ($validate->fails()) {
        return response()->json([
            "status" => "Echec",
            "message" => $validate->errors(),
        ], 400);
    }

    foreach ($request->listReponse as $item) {
        Reponses::create([
            'name' => $item['name'],
            'status' => $item['status'],
            'question_id' => $lastQuestion->id,
        ]);
    }

    return response()->json([
        "status" => "Success",
        "message" => "Réponses créées avec succès",
        "data" => $request->listReponse,
    ]);
}    public function edit($id)
    {
        $reponse = Reponses::find($id);
        if ($reponse) {
            return response()->json([
                "status" => "Success",
                "message" => "Reponse retrouver",
                "data" => $reponse,
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => "Reponse non retrouver",
        ]);
    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:1000",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "Echoué",
                "message" => $validate->errors(),
            ]);
        }

        $reponseUpdate = Reponses::where("id", "=", $id)->get()->first();

        if (!$reponseUpdate) {
            return response()->json([
                "status" => "Echoué",
                "message" => "Aucune Reponse trouver avec cet id",
            ], 400);
        }

        if ($reponseUpdate) {
            $reponseUpdate->update([
                "name" => $request->name,
                "status" => $request->status,
                "question_id" => $request->question_id,
            ]);

            return response()->json([
                "status" => "Success",
                "message" => " Reponse modifier avec success",
                "data" => $reponseUpdate,
            ]);
        }
    }
    public function destroy($id)
    {
        $reponse = Reponses::find($id);
        if ($id) {
            $reponse->delete();

            return response()->json([
                "status" => "Success",
                "message" => " Reponse supprimer avec success",
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => " Aucune Reponse trouver avec cet id pour suppression",
        ], 400);
    }
}
