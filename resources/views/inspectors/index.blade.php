@extends('layouts.admin')

@section('h1')
    Inspector Dashboard
@endsection
@section('style')
@endsection
@section('content')
    <div class="container">
        <h2 class="mb-3">Inspector Dashboard</h2>

        <!-- Filtrlash -->
        <form action="{{ route('inspectors.index') }}" method="GET" class="d-flex align-items-center mb-3">
            <select name="group_id" class="form-select form-control" style="width: 20%;">
                <option value="">Barcha guruhlar</option>
                @foreach($groups as $g)
                    <option value="{{ $g->id }}" {{ request('group_id') == $g->id ? 'selected' : '' }}>
                        {{ $g->name }}
                    </option>
                @endforeach
            </select>

            <select name="status" class="form-select form-control ml-3" style="width: 20%;">
                <option value="">Barchasi</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Bor</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Yo‘q</option>
            </select>

            <button type="submit" class="btn btn-primary ml-3">Filter</button>
        </form>

        <!-- Jadval -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-primary text-center">
                <tr>
                    <th>Users</th>
                    <th>Guruh</th>
                    <th>Status</th>
                    <th>Amaliyot Kuni</th>
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
                        <td>{{ $inspector->group->name ?? 'N/A' }}</td>

                        <!-- Status -->
                        <td class="text-center">
                            @if($inspector->status)
                                <span class="badge bg-success">Bor</span>
                            @else
                                <span class="badge bg-danger">Yo‘q</span>
                            @endif
                        </td>

                        <!-- Amaliyot kuni -->
                        <td class="text-center">
                            @php
                                $practiceDate = $practiceDates->where('group_id', $inspector->group_id)->first();
                            @endphp
                            {{ $practiceDate ? $practiceDate->day : 'N/A' }}
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
@endsection
