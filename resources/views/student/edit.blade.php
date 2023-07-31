@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title') {{__('Edit')}} @endsection

@section('content')
    <form method="post" action="{{route('student.update', $data->id)}}" enctype=multipart/form-data>
        @csrf
        @method('PUT')
        <label for="" class="form-label">{{__('Full name')}}</label>
        <input type="text" id="full_name" value="{{$data->full_name}}" class="form-control" name="full_name">
        @error('full_name')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label" >Email</label>
        <input type="text" value="{{$data->email}}" disabled id="email" class="form-control" name="email">
        @error('email')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Phone')}}</label>
        <input type="text" id="phone" value="{{$data->phone}}" class="form-control" name="phone">
        @error('phone')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Address')}}</label>
        <input type="text" id="address" value="{{$data->address}}" class="form-control" name="address">
        @error('address')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Gender')}}</label>
        <select class="form-select" name="gender" aria-label="Default select example">
            <option selected>{{__('Open this select menu')}}</option>
            <option value="male" {{$data->gender === 'male' ? 'selected' : ''}}>{{__('Male')}}</option>
            <option value="female" {{$data->gender === 'female' ? 'selected' : ''}}>{{__('Female')}}</option>
            <option value="other" {{$data->gender === 'other' ? 'selected' : ''}}>{{__('Other')}}</option>
        </select>
        @error('gender')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <label for="" class="form-label">Avatar</label>
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
