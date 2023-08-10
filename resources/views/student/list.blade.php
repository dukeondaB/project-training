@extends('layouts.dashboard')
@section('title') {{__('User')}}   @endsection
@section('sub-title','List')
@section('content')

    <div class="row">
        <div>
            {!! Html::linkRoute('students.create', __('Create'), [], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
        </div>
    </div>
    <div class="pt-5">
        {!! Form::open(['route' => 'student-subject.import', 'method' => 'POST', 'class' => 'form-control-sm', 'enctype' => 'multipart/form-data']) !!}
        @csrf
        {!! Form::file('import_file', ['class' => 'form-control', 'required' => 'required']) !!}
        {!! Form::submit(__('Import'), ['class' => 'btn-success']) !!}
        {!! Form::close() !!}
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
        <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white" data-toggle="modal" data-target="#myModal">Thêm nhanh</button>
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
                    {{ $item->phone }}
                </td>
                <td>
                    <img width="150px" src="{{ asset('storage/images/student/' . $item->avatar) }}" alt="Product Image">
                </td>
                <td>{{ $item->address }}</td>
                <td>{{ $item->age }}</td>
                <td>{{ __($item->gender) }}</td>
                <td>{{ $item->total_point === null ? 'N/A' : $item->total_point }}</td>
                <td>
                    @if ($item->count !== null && $item->count !== '')
                        {{ $item->count }}
                        <a href="{{ route('student.subject-list', ['student_id' => $item->id])}}"> <button class="btn btn-success">Xem chi tiết</button></a>
                    @else
                        {{ __('N/A') }}
                    @endif
                </td>
                <td>
                    {!! Form::open(['route' => ['students.destroy', $item->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
                    {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
                    {!! Html::linkRoute('students.edit', __('Edit'), ['student' => $item->id], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
                    {!! Form::close() !!}
                </td>
                <td>
                    @if ($item->count !== null && $item->count != ($item->faculty ? $item->total_subject : 0))
                        {!! Form::open(['route' => ['send-notification', 'studentId' => $item->id], 'method' => 'POST']) !!}
                        {!! Form::submit(__('Send email'), ['class' => 'btn btn-success']) !!}
                        {!! Form::close() !!}
                    @else
                        <span class="text-success">{{__('Registered')}}</span>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel">Thêm nhanh sinh viên</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'students.store', 'method' => 'POST', 'id' => 'form', 'enctype' => 'multipart/form-data']) !!}
                    {!! Form::label('name', __('Full name'), ['class' => 'form-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}

                    {!! Form::label('email', __('Email'), ['class' => 'form-label']) !!}
                    {!! Form::text('email', old('email'), ['class' => 'form-control']) !!}

                    {!! Form::label('phone', __('Phone'), ['class' => 'form-label']) !!}
                    {!! Form::text('phone', old('phone'), ['class' => 'form-control']) !!}

                    {!! Form::label('address', __('Address'), ['class' => 'form-label']) !!}
                    {!! Form::text('address', old('address'), ['class' => 'form-control']) !!}

                    {!! Form::label('gender', __('Gender'), ['class' => 'form-label']) !!}
                    {!! Form::select('gender', ['' => __('Open this select menu'), 'male' => __('Male'), 'female' => __('Female'), 'other' => __('Other')], old('gender'), ['class' => 'form-select']) !!}

                    {!! Form::label('faculty_id', __('Faculty'), ['class' => 'form-label']) !!}
                    {!! Form::select('faculty_id', ['' => '-- Chọn khoa --'] + $faculties->pluck('name', 'id')->toArray(), old('faculty_id'), ['class' => 'form-control']) !!}

                    {!! Form::label('birth_day', __('Date Birth'), ['class' => 'form-label']) !!}
                    {!! Form::date('birth_day', old('birth_day'), ['class' => 'form-control']) !!}

                    <img id="imagePreview" src="#" alt="Preview" style="display: none; max-width: 200px;">
                    {!! Form::label('avatar', __('Avatar'), ['class' => 'form-label']) !!}
                    {!! Form::file('avatar', ['class' => 'form-control', 'id' => 'avatar', 'onchange' => 'previewImage(event)']) !!}

                    <div class="pt-3">
                        {!! Form::button(__('Save'), ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white', 'type' => 'submit']) !!}
                    </div>
                    {!! Form::close() !!}
                </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

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
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Trong phần script của trang -->
    <script>
        function previewImage(event) {
            const input = event.target;
            const imagePreview = document.getElementById('imagePreview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                imagePreview.src = '#';
                imagePreview.style.display = 'none';
            }

        }

        $('#form').submit(function(event) {
            event.preventDefault();
            var form = $(this);
            var url = form.attr('action');

            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                beforeSend: function() {
                    $(document).find('p.error').html('');
                },
                success: function(data) {
                    console.log('0');
                     location.reload();
                },
                error: function(xhr, status, error) {
                    console.log('1');
                    var errors = xhr.responseJSON.errors;
                    for (var key in errors) {
                        form.find('[name="' + key + '"]').after('<p class="error" style="color: red">' + errors[key][0] + '</p>');
                    }
                }
            });
        });
    </script>


@endsection
