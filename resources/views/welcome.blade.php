<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TTYSI Dual Ta`lim</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 500px;
            margin-top: 50px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        #imagePreview {
            display: none;
            margin-top: 15px;
            max-width: 100%;
            border-radius: 10px;
        }
        body {
            background-color: #288ae1;
        }
    </style>
</head>
<body>
<div class="container">
    <div style="display: flex; justify-content: center; align-items: center"><a href="{{ route('profile') }}">Profil</a></div>
    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 15px">
        <div style="margin-right: 10px">Murojaat uchun +998975413303 </div> | <a href="https://t.me/Muhammad_alayhissalom_ummati" style="margin-left: 10px">Telegram</a>

    </div>
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

    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-danger w-100 mb-3">Chiqish</button>
    </form>

    <form id="imageForm" action="{{ route('inspectors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="photo" class="form-label">Rasm yuklash</label>
            <input type="file" name="photo" id="photo" class="form-control" required accept="image/*">
            <img id="imagePreview" src="#" alt="Image Preview" style="max-height: 500px">
        </div>
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">
        <button type="submit" class="btn btn-primary w-100">Yuklash</button>
    </form>
</div>


<script>
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            document.getElementById('latitude').value = position.coords.latitude;
            document.getElementById('longitude').value = position.coords.longitude;
        }, function(error) {
            alert("Geolokatsiya xatosi: " + error.message);
        });
    } else {
        alert("Geolokatsiya brauzeringiz tomonidan qo‘llab-quvvatlanmaydi.");
    }

    document.getElementById('photo').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgPreview = document.getElementById('imagePreview');
                imgPreview.src = e.target.result;
                imgPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
