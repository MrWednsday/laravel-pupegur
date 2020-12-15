@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
    <div div class="container align-middle">
        <div class="raw">
            <div class="jumbotron col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <h1> Welcome to Pupegur - User profile </h1>
                
                @if(Auth::user())
                    @if(Auth::user()->id === $user->id)
                        <profile-image-update
                            :current_user="{{Auth::user()}}"
                            :current_user_image="{{Auth::user()->image}}"
                        />
                    @else
                        <div class="d-flex flex-row bd-highlight mb-3">
                            <div>
                                <img class="mx-auto d-block img-fluid img_profile" src="{{ asset('storage/images/' . $user->image->path) }}" alt={{$user->image->path}} :id="profileImage">
                            </div>
                            <div>
                                <h2 style="color: black"> {{$user->name}} </h2>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="d-flex flex-row bd-highlight mb-3">
                        <div>
                            <img class="mx-auto d-block img-fluid img_profile" src="{{ asset('storage/images/' . $user->image->path) }}" alt={{$user->image->path}} :id="profileImage">
                        </div>
                        <div>
                            <h2 style="color: black"> {{$user->name}} </h2>
                        </div>
                    </div>
                @endif
                @if(Auth::user())
                    @if(Auth::user()->id === $user->id)
                        <user-data
                            :user_data="{{ $user->userData }}"
                            :email="{{json_encode($user->email)}}"
                            :api_user_data_post={{ json_encode(route('api.userData.update')) }}
                        />
                    @else
                        @if($user->userData->show_email)
                            <p>User email: {{$user->email}}</p>
                        @endif
                            <p>Gender: {{$user->userData->gender}}</p>
                    @endif
                @else
                    @if($user->userData->show_email)
                        <p>User email: {{$user->email}}</p>
                    @endif
                    <p>Gender: {{$user->userData->gender}}</p>
                @endif
            </div>
            @if (count($user->posts) === 0)
                @if(Auth::user())
                    @if(Auth::user()->id === $user->id)
                        <h3 style="color: black">Looks like you have no posts on Pupegur. Feel free to upload cute pictures of dogs.</h3>
                    @else
                        <h3 style="color: black">{{$user->name}} haven't uploaded any images yet</h3>
                    @endif
                @else
                    <h3 style="color: black">{{$user->name}} haven't uploaded any images yet</h3>
                @endif
            @else
            <div>
                @foreach($user->posts as $post)
                    <div class="jumbotron col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <h2 class="m-0"> {{$post->title}} </h2>
                        <div>
                            <a href="{{ route('post.show', $post->id) }}">
                                <img class="mx-auto d-block img-fluid" src="{{ asset('storage/images/' . $post->path) }}" alt={{$post->path}}>
                            </a>
                            <div class="d-flex bd-highlight mb-3">
                                <div class="ml-auto p-2 bd-highlight">
                                    <span>
                                        Posted: {{$post->created_at}}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>  
@endsection()