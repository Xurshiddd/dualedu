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
            <a href="{{ route('students.index') }}" class="btn btn-info">Ortga</a>
        <div class="panel panel-info" style="margin-top: 10px">
            <div class="panel-heading">
                Talaba qo'shish
            </div>
            <div class="panel-body">
                <form role="form" action="{{ $student->id ? route('students.update', $student->id) : route('students.store') }}" method="POST">
                    @csrf
                    @if($student->id)
                        @method('PUT')
                    @endif
                    <div class="form-group">
                        <label>Ism</label>
                        <input class="form-control" name="name" type="text" value="{{ $student->name }}">
                    </div>
                    <div class="form-group">
                        <label>Telefon</label>
                        <input type="tel" id="phone" name="phone" class="form-control" maxlength="9" value="{{ substr($student->phone, -9) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" name="password" type="password">
                        @if($student->id)<small style="color: #00CA79">Agar parolni yangilamoqchi bo'lmasangiz bo'sh qoldiring</small> @endif
                    </div>
                    <div class="form-group" style="display: none">
                        <label for="std">Student</label>
                        <input class="form-checkbox" id="std" name="is_student" type="checkbox" checked>
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
@endsection
