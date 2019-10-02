<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Requests\API\Posts\Store;
use App\Http\Requests\API\Posts\Update;
use App\Http\Requests\API\Posts\Destroy;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post as PostResource;
use App\Http\Resources\PostCollection;
use App\Post;
use Carbon;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::whereUserId(request()->user()->id)->latest()->paginate();

        return new PostCollection($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Posts\Store  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Store $request)
    {
        $requestAll = request()->all();
        $requestAll['user_id'] = request()->user()->id;
        $requestAll['post_date'] = Carbon::parse($requestAll['post_date'])->format('Y-m-d');

        $post = new Post($requestAll);
        
        if($post->save()) {          
            return response()->json([
                'success' => true,
                'message' => 'Post successfully added'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post not added'
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\API\Posts\Update  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Update $request, $id)
    {
        $requestAll = $request->all();
        $requestAll['post_date'] = Carbon::parse($requestAll['post_date'])->format('Y-m-d');

        $post = Post::findOrFail($id);
        $post->fill($requestAll);
        
        if($post->save()) {
            return response()->json([
                'success' => true,
                'message' => 'Post successfully updated'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Post not updated'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if($post->delete()) {
            return response()->json([
                'success' => true,
                'message' => 'Post successfully deleted'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Post not deleted'
        ]);
    }
}
