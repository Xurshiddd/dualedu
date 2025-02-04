@extends('layouts.admin')

@section('h1')
    Groups
@endsection

@section('content')
    <div class="container mt-4">
        <a href="{{ route('groups.index') }}" class="flex flex-start btn bg-success">Ortga</a>
        <div class="card shadow-sm">
            <div class="card-body">
                <form role="form" action="{{ $group->id ? route('groups.update', $group->id) : route('groups.store') }}" method="POST">
                    @csrf
                    @if($group->id)
                        @method('PUT')
                    @endif

                    <div class="mb-3">
                        <label for="name" class="form-label">Group Name</label>
                        <input id="name" class="form-control w-full" name="name" type="text" value="{{ old('name', $group->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="kurs_num" class="form-label">Kurs</label>
                        <select name="kurs_num" class="form-control w-full" id="kurs_num">
                            <option value="1" {{ old('kurs_num', $group->kurs_num) == 1 ? 'selected' : '' }}>1</option>
                            <option value="2" {{ old('kurs_num', $group->kurs_num) == 2 ? 'selected' : '' }}>2</option>
                            <option value="3" {{ old('kurs_num', $group->kurs_num) == 3 ? 'selected' : '' }}>3</option>
                            <option value="4" {{ old('kurs_num', $group->kurs_num) == 4 ? 'selected' : '' }}>4</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Users</label>
                        <div class="row">
                            @foreach($users as $user)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            id="user-{{ $user->id }}"
                                            name="users_id[]"
                                            value="{{ $user->id }}"
                                            {{ in_array($user->id, $group->users->pluck('id')->toArray()) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="user-{{ $user->id }}">{{ $user->name }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success w-100">Save</button>
                </form>
            </div>
        </div>
    </div>
@endsection
