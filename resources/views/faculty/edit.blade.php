@extends('layouts.dashboard')
@section('title')   {{__('faculty')}}  @endsection
@section('sub-title') {{__('Edit')}} @endsection

@section('content')
    {!! Form::model($data, ['route' => ['faculty.update', $data->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    @csrf
    <label for="name" class="form-label">{{__('Faculty Name')}}</label>
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror
    <label for="description" class="form-label">{{__('Description')}}</label>
    {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
    @error('description')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror
    <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
    <div class="pt-3">
        {!! Form::submit(__('Update'), ['class' => 'btn btn-info text-white']) !!}
    </div>
    {!! Form::close() !!}

    {!! Form::open(['route' => ['faculty.destroy', $data->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
    @csrf
    @method('DELETE')
    {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
    {!! Form::close() !!}

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
