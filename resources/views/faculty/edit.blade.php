@extends('layouts.dashboard')
@section('title')   {{__('faculty')}}  @endsection
@section('sub-title') {{__('Edit')}} @endsection

@section('content')
    <form method="post" action="{{route('faculty.update',$data->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">{{__('Faculty Name')}}</label>
        <input type="text" id="name" class="form-control" name="name" value="{{$data->name}}">
        @error('name')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Description')}}</label>
        <textarea id="description" name="description" class="form-control" rows="3">{{$data->description}}</textarea>
        @error('description')
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <label for="" class="form-label">{{__('Image')}}</label>
        <input  class="form-control" type="file" id="image" name="image" onchange="previewImage(event)">
        @error('image')
        <label for=""  class="form-label">{{__('Faculty')}}</label>
        <select class="form-control" name="faculty_id">
            <option value="">-- Chọn khoa --</option>
            @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}">{{ $faculty->name }}</option>
            @endforeach
        </select>
        @error('faculty_id')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <div class="pt-3">
            <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Update')}}</button>
        </div>
    </form>
    <form action="{{ route('faculty.destroy', $data->id) }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
    </form>

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