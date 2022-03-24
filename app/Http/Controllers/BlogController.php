<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use App\Models\blog_image;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;


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
            $img = Image::make($request->file('photo_header'));
            $img->resize(521, null,  function ($constraint)
            {
                $constraint->aspectRatio();
            });
            $filename = time().'.'.$request->file('photo_header')->getClientOriginalExtension();
            $img_path = 'blog_photo/'.$filename;
            Storage::put($img_path, $img->encode());
            $blog->gambar = $img_path;
        }
        $blog->save();

        if($request->hasfile('image'))
         {
            foreach($request->file('image') as $file)
            {
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $filename = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                $img_path = 'blog_photo/'.$filename;
                Storage::put($img_path, $img->encode());

                $file= new blog_image();
                $file->blog_id = $blog->id;
                $file->image = $img_path;
                $file->save();
            }
         }



        if ($blog) {
            Alert::success('Data berhasil disimpan');
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
        $image = blog_image::where('blog_id', $id)->get();

        return view('pages.blog.edit', ['blog' => $blog, 'image' => $image]);
    }

    public function update(Request $request, $id){
        $blog = Blog::findOrFail($id);
        $blog-> judul = $request-> judul;
        $blog-> desc = $request-> desc;

        // dd($request->all());
        if ($request->hasFile('photo_header')) {
            Storage::disk('public')->delete($blog->photo_header);
            $img = Image::make($request->file('photo_header'));
            $img->resize(521, null,  function ($constraint) {
                $constraint->aspectRatio();
            });
            // dd($img);
            $filename = time() . '.' . $request->file('photo_header')->getClientOriginalExtension();
            $img_path = 'blog_photo/' . $filename;
            Storage::put($img_path, $img->encode());
            $blog->gambar = $img_path;
        }


        // if ($request->hasFile('photo_header')) {
        //     Storage::disk('public')->delete($blog->photo_identitas);
        //     $img = Image::make($request->file('photo_identitas'));
        //     $img->resize(521, null,  function ($constraint)
        //     {
        //         $constraint->aspectRatio();
        //     });
        //     // dd($img);
        //     $filename = time().'.'.$request->file('photo_identitas')->getClientOriginalExtension();
        //     $img_path = 'blog_photo/'.$filename;
        //     Storage::put($img_path, $img->encode());
        //     $blog->photo_identitas = $img_path;
        // }
        $blog->update();

        if($request->hasfile('image'))
        {
            foreach($request->file('image') as $file)
            {
                // $name = time().rand(1,100).'.'.$file->extension();
                // $file->move(public_path('files'), $name);
                // $files[] = $name;
                $img = Image::make($file);
                $img->resize(521, null,  function ($constraint)
                {
                    $constraint->aspectRatio();
                });

                $filename = time().rand(1,100).'.'.$file->getClientOriginalExtension();
                $img_path = 'blog_photo/'.$filename;
                Storage::put($img_path, $img->encode());

                $file= new blog_image();
                $file->blog_id = $blog->id;
                $file->image = $img_path;
                $file->save();
            }
        }

        if ($blog) {
            Alert::success('Data berhasil diupdate');
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

    public function imgdelete($id){
        $image = blog_image::findOrFail($id);
        // dd($image->image);
        Storage::delete($image->image);
        $image->delete();
        return redirect()->back();
    }

    public function delete($id){
        $blog = Blog::findOrFail($id);

        Storage::delete($blog->gambar);

        $image = blog_image::where('blog_id', $blog->id)->get();

        foreach($image as $img){
            Storage::delete($img->image);
            $img->delete();
        }
        $blog->delete();

        if ($blog) {
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

    public function detail($id){
        $blog = Blog::findOrFail($id);
        $image = blog_image::where('blog_id', $id)->get();
        // dd($image);
        return view('pages.blog.detail', ['blog' => $blog, 'image' => $image]);
    }
}
