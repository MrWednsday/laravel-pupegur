@extends('layouts.app')

@section('title', 'Post')

@section('content')
    <div class="container align-middle">
        <div class="raw">
            <div class="jumbotron col-lg-12 col-md-12 col-sm-12 col-xs-12 mb-0" >
                <div>
                    <post-title
                        :auth_user="{{ Auth::user() ? Auth::user() : 'null' }}"
                        :api_post_update = {{ json_encode(route('api.post.update')) }}
                        :post_title = "{{ json_encode($post->title) }}" 
                        :post_id = "{{ $post->id }}"
                        :post_user_id = "{{ $post->user_id}}" 
                    />
                </div>
                <div class="d-flex p-2">
                    <a class="m-0" href="{{ route('user.show', $post->user_id) }}">
                        <p> {{$post->user->name}} </p>
                    </a>
                </div>
                <div>
                    <img img class="mx-auto d-block img-fluid" src="{{ asset('storage/images/' . $post->image->path) }}" alt={{$post->image->path}}>
                    <div class="d-flex bd-highlight mb-3">
                        <div class="ml-auto p-2 bd-highlight">
                            <span>
                                Posted: {{$post->created_at}}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @foreach($post->tags as $tag)
                        <div class="col-lg-3 col-md-3 col-sm-2 col-xs-2 mr-2">
                            <a href="{{ route('post.index', ['tag' => $tag->tag]) }}">
                                <button class="tag">{{$tag->tag}}</button>
                            </a>
                        </div>
                    @endforeach
                </div>
                <post-delete-button
                    :auth_user="{{ Auth::user() ? Auth::user() : 'null' }}"
                    :admin="{{Auth::user() ? Auth::user()->userRole->admin : 0}}"
                    :api_post_delete = {{ json_encode(route('api.post.delete', $post->id)) }}
                    :post_user_id = "{{ $post->user->id }}" 
                />
            </div>
        </div>
        <div>
            <comments 
                :post_id="{{ $post->id }}" 
                :auth_user="{{ Auth::user() ? Auth::user() : 'null' }}"
                :admin="{{Auth::user() ? Auth::user()->userRole->admin : 0}}"
                :api_comment_get = {{ json_encode(route('api.comment.get', $post->id)) }}
                :api_comment_store = {{ json_encode(route('api.comment.store')) }}
                :api_comment_edit = {{ json_encode(route('api.comment.edit')) }}
            ></comments>
        </div>
    </div>
@endsection