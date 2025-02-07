@extends('layouts.admin')
@section('h1')
    Amaliyot davri
@endsection
@section('style')
@endsection
@section('content')
    <div class="container mt-4">
        <a href="{{ route('practics.create') }}" class="btn btn-success mb-3" style="margin-bottom: 10px">Create</a>

        @foreach($groups as $group)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white fw-bold text-center p-4" style="padding: 5px; border-radius: 10px">
                    {{ $group->name }}
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-2" style="display: flex; flex-wrap: wrap; gap: 2">
                        @foreach($group->dates as $day)
                            <div class="p-2 border rounded text-center bg-light fw-semibold" style="min-width: 100px; background-color: #c0d9e1; margin: 2px; border-radius: 5px; font-weight: 700">
                                {{ $day->day }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

@endsection
@section('script')
@endsection
