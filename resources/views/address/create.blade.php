@extends('layouts.admin')

@section('h1')
    Address
@endsection

@section('content')
    <div class="row">
        <!-- Form -->
        <div class="col-md-6">
            <a href="{{ route('addresses.index') }}" class="btn bg-info m-3">Ortga</a>
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
                            <input type="text" id="longitude" name="longitude" class="form-control" readonly>
                        </div>

                        <div class="form-group">
                            <label>Latitude</label>
                            <input type="text" id="latitude" name="latitude" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-info">Save</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Google Map -->
        <div class="col-md-6" style="margin-top: 50px">
            <div id="map" style="height: 400px;"></div>
        </div>
    </div>
@endsection

@section('script')
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Google Maps API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA7tWTnuArv9FmZXyN17vDENp58iIGb5CE&callback=initMap" async defer></script>

    <script>
        function initMap() {
            var defaultLocation = { lat: 41.2995, lng: 69.2401 }; // Toshkent koordinatalari
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 13,
                center: defaultLocation
            });

            var marker = new google.maps.Marker({
                position: defaultLocation,
                map: map,
                draggable: true
            });

            // Marker harakatlantirilganda koordinatalarni o‘zgartirish
            google.maps.event.addListener(marker, 'dragend', function(event) {
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Xaritada bosilganda marker joylashuvini yangilash
            google.maps.event.addListener(map, 'click', function(event) {
                marker.setPosition(event.latLng);
                document.getElementById('latitude').value = event.latLng.lat();
                document.getElementById('longitude').value = event.latLng.lng();
            });

            // Brauzerdan foydalanuvchi lokatsiyasini olish
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLocation = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    map.setCenter(userLocation);
                    marker.setPosition(userLocation);
                    document.getElementById('latitude').value = userLocation.lat;
                    document.getElementById('longitude').value = userLocation.lng;
                });
            }
        }

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
                            users.forEach(function(user) {
                                userSelect.append('<option value="' + user.id + '">' + user.name + '</option>');
                            });
                        }
                    });
                }
            });
        });
    </script>
@endsection
