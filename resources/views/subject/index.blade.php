@extends('layouts.dashboard')
@section('title') {{__('Subject')}}   @endsection
@section('sub-title') {{__('List')}} @endsection
@section('content')

    <div class="">
        <a href="{{route('subject.create')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Create')}}</a>
    </div>
    <div class="pt-5">
        <form class="form-control-sm" action="{{ route('subject-import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="file" class="form-control" name="import_file" required>
            <button type="submit" class="btn-success">Import</button>
        </form>
    </div>
    <table class="table table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('Subject Name')}}</th>
            <th>{{__('Description')}}</th>
            <th>{{__('Faculty')}}</th>
            <th>{{__('Point')}}</th>
            <th>{{__('Action')}}</th>
            <th></th>
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
                    {{$item->description}}
                </td>
                <td>
                    {{$item->faculty->name}}
                </td>
{{--                @can('student-access', Auth()->student())--}}
                    <td>
                        @php
                            $studentPoint = $subjectRepository->getStudentPointInSubject($item->id);
                        @endphp

                        @if ($studentPoint !== null && $studentPoint !== '')
                            {{$studentPoint}}
                        @else
                            {{__('N/A')}}
                        @endif
{{--                    </td>--}}
{{--                @endcan--}}





                <td>
                    <form action="{{ route('subject.destroy', $item->id) }}" method="POST" id="deleteForm">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger" onclick="return confirmDelete()">{{__('Delete')}}</button>
                        <a href="{{route('subject.edit', $item->id)}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Edit')}}</a>
                    </form>
                </td>

                @if ($user->student->isSubjectRegistered($item->id))
                    <td>{{__('Registered')}}</td>
                @else
                    <td>
                        <form action="{{route('subject-register', $item->id)}}" method="POST" id="registerForm" >
                            @csrf

                            <button class="btn btn-success" {{ $user->student->isSubjectRegistered($item->id) === true ? 'disabled' : '' }}>Đăng kí</button>
                        </form>
                    </td>
                @endif
{{--                    @can('student-access', Auth()->student())--}}

{{--                    @endcan--}}

            </tr>

        @endforeach

        </tbody>
    </table>
    {{ $data->links() }}


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
