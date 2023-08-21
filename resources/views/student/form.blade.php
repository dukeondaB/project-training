@extends('layouts.dashboard')
@section('title')
    {{ isset($student) ? __('Edit User') : __('Create User') }}
@endsection
@section('sub-title')
    {{ isset($student) ? __('Edit') : __('Create') }}
@endsection

@section('content')
    @if(isset($student))
        {!! Form::model($student, ['route' => ['students.update', $student->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    @else
        {!! Form::open(['route' => 'students.store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    @endif
    @csrf

    <label for="name" class="form-label">{{ __('Full Name') }}</label>
    {!! Form::text('name', old('name', isset($student) ? $student->user->name : null), ['class' => 'form-control']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="email" class="form-label">{{ __('Email') }}</label>
    {!! Form::text('email', old('email', isset($student) ? $student->user->email : null), ['class' => 'form-control', 'disabled' => isset($student)]) !!}
    @error('email')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="phone" class="form-label">{{ __('Phone') }}</label>
    {!! Form::text('phone', old('phone', isset($student) ? $student->phone : null), ['class' => 'form-control']) !!}
    @error('phone')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="address" class="form-label">{{ __('Address') }}</label>
    {!! Form::text('address', old('address', isset($student) ? $student->address : null), ['class' => 'form-control']) !!}
    @error('address')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="gender" class="form-label">{{ __('Gender') }}</label>
    {!! Form::select('gender', ['' => __('Open this select menu'), 'male' => __('Male'), 'female' => __('Female'), 'other' => __('Other')], old('gender', isset($student) ? $student->gender : null), ['class' => 'form-select']) !!}
    @error('gender')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="faculty_id" class="form-label">{{ __('Faculty') }}</label>
    {!! Form::select('faculty_id', ['' => '-- Chọn khoa --'] + $faculties->pluck('name', 'id')->toArray(), old('faculty_id', isset($student) ? $student->faculty_id : null), ['class' => 'form-control']) !!}
    @error('faculty_id')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    @if(isset($student))
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <label for="avatar" class="form-label">{{ __('Avatar') }}</label>
        {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar', 'onchange' => 'previewImage(event)']) !!}
    @endif

    <div class="pt-3">
        {!! Form::button(__('Save'), ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white', 'type' => 'submit']) !!}
    </div>
    {!! Form::close() !!}

    @if(isset($student))
        {!! Form::open(['route' => ['students.destroy', $student->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
        {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
        {!! Form::close() !!}
    @endif

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

        function confirmDelete() {
            if (confirm('Are you sure you want to delete this user?')) {
                document.getElementById('deleteForm').submit();
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection
