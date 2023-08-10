@extends('layouts.dashboard')
@section('title') {{__('Subject')}}   @endsection
@section('sub-title') {{__('List')}} @endsection
@section('content')
    <div class="">
        {!! Html::linkRoute('subject.create', __('Create'), [], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
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
                    {{ $loop->iteration }}
                </td>
                <td>
                    {{ $item->name }}
                </td>
                <td>
                    {{ $item->description }}
                </td>
                <td>
                    {{ $item->faculty->name }}
                </td>
                {{-- @can('student-access', Auth()->student()) --}}
                <td>
                    @if (isset($item->studentPoint) && $item->studentPoint !== '')
                        {{ $item->studentPoint }}
                    @else
                        {{ __('N/A') }}
                    @endif
                </td>
                {{-- @endcan --}}
                <td>
                    {!! Form::open(['route' => ['subject.destroy', $item->id], 'method' => 'POST', 'id' => 'deleteForm']) !!}
                    @csrf
                    @method('DELETE')

                    {!! Form::submit(__('Delete'), ['class' => 'btn btn-danger', 'onclick' => 'return confirmDelete()']) !!}
                    {!! Html::linkRoute('subject.edit', __('Edit'), ['subject' => $item->id], ['class' => 'btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white']) !!}
                    {!! Form::close() !!}
                </td>
                @if($user->student)
                    @if ($user->student->isSubjectRegistered($item->id))
                        <td>{{__('Registered')}}</td>
                    @else
                        <td>
                            {!! Form::open(['route' => ['subject.register', $item->id], 'method' => 'POST', 'id' => 'registerForm']) !!}
                            @csrf
                            {!! Form::button(__('Register'), ['class' => 'btn btn-success', 'type' => 'submit', 'disabled' => $user->student->isSubjectRegistered($item->id) === true]) !!}
                            {!! Form::close() !!}
                        </td>
                    @endif
                @endif

                {{-- @can('student-access', Auth()->student()) --}}

                {{-- @endcan --}}
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
