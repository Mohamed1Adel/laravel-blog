@extends('layouts.app')

@section('title') Post Create @endsection
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<form method="post" action="{{route('posts.store')}}">
  @csrf
     <!-- Dropzone -->
     <div class="dropzone" id="imageUpload"></div>
    <input type="hidden" name="image" id="uploadedImage">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">title</label>
    <input type="text" name="title" class="form-control" id="title" aria-describedby="title" value="{{old('title')}}">
  </div>
  <div class="mb-3">
  <div class="form-floating">
  <textarea class="form-control" name="description" placeholder="Description" id="Description" value="{{old('description')}}"></textarea>
  <label for="floatingTextarea">Description</label>
</div>
  </div>
  <div class="mb-3 ">
    <label for="exampleInputPassword1" class="form-label">Post Creator</label>
    <select class="form-select" name="post_creator">
      @foreach ($users as $user)
      <option value="{{$user->id}}">{{$user->name}}</option>
      @endforeach
    </select>
  </div>

  <button type="submit" class="btn btn-success">Submit</button>
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

