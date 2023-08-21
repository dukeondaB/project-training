@extends('layouts.dashboard')
@section('title')
    {{ isset($data) ? __('Edit Subject') : __('Create Subject') }}
@endsection
@section('sub-title')
    {{ isset($data) ? __('Edit') : __('Create') }}
@endsection

@section('content')
    @if(isset($data))
        {!! Form::model($data, ['route' => ['subject.update', $data->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    @else
        {!! Form::open(['route' => 'subject.store', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
    @endif
    @csrf

    <label for="" class="form-label">{{__('Subject name')}}</label>
    {!! Form::text('name', old('name', isset($data) ? $data->name : null), ['class' => 'form-control', 'id' => 'name']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="" class="form-label">{{__('Description')}}</label>
    {!! Form::textarea('description', old('description', isset($data) ? $data->description : null), ['class' => 'form-control', 'id' => 'description', 'rows' => 3]) !!}
    @error('description')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <label for="" class="form-label">{{__('Faculty')}}</label>
    {!! Form::select('faculty_id', ['' => '-- ' . __('Chọn khoa') . ' --'] + $faculties->pluck('name', 'id')->toArray(), isset($data) ? $data->faculty_id : null, ['class' => 'form-control']) !!}
    @error('faculty_id')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <div class="pt-3">
        {!! Form::submit(isset($data) ? __('Save') : __('Update'), ['class' => 'btn btn-info pull-left hidden-sm-down text-white']) !!}
    </div>

    @if(isset($data))
        {!! Form::close() !!}
        {!! Form::open(['route' => ['subject.destroy', $data->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
        {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
        {!! Form::close() !!}
    @else
        {!! Form::close() !!}
    @endif

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this subject?')) {
                document.getElementById('deleteForm').submit();
                return true;
            } else {
                return false;
            }
        }
    </script>
@endsection
