<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producer;
use App\Models\FilmProducer;
use Validator;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $producers = Producer::withCount('filmproducers')->orderBy('filmproducers_count','desc')->get();
        
        return response()->json([
            'success' => true,
            'producers' => $producers
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            'name' => 'required|string|min:4|max:64',
            'email' => 'required|email',
            'website' => 'required|url',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $producer = new Producer;
        $producer->name = $request->name;
        $producer->email = $request->email;
        $producer->website = $request->website;
        $producer->save();

        return response()->json([
            'success' => true,
            'message' => 'New producer created succesfully',
            'producer' => $producer
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
            $producer = Producer::findOrFail($id);
            $movies = FilmProducer::with('movie')->where('producer_id', $producer->id)->get()->pluck('movie');
            return response()->json([
                'success' => true,
                'message' => 'Found producer data',
                'producer' => $producer,
                'movies' => $movies
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No producer id found',
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
            $producer = Producer::findOrFail($id);
            
            return response()->json([
                'success' => true,
                'message' => 'Found producer data',
                'producer' => $producer,
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No producer id found',
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
            'name' => 'required|string|min:4|max:64',
            'email' => 'required|email',
            'website' => 'required|url',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        try {
            $producer = Producer::findOrFail($id);
            $producer->name = $request->name;
            $producer->email = $request->email;
            $producer->website = $request->website;
            $producer->save();

            return response()->json([
                'success' => true,
                'message' => 'Producer successfully updated',
                'producer' => $producer
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No producer id found',
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
            $producer = Producer::findOrFail($id);
            $producer->delete();
            return response()->json([
                'success' => true,
                'message' => 'Producer successfully deleted',
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No producer id found',
            ]);
        }
    }
}
