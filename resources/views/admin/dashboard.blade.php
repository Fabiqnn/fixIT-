@extends('layouts.template')
@section('title', $page->title)
@section('header', $page->header)

@section('content')
    <div class="container mx-auto px-4">
        <h2 class="text-xl font-bold my-4">Grafik Status Perbaikan per Periode</h2>
        <div id="chart"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        var options = {
            chart: {
                type: 'bar',
                height: 400
            },
            series: [{
                name: 'Tuntas',
                data: {!! json_encode($tuntas) !!}
            }, {
                name: 'Diproses',
                data: {!! json_encode($diproses) !!}
            }],
            xaxis: {
                categories: {!! json_encode($labels) !!}
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '20%' // Biar mepet
                }
            },
            title: {
                text: 'Status Perbaikan per Periode',
                align: 'center',
                style: {
                    fontSize: '16px',
                    fontWeight: 'bold'
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
@endsection
