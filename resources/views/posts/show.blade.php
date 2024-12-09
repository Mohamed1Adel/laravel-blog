@extends('layouts.app')

@section('title') Post Details @endsection
@section('content')
    <div class="card">
        <div class="card-header">
          Post Content
        </div>
        <div class="card-body">
           <img src="{{asset('uploads/' . $post->image)}}" width="300" />
          <h5 class="card-title">Title : {{$post->title}}</h5>
          <p class="card-text">Description : {{$post->description}}</p>
          <p class="card-text">Posted By : {{$post->user ? $post->user->name : 'not found'}}</p>
          <p class="card-text">Created At : {{$post->created_at}}</p>
          
        </div>
      </div>

      @endsection
