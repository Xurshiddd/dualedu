<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>
<body>
<div class="container">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
            {{ session('error') }}
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
            </div>

            <script>
                setTimeout(function() {
                    document.getElementById('success-alert').style.display = 'none';
                }, 5000); // 5 sekunddan keyin yo‘qoladi
            </script>
        @endif
    <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit" class="btn bg-info">Chiqish</button>
    </form>
    <form id="imageForm" action="{{ route('inspectors.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Rasm input -->
        <div>
            <label for="photo" class="block">Upload Image</label>
            <input type="file" name="photo" id="photo" class="block mt-1 w-full" required>
        </div>

        <!-- Hidden fields for geolocation -->
        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>
    <script>
        // Geolokatsiyani olish va formaga kiritish
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                // Geolokatsiya muvaffaqiyatli olinganidan so'ng
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                // Formaga latitude va longitude qo'shish
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            }, function(error) {
                // Xatolik yuz berishi holatida xabar
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        alert("Foydalanuvchi geolokatsiyani olishga ruxsat bermadi.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        alert("Geolokatsiya ma'lumotlari mavjud emas.");
                        break;
                    case error.TIMEOUT:
                        alert("Geolokatsiya olishda vaqt o‘tgach xatolik yuz berdi.");
                        break;
                    case error.UNKNOWN_ERROR:
                        alert("Noma'lum xatolik yuz berdi.");
                        break;
                }
            });
        } else {
            alert("Geolokatsiya bu brauzerda qo'llab-quvvatlanmaydi.");
        }


    </script>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>
