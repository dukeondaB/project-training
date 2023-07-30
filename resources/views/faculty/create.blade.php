@extends('layouts.dashboard')
@section('title')   {{__('Faculty')}}  @endsection
@section('sub-title') {{__('Create')}} @endsection

@section('content')
   <form method="post" action="{{route('faculty.store')}}">
       @csrf
       @method('POST')
       <label for="" class="form-label">{{__('Faculty name')}}</label>
       <input type="text" id="name" value="{{old('name')}}" class="form-control" name="name">
       @error('name')
       <p class="error" style="color: red">{{ $message }}</p>
       @enderror
       <label for="" class="form-label">{{__('Description')}}</label>
       <textarea id="detail" name="detail" class="form-control" rows="3">{{old('detail')}}</textarea>
       @error('detail')
       <p class="error" style="color: red">{{ $message }}</p>
       @enderror
       <div class="pt-3">
       <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Save')}}</button>
       </div>
   </form>

@endsection
