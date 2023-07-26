@extends('layouts.dashboard')
@section('title') {{__('Course')}}   @endsection
@section('sub-title') {{__('Edit')}} @endsection

@section('content')
    <form method="post" action="{{route('course.update',$data->id)}}" enctype=multipart/form-data>
        @csrf
        @method('PUT')
        <label for="" class="form-label">{{__('Course name')}}</label>
        <input type="text" id="name" class="form-control" name="name" value="{{$data->name}}">
        @error('name')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Detai')}}l</label>
        <textarea id="detail" name="detail" class="form-control" rows="3">{{$data->detail}}</textarea>
        @error('detail')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <label for="" class="form-label">{{__('Image')}}</label>
        <input class="form-control" type="file" id="image" name="image" onchange="previewImage(event)">
        @error('image')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Status')}}</label>
        <select class="form-select" name="status" aria-label="Default select example">
            <option value="open" {{$data->status === 'open' ? 'selected': ''}}>{{__('Open')}}</option>
            <option value="in_progress" {{$data->status === 'in_progress' ? 'selected': ''}}>{{__('In Progress')}}</option>
            <option value="completed" {{$data->status === 'completed' ? 'selected': ''}}>{{__('Completed')}}</option>
            <option value="cancel" {{$data->status === 'cancel' ? 'selected': ''}}>{{__('Cancel')}}</option>
        </select>
        <div class="pt-3">
            <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Save')}}</button>
        </div>
    </form>


    <form action="{{ route('course.destroy', $data->id) }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
    </form>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this course?')) {
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
