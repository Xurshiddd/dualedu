@extends('layouts.admin')
@section('h1')
    User
@endsection
@section('style')
    <!-- Select2 CSS -->


@endsection
@section('content')
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="panel panel-info">
            <div class="panel-heading">
                User Create
            </div>
            <div class="panel-body">
                <form role="form" action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Ism</label>
                        <input class="form-control" name="name" type="text">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" type="email">
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="password" type="password">
                    </div>
                    <div class="form-group">
                        <label>Roles</label>
                        <select name="roles[]" class="form-control select2" multiple="multiple">
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-info">Save</button>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('script')

    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
