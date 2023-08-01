@extends('layouts.dashboard')
@section('title',) {{__('Profile')}}     @endsection

    @section('sub-title', 'Profile')
@section('content')
    <div class="row">
        <!-- Column -->
        <div class="col-lg-4 col-xlg-3 col-md-5">
            <div class="card">
                <div class="card-body">
                    <center class="mt-4">
                        @if ($user->student)
                            <img src="{{ asset('storage/images/student/' . $user->student->avatar) }}" alt="user" class="" />
                    <center class="mt-4">
                        @if ($user->student)
                            <img src="{{ asset('storage/images/student/' . $user->student->avatar) }}" width="200px" alt="user" class="" />
                        @else
                            <img src="{{ asset('path/to/default/avatar.png') }}" alt="user" class="" /> <!-- Đường dẫn đến hình ảnh mặc định -->
                        @endif
                        <h4 class="card-title mt-2">{{$user->name}}</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="row text-center justify-content-md-center">
                        </div>
                        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
                        <form method="post" action="{{route('profile.update', $user->id)}}" enctype=multipart/form-data>
                            @csrf
                            @method('PUT')

                            <label for="" class="form-label">{{__('Avatar')}}</label>
                            <input class="form-control" type="file" id="avatar" name="avatar"
                                   onchange="previewImage(event)">
                            <div class="pt-3">
                                <button
                                    class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">
                                    {{__('Save')}}</button>
                            </div>
                        </form>

                    </center>
                </div>
            </div>
        </div>
        <!-- Column -->
        <!-- Column -->
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <!-- Tab panes -->
                <div class="card-body">

                    <label for="" class="form-label">{{__('Full name')}}</label>
                    <input type="text" id="full_name" disabled value="{{$user->name}}" class="form-control"
                           name="full_name">

                    <label for="" class="form-label">Email</label>
                    <input type="text" disabled value="{{$user->email}}" id="email" class="form-control" name="email">

                    <label for="" class="form-label">{{__('Phone')}}</label>
                    <input type="text" id="phone" disabled value="{{ optional($user->student)->phone }}" class="form-control" name="phone">

                    <label for="" class="form-label">{{__('Address')}}</label>
                    <input type="text" id="address" disabled value="{{ optional($user->student)->address }}" class="form-control" name="address">
                    <label for="" class="form-label">{{__('Gender')}}</label>
                    <select class="form-select" disabled name="gender" aria-label="Default select example">
                        <option selected>{{ optional($user->student)->gender }}</option>

                    </select>
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
                </div>
            </div>
        </div>
@endsection
