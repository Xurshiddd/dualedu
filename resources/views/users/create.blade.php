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
            <a href="{{ route('users.index') }}" class="btn btn-info">Ortga</a>
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
                        <label>Telefon</label>
                        <input type="tel" id="phone" name="phone" class="form-control" maxlength="9" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="password" type="password">
                    </div>
                    <div class="form-group">
                        <label for="std">Student</label>
                        <input class="form-checkbox" id="std" name="is_student" type="checkbox">
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
        var input = document.querySelector("#phone");
        var iti = window.intlTelInput(input, {
            initialCountry: "uz",
            utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input/build/js/utils.js"
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
