<h2>Finance Report</h2>
<p>Academic Year: {{ $year?->name }}</p>
<p>Term: {{ $term?->name }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="5">
    <thead>
        <tr>
            <th>Student</th>
            <th>Class</th>
            <th>Total</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
            <tr>
                <td>{{ $bill->student->user->name }}</td>
                <td>{{ $bill->student->activeEnrollment?->schoolClass?->name }}</td>
                <td>{{ number_format($bill->amount, 2) }}</td>
                <td>{{ number_format($bill->balance, 2) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
