<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\blog_image;
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
        if($request->hasFile('photo_header'))
        {
            $file = $request->file('photo_header');
            $extention = $file->getClientOriginalExtension();
            $filename=time().'.'.$extention;
            $file->move('blog_image',$filename);
            $blog->gambar=$filename;
        }
        $blog->save();

        $files = [];
        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('blog_image'), $name);
                $files[] = $name;

                $file= new blog_image();
                $file->blog_id = $blog->id;
                $file->image = $name;
                $file->save();
            }
         }



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

        $image_path = public_path().'/blog_image/'.$post->gambar;
        unlink($image_path);

        $image = blog_image::where('blog_id', $post->id)->get();

        foreach($image as $img){
            $img->delete();
            $image_path = public_path().'/blog_image/'.$img->image;
            unlink($image_path);
        }
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
