@extends('layouts.admin')
@section('h1')
    Permissions
@endsection
@section('')
@endsection
@section('content')
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="panel panel-info">
            <div class="panel-heading">
                Permissions Create
            </div>
            <div class="panel-body">
                <form role="form" action="{{ $permission->id ? route('permissions.update', $permission->id) : route('permissions.store') }}" method="POST">
                    @csrf
                    @if($permission->id)
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" type="text" value="{{$permission->name}}">
                    </div>
                    <button type="submit" class="btn btn-info">Saqlash</button>
                </form>
            </div>
        </div>
    </div>
@endsection
