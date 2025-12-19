<?php

namespace App\Http\Controllers;

use App\Models\Themes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ThemesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $themes = Themes::with("questions")->get();
$themeQuestionReponse = Themes::with('questions.reponses')->get();

        if($themes){
            return response()->json([
                "status" => "Success",
                "message" => "listes des themes trouver",
                "data" => $themes,
                "themeQuestionReponse" => $themeQuestionReponse,
            ]);
        }
         return response()->json([
                "status" => "Success",
                "message" => "listes des themes non trouver",
            ]);
    }
     public function indexThemeId($id)
    {

$theme = Themes::with('questions.reponses')->find($id);
        if($theme){
            return response()->json([
                "status" => "Success",
                "message" => "Theme trouver",
                "data" => $theme,
            ]);
        }
         return response()->json([
                "status" => "Success",
                "message" => "Theme theme non trouver",
            ]);
    }

     public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            "name" => "required|string|max:1000",
        ]);
        if ($validate->fails()) {
            return response()->json([
                "status" => "Echec",
                "message" => $validate->errors(),
            ], 400);
        }
        $theme = Themes::create([
            "name" => $request->name,
        ]);

        return response()->json([
            "status" => "Success",
            "message" => "Theme creer avec success",
            "data" => $theme,
        ]);
    }
    public function edit($id)
    {
        $theme = Themes::find($id);
        if ($theme) {
            return response()->json([
                "status" => "Success",
                "message" => "Theme retrouver",
                "data" => $theme,
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => "Theme non retrouver",
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
        
        $themeUpdate = Themes::where("id", "=", $id)->get()->first();
        
        if (!$themeUpdate) {
            return response()->json([
                "status" => "Echoué",
                "message" => "Aucun Theme trouver avec cet id",
            ], 400);
        }
        
        if ($themeUpdate) {
            $themeUpdate->update([
                "name" => $request->name,
            ]);
            
            return response()->json([
                "status" => "Success",
                "message" => " Theme modifier avec success",
                "data" => $themeUpdate,
            ]);
        }
    }
    public function destroy($id)
    {
        $theme = Themes::find($id);
        if ($id) {
            $theme->delete();

            return response()->json([
                "status" => "Success",
                "message" => " Theme supprimer avec success",
            ]);
        }
        return response()->json([
            "status" => "Echec",
            "message" => " Aucun Theme trouver avec cet id pour suppression",
        ]);
    }
}
