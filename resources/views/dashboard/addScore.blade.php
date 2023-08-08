@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title') {{__('Add Point')}}  @endsection
@section('content')
    <style>
        .inline-row {
            display: inline-flex; /* Kiểu hiển thị inline flexbox cho hàng */
            align-items: center; /* Căn giữa các phần tử trong hàng */
            margin-bottom: 10px; /* Khoảng cách giữa các hàng */
        }

        .inline-row select,
        .inline-row input,
        .inline-row button {
            margin-right: 5px; /* Khoảng cách giữa các phần tử trong hàng */
        }

        .inline-row button {
            padding: 2px 6px; /* Kích thước nút "X" */
            line-height: 1; /* Đặt chiều cao của nút "X" bằng 1 để nút hiển thị đúng */
        }
    </style>

    <div class="">
        {!! Html::linkRoute('students.index', __('Go back'), [], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
        <button type="button" class="btn btn-primary" id="openModalButton">Nhập điểm</button>
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
                    {!! Form::open(['route' => ['student.update-point', 'student_id' => $student->id, 'subject_id'=> $item->id], 'method' => 'PUT']) !!}
                    {!! Form::text('point', null, ['placeholder' => __('Enter Point')]) !!}
                    {!! Form::submit(__('Update point'), ['id' => 'update-score-btn']) !!}
                    {!! Form::close() !!}
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="modal" id="scoreModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nhập điểm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                {!! Form::open(['route' => 'student.save-points', 'method' => 'POST']) !!}
                {!! Form::hidden('student_id', $student->id) !!}
                <div class="modal-body" id="modalBody">
                    <!-- Dòng đầu tiên -->
                    <div class="inline-row">
                        {!! Form::select('subject_id[]', ['' => '-- Chọn môn học --'] + $subject->pluck('name', 'id')->toArray(), null) !!}
                        {!! Form::text('point[]', null, ['placeholder' => __('Point')]) !!}
                    </div>
                    <!-- Không cần nút "X" cho dòng đầu tiên -->

                    <!-- Các dòng tiếp theo -->
                    <div class="inline-row" id="inputRowTemplate" style="display: none;">
                        {!! Form::select('subject_id[]', ['' => '-- Chọn môn học --'] + $subject->pluck('name', 'id')->toArray(), null) !!}
                        {!! Form::text('point[]', null, ['placeholder' => __('Point')]) !!}
                        <button type="button" class="btn btn-danger deleteRowButton">X</button>
                    </div>

                    {!! Form::button('+', ['type' => 'button', 'class' => 'btn btn-primary', 'id' => 'addRowButton']) !!}
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                    {!! Form::submit(__('Lưu điểm'), ['class' => 'btn btn-primary', 'id' => 'saveScoreButton']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <script>
        document.getElementById('openModalButton').addEventListener('click', function() {
            $('#scoreModal').modal('show');
        });

        document.getElementById('addRowButton').addEventListener('click', function() {
            let rowTemplate = document.getElementById('inputRowTemplate');
            let newRow = rowTemplate.cloneNode(true);
            newRow.style.display = 'flex'; // Hiển thị dòng mới

            let inputs = newRow.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.value = '';
            });

            let modalBody = document.getElementById('modalBody');
            modalBody.insertBefore(newRow, document.getElementById('addRowButton'));
        });

        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('deleteRowButton')) {
                let row = event.target.parentElement;
                if (!row.classList.contains('row-template')) {
                    row.remove(); // Xóa dòng khi không phải dòng mẫu (không xóa dòng đầu tiên)
                }
            }
        });

        document.getElementById('saveScoreButton').addEventListener('click', function() {
            $('#scoreModal').modal('hide');
        });
    </script>


@endsection
