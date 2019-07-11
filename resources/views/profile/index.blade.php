@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row p-5">
        <div class="col-3">
            <img src="/storage/{{$user->profile->image}}" alt="profile image" class="rounded-circle w-100">
        </div>
        <div class="col-9">
            <div class="pt-3 pb-3 d-flex justify-content-between align-items-baseline">
                
                <div class="d-flex align-items-baseline" >
                    <h2>{{$user->username}}</h2>
                    
                    <follow-button user-id="{{ $user->id }}" follows="{{ $follows }}"> </follow-button>

                </div>

                @can('update', $user->profile)
                    <a  class="btn btn-sm btn-primary" href="/p/create">New Post</a>
                @endcan
                
            </div>

            @can('update', $user->profile)
                <a  class="btn mb-3 btn-sm btn-secondary" href="/profile/{{$user->id}}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"> <strong> {{$postCount}} </strong> posts </div>
                <div class="pr-5"><strong> {{$followedCount}} </strong> followers </div>
                <div class="pr-5"><strong> {{$followingCount}} </strong> following </div>
            </div>
            <div class="pt-3"><strong>{{$user->profile->title}}</strong></div>
            <div>{{$user->profile->description}}</div>
            <div><a href="{{$user->profile->url}}">{{$user->profile->url}}</a></div>
        </div>
    </div>

    <div class="row pt-4">
        @foreach($user->posts as $post)

        <div class="col-3 mb-5">
            <a href="/p/{{$post->id}}">
                <img src="{{'/storage/'.$post->image}}" class="w-100">
            </a>
        </div>

        @endforeach
        
    </div>
</div>
@endsection
