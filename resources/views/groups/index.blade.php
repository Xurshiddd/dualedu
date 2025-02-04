@extends('layouts.admin')
@section('h1')
    Roles
@endsection
@section('')
@endsection
@section('content')
    <a href="/admin/groups/create" class="btn btn-success">User biriktirish</a>
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
                            @foreach($groups as $group)
                                <tr>
                                    <td>{{ $group->id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td style="display: flex; justify-content: space-around">
                                        <a href="{{ route('groups.edit', $group->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        <a href="{{ route('groups.show', $group->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <form action="{{ route('groups.destroy', $group->id) }}" method="POST">
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
