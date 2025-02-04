@extends('layouts.admin')
@section('h1')
    Roles
@endsection
@section('')
@endsection
@section('content')
    <a href="/admin/roles/create" class="btn btn-success">Qo'shish</a>
    <div>
        <div class="">
            <!--   Kitchen Sink -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Roles
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nomi</th>
                                <th>Xarakat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $role->id }}</td>
                                    <td>{{ $role->name }}</td>
                                    <td style="display: flex; justify-content: space-around">
                                        <a href="{{ route('roles.edit', $role->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('roles.show', $role->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background-color: white"><i class="fa-solid fa-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- End  Kitchen Sink -->
        </div>
    </div>
@endsection
