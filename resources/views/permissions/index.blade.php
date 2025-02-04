@extends('layouts.admin')
@section('h1')
    Permissions
@endsection
@section('')
@endsection
@section('content')
    <a href="/admin/permissions/create" class="btn btn-success">Qo'shish</a>
    @if('success')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            msg
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div>
        <div class="">
            <!--   Kitchen Sink -->
            <div class="panel panel-default">
                <div class="panel-heading">
                    Permissions
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
                            @foreach($permissons as $permission)
                                <tr>
                                    <td>{{ $permission->id }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td style="display: flex; justify-content: space-around">
                                        <a href="{{ route('permissions.edit', $permission->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <form action="{{ route('permissions.destroy', $permission->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a role="button" type="submit"><i class="fa-solid fa-trash"></i></a>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{$permissons->links()}}
                    </div>
                </div>
            </div>
            <!-- End  Kitchen Sink -->
        </div>
    </div>
@endsection
