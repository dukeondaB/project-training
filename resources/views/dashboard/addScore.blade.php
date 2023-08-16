@extends('layouts.dashboard')
@section('title')
    {{__('User')}}
@endsection
@section('sub-title')
    {{__('Add Point')}}
@endsection
@section('content')

    <div class="">
        {!! Html::linkRoute('students.index', __('Go back'), [], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
        {!! Html::linkRoute('student.add-points', __('Add Points'), ['studentId' => $student->id], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
    </div>
    <table>
        <tr>
            <td>{{__('Full name')}}:</td>
            <td>{{$student->user->name}}</td>
        </tr>
    </table>

    <table class="table table-sm">
        <thead>
        <tr>
            <th>
                #
            </th>
            <th>
                {{__('Subject')}}
            </th>
            <th>
                {{__('Score')}}
            </th>
            <th>
                {{__('Action')}}
            </th>
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
                    {{$subjectPoint[$item->id]}}
                </td>
                <td>
                    {!! Form::open(['route' => ['student.update-point', 'student_id' => $student->id, 'subject_id'=> $item->id], 'method' => 'PUT']) !!}
                    {!! Form::text('point', null, ['placeholder' => __('Enter Point'), 'class' => 'form-control', 'style' => 'width:200px']) !!}
                    {!! Form::submit(__('Update point'), ['id' => 'update-score-btn', 'class' => 'btn btn-success']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
