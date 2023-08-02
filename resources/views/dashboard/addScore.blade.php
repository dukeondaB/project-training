@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title','Add Score')
@section('content')

    <div class="">
        <a href="{{route('student.index')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Go back')}}</a>
        <button>Thêm điểm nhanh</button>
    </div>

{{--    <div>--}}
{{--        Sinh viên :--}}
{{--        Mã Sinh viên :--}}
{{--    </div>--}}
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
                @php
                    $userScore = $subjectRepository->getStudentPoint($student->id,$item->id);
                @endphp

                @if ($userScore !== null && $userScore !== '')
                    {{$userScore}}
                @else
                    {{__('N/A')}}
                @endif
            </td>
            <td>
                <form method="post" action="{{route('update-point', ['student_id' => $student->id, 'subject_id'=> $item->id])}}">
                    @csrf
                    @method("PUT")
                    <input type="text" id="point" name="point" placeholder="Enter score">
                    <button id="update-score-btn">Update Score</button>
                </form>
{{--                <input type="hidden" id="user-id-input" value="{{ $student->id }}">--}}
{{--                <!-- Giá trị của $courseId -->--}}
{{--                <input type="hidden" id="course-id-input" value="{{ $item->id }}">--}}


            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
{{--    <script src="{{asset('vendor/jquery/jquery-3.2.1.min')}}"></script>--}}

{{--    <script>--}}
{{--        $('#update-score-btn').click(function() {--}}
{{--            var userId = $('#student-id-input').val();--}}
{{--            var courseId = $('#subject-id-input').val();--}}
{{--            var score = $('#score-input').val();--}}

{{--            $.ajax({--}}
{{--                type: 'POST',--}}
{{--                url: '{{ route('update-score', ['userId' => $student->id, 'courseId' => $item->id]) }}',--}}
{{--                data: {--}}
{{--                    _token: '{{ csrf_token() }}', // Thêm token CSRF nếu bạn sử dụng CSRF protection--}}
{{--                    score: score--}}
{{--                },--}}
{{--                success: function(response) {--}}
{{--                    alert(response.message);--}}
{{--                    console.log(userId,courseId, courseId);--}}
{{--                },--}}
{{--                error: function(xhr, status, error) {--}}
{{--                    console.error(xhr.responseText);--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}
@endsection
