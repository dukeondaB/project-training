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
        <a href="{{route('students.index')}}" class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Go back')}}</a>
        <button type="button" class="btn btn-primary" id="openModalButton">Nhập điểm</button>
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
                <form method="post" action="{{route('student.update-point', ['student_id' => $student->id, 'subject_id'=> $item->id])}}">
                    @csrf
                    @method("PUT")
                    <input type="text" id="point" name="point" placeholder="{{__('Enter Point')}}">
                    <button id="update-score-btn">{{__('Update point')}}</button>
                </form>
{{--                <input type="hidden" id="user-id-input" value="{{ $student->id }}">--}}
{{--                <!-- Giá trị của $courseId -->--}}
{{--                <input type="hidden" id="course-id-input" value="{{ $item->id }}">--}}


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
                <form action="{{ route('student.save-points') }}" method="POST">
                    @csrf
                    <input type="hidden" name="student_id" value="{{ $student->id }}">
                    <div class="modal-body" id="modalBody">
                        <!-- Dòng đầu tiên -->
                        <div class="inline-row">
                            <select class="" name="subject_id[]">
                                <option value="">-- Chọn môn học --</option>
                                @foreach($subject as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="point[]" value="" placeholder="{{__('Point')}}">
                        </div>
                        <!-- Không cần nút "X" cho dòng đầu tiên -->

                        <!-- Các dòng tiếp theo -->
                        <div class="inline-row" id="inputRowTemplate" style="display: none;">
                            <select class="" name="subject_id[]">
                                <option value="">-- Chọn môn học --</option>
                                @foreach($subject as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <input type="text" name="point[]" placeholder="{{__('Point')}}">
                            <button type="button" class="btn btn-danger deleteRowButton">X</button>
                        </div>

                        <button type="button" class="btn btn-primary" id="addRowButton">+</button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="saveScoreButton">Lưu điểm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('openModalButton').addEventListener('click', function() {
            // Thực hiện các bước để lấy thông tin môn học và sinh viên cần nhập điểm
            // Sau đó, cập nhật nội dung của modal với thông tin vừa lấy được

            // Hiển thị modal
            $('#scoreModal').modal('show');
        });

        document.getElementById('addRowButton').addEventListener('click', function() {
            // Lấy dòng mẫu và tạo một bản sao của nó
            let rowTemplate = document.getElementById('inputRowTemplate');
            let newRow = rowTemplate.cloneNode(true);
            newRow.style.display = 'flex'; // Hiển thị dòng mới

            // Xóa giá trị trong input của dòng mới
            let inputs = newRow.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.value = '';
            });

            // Thêm dòng mới vào modal trước nút "+"
            let modalBody = document.getElementById('modalBody');
            modalBody.insertBefore(newRow, document.getElementById('addRowButton'));
        });

        // Xử lý khi nhấn nút "X"
        document.addEventListener('click', function(event) {
            if (event.target && event.target.classList.contains('deleteRowButton')) {
                let row = event.target.parentElement;
                if (!row.classList.contains('row-template')) {
                    row.remove(); // Xóa dòng khi không phải dòng mẫu (không xóa dòng đầu tiên)
                }
            }
        });

        document.getElementById('saveScoreButton').addEventListener('click', function() {
            // Xử lý logic khi người dùng nhấn nút "Lưu điểm" trong modal
            // Gửi dữ liệu điểm vừa nhập lên server thông qua AJAX hoặc form post

            // Sau khi xử lý xong, bạn có thể đóng modal bằng cách gọi:
            $('#scoreModal').modal('hide');
        });
    </script>


@endsection
