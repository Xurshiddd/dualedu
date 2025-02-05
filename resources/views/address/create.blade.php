@extends('layouts.admin')

@section('h1')
    Address
@endsection

@section('content')
    <div class="row">
        <!-- Form -->
        <div class="col-md-6">
            <a href="{{ route('addresses.index') }}" class="btn bg-info m-3" style="margin: 10px">Ortga</a>
            <div class="panel panel-info">
                <div class="panel-heading">Address Create</div>
                <div class="panel-body">
                    <form action="{{ route('addresses.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Group</label>
                            <select class="form-select w-full form-control" id="groupSelect">
                                <option value="">Select Group</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>User</label>
                            <select name="user_id" id="userSelect" class="form-select form-control">
                                <option value="">Select User</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Company Name</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Street</label>
                            <input type="text" name="street" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Number</label>
                            <input type="text" name="number" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Longitude</label>
                            <input type="text" id="longitude" name="long" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" id="latitude" name="lat" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-info">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Map -->
        <div class="col-md-6" style="margin-top: 50px">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>
@endsection

@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        $(document).ready(function() {
            // Group select bo'yicha AJAX orqali foydalanuvchilarni yuklash
            $('#groupSelect').change(function() {
                var groupId = $(this).val();
                var userSelect = $('#userSelect');

                userSelect.empty().append('<option value="">Select User</option>');

                if (groupId) {
                    $.ajax({
                        url: '/admin/groups/' + groupId + '/users',
                        type: 'GET',
                        success: function(users) {
                            console.log(users)
                            users.forEach(function(user) {
                                userSelect.append('<option value="' + user.id + '">' + user.name + '</option>');
                            });
                        }
                    });
                }
            });

            // Leaflet xarita sozlamalari
            var map = L.map('map').setView([41.2995, 69.2401], 13); // Toshkent koordinatalari

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker = L.marker([41.2995, 69.2401], { draggable: true }).addTo(map);

            marker.on('dragend', function(event) {
                var position = marker.getLatLng();
                $('#latitude').val(position.lat);
                $('#longitude').val(position.lng);
            });

            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                $('#latitude').val(e.latlng.lat);
                $('#longitude').val(e.latlng.lng);
            });
        });
    </script>
@endsection
