@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title','List')
@section('content')

    <div class="">
        <a href="{{route('student.create')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Create')}}</a>
    </div>
    <div>
        <form class="form-control-sm" action="{{ route('student.index') }}" method="GET">
            @csrf
            <label for="minAge" class="">{{__('Min Age')}}:</label>
            <input type="number" name="minAge" class="form-control-sm" id="minAge" min="0">

            <label for="maxAge">{{__('Max Age')}}:</label>
            <input type="number" name="maxAge" class="form-control-sm" id="maxAge" min="0">

            <button class="btn btn-success" type="submit">{{__("Filter")}}</button>
        </form>
    </div>
    <table class="table table-sm">
        <thead>
        <tr class="text-center">
            <th>#</th>
            <th>{{__('Full Name')}}</th>
            <th>{{__('Email')}}</th>
            <th>{{__('Phone')}}</th>
            <th>{{__('Avatar')}}</th>
            <th>{{__('Address')}}</th>
            <th>{{__('Age')}}</th>
            <th>{{__('Gender')}}</th>
            <th>{{__('Subject register count')}}</th>
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
                    {{$item->user->name}}
                </td>
                <td>
                    {{$item->user->email}}
                </td>
                <td>
                    {{$item->phone}}
                </td>
                <td>
                    <img width="150px" src="{{ asset('storage/images/student/' . $item->avatar) }}" alt="Product Image">
                </td>
                <td>{{$item->address}}</td>
                <td>{{$item->age}}</td>
                <td>{{__($item->gender)}}</td>
                <td>
                    @php
                        $count = $countRegisterCourse->countRegisterCourse($item->id);
                    @endphp

                    @if ($count !== null && $count !== '')
                        {{$count}}
                        <a href="{{ route('list-subject-by-student', ['student_id' => $item->id])}}"> <i class="fa fa-bars"></i> </a>
                    @else
                        {{__('N/A')}}
                    @endif
                </td>
                <td>
                    <form action="{{ route('student.destroy', $item->id) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
                        <a href="{{route('student.edit', $item->id)}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Edit')}}</a>
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