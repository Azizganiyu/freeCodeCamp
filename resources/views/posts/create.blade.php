@extends('layouts.app')

@section('content')
    
    <div class="container">
        <form action="/p" enctype="multipart/form-data" method="post">
        @csrf
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="row pb-5">
                        <h2>Add a New Post</h2>
                    </div>
                    <div class="form-group row">
                        <label for="caption" class="col-md-4 col-form-label">Image Caption</label>

                            <input id="caption" type="text" class="form-control @error('caption') is-invalid @enderror" name="caption" value="{{ old('caption') }}" autocomplete="caption" autofocus>

                            @error('caption')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>

                    <div class="row">
                        <label for="image" class="col-md-4 col-form-label">Post Image</label>

                        <input type="file" id="image" class="form-control-file" name="image" value="{{ old('image') }}" autocomplete="image" autofocus>

                            @error('image')
                                    <strong>{{ $message }}</strong>
                            @enderror
                    </div>

                    <div class="row mt-5">
                        <button class="btn btn-sm btn-primary"> Post </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

@endsection