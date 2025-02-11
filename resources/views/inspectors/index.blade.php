@extends('layouts.admin')

@section('h1')
    Inspector
@endsection
@section('style')
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-3">Tekshiruv</h2>

        <!-- Filtrlash -->
        <form action="{{ route('inspectors.index') }}" method="GET" style="display: flex; align-items: center; margin-top: 10px; margin-bottom: 10px;">
            <select name="group_id" id="group-select" class="form-select form-control" style="width: 20%;">
                <option value="">Barcha guruhlar</option>
                @foreach($groups as $g)
                    <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>
                        {{ $g->name }}
                    </option>
                @endforeach
            </select>
            <!-- Sana bo‘yicha filter -->
            <select name="date" id="date-select" class="form-select form-control ml-3" style="width: 20%; margin-right: 10px; margin-left: 10px">
                <option value="">Barcha kunlar</option>
                @foreach($practiceDates as $p)
                    <option value="{{ $p }}" {{ request('date', date('Y-m-d')) == $p ? 'selected' : '' }}>
                        {{ $p }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary ml-3">Filter</button>
        </form>


        <!-- Jadval -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary text-center">
                <tr>
                    <th>Users</th>
                    <th>Telefon</th>
                    <th>Status</th>
                    <th>Amaliyotdan uzoqda</th>
                    <th>Joylashuv</th>
                    <th>Rasm</th>
                </tr>
                </thead>
                <tbody>
                @foreach($inspectors as $inspector)
                    <tr>
                        <!-- Talabaning ismi -->
                        <td>{{ $inspector->user->name ?? 'N/A' }}</td>

                        <!-- Guruh -->
                        <td>{{ $inspector->user->phone ?? 'N/A' }}</td>

                        <!-- Status -->
                        <td class="text-center">
                            @if($inspector->status)
                                <span class="badge bg-success" style="background-color: #00CA79">Bor</span>
                            @else
                                <span class="badge bg-danger" style="background-color: red">Yo‘q</span>
                            @endif
                        </td>

                        <!-- Amaliyot kuni -->
                        <td class="text-center">
                            {{ $inspector ? $inspector->distance : 'N/A' }}
                        </td>


                        <!-- Geolokatsiya -->
                        <td class="text-center">
                            @if($inspector->user->address)
                                <a href="https://www.google.com/maps/search/?api=1&query={{ $inspector->user->address->latitude }},{{ $inspector->user->address->longitude }}"
                                   target="_blank"
                                   class="btn btn-sm btn-info">
                                    <i class="fas fa-map-marker-alt"></i> Xaritada ko‘rish
                                </a>
                            @else
                                <span>N/A</span>
                            @endif
                        </td>

                        <!-- Rasm -->
                        <td class="text-center">
                            @if($inspector->images->isNotEmpty())
                                @foreach($inspector->images as $image)
                                    <a href="{{ asset($image->url) }}" target="_blank">
                                        <img src="{{ asset($image->url) }}" alt="Image" width="50" class="mr-2">
                                    </a>
                                @endforeach
                            @else
                                <span>No Image</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.getElementById('group-select').addEventListener('change', function () {
            let groupId = this.value;
            let dateSelect = document.getElementById('date-select');

            // Eski kunlarni tozalash
            dateSelect.innerHTML = '<option value="">Barcha kunlar</option>';

            if (groupId) {
                fetch(`/admin/get-practice-dates/${groupId}`)
                    .then(response => response.json())
                    .then(data => {
                        data.forEach(function (date) {
                            let option = document.createElement('option');
                            option.value = date;
                            option.textContent = date;
                            dateSelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Xatolik:', error));
            }
        });
    </script>
@endsection
