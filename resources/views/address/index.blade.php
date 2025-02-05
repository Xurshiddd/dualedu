@extends('layouts.admin')

@section('h1')
    Address
@endsection

@section('content')
    <div class="block">
        <a href="{{ route('addresses.create') }}" class="btn bg-success">Create</a>
    </div>
    <div style="margin-top: 15px">
        <div class="panel panel-info">
            <div class="panel-heading">Address List</div>
            <div class="panel-body">
                <form method="GET" action="{{ route('addresses.index') }}">
                    <div class="form-group">
                        <label>Filter by Group:</label>
                        <select name="group_id" class="form-select" onchange="this.form.submit()">
                            <option value="">All Groups</option>
                            @foreach($groups as $group)
                                <option value="{{ $group->id }}" {{ $groupId == $group->id ? 'selected' : '' }}>
                                    {{ $group->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>

                <table class="table table-bordered mt-4">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Company Name</th>
                        <th>Street</th>
                        <th>City</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($addresses as $key => $address)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ optional($address->user)->name ?? 'No User' }}</td>
                            <td>{{ $address->company_name }}</td>
                            <td>{{ $address->street }}</td>
                            <td>{{ $address->city }}</td>
                            <td style="display: flex; justify-content: center; align-items: center">
                                <form action="{{route('addresses.destroy', $address->id)}}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button type="submit" style="border: none; background-color: white"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-danger">No addresses found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                {{ $addresses->links() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection

