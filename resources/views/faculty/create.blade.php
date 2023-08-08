@extends('layouts.dashboard')
@section('title')   {{__('Faculty')}}  @endsection
@section('sub-title') {{__('Create')}} @endsection

@section('content')
    {!! Form::open(['route' => 'faculty.store']) !!}
    {!! Form::label('name', __('Faculty Name'), ['class' => 'form-label']) !!}
    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror
    {!! Form::label('description', __('Description'), ['class' => 'form-label']) !!}
    {!! Form::textarea('description', old('description'), ['class' => 'form-control', 'rows' => 3]) !!}
    @error('description')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror
    <div class="pt-3">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-info text-white']) !!}
    </div>
    {!! Form::close() !!}
@endsection
