@extends('layouts.dashboard')
@section('title')   {{__('Department')}}  @endsection
@section('sub-title') {{__('Edit')}} @endsection

@section('content')
    <form method="post" action="{{route('department.update',$data->id)}}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <label for="" class="form-label">{{__('Department name')}}</label>
        <input type="text" id="name" class="form-control" name="name" value="{{$data->name}}">
        @error('name')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <label for="" class="form-label">{{__('Detail')}}</label>
        <textarea id="detail" name="detail" class="form-control" rows="3">{{$data->detail}}</textarea>
        @error('detail')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
        <label for="" class="form-label">{{__('Image')}}</label>
        <input  class="form-control" type="file" id="image" name="image" onchange="previewImage(event)">
        @error('image')
        <p class="error" style="color: red">{{ $message }}</p>
        @enderror
        <div class="pt-3">
            <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Update')}}</button>
        </div>
    </form>
    <form action="{{ route('department.destroy', $data->id) }}" method="POST" id="deleteForm">
        @csrf
        @method('DELETE')

        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
    </form>

    <script>
        function confirmDelete() {
            if (confirm('Are you sure you want to delete this department?')) {
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
