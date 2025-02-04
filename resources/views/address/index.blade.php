@extends('layouts.admin')

@section('h1')
    Address
@endsection

@section('content')
    <div>
        <a href="{{ route('addresses.create') }}">Create</a>
    </div>
@endsection

@section('script')
@endsection

