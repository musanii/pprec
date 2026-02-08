<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Report Card</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #1f2937;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .school {
            font-size: 18px;
            font-weight: bold;
            color: #1E3A8A;
        }

        .sub {
            font-size: 12px;
            color: #6b7280;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
        }

        th {
            background: #f3f4f6;
            text-align: left;
        }

        .right {
            text-align: right;
        }

        .summary td {
            font-weight: bold;
        }
    </style>
</head>

<body>

<div class="header">
    <div class="school">Piphan Rose Educational Centre</div>
    <div class="sub">Student Report Card</div>
</div>

<table>
    <tr>
        <td><strong>Student:</strong> {{ $student->user?->name }}</td>
        <td><strong>Admission No:</strong> {{ $student->admission_no }}</td>
    </tr>
    <tr>
        <td><strong>Class:</strong> {{ $student->activeEnrollment?->schoolClass?->name }}</td>
        <td><strong>Exam:</strong> {{ $exam->name }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th class="right">Marks</th>
            <th class="right">Grade</th>
        </tr>
    </thead>

    <tbody>
        @foreach($results as $row)
            <tr>
                <td>{{ $row->subject?->name }}</td>
                <td class="right">{{ $row->marks }}</td>
                <td class="right">{{ $row->grade ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>

    <tfoot>
        <tr class="summary">
            <td>Total</td>
            <td class="right">{{ $totalMarks }}</td>
            <td></td>
        </tr>
        <tr class="summary">
            <td>Average</td>
            <td class="right">{{ $average }}</td>
            <td></td>
        </tr>
    </tfoot>
</table>

<p style="margin-top: 40px; font-size: 11px; color: #6b7280;">
    Generated on {{ now()->format('d M Y') }}
</p>

</body>
</html>
