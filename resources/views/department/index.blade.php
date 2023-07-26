@extends('layouts.dashboard')
@section('title')   {{__('Department')}}  @endsection
@section('sub-title') {{__('List')}} @endsection
@section('content')
    @can('admin-access', Auth()->user())
    <div class="">
        <a href="{{route('department.create')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Create')}}</a>
    </div>
    @endcan
    <table  class="table table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('Department Name')}}</th>
            <th>{{__('Details')}}</th>
            <th>{{__('Image')}}</th>
            @can('admin-access', Auth()->user())
            <th>{{__('Action')}}</th>@endcan
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
                    <img width="150px" src="{{ asset('storage/images/department/' . $item->image) }}" alt="Product Image">
                </td>
                @can('admin-access', Auth()->user())
                <td>
                    <form action="{{ route('department.destroy', $item->id) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
                        <a href="{{route('department.edit', $item->id)}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Edit')}}</a>
                    </form>
                </td>
                @endcan
            </tr>

        @endforeach



        </tbody>
    </table>

    {{ $data->links() }}

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

@endsection
