<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FilmProducer;
use App\Models\Movie;
use App\Models\Producer;
use Validator;

class FilmProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filmProducers = FilmProducer::with('movie', 'producer')->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'filmProducers' => $filmProducers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $movies = Movie::orderBy('id','desc')->get();
        $producers = Producer::orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'movies' => $movies,
            'producers' => $producers
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
            'producer_id' => 'required|exists:producers,id',
            'movie_id' => 'required|exists:movies,id',
            'type' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $filmProducer = new FilmProducer;
        $filmProducer->movie_id = $request->movie_id;
        $filmProducer->producer_id = $request->producer_id;
        $filmProducer->type = $request->type;
        $filmProducer->save();  

        $filmProducer = FilmProducer::with('movie', 'producer')->findOrFail($filmProducer->id);
        return response()->json([
            'success' => true,
            'message' => 'New film producer created succesfully',
            'filmProducer' => $filmProducer
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
            $filmProducer = FilmProducer::with('movie', 'producer')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Found film producer data',
                'filmProducer' => $filmProducer
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film producer id found',
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
            $filmProducer = FilmProducer::with('movie', 'producer')->findOrFail($id);
            $movies = Movie::orderBy('id','desc')->get();
            $producers = Producer::orderBy('id','desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Found film producer data',
                'filmProducer' => $filmProducer,
                'movies' => $movies,
                'producers' => $producers
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film producer id found',
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
            'producer_id' => 'required|exists:producers,id',
            'movie_id' => 'required|exists:movies,id',
            'type' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        try {
            $filmProducer = FilmProducer::findOrFail($id);
            $filmProducer->movie_id = $request->movie_id;
            $filmProducer->producer_id = $request->producer_id;
            $filmProducer->type = $request->type;
            $filmProducer->save(); 

            $filmProducer = FilmProducer::with('movie', 'producer')->find($filmProducer->id);
            return response()->json([
                'success' => true,
                'message' => 'Film producer successfully updated',
                'filmProducer' => $filmProducer
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film producer id found',
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
            $filmProducer = FilmProducer::findOrFail($id);
            $filmProducer->delete();
            return response()->json([
                'success' => true,
                'message' => 'Film producer successfully deleted',
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film producer id found',
            ]);
        }
    }
}
