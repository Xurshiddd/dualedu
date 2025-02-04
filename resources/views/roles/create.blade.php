@extends('layouts.admin')
@section('h1')
    Roles
@endsection
@section('')
@endsection
@section('content')
    <div>
        <div class="panel panel-info">
            <div class="panel-heading">
                Roles Create
            </div>
            <div class="panel-body">
                <form role="form" action="{{ $role->id ? route('roles.update', $role->id) : route('roles.store') }}" method="POST">
                    @csrf
                    @if($role->id)
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label>Name</label>
                        <input class="form-control" name="name" type="text" value="{{ old('name', $role->name) }}">
                    </div>

                    <div class="form-group">
                        <label>Permissions</label>
                        @foreach($permissions as $permission)
                            <div>
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->name }}"
                                    {{ in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }}>
                                {{ $permission->name }}
                            </div>
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-info">Save</button>
                </form>

            </div>
        </div>
    </div>
@endsection
