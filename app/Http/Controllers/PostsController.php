<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Post;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        //$posts = Post::whereIn('user_id', $users)->latest()->paginate(2);
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(2);

        return view('posts.index', compact('posts', 'follows'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data = request()->validate([
            'caption' => 'required',
            'image' => ['required', 'image'],
        ]);

        $imagePath = request('image')->store('uploads', 'public'); //this get saved in storage/app/public/uploads which is not accessible, to make it accessible you have to run artisan storage:link

       // \App\Post::create($data); //this will not work because we have to post in the authenticated user id
        
       //pull in a library using composer 'composer require intervention/image'

       $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
       $image->save();

       auth()->user()->posts()->create([
           'caption' => $data['caption'],
           'image' => $imagePath,
       ]); //this should work instead


        //dd(request()->all());

        return redirect('/profile/' .  auth()->user()->id);
    }

    public function show(Post $post )
    {
        //dd($post);
        return view('posts.show', compact('post'));
    }
}
