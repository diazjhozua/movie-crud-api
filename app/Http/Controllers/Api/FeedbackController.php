<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Validator;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $feedbacks = Feedback::with('user', 'movie')->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'feedbacks' => $feedbacks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $movies = Movie::select('id', 'title', 'picture')->orderBy('id','desc')->get();
        
        return response()->json([
            'success' => true,
            'movies' => $movies
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = array(
            'movie_id' => 'required|exists:movies,id',
            'comment' => 'required',
            'score' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $feedback = new Feedback;
        $feedback->user_id = Auth::user()->id;
        $feedback->movie_id = $request->movie_id;
        $feedback->comment = $request->comment;
        $feedback->score = $request->score;
        $feedback->save();  

        $feedback = Feedback::with('user', 'movie')->orderBy('id','desc')->findOrFail($feedback->id);

        return response()->json([
            'success' => true,
            'message' => 'New feedback created succesfully',
            'feedback' => $feedback
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $feedback = Feedback::with('movie')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Found feedback data',
                'feedback' => $feedback
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No feedback id found',
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $feedback = Feedback::with('movie')->findOrFail($id);
            $movies = Movie::select('id', 'title', 'picture')->orderBy('id','desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Found feedback data',
                'feedback' => $feedback,
                'movies' => $movies
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No feedback id found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = array(
            'movie_id' => 'required|exists:movies,id',
            'comment' => 'required',
            'score' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        try {
            $feedback = Feedback::findOrFail($id);
            $feedback->movie_id = $request->movie_id;
            $feedback->comment = $request->comment;
            $feedback->score = $request->score;
            $feedback->save();  

            $feedback = Feedback::with('user', 'movie')->orderBy('id','desc')->findOrFail($feedback->id);

            return response()->json([
                'success' => true,
                'message' => 'Feedback successfully updated',
                'feedback' => $feedback
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No feedback id found',
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $feedback = Feedback::findOrFail($id);
            $feedback->delete();
            return response()->json([
                'success' => true,
                'message' => 'Feedback successfully deleted',
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No feedback id found',
            ]);
        }
    }
}
