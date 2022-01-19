<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(){
        $blog = Blog::all();
        return view('pages.blog.index', ['blog'=> $blog]);
    }

    public function create(){
        return view('pages.blog.create');
    }

    public function store(Request $request){
        $blog = new Blog();
        $blog-> judul = $request-> judul;
        $blog-> desc = $request-> desc;

        $blog->save();

        if ($blog) {
            return redirect()
                ->route('blog')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function edit($id){
        $blog = Blog::findOrFail($id);
        return view('pages.blog.edit', ['blog' => $blog]);
    }

    public function update(Request $request, $id){
        $blog = Blog::findOrFail($id);
        $blog-> judul = $request-> judul;
        $blog-> desc = $request-> desc;
        $blog->update();

        if ($blog) {
            return redirect()
                ->route('blog')
                ->with([
                    'success' => 'New post has been created successfully'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Some problem occurred, please try again'
                ]);
        }
    }

    public function delete($id){
        $post = Blog::findOrFail($id);
        $post->delete();

        if ($post) {
            return redirect()
                ->route('blog')
                ->with([
                    'success' => 'Post has been deleted successfully'
                ]);
        } else {
            return redirect()
                ->route('blog')
                ->with([
                    'error' => 'Some problem has occurred, please try again'
                ]);
        }
    }
}
