@extends('layouts.admin')

@section('h1')
    Amaliyot kunlari
@endsection
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
@endsection
@section('content')
    <style>
        .selected-date {
            background-color: #28a745 !important;
            color: white !important;
        }
    </style>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" id="error-alert">
            {{ session('error') }}
        </div>

        <script>
            setTimeout(function() {
                document.getElementById('error-alert').style.display = 'none';
            }, 5000); // 5 sekunddan keyin yo‘qoladi
        </script>
    @endif
    <div class="container mt-5">
        <h2>Select Multiple Dates</h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" id="success-alert">
                {{ session('success') }}
            </div>

            <script>
                setTimeout(function() {
                    document.getElementById('success-alert').style.display = 'none';
                }, 5000); // 5 sekunddan keyin yo‘qoladi
            </script>
        @endif
        <form action="{{ route('practics.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Select Group</label>
                <select name="group_id" class="form-control" required>
                    <option value="">-- Select Group --</option>
                    @foreach($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Hidden input for year, month, and selected days --}}
            <input type="hidden" name="year" id="selected-year">
            <input type="hidden" name="month" id="selected-month">
            <input type="hidden" name="days" id="selected-days">

            <button type="submit" class="btn btn-primary" style="margin-top: 10px">Save Schedule</button>
        </form>

        {{-- Calendar --}}
        <div id="calendar" class="mt-4"></div>
    </div>

@endsection

@section('script')
    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/locales-all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var selectedDays = new Set();

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'en',
                dateClick: function(info) {
                    let dateStr = info.dateStr;

                    // Adding and removing days from the set
                    if (selectedDays.has(dateStr)) {
                        selectedDays.delete(dateStr);
                        info.dayEl.classList.remove('selected-date');
                    } else {
                        selectedDays.add(dateStr);
                        info.dayEl.classList.add('selected-date');
                    }

                    // Update the hidden input field with selected days
                    document.getElementById('selected-days').value = Array.from(selectedDays).map(date => date.split('T')[0]).join(',');

                    // Get the selected month and year
                    var selectedDate = new Date(info.dateStr);
                    document.getElementById('selected-year').value = selectedDate.getFullYear();
                    document.getElementById('selected-month').value = selectedDate.getMonth() + 1;
                }
            });

            calendar.render();
        });
    </script>
@endsection
