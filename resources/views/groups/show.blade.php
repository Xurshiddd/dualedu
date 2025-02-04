@extends('layouts.admin')

@section('h1')
    Groups
@endsection

@section('content')
    <div class="container mt-4">
        <a href="{{ route('groups.index') }}" class="flex flex-start btn bg-success">Ortga</a>
        <h2 class="text-center">{{ $group->name }}</h2>
        <div class="card mt-6 p-4">
            <div class="row">
                @foreach($group->users as $key => $value)
                    <div class="col-md-4">
                        <div>{{ $key + 1 }}. {{ $value->name }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection
