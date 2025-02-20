<!doctype html>
<html lang="uz">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTYSI Dual Ta`lim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 70%;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        body {
            background-color: #288ae1;
        }
    </style>
</head>
<body>
<div class="container">
    <a href="{{route('dashboard')}}" class="btn btn-success">Ortga</a>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('error-alert').style.display = 'none';
            }, 5000); // 5 sekunddan keyin yo‘qoladi
        </script>
    @endif
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" id="success-alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <script>
            setTimeout(function() {
                document.getElementById('success-alert').style.display = 'none';
            }, 5000); // 5 sekunddan keyin yo‘qoladi
        </script>
    @endif
    <div>
        <form action="{{ route('updateProfile') }}" method="post">
            @csrf
            <div style="display: flex; justify-content: center">{{ auth()->user()->name }} malumotlari</div>
            <div class="form-group">
                <label for="name">F.I.SH</label>
                <input type="text" id="name" value="{{ $user->name }}" name="name" class="form-control" placeholder="Ism Sharif">
            </div>
            <div class="form-group">
                <label for="telefon">Telefon</label>
                <input type="tel" name="phone" id="telefon" value="{{ $user->phone }}" class="form-control" placeholder="+998971234567">
            </div>
            <div class="form-group">
                <label for="parol">Parol</label>
                <input type="password" name="password" class="form-control" placeholder="******">
                <span class="text-success" style="font-size: smaller">Agar parolni yangilashni xohlamasangiz bo'sh qoldiring</span>
            </div>
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Saqlash</button>
            </div>
        </form>
    </div>
</div>

<script>

</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
