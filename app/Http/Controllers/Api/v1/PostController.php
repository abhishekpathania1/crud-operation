<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Post;
use Illuminate\Http\Request;
use Spatie\Fractalistic\Fractal;
use App\Http\Controllers\Controller;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Post::all();
        return Fractal::create()->collection($data)->transformWith(new Post)->toArray();
    }


    public function store(Request $request)
    {
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'created_by' => auth()->user()->id,
        ];
        Post::create($data);
        return response()->json(['message' => 'Post created successfully']);
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
        $data = Post::findOrFail($id);
        $input = [
            'title' => $request->title,
            'description' => $request->description,
            'updated_by' => auth()->user()->id,
        ];
        $data->update($input);
        return response()->json(['message' => 'Post Updated successfully', 'data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Post::findOrFail($id);
        $data->delete();
        return response()->json(['message' => 'Post Deleted successfully']);


    }
}
