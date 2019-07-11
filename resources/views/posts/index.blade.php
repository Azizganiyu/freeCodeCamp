@extends('layouts.app')

@section('content')
    
    <div class="container">
        @foreach($posts as $post)
        <div class="row mt-5">
            <div class="col-4 offset-4 d-flex align-items-baseline mb-4">
                <div class="col-3">
                    <img src="/storage/{{$post->user->profile->image}}" alt="profile image" class="rounded-circle w-100">
                </div>
                <h6><strong>{{$post->user->username}}</strong></h6>
                <a href="#" class="ml-5 btn btn-sm btn-primary">Unfollow</a>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-4 offset-4">
                <img src="/storage/{{$post->image}}" alt="image" class="w-100">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4 offset-4 ">
                <h4>{{$post->caption}}</h4>
            </div>
        </div>
        @endforeach

        <div class="row">
            <div class="col-12">
                {{$posts->links()}}
            </div>
        </div>
    </div>

@endsection