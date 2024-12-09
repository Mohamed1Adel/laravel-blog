@extends('layouts.app')

@section('title') Post Create @endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
<form method="post" action="{{route('posts.update',$post->id)}}">
  @csrf
  @method('PUT')
  <div class="dropzone" id="imageUpload"></div>
  <input type="hidden" name="image" id="uploadedImage" value="{{$post->image}}">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">title</label>
    <input type="text" name="title" class="form-control" id="title" value="{{$post->title}}" aria-describedby="title">
  </div>
  <div class="mb-3">
  <div class="form-floating">
  <textarea class="form-control" name="description" placeholder="Description" id="Description">{{$post->description}}</textarea>
  <label for="floatingTextarea">Description</label>
</div>
  </div>
  <div class="mb-3 ">
    <label for="exampleInputPassword1" class="form-label">Post Creator</label>
    <select class="form-select" name="post_creator">
      @foreach ($users as $user)
      <!-- <option @if($user->id == $post->user_id) selected @endif value="{{$user->id}}">{{$user->name}}</option> -->
      <option @selected($post->user_id == $user->id) value="{{$user->id}}">{{$user->name}}</option>
      @endforeach
    </select>
  </div>
  <button type="submit" class="btn btn-primary">Update</button>
</form>
<script>
    Dropzone.options.imageUpload = {
        url: "{{ route('posts.uploadImage') }}", // المسار المسؤول عن رفع الصورة
        maxFiles: 1, // عدد الصور المسموح برفعها
        maxFilesize: 5, // حجم الصورة بالميجابايت
        acceptedFiles: "image/*", // السماح برفع الصور فقط
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            // عند نجاح رفع الصورة
            document.getElementById('uploadedImage').value = response.image; // تعيين اسم الصورة في الحقل المخفي
        },
        error: function (file, response) {
            alert('Error uploading image');
        }
    };
</script>
@endsection