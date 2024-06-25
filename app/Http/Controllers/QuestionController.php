<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionRequest;
use App\Models\Question;
use App\Models\QuestionComment;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            // recuperer les questions avec les tags et les reponses associees
            $questions = Question::all();
            return response()->json([
                'questions' => $questions,
                'message' => 'Donnees recuperees avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la recuperation des donnees',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuestionRequest $request)
    {
        try {
//            return $request->validated();
            $question = Question::create([
                'title' => $request->validated('title'),
                'body' => $request->validated('body'),
                'user_id' => $request->validated('user_id')

            ]);
            $question->tags()->sync($request->validated('tags'));
            // formater la question et les tags dans une meme variable
            $question = Question::with('tags')->find($question->id);
            return response()->json([
                'question' => $question,
                'message' => 'Question creee avec succes',
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la creation de la question',
                'status' => 500
            ], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $question = Question::with('tag', 'comment')->find($id);
            if (!$question) {
                return response()->json([
                    'message' => 'Question non trouvée',
                    'status' => 404
                ], 404);
            }
            return response()->json([
                'question' => $question,
                'message' => 'Données récupérées avec succès',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la récupération des données',
                'status' => 500
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $question = Question::find($id);
            return response()->json([
                'question' => $question,
                'message' => 'Donnees recuperees avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la recuperation des donnees',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(QuestionRequest $request, string $id)
    {
        try {
            $question = Question::find($id);
            $question->update($request->validated());
            return response()->json([
                'question' => $question,
                'message' => 'Question modifiee avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la modification de la question',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $question = Question::find($id);
            $question->delete();
            return response()->json([
                'message' => 'Question supprimee avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la question',
                'status' => 500
            ], 500);
        }
    }

    public function addComment(Request $request, string $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        try {
            $question = Question::findOrFail($id);

            $comment = QuestionComment::create([
                'comment' => $request->input('comment'),
                'user_id' => $request->user()->id,
                'question_id' => $id,
            ]);

            return response()->json([
                'comment' => $comment,
                'message' => 'Commentaire ajouté avec succès',
                'status' => 201
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'ajout du commentaire',
                'status' => 500
            ], 500);
        }
    }

}
