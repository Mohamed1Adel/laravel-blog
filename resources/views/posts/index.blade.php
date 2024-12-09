@extends('layouts.app')

@section('title') Index @endsection
@section('content')
    <div class="text-center">
    <a href="{{route('posts.create')}}" class="btn btn-success">Create Post</a>
    </div>
<table class="table mt-4">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Post image</th>
      <th scope="col">Title</th>
      <th scope="col">Posted By</th>
      <th scope="col">Created At</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
 
    @foreach($posts as $post)
   
    <tr>
      <th scope="row">{{$post->id}}</th>
      <td><img src="{{ asset('uploads/' . $post->image) }}" width="200px" /></td>
      <td>{{$post->title}}</td>
      <td>{{$post->user ? $post->user->name : 'not found'}}</td>
     
      <td>{{$post->created_at->addDays(35)->format('Y-m-d');}}</td>
      <td>
            {{-- <a href="/posts/{{$post['id']}}" class="btn btn-info">View</a> --}}
            <a href="{{route('posts.show',$post->id)}}" class="btn btn-info">View</a>
            <a href="{{route('posts.edit',$post->id)}}" class="btn btn-primary">Edit</a>
            <form style="display:inline;" onsubmit="return confirm('do you wont delete this post ?');" method="post" action="{{route('posts.destroy',$post->id)}}">
              @csrf
              @method('DELETE')
              <button  type="submit" class="btn btn-danger">Delete</button>

            </form>
      </td>
    </tr>
    @endforeach
   
  </tbody>
</table>

@endsection
