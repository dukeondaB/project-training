@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title') {{__('Create')}} @endsection

@section('content')
    <form method="post" action="{{route('students.store')}}" enctype=multipart/form-data>
        @csrf
        <label for="" class="form-label">{{__('Full name')}}</label>
        <input type="text" id="name" value="{{old('name')}}" class="form-control" name="name">
        @error('name')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Email')}}</label>
        <input type="text" id="email" class="form-control" value="{{old('email')}}" name="email">
        @error('email')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Phone')}}</label>
        <input type="text" id="phone" class="form-control" value="{{old('phone')}}" name="phone">
             @error('phone')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Address')}}</label>
        <input type="text" id="address" class="form-control" value="{{old('address')}}" name="address">
        @error('address')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Gender')}}</label>
        <select class="form-select" name="gender" aria-label="Default select example">
            <option selected>{{__('Open this select menu')}}</option>
            <option value="male">{{__('Male')}}</option>
            <option value="female">{{__('Female')}}</option>
            <option value="other">{{__('Other')}}</option>
        </select>
        @error('gender')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for=""  class="form-label">{{__('Faculty')}}</label>
        <select class="form-control" name="faculty_id">
            <option value="">-- Chọn khoa --</option>
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
            @endforeach
        </select>
        @error('faculty_id')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Date Birth')}}</label>
        <input type="date" name="birth_day" class="form-control" value="{{old('birth_day')}}">
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <label for="" class="form-label">{{__('Avatar')}}</label>
        <input class="form-control" type="file" id="avatar" name="avatar" onchange="previewImage(event)">
        <div class="pt-3">
            <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Save')}}</button>
        </div>
</form>
<script>
    function previewImage(event) {
    const input = event.target;
    const imagePreview = document.getElementById('imagePreview');

    if (input.files && input.files[0]) {
    const reader = new FileReader();

    reader.onload = function (e) {
    imagePreview.src = e.target.result;
    imagePreview.style.display = 'block';
    };

    reader.readAsDataURL(input.files[0]);
    } else {
    imagePreview.src = '#';
    imagePreview.style.display = 'none';
    }
    }
    </script>
@endsection
