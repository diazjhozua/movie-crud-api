<?php

namespace App\Http\Controllers\Api;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\FilmActor;
use App\Models\FilmProducer;
use App\Models\Genre;
use App\Models\Certificate;
use Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $movies = Movie::with('genre:id,name', 'certificate:id,name,description')->withCount('filmactors', 'filmproducers')->orderBy('id','desc')->get();

        return response()->json([
            'success' => true,
            'movies' => $movies
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::withCount('movies')->orderBy('movies_count','desc')->get();
        $certificates = Certificate::withCount('movies')->orderBy('movies_count','desc')->get();

        return response()->json([
            'success' => true,
            'certificates' => $certificates,
            'genres' => $genres
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
            'genre_id' => 'required|exists:genres,id',
            'certificate_id' => 'required|exists:certificates,id',
            'title' => 'required|string|min:1|max:64',
            'studio' => 'required|string|min:4|max:64',
            'duration' => 'required|string|min:4|max:64',
            'saga' => 'required|string|min:4|max:64',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        $movie = new Movie;
        $movie->certificate_id = $request->certificate_id;
        $movie->genre_id = $request->genre_id;
        $movie->title = $request->title;
        $movie->studio = $request->studio;
        $movie->duration = $request->duration;
        $movie->saga = $request->saga;

        if($request->picture != ''){
            // generate a new filename. getClientOriginalExtension() for the file extension
            $name = preg_replace('/\s+/', '', $request->title);

            $fileName = $name.'-photo-'.time().'.jpg';

            // save to storage/app/photos as the new $filename
            Storage::put('public/movies/'.$fileName,base64_decode($request->picture));
            $movie->picture = $fileName;
        }

        if($request->background != ''){
            $movie->background= $request->background;
        }

        $movie->save();

        $movie = Movie::with('genre:id,name', 'certificate:id,name,description')->find($movie->id);
            
        return response()->json([
            'success' => true,
            'message' => 'New movie created succesfully',
            'movie' => $movie
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
            $movie = Movie::with('genre:id,name', 'certificate:id,name,description')->findOrFail($id);
            $film_actors = FilmActor::with('actor', 'role')->where('movie_id', $movie->id)->orderBy('created_at','desc')->get();
            $producers = FilmProducer::with('producer')->where('movie_id', $movie->id)->orderBy('created_at','desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Found movie data',
                'movie' => $movie,
                'film_actors' => $film_actors,
                'producers' => $producers
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No movie id found',
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
            $movie = Movie::with('genre:id,name', 'certificate:id,name,description')->withCount('filmactors', 'filmproducers')->findOrFail($id);
            $genres = Genre::withCount('movies')->orderBy('movies_count','desc')->get();
            $certificates = Certificate::withCount('movies')->orderBy('movies_count','desc')->get();

            return response()->json([
                'success' => true,
                'message' => 'Found movie data',
                'movie' => $movie,
                'certificates' =>$certificates,
                'genres' => $genres,
            ]);

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No movie id found',
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
            'genre_id' => 'required|exists:genres,id',
            'certificate_id' => 'required|exists:certificates,id',
            'title' => 'required|string|min:1|max:64',
            'studio' => 'required|string|min:4|max:64',
            'duration' => 'required|string|min:4|max:64',
            'saga' => 'required|string|min:4|max:64',
        );

        $error = Validator::make($request->all(), $rules);

        if($error->fails()) {
            return response()->json([
                'success' => false,
                'message' => $error->errors(),
            ]);
        }

        try {
            $movie = Movie::with('genre:id,name', 'certificate:id,name,description')->withCount('filmactors', 'filmproducers')->findOrFail($id);
            $movie->certificate_id = $request->certificate_id;
            $movie->genre_id = $request->genre_id;
            $movie->title = $request->title;
            $movie->studio = $request->studio;
            $movie->duration = $request->duration;
            $movie->saga = $request->saga;

            if($request->picture != ''){

                if($movie->picture != '') {
                    // delete existing file
                    Storage::delete('public/movies/'. $movie->picture);
                }
                
                // generate a new filename. getClientOriginalExtension() for the file extension
                $name = preg_replace('/\s+/', '', $request->title);

                $fileName = $name.'-photo-'.time().'.jpg';

                // save to storage/app/photos as the new $filename
                Storage::put('public/movies/'.$fileName,base64_decode($request->picture));
                $movie->picture = $fileName;
            }

            if($request->background != ''){
                $movie->background = $request->background;
            }

            $movie->save();

            $movie = Movie::with('genre:id,name', 'certificate:id,name,description')->withCount('filmactors', 'filmproducers')->find($movie->id);
            
            return response()->json([
                'success' => true,
                'message' => 'Movie successfully updated',
                'movie' => $movie
            ]); 

        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No movie id found',
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
            $movie = Movie::findOrFail($id);

            if($movie->picture != '') {
                // delete existing file
                Storage::delete('public/movies/'. $movie->picture);
            }

            $movie->delete();
            return response()->json([
                'success' => true,
                'message' => 'Movie successfully deleted',
            ]);
        } catch (ModelNotFoundException $ex){
            return response()->json([
                'success' => false,
                'message' => 'No movie id found',
            ]);
        }
    }
}
