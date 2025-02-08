@extends('layouts.admin')

@section('h1')
    Inspector
@endsection

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3 form-group" style="display: flex">
            <select class="form-select form-control" style="width: 15%">
                @foreach(\DB::table('groups')->get() as $g)
                <option class="" value="{{$g->id}}">{{ $g->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary ml-5">Filter</button>
        </div>

        <table class="table table-bordered">
            <thead class="table-primary text-center">
            <tr>
                <th>Users</th>
                <th>Status</th>
                <th>Kun</th>
                <th>Rasm</th>
            </tr>
            </thead>
            <tbody>
            @foreach($inspectors as $inspector)
                <tr>
                    <td>{{ $inspector->user->name ?? 'N/A' }}</td>
                    <td>{{ $inspector->status ?? 'N/A' }}</td>
                    <td>{{ $inspector->created_at->format('Y-m-d') }}</td>
                    <td>
                        @if($inspector->images->isNotEmpty())
                            <img src="{{asset($inspector->images->first()->url)}}" alt="Image" width="50">
                        @else
                            <span>No Image</span>
                        @endif
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
