@extends('layouts.dashboard')
@section('title')   {{__('Faculty')}}  @endsection
@section('sub-title') {{__('Create')}} @endsection

@section('content')
   <form method="post" action="{{route('faculty.store')}}">
       @csrf
       <label for="" class="form-label">{{__('Faculty Name')}}</label>
       <input type="text" id="name" value="{{old('name')}}" class="form-control" name="name">
       @error('name')
       <p class="error" style="color: red">{{ $message }}</p>
       @enderror
       <label for="" class="form-label">{{__('Description')}}</label>
       <textarea id="description" name="description" class="form-control" rows="3">{{old('description')}}</textarea>
       @error('description')
       <p class="error" style="color: red">{{ $message }}</p>
       @enderror
       <div class="pt-3">
       <button class="btn waves-effect waves-light btn btn-info pull-left hidden-sm-down text-white">{{__('Save')}}</button>
       </div>
   </form>

@endsection
