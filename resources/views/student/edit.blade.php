@extends('layouts.dashboard')
@section('title') {{ __('User') }}   @endsection
@section('sub-title') {{ __('Edit') }} @endsection

@section('content')
    {!! Form::model($student, ['route' => ['students.update', $student->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    <label for="name" class="form-label">{{ __('Full_name') }}</label>
    {!! Form::text('name', $student->user->name, ['class' => 'form-control']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="email" class="form-label">{{ __('Email') }}</label>
    {!! Form::text('email', $student->user->email, ['class' => 'form-control', 'disabled']) !!}
    @error('email')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="phone" class="form-label">{{ __('Phone') }}</label>
    {!! Form::text('phone', $student->phone, ['class' => 'form-control']) !!}
    @error('phone')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="address" class="form-label">{{ __('Address') }}</label>
    {!! Form::text('address', $student->address, ['class' => 'form-control']) !!}
    @error('address')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="gender" class="form-label">{{ __('Gender') }}</label>
    {!! Form::select('gender', ['' => __('Open this select menu'), 'male' => __('Male'), 'female' => __('Female'), 'other' => __('Other')], $student->gender, ['class' => 'form-select']) !!}
    @error('gender')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="faculty_id" class="form-label">{{ __('Faculty') }}</label>
    {!! Form::select('faculty_id', ['' => '-- Chọn khoa --'] + $faculties->pluck('name', 'id')->toArray(), $student->faculty_id, ['class' => 'form-control']) !!}
    @error('faculty_id')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
    <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
    {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar', 'onchange' => 'previewImage(event)']) !!}

    <div class="pt-3">
        {!! Form::button(__('Save'), ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white', 'type' => 'submit']) !!}
    </div>
    {!! Form::close() !!}

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
