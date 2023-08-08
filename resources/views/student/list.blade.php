@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title','List')
@section('content')

    <div class="row">
        <div>
            {!! Html::linkRoute('students.create', __('Create'), [], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
        </div>
    </div>

    <div class="row">
        <div>
            {!! Form::open(['route' => 'students.index', 'method' => 'GET', 'class' => 'form-control-sm']) !!}
            <label for="minAge">{{__('Min Age')}}:</label>
            {!! Form::number('minAge', null, ['class' => 'form-control-sm', 'id' => 'minAge', 'min' => 0]) !!}

            <label for="maxAge">{{__('Max Age')}}:</label>
            {!! Form::number('maxAge', null, ['class' => 'form-control-sm', 'id' => 'maxAge', 'min' => 0]) !!}

            <button class="btn btn-success" type="submit">{{__("Filter")}}</button>
            {!! Form::close() !!}
        </div>
        <div>
            {!! Form::open(['route' => 'students.index', 'method' => 'GET', 'class' => 'form-control-sm']) !!}
            <label for="minPoint">{{__('Min Point')}}:</label>
            {!! Form::number('minPoint', null, ['class' => 'form-control-sm', 'id' => 'minPoint', 'min' => 0]) !!}

            <label for="maxPoint">{{__('Max point')}}:</label>
            {!! Form::number('maxPoint', null, ['class' => 'form-control-sm', 'id' => 'maxPoint', 'min' => 0]) !!}

            <button class="btn btn-success" type="submit">{{__("Filter")}}</button>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="grid">
        <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">Thêm nhanh</button>
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
            <th>{{__('Average point')}}</th>
            <th>{{__('Subject register count')}}</th>
            <th>{{__('Action')}}</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $item)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ $item->user->name }}
                </td>
                <td>
                    {{ $item->user->email }}
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
                <td>{{$item->total_point === null ? 'N/A' : $item->total_point}}</td>
                <td>
                    @if (count($item->studentSubjects) !== null && count($item->studentSubjects) !== '')
                        {{count($item->studentSubjects)}}
                        <a href="{{ route('student.subject-list', ['student_id' => $item->id])}}"> <button class="btn btn-success">Xem chi tiết</button></a>
                    @else
                        {{__('N/A')}}
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['students.destroy', $item->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
                    {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
                    {!! Html::linkRoute('students.edit', __('Edit'), ['student' => $item->id], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    @if (!$isRegistrationComplete = count($item->studentSubjects) !== null && count($item->studentSubjects) >= $totalSubjectsInFaculty = $item->faculty ? count($item->faculty->subjects) : 0)
                        {!! Form::open(['route' => ['send-notification', 'studentId' => $item->id], 'method' => 'POST']) !!}
                        {!! Form::submit(__('Gửi email'), ['class' => 'btn btn-success']) !!}
                        {!! Form::close() !!}
                    @else
                        <span class="text-success">{{__('Đã đăng ký đủ')}}</span>
                    @endif
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
