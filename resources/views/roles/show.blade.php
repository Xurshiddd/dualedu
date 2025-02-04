@extends('layouts.admin')
@section('h1')
    Roles
@endsection
@section('')
@endsection
@section('content')
    <a href="/admin/roles" class="btn btn-success">ortga</a>
    <div>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">{{ $role->id }}</th>
            </tr>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">{{ $role->name }}</th>
            </tr>
            <tr>
                <th scope="col">permissions</th>
                <th scope="col" style="display: flex">
                    @foreach($role->permissions as $per)
                        <p>{{ $per->name }}, &nbsp;</p>
                    @endforeach
                </th>
            </tr>
            </thead>
            <tbody>
            {{--            <tr>--}}
            {{--                <td scope="row"></td>--}}
            {{--                <td>Mark</td>--}}
            {{--                <td>Otto</td>--}}
            {{--                <td>@mdo</td>--}}
            {{--            </tr>--}}
            </tbody>
        </table>
    </div>
@endsection
