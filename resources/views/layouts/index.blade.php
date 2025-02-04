<!doctype html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="https://ttysi.uz/assets/public/images/logo_black.svg"/>
    <title>Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .dropdown {
            display: inline-block;
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            width: max-content;
            z-index: 100;
            overflow: auto;
            box-shadow: 0px 10px 10px 0px rgba(0, 0, 0, 0.4);
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            display: block;
            color: #000000;
            padding: 5px;
            text-decoration: none;
        }

        .dropdown-content a:hover {
            color: #FFFFFF;
            background-color: #00A4BD;
        }
        #popup {
            width: 500px;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        #popup h3 {
            background: #f4f4f4;
            padding: 10px;
            margin: 0;
            text-align: center;
        }

        #popup-content p {
            margin: 10px 0;
            line-height: 1.5;
        }
        body {
            background-image: url("{{asset('background-image.jpg')}}");
            height: 100vh;
            margin: 0;
        }
    </style>
    <link href="//cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary" style="background-color: blue!important; color: white!important;">
    <div class="container container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" style="color: white!important;">Home</a>
                </li>
            </ul>
            <div class="dropdown">
                <div>{{\Illuminate\Support\Facades\Auth::user()->name}}</div>
                <div class="dropdown-content">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn btn-primary">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
<!-- begin alert -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('errors'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
        {{ session('errors') }}
    </div>
@endif
<!-- end alert -->
<!-- main -->
<div class="container">
    <div class="card mt-3">
        <div class="card-body">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                            aria-selected="true">So'rovnomalar
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                            aria-selected="false">So'rovnoma jo'natish
                    </button>
                </li>
{{--                <li class="nav-item" role="presentation">--}}
{{--                    <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill"--}}
{{--                            data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact"--}}
{{--                            aria-selected="false">Contact--}}
{{--                    </button>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>
    <div class="card mt-3">
        <div class="card-header text-center" style="color: blue; background-color: rgba(92,221,211,0.39); font-weight: 600">
            So'rovnomalar
        </div>
        <div class="card-body">
            <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


                    <table id="Table_ID" class="table table-striped table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Kafedra</th>
                            <th>Bino</th>
                            <th>Qavat</th>
                            <th>Xona</th>
                            <th>Holat</th>
                            <th>Yaratilgan vaqt</th>
                            <th>Xarakat</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($requests as $key => $value)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ substr($kafedras->where('id', $value->kafedra_id)->first()->name, 0, 40).'...' }}</td>
                            <td>{{ $value->building }}</td>
                            <td>{{ $value->floor }}</td>
                            <td>{{ $value->room }}</td>
                            <td style="
    @if($value->status == 'new') color: green;
    @elseif($value->status == 'done') color: blue;
    @elseif($value->status == 'progress') color: yellow;
    @elseif($value->status == 'failed') color: red;
    @endif
">
                                @switch($value->status)
                                    @case('new')
                                        Yangi
                                        @break
                                    @case('progress')
                                        Bajarilyapti
                                        @break
                                    @case('done')
                                        Bajarildi
                                        @break
                                    @case('failed')
                                        Bajarilmadi
                                        @break
                                    @default
                                        Noma'lum
                                @endswitch
                            </td>

                            <td>{{ $value->created_at }}</td>
                            <td style="display: flex">
                                <button class="btn btn-primary" id="show" onclick="openPopup({{$value->id}})">Ochish</button>
                                @if($value->status == 'new')
                                    <form action="{{route('requests.destroy', $value->id)}}" method="POST">
                                        @csrf
                                        @method("DELETE")
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                            @endif
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <form action="{{ route('requests.store') }}" method="POST">
                            @csrf
                            <div class="form-group row">
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Kafedra</label>
                                    <select class="form-control" name="kafedra_id">
                                        @foreach($kafedras as $kafedra)
                                            <option value="{{ $kafedra->id }}">{{$kafedra->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Bino</label>
                                    <select class="form-control" name="building">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Qavat</label>
                                    <input type="number" class="form-control" name="floor" id="floor" min="1" max="6" step="1">
                                </div>
                                <div class="form-group col-sm-12 col-md-6 col-lg-6 mt-2">
                                    <label class="col-sm-2 form-label">Xona raqami</label>
                                    <input type="number" class="form-control" name="room">
                                </div>
                                <div class="form-group col-12 mt-2">
                                    <label class="col-sm-2 form-label">Mazmun</label>
                                    <textarea class="form-control" name="description"></textarea>
                                </div>
                            </div>

                            <div class="form-group row mt-3">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" onclick="return confirm('Rostdan ham so\'rovni jo\'natmoqchimisiz?')">Jo'natish</button>
                                </div>
                            </div>
                        </form>
                </div>
{{--                <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">...--}}
{{--                </div>--}}
            </div>
        </div>
    </div>
</div>
<div id="popup" style="display: none; position: fixed; top: 50%; left: 50%; width: 60%; transform: translate(-50%, -50%); background: white; border: 1px solid #ccc; padding: 20px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); z-index: 1000;">
    <h3 style="text-align: center;">So'rovnoma ko'rinishi</h3>
    <div style="display: flex; justify-content: end">
        <div style="flex-wrap: nowrap; width: 30%">
            "Raqamli ta`lim texnologiyalari markazi" <br>
            rahbari Sherzod Fayazovga <br>
            <p id="kafedra" style="display: inline"></p> kafedrasi mudiri
            <p id="mdr" style="display: inline"></p>dan
        </div>
    </div>
    <h4 class="text-center">So'rovnoma</h4>
    <div id="popup-content">
        <!-- Dinamik ma'lumotlar bu yerga kiritiladi -->
        <p><strong>Bino:</strong> <span id="popup-building"></span></p>
        <p><strong>Qavat:</strong> <span id="popup-floor"></span></p>
        <p><strong>Xona:</strong> <span id="popup-room"></span></p>
        <p><strong>Mazmuni:</strong> <span id="popup-description"></span></p>
        <p><strong>Vaqt:</strong> <span id="popup-create"></span></p>
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <button onclick="closePopup()" style="padding: 10px 20px; background: #f44336; color: white; border: none; cursor: pointer; margin-left: 10px;">Yopish</button>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script src="//cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#Table_ID').DataTable();
    });
    setTimeout(function() {
        const successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.classList.remove('show');  // Hide alert with Bootstrap fade out effect
        }
    }, 3000);

    // Hide the error alert after 3 seconds
    setTimeout(function() {
        const errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.classList.remove('show');  // Hide alert with Bootstrap fade out effect
        }
    }, 3000);
    function openPopup(id) {
        let dat = @json($requests);
        let data = dat.find(item => item.id === id);
        document.getElementById("popup-building").textContent = data.building;
        document.getElementById("popup-floor").textContent = data.floor;
        document.getElementById("kafedra").textContent = data.name;
        document.getElementById("mdr").textContent = data.user;
        document.getElementById("popup-room").textContent = data.room;
        document.getElementById("popup-description").textContent = data.description;
        document.getElementById("popup-create").textContent = data.created_at;

        // Pop-upni ko'rsatish
        document.getElementById("popup").style.display = "block";
    }

    function closePopup() {
        document.getElementById("popup").style.display = "none";
    }
</script>
</body>
</html>
