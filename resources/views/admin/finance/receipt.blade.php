<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Receipt</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            color: #1e293b;
        }
        .receipt {
            max-width: 700px;
            margin: auto;
            border: 1px solid #e2e8f0;
            padding: 30px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .title {
            font-size: 22px;
            font-weight: bold;
        }
        .section {
            margin-bottom: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .table th, .table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background: #f8fafc;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #64748b;
        }
        .print-btn {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

<div class="print-btn">
    <button onclick="window.print()">Print Receipt</button>
</div>

<div class="receipt">

    <div class="header">
        <div>
            <div class="title">Piphan Rose Educational Centre</div>
            <div>Official Payment Receipt</div>
        </div>
        <div>
            <strong>Receipt #:</strong> {{ $payment->id }}<br>
            <strong>Date:</strong> {{ $payment->created_at->format('d M Y H:i') }}
        </div>
    </div>

    <div class="section">
        <strong>Student Details</strong><br>
        Name: {{ $payment->student->user->name }}<br>
    
        Bill ID: {{ $payment->bill->id }}
    </div>

    <div class="section">
        <strong>Payment Details</strong>
        <table class="table">
            <tr>
                <th>Fee Type</th>
                <td>{{ $payment->bill->feeStructure->name }}</td>
            </tr>
            <tr>
                <th>Amount Paid</th>
                <td class="text-right">
                    {{ number_format($payment->amount, 2) }}
                </td>
            </tr>
            <tr>
                <th>Payment Method</th>
                <td>{{ ucfirst($payment->method) }}</td>
            </tr>
            <tr>
                <th>Reference</th>
                <td>{{ $payment->reference ?? '-' }}</td>
            </tr>
            <tr>
                <th>Recorded By</th>
                <td>{{ $payment->recorder?->name }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <strong>Remaining Balance:</strong>
        {{ number_format($payment->bill->balance, 2) }}
    </div>

    <div class="footer">
        This is a computer-generated receipt and does not require a signature.
    </div>

</div>

</body>
</html>
