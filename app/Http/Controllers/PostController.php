<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\post;
use App\Tag;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = post::orderBy('created_at', 'desc')->paginate(5);

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $tags = Tag::all();

        return view('posts.create', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        
        
        $request->validate($this->validation());

        $data['slug'] = Str::slug($data['title'], '-');
        
        if( ! empty($data['path_img']) ){

           $data['path_img'] = Storage::disk('public')->put('img',$data['path_img']);
        }

        $newPost = new post();
        $newPost->fill($data);
        $saved = $newPost->save();

        if($saved){
            if(!empty($data['tags'])){
                $newPost->tags()->attach($data['tags']); 
            }
           return redirect()->route('posts.index');
        } 
        else{
           return redirect()->route('homepage');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $post = post::where('slug' , $slug)->first();

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $post = post::where('slug' , $slug)->first();

        $tags = Tag::all();

        return view('posts.edit', compact('post' , 'tags'));
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
        $data = $request->all();

        $request->validate($this->validation());

        $post = post::find($id);

        $data['slug'] = Str::slug($data['title'], '-');

        if( !empty($data['path_img']) ){

            if( !empty($post->path_img) ){

                Storage::disk('public')->delete($post->path_img);
            }

            $data['path_img'] = Storage::disk('public')->put('img',$data['path_img']);
        }

        $updated = $post->update($data);

        if($updated){
            if(!empty($data['tags'])){
                $post->tags()->sync($data['tags']);
            }
            else{
                $post->tags()->detach();
            }

            return redirect()->route('posts.show', $post->slug);
        }
        else{

            return redirect()->route('homepage');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(post $post)
    {
        $title = $post->title;
        $image = $post->path_img;
        $deleted = $post->delete();
        $post->tags()->detach();

        if($deleted){
            if(! empty($image)){
              Storage::disk('public')->delete($image);
            }
           return redirect()->route('posts.index')->with('post-deleted', $title);
        }
        else{
            return redirect()->route('homepage');
        }
    }

    // validation
    private function validation(){
        return [
            'title' => 'required',
            'body' => 'required',
            'path_img' => 'mimes:jpg,bmp,png',
        ];
    }
}
