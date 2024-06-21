<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\QuestionComment;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(CommentRequest $request)
    {
        try {
            $answer = QuestionComment::create($request->validated());
            return response()->json([
                'answer' => $answer,
                'message' => 'Reponse ajoutee avec succes',
                'status' => 201
            ], 201);
        }catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de l\'ajout de la reponse',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        /*try {
            $answers = $question->answers;
            return response()->json([
                'answers' => $answers,
                'message' => 'Reponses recuperees avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la recuperation des reponses',
                'status' => 500
            ], 500);
        }*/
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $answer = Answer::find($id);
            return response()->json([
                'answer' => $answer,
                'message' => 'Reponse recuperee avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la recuperation de la reponse',
                'status' => 500
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AnswerRequest $request, string $id)
    {
        try {
            $answer = Answer::find($id);
            $answer->update($request->validated());
            return response()->json([
                'answer' => $answer,
                'message' => 'Reponse modifiee avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la modification de la reponse',
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
            $answer = Answer::find($id);
            $answer->delete();
            return response()->json([
                'message' => 'Reponse supprimee avec succes',
                'status' => 200
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la reponse',
                'status' => 500
            ], 500);
        }
    }
}
