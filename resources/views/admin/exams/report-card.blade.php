<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; }
        th, td { border:1px solid #ddd; padding:6px; }
        th { background:#f3f4f6; }
    </style>
</head>
<body>

<h2>Piphan Rose Educational Centre</h2>
<h3>Official Report Card</h3>

<p><strong>Student:</strong> {{ $student->user->name }}</p>
<p><strong>Exam:</strong> {{ $exam->name }}</p>

<table>
    <thead>
        <tr>
            <th>Subject</th>
            <th>Marks</th>
            <th>Grade</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subjects as $result)
        <tr>
            <td>{{ $result->subject->name }}</td>
            <td>{{ $result->marks }}</td>
            <td>{{ $result->grade }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<br>

<p><strong>Total:</strong> {{ $aggregate->total_marks }}</p>
<p><strong>Mean:</strong> {{ $aggregate->mean_score }}</p>
<p><strong>Class Rank:</strong> {{ $aggregate->class_rank }}</p>
<p><strong>Stream Rank:</strong> {{ $aggregate->stream_rank }}</p>

</body>
</html>
