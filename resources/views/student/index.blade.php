@extends('layouts.admin')
@section('h1')
    Students
@endsection
@section('')
@endsection
@section('content')
    <a href="/admin/students/create" class="btn btn-success" style="width: 10%">Talaba qo'shish</a>
    <div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
            <form method="GET" action="{{ route('students.index') }}">
                <div class="form-group">
                    <label for="group">Guruhni tanlang:</label>
                    <select name="group_id" id="group" class="form-control" style="width: 15%" onchange="this.form.submit()">
                        <option value="">Barcha guruhlar</option>
                        @foreach($groups as $g)
                            <option value="{{ $g->id }}" {{ $group == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="panel panel-default" style="margin-top: 15px">
                <div class="panel-heading">Talabalar</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Guruh</th>
                                <th>Ism</th>
                                <th>Telefon</th>
                                <th>Geolocation</th>
                                <th>Xarakat</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($students as $index => $student)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $student->groups->pluck('name')->join(', ') }}</td>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->phone }}</td>
                                    <td>
                                        @if($student->address)
                                        <a href="https://www.google.com/maps/search/?api=1&query={{ $student->address->latitude }},{{ $student->address->longitude }}"
                                           target="_blank"
                                           class="btn btn-sm btn-info">
                                            <i class="fas fa-map-marker-alt"></i> Xaritada ko‘rish
                                        </a>
                                        @else
                                            Addres yo'q
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('students.edit', $student->id) }}" class="btn btn-warning btn-sm">Tahrirlash</a>
                                        <form action="{{ route('students.destroy', $student->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">O‘chirish</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $students->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('script')

@endsection
