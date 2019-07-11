<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\User;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user = null)
    {
        //$user = User::findOrFail($user);
        if(!$user)
        {
            $user = auth()->user();
        }

        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        /*$postCount = $user->posts->count();
        $followedCount = $user->profile->followed->count();
        $followingCount = $user->following->count();*/

        //Using cache instead
        $postCount = Cache::remember(
            'count.post.'.$user->id,
            now()->addSeconds(30), 
            function () use ($user) {
                return $user->posts->count();
            }
        );

        $followedCount = Cache::remember(
            'count.followed.'.$user->id,
            now()->addSeconds(30), 
            function () use ($user) {
                return $user->profile->followed->count();
            }
        );

        $followingCount = Cache::remember(
            'count.following.'.$user->id,
            now()->addSeconds(30), 
            function () use ($user) {
                return $user->following->count();
            }
        );

        //dd($follows);

        return view('profile.index', [
            'user' => $user,
            'follows' => $follows,
            'postCount' => $postCount,
            'followedCount' => $followedCount,
            'followingCount' => $followingCount,
            ]);

    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image'=> 'image',
        ]);

        //dd($data);

        //$user->profile->update($data);
        if(request('image'))
        {
            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(500, 500);
            $image->save();

            $imageArray =  ['image' => $imagePath];
        }


        auth()->user()->profile->update(array_merge(
            $data, $imageArray ?? []
        ));

        return redirect('/profile/'.$user->id);

    }
}
