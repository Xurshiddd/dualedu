@extends('layouts.admin')
@section('h1')
    Roles
@endsection
@section('style')
@endsection
@section('content')
    <a href="/admin/users" class="btn btn-success">ortga</a>
    <div>
        <form role="form" action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label>Ism</label>
                <input class="form-control" name="name" type="text" value="{{ $user->name }}">
            </div>
            <div class="form-group">
                <label>Telefon</label>
                <input type="tel" id="phone" name="phone" class="form-control" maxlength="9" value="{{ substr($user->phone, -9) }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" name="password" type="password">
                <small style="color: #00CA79">Agar parolni yangilamoqchi bo'lmasangiz bo'sh qoldiring</small>
            </div>
            <div class="form-group">
                <label>Student</label>
                <input type="checkbox" name="is_student" class="form-checkbox" @checked($user->is_student == true)>
            </div>
            <div class="form-group">
                <label>Roles</label>
                <select name="roles[]" class="form-control select2" multiple="multiple">
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"
                            {{ in_array($role->name, $user->roles->pluck('name')->toArray()) ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-info">Save</button>
        </form>
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
