@extends('layouts.dashboard')
@section('title')   {{__('faculty')}}  @endsection
@section('sub-title') {{__('List')}} @endsection
@section('content')

    <div class="">
        <a href="{{route('faculty.create')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Create')}}</a>
    </div>

    <table  class="table table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('faculty Name')}}</th>
            <th>{{__('Details')}}</th>
            <th>{{__('Image')}}</th>

            <th>{{__('Action')}}</th>
        </tr>
        </thead>
        <tbody>
{{--        {{dd($data)}}--}}
        @foreach($data as $item)
            <tr>
                <td>
                    {{$item->id}}
                </td>
                <td>
                    {{$item->name}}
                </td>
                <td>
                    {{$item->detail}}
                </td>
                <td>
                    <img width="150px" src="{{ asset('storage/images/faculty/' . $item->image) }}" alt="Product Image">
                </td>

                <td>
                    <form action="{{ route('faculty.destroy', $item->id) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
                        <a href="{{route('faculty.edit', $item->id)}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Edit')}}</a>
                    </form>
                </td>

            </tr>

        @endforeach



        </tbody>
    </table>

    {{ $data->links() }}

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
