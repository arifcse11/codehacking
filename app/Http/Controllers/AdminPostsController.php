<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\PostCreateRequest;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $posts = Post::paginate(2);
        
        return view('admin.posts.index', compact('posts'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        $categories = Category::lists('name','id')->all();
        
        return view('admin.posts.create', compact('categories'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostCreateRequest $request)
    {

        $input = $request->all();

        $user = Auth::user();

        if ($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;


        }

        $user->posts()->create($input);
        
        Session::flash('created_post','Post has been created successfully !!!');

        return redirect('/admin/posts');
        
        
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        $post = Post::findOrFail($id);
        
        $categories = Category::lists('name','id')->all();
        
        return view('admin.posts.edit', compact('post','categories'));
        
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

        $input = $request->all();



        if ($file = $request->file('photo_id')){

            $name = time() . $file->getClientOriginalName();

            $file->move('images', $name);

            $photo = Photo::create(['file'=>$name]);

            $input['photo_id'] = $photo->id;


        }

        Auth::user()->posts()->whereId($id)->first()->update($input);

        Session::flash('updated_post','Post has been updated successfully !!!');

        return redirect('/admin/posts');

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

        if ($post->photo){

            unlink(public_path(). $post->photo->file);

        }

        $post->delete();

        Session::flash('deleted_post','The post has been deleted');

        return redirect('admin/posts');

    }


    public function post($slug){

       
        $post = Post::whereSlug($slug)->first();

        $comments = $post->comments()->whereIsActive(1)->get();

        return view('post', compact('post','comments'));

    }


    public function posts()
    {
        
        $posts = Post::paginate(2);

        $categories = Category::all();

        return view('blog', compact('posts', 'categories'));
        
    }

    public function getPostByCategory($category){


        $category = Category::whereName($category)->first();

        $posts = $category->posts()->OrderBy('id','desc')->paginate(1);

        return view('category', compact('posts'));

    }


}
