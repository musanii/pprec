@extends('layouts.app')

@section('page_title','Attendance Analytics')

@section('content')

<div class="bg-white rounded-2xl border p-6">

    <canvas id="attendanceChart"></canvas>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('attendanceChart');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json($months),
        datasets: [{
            label: 'Attendance %',
            data: @json($rates),
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                max: 100
            }
        }
    }
});
</script>

@endsection