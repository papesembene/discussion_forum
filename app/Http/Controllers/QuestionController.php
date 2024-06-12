<?php

namespace App\Http\Controllers;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuestionController extends Controller
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
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'tags' => 'required',
        ]);

        $title = $request->title;
        $description = $request->description;
        $tagsArr = explode(',',$request->tags);

        $Questiondata = [
            'user_id' => Auth::user()->id,
            'title' => $title,
            'description' => $description,
            'slug' => Str::slug($title).'-'.uniqid(),
            'created_at' => Carbon::now(),
        ];

        $createdQuestion = Question::create($Questiondata);

        $currentQuestion = Question::find($createdQuestion->id);
        $currentQuestion->tag()->attach($tagsArr);

        return redirect()->route('home')->with(['message'=>'Question created successfully']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Question::where('id',$id)->delete();
        return response()->json([
            'success'=> true,
        ]);
    }
}
