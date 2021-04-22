<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Actor;
use App\Models\FilmActor;
use Validator;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $actors = Actor::withCount('filmactors')->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'actors' => $actors
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
            'city' => 'required|string|min:4|max:64',
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

        $actor = new Actor;
        $actor->name = $request->name;
        $actor->city = $request->city;
        $actor->email = $request->email;
        $actor->website = $request->website;

        if($request->picture != ''){
            // generate a new filename. getClientOriginalExtension() for the file extension
            $name = preg_replace('/\s+/', '', $request->name);

            $fileName = $name.'-photo-'.time().'.jpg';

            // save to storage/app/photos as the new $filename
            Storage::put('public/actors/'.$fileName,base64_decode($request->picture));
            $actor->picture = $fileName;
        }

        if($request->background != ''){
            $actor->background= $request->background;
        }

        $actor->save();

        return response()->json([
            'success' => true,
            'message' => 'New actor created succesfully',
            'actor' => $actor
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
            $actor = Actor::findOrFail($id);
            $film_actors = FilmActor::with('movie', 'role')->where('actor_id', $actor->id)->orderBy('created_at','desc')->get();
            return response()->json([
                'success' => true,
                'message' => 'Found actor data',
                'actor' => $actor,
                'film_actors' => $film_actors
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No actor id found',
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
            $actor = Actor::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Found actor data',
                'actor' => $actor,
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No actor id found',
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
            'city' => 'required|string|min:4|max:64',
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
            $actor = Actor::withCount('filmactors')->findOrFail($id);
            $actor->name = $request->name;
            $actor->city = $request->city;
            $actor->email = $request->email;
            $actor->website = $request->website;


            if($request->picture != ''){

                if($actor->picture != '') {
                    // delete existing file
                    Storage::delete('public/actors/'. $actor->picture);
                }

                // generate a new filename. getClientOriginalExtension() for the file extension
                $name = preg_replace('/\s+/', '', $request->name);

                $fileName = $name.'-photo-'.time().'.jpg';

                // save to storage/app/photos as the new $filename
                Storage::put('public/actors/'.$fileName,base64_decode($request->picture));
                $actor->picture = $fileName;
            }
        
            if($request->background != ''){
                $actor->background = $request->background;
            }
            
            $actor->save();

            return response()->json([
                'success' => true,
                'message' => 'Actor successfully updated',
                'actor' => $actor
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No actor id found',
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
            $actor = Actor::findOrFail($id);

            if($actor->picture != '') {
                // delete existing file
                Storage::delete('public/actors/'. $actor->picture);
            }

            $actor->delete();
            return response()->json([
                'success' => true,
                'message' => 'Actor successfully deleted',
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No actor id found',
            ]);
        }
    }
}
