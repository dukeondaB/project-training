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
                        @if (\Illuminate\Support\Facades\Auth::user()->student)
                            <img src="{{ asset('storage/images/student/' . \Illuminate\Support\Facades\Auth::user()->student->avatar) }}" width="200px" alt="user" class="" />
                        @else
                            <img src="{{ asset('path/to/default/avatar.png') }}" alt="user" class="" /> <!-- Đường dẫn đến hình ảnh mặc định -->
                        @endif
                        <h4 class="card-title mt-2">{{\Illuminate\Support\Facades\Auth::user()->name}}</h4>
                        <h6 class="card-subtitle"></h6>
                        <div class="row text-center justify-content-md-center">
                        </div>
                        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
                        {!! Form::open(['route' => ['profiles.update', \Illuminate\Support\Facades\Auth::user()->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                        {!! Form::label('avatar', __('Avatar'), ['class' => 'form-label']) !!}
                        {!! Form::file('avatar', ['class' => 'form-control', 'onchange' => 'previewImage(event)']) !!}
                        <div class="pt-3">
                            {!! Form::submit(__('Save'), ['class' => 'btn btn-info pull-left hidden-sm-down text-white']) !!}
                        </div>
                        {!! Form::close() !!}
                    </center>
                </div>
            </div>
        </div>
        <div class="col-lg-8 col-xlg-9 col-md-7">
            <div class="card">
                <div class="card-body">
                    {!! Form::label('full_name', __('Full name'), ['class' => 'form-label']) !!}
                    {!! Form::text('full_name', \Illuminate\Support\Facades\Auth::user()->name, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                    {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                    {!! Form::text('email', \Illuminate\Support\Facades\Auth::user()->email, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                    {!! Form::label('phone', __('Phone'), ['class' => 'form-label']) !!}
                    {!! Form::text('phone', optional(\Illuminate\Support\Facades\Auth::user()->student)->phone, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                    {!! Form::label('address', __('Address'), ['class' => 'form-label']) !!}
                    {!! Form::text('address', optional(\Illuminate\Support\Facades\Auth::user()->student)->address, ['class' => 'form-control', 'disabled' => 'disabled']) !!}

                    {!! Form::label('gender', __('Gender'), ['class' => 'form-label']) !!}
                    {!! Form::select('gender', [optional(\Illuminate\Support\Facades\Auth::user()->student)->gender => optional(\Illuminate\Support\Facades\Auth::user()->student)->gender], null, ['class' => 'form-select', 'disabled' => 'disabled']) !!}

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
    </div>
@endsection
