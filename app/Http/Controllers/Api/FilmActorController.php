<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FilmActor;
use App\Models\Movie;
use App\Models\Actor;
use App\Models\Role;
use Validator;

class FilmActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $filmActors = FilmActor::with('movie', 'actor', 'role')->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'filmActors' => $filmActors
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
        $actors = Actor::orderBy('id','desc')->get();
        $roles = Role::orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'movies' => $movies,
            'actors' => $actors,
            'roles' => $roles
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
            'actor_id' => 'required|exists:actors,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required',
            'description' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $filmActor = new FilmActor;
        $filmActor->movie_id = $request->movie_id;
        $filmActor->actor_id = $request->actor_id;
        $filmActor->role_id = $request->role_id;
        $filmActor->name = $request->name;
        $filmActor->description = $request->description;
        $filmActor->save();  

        $filmActor = FilmActor::with('movie', 'actor', 'role')->findOrFail($filmActor->id);
        return response()->json([
            'success' => true,
            'message' => 'New film actor created succesfully',
            'filmActor' => $filmActor
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
            $filmActor = FilmActor::with('movie', 'actor', 'role')->findOrFail($id);
            return response()->json([
                'success' => true,
                'message' => 'Found film actor data',
                'filmActor' => $filmActor
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film actor id found',
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
            $filmActor = FilmActor::with('movie', 'actor', 'role')->findOrFail($id);
            $movies = Movie::orderBy('id','desc')->get();
            $actors = Actor::orderBy('id','desc')->get();
            $roles = Role::orderBy('id','desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Found film actor data',
                'filmActor' => $filmActor,
                'movies' => $movies,
                'actors' => $actors,
                'roles' => $roles,
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film actor id found',
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
            'actor_id' => 'required|exists:actors,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required',
            'description' => 'required',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        try {
            $filmActor = FilmActor::findOrFail($id);
            $filmActor->movie_id = $request->movie_id;
            $filmActor->actor_id = $request->actor_id;
            $filmActor->role_id = $request->role_id;
            $filmActor->name = $request->name;
            $filmActor->description = $request->description;
            $filmActor->save();  

            $filmActor = FilmActor::with('movie', 'actor', 'role')->find($filmActor->id);
            return response()->json([
                'success' => true,
                'message' => 'Film actor successfully updated',
                'filmActor' => $filmActor
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film actor id found',
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
            $filmActor = FilmActor::findOrFail($id);
            $filmActor->delete();
            return response()->json([
                'success' => true,
                'message' => 'Film actor successfully deleted',
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No film actor id found',
            ]);
        }
    }
}
