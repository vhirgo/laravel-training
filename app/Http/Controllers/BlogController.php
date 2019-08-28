<?php

namespace App\Http\Controllers;

use App\Blog;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $blog = (new Blog)->newQuery();
        $blog->whereNotNull('published_at');

        if ($request->search) {
            $blog->orWhere('title', 'LIKE', "%{$request->search}%");
            $blog->orWhere('content', 'LIKE', "%{$request->search}%");
        }

        if ($request->sort_by) {
            $blog->orderBy($request->sort_by);
        }

        if ($request->sort_by_desc) {
            $blog->orderByDesc($request->sort_by);
        }

        return Blog::paginate($request->get('limit', 15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data = $request->all();
        $data['published_at'] = $request->publish ? now() : null;

        return Blog::create($data);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return Blog::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            return response([
                'message' => "Fail to get blog post with ID {$id}, because it was not found.",
            ], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $task)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $data = $request->all();
        $data['published_at'] = $request->publish ? now() : null;

        return tap($task)->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $task = Blog::findOrFail($id);
            return tap($task)->delete();
        } catch (ModelNotFoundException $exception) {
            return response([
                'message' => "Fail to delete blog post with ID {$id}, because it was not found.",
            ], 404);
        }
    }
}
