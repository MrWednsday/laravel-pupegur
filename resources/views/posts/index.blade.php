@extends('layouts.app')

@section('title', 'Posts')

@section('content')
    <div class="container align-middle">
        <div class="page-header white-text">
            <h1> Welcome to Pupegur - all things pup </h1>
        </div>
        <div class="row">
            @foreach($posts as $post)
                <div class="jumbotron col-lg-5 col-md-5 col-sm-12 col-xs-12 mr-5">
                    <div class="title">
                        <div>
                            <h2 class="m-0"> {{$post->title}} </h2>
                        </div>
                        <a class="m-0" href="{{ route('user.show', $post->user_id) }}">
                            <p> {{$post->user->name}} </p>
                        </a>
                    </div>
                    <div class="m-0 img-margin">
                        <a class="m-0" href="{{ route('post.show', $post->id) }}">
                            <img class="mx-auto d-block img-fluid" src="{{ asset('storage/images/' . $post->image->path) }}" alt={{$post->image->path}}>
                        </a>
                        <div class="ml-auto p-2 bd-highlight">
                            <span>
                                Posted: {{$post->created_at}}
                            </span>
                        </div>
                        <div class="row">
                            @foreach($post->tags as $tag)
                                <div class="col-lg-4 col-md-4 col-sm-2 col-xs-2 mr-2">
                                    <a href="{{ route('post.index', ['tag' => $tag->tag]) }}">
                                        <button class="tag">{{$tag->tag}}</button>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- Pagination --}}
        </div>
        <div div class="row h-100 justify-content-center align-items-center">
            <div class="d-flex p-2">
                {!! $posts->links('vendor.pagination.custom') !!}
            </div>
        </div >
    </div>
@endsection()