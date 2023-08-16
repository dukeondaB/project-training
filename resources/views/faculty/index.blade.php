@extends('layouts.dashboard')
@section('title')   {{__('Faculty')}}  @endsection
@section('sub-title') {{__('List')}} @endsection
@section('content')
    <div class="">
        {!! Html::linkRoute('faculties.create', __('Create'), [], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
    </div>

    <table class="table table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>{{__('Faculty Name')}}</th>
            <th>{{__('Description')}}</th>
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
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->description }}
                </td>

                <td>
                    {!! Form::open(['route' => ['faculties.destroy', $item->id], 'method' => 'DELETE', 'id' => 'deleteForm']) !!}
                    {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
                    {!! Html::linkRoute('faculties.edit', __('Edit'), ['faculty' => $item->id], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
                    {!! Form::close() !!}
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
    <script>
        // Đợi cho trang tải hoàn tất
        window.addEventListener('load', function() {
            // Gọi hộp thoại thông báo Sweet Alert
            Swal.fire({
                icon: 'info', // Loại biểu tượng (info, success, error, warning, question)
                title: 'Chào mừng đến với trang của tôi!', // Tiêu đề hộp thoại
                text: 'Bạn đã vào trang thành công!', // Nội dung hộp thoại
            });
        });
    </script>

@endsection
