@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <div class="container align-middle">
        <div class="page-header white-text">
            <h1> Pupegur - Image Upload </h1>
        </div>
        <div class="jumbotron col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <image-upload
                :api_post_create = {{ json_encode(route('api.post.store'))}}
            />
        </div>
    </div>
@endsection()