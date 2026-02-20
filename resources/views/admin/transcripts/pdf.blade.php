<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Transcript</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        th {
            background: #f3f4f6;
            text-align: left;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .small {
            font-size: 10px;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>Piphan Rose Educational Centre</h2>
        <div class="small">Official Academic Transcript</div>
    </div>

    <p>
        <strong>Student:</strong> {{ $student->user->name }} <br>
        <strong>Admission No:</strong> {{ $student->admission_no }}
    </p>

    <table>
        <thead>
            <tr>
                <th>Exam</th>
                <th>Academic Year</th>
                <th>Total</th>
                <th>Mean</th>
                <th>Class Rank</th>
                <th>Stream Rank</th>
            </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
                <tr>
                    <td>{{ $record->exam->name }}</td>
                    <td>{{ $record->exam->term->academicYear->name }}</td>
                    <td>{{ $record->total_marks }}</td>
                    <td>{{ $record->mean_score }}</td>
                    <td>{{ $record->class_rank }}</td>
                    <td>{{ $record->stream_rank }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br><br>
    <div class="mt-8 bg-slate-50 border rounded-xl p-4 text-sm">
        <div class="font-semi-bold mb-3">Grading Scale</div>
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 text-xs">
            <div>A: 80-100 (Excellent)</div>
            <div>B: 70-79 (Very Good)</div>
            <div>C: 60-69 (Good)</div>
            <div>D:50-59 (Average)</div>
            <div>E: 40-49 (Below Avg)</div>
            <div>F: 0-39 (Fail)</div>

        </div>
    </div>

    <br><br>

    <p>
        <strong>Verification Hash:</strong><br>
        {{ $records->first()->result_hash }}
    </p>

  @php
use SimpleSoftwareIO\QrCode\Facades\QrCode;

$verifyUrl = route('results.verify', $records->first()->result_hash);

$qr = base64_encode(
    QrCode::format('png')
        ->size(150)
        ->margin(1)
        ->generate($verifyUrl)
);
@endphp

<img src="data:image/png;base64,{{ $qr }}" width="120">
<br>
<small>Scan to verify authenticity</small>


</body>

</html>