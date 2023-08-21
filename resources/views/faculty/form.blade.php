@extends('layouts.dashboard')
@section('title')
    {{ isset($data) ? __('Edit Faculty') : __('Create Faculty') }}
@endsection
@section('sub-title')
    {{ isset($data) ? __('Edit') : __('Create') }}
@endsection

@section('content')
    @if(isset($data))
        {!! Form::model($data, ['route' => ['faculties.update', $data->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    @else
        {!! Form::open(['route' => 'faculties.store']) !!}
    @endif
    @csrf

    {!! Form::label('name', __('Faculty Name'), ['class' => 'form-label']) !!}
    {!! Form::text('name', old('name', isset($data) ? $data->name : null), ['class' => 'form-control']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!}
    {!! Form::textarea('description', old('description', isset($data) ? $data->description : null), ['class' => 'form-control', 'rows' => 3]) !!}
    @error('description')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    @if(isset($data))
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <div class="pt-3">
            {!! Form::submit(__('Update'), ['class' => 'btn btn-info text-white']) !!}
        </div>
    @else
        <div class="pt-3">
            {!! Form::submit(__('Save'), ['class' => 'btn btn-info text-white']) !!}
        </div>
    @endif

    @if(isset($data))
        {!! Form::close() !!}
        {!! Form::open(['route' => ['faculties.destroy', $data->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
        @csrf
        @method('DELETE')
        {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
        {!! Form::close() !!}
    @else
        {!! Form::close() !!}
    @endif

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this faculty?')) {
                document.getElementById('deleteForm').submit();
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection
