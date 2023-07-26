@extends('layouts.dashboard')
@section('title','Profile')
@section('sub-title', 'Profile')
@section('content')
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="mt-4"> <img src="{{ asset('storage/images/user/' . $user->avatar) }}" class="img-circle"
                                                       width="150" />
                                <h4 class="card-title mt-2">{{$user->full_name}}</h4>
                                <h6 class="card-subtitle"></h6>
                                <div class="row text-center justify-content-md-center">

                                </div>
                                <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">

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
                            <form method="post" action="{{route('profile.update', $user->id)}}" enctype=multipart/form-data>
                                @csrf
                                @method('PUT')
                                <label for="" class="form-label">{{__('Full name')}}</label>
                                <input type="text" id="full_name" value="{{$user->full_name}}" class="form-control" name="full_name">
                                @error('full_name')
                                <p class="error" style="color: red">{{ $message }}</p>
                                @enderror
                                <label for="" class="form-label">Email</label>
                                <input type="text" disabled value="{{$user->email}}" id="email" class="form-control" name="email">
                                @error('email')
                                <p class="error" style="color: red">{{ $message }}</p>
                                @enderror
                                <label for="" class="form-label">{{__('Phone')}}</label>
                                <input type="text" id="phone" value="{{$user->phone}}" class="form-control" name="phone">
                                @error('phone')
                                <p class="error" style="color: red">{{ $message }}</p>
                                @enderror
                                <label for="" class="form-label">{{__('Address')}}</label>
                                <input type="text" id="address" value="{{$user->address}}" class="form-control" name="address">
                                @error('full_name')
                                <p class="error" style="color: red">{{ $message }}</p>
                                @enderror
                                <label for="" class="form-label">{{__('Gender')}}</label>
                                <select class="form-select" name="gender" aria-label="Default select example">
                                    <option selected>{{__('Open this select menu')}}</option>
                                    <option value="male" {{$user->gender === 'male' ? 'selected' : ''}}>{{_('Male')}}</option>
                                    <option value="female" {{$user->gender === 'female' ? 'selected' : ''}}>{{__('Female')}}</option>
                                    <option value="other" {{$user->gender === 'other' ? 'selected' : ''}}>{{__('Other')}}</option>
                                </select>
                                @error('full_name')
                                <p class="error" style="color: red">{{ $message }}</p>
                                @enderror
                                <label for="" class="form-label">{{__('Avatar')}}</label>
                                <input class="form-control" type="file" id="avatar" name="avatar" onchange="previewImage(event)">
                                <div class="pt-3">
                                    <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">
                                        {{__('Save')}}</button>
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
                        </div>
                    </div>
                </div>
@endsection
