@extends('layouts.dashboard')
@section('title') {{__('Subject')}}   @endsection
@section('sub-title') {{__('Edit')}} @endsection

@section('content')
    {!! Form::open(['route' => ['subject.update', $data->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
    @csrf
    <label for="" class="form-label">{{__('Subject name')}}</label>
    {!! Form::text('name', $data->name, ['class' => 'form-control', 'id' => 'name']) !!}
    @error('name')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror
    <label for="" class="form-label">{{__('Description')}}</label>
    {!! Form::textarea('description', $data->description, ['class' => 'form-control', 'id' => 'description', 'rows' => 3]) !!}
    @error('description')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror
    <label for="" class="form-label">{{__('Faculty')}}</label>
    {!! Form::select('faculty_id', ['' => '-- ' . __('Chọn khoa') . ' --'] + $faculties->pluck('name', 'id')->toArray(), $data->faculty_id, ['class' => 'form-control']) !!}
    @error('faculty_id')
    <p class="error" style="color: red">{{ $message }}</p>
    @enderror

    <div class="pt-3">
        {!! Form::submit(__('Save'), ['class' => 'btn btn-info pull-left hidden-sm-down text-white']) !!}
    </div>
    {!! Form::close() !!}

    {!! Form::open(['route' => ['subject.destroy', $data->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
    {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
    {!! Form::close() !!}


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
