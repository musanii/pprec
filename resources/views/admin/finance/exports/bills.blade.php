<table>
    <thead>
        <tr>
            <th>Student</th>
            <th>Class</th>
            <th>Fee Structure</th>
            <th>Total Amount</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bills as $bill)
            <tr>
                <td>{{ $bill->student->user->name }}</td>
                <td>{{ $bill->student->activeEnrollment?->schoolClass?->name }}</td>
                <td>{{ $bill->feeStructure->name }}</td>
                <td>{{ $bill->amount }}</td>
                <td>{{ $bill->balance }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
