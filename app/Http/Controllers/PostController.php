<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();

        return response()->json([
            'data' => $posts,
            'message' => 'Retrieved Successfully'
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                $validator->errors()
            ], 400);
        }

        $post = Post::create([
            'title' => $request->title,
            'content' => $request->content
        ]);

        if($post){
            return response()->json([
                'success' => true,
                'message' => 'Post Created',
                'data' => $post
            ], 201);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Post Failed to Save',
            ], 409);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        if($post){
            return response()->json([
                'data' => $post,
                'message' => 'Retrieved Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Post not found!'
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'   => 'required',
            'content' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $post = Post::findOrFail($post->id);

        if($post) {
            //update post
            $post->update([
                'title'     => $request->title,
                'content'   => $request->content
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Post Updated',
                'data'    => $post  
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Post Not Found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find post by ID
        $post = Post::findOrfail($id);

        if($post) {
            //delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post Deleted',
            ], 200);
        }elseif(!$post){
            return response()->json([
                'success' => false,
                'message' => 'Post Not Found',
            ], 404);
        }
    }
}
