@extends('layouts.admin')

@section('h1')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Tekshiruv Statistikasi</h3>
                </div>
                <div class="card-body">
                    <div id="apexChart"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 350
            },
            series: [{
                name: 'Inspectors Count',
                data: {!! json_encode($inspectors) !!}
            }],
            xaxis: {
                categories: {!! json_encode($months) !!}
            }
        };

        var chart = new ApexCharts(document.querySelector("#apexChart"), options);
        chart.render();
    </script>
@endsection
