<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['posts'] = Post::all();
        
        return response()->json([
            'status' => true,
            'message' => 'All Posts Data.',
            'data' => $data,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error!',
                'errors' => $validator->errors()->all(),
            ], 401);
        }

        $post = Post::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post Created Successfully.',
            'post' => $post,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Post::select('id', 'title', 'description')->where(['id' => $id])->get();

        return response()->json([
            'status' => true,
            'message' => 'Single Post.',
            'data' => $data,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $rules = [
            'title' => 'required',
            'description' => 'required',
        ];
        
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error!',
                'errors' => $validator->errors()->all(),
            ], 401);
        }

        $post = Post::where(['id' => $id])->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Post Updated Successfully.',
            'post' => $post,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Post::where(['id' => $id])->delete();

        return response()->json([
            'status' => true,
            'message' => 'Post Deleted Successfully.',
            'post' => $post,
        ], 200);
    }
}