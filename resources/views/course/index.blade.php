@extends('layouts.dashboard')
@section('title') {{__('Course')}}   @endsection
@section('sub-title') {{__('List')}} @endsection
@section('content')
    @can('admin-access', Auth()->user())
    <div class="">
        <a href="{{route('course.create')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Create')}}</a>
    </div>
    @endcan

    <table class="table table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('Course Name')}}</th>
            <th>{{__('Detail')}}</th>
            <th>{{__('Status')}}</th>
            <th>{{__('Image')}}</th>
            @can('user-access', Auth()->user())<th>{{__('Score')}}</th>@endcan
            @can('admin-access', Auth()->user())<th>{{__('Action')}}</th>@endcan
        </tr>
        </thead>
        <tbody>
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
                    {{$item->status}}
                </td>
                <td>
                    <img width="150px" src="{{ asset('storage/images/courses/' . $item->image) }}" alt="Product Image">
                </td>
                @can('user-access', Auth()->user())
                    <td>
                        @php
                            $userScore = $courseRepository->getUserScoreInCourse($item->id);
                        @endphp

                        @if ($userScore !== null && $userScore !== '')
                            {{$userScore}}
                        @else
                            {{__('N/A')}}
                        @endif
                    </td>
                @endcan




            @can('admin-access', Auth()->user())
                <td>
                    <form action="{{ route('course.destroy', $item->id) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
                        <a href="{{route('course.edit', $item->id)}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Edit')}}</a>
                    </form>
                </td>
                    @endcan
                @if (in_array($item->id, $isRegister->pluck('id')->toArray()))
                    <td>
                        <span>Đã đăng ký</span>
                    </td>
                @else
                    @can('user-access', Auth()->user())
                        <td>
                            <form action="{{route('course-register', $item->id)}}" method="POST" id="registerForm" >
                                @csrf

                                <button class="btn btn-success" {{ in_array($item->id, $isRegister->pluck('id')->toArray()) ? 'disabled' : '' }}>Đăng kí</button>
                            </form>
                        </td>
                    @endcan
                @endif
            </tr>

        @endforeach

        </tbody>
    </table>
    {{ $data->links() }}


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
@endsection
