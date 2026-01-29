<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice Report</title>

    <style>
        @page {
            margin: 10px;
        }

        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        h3 {
            margin-bottom: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed; /* 🔑 VERY IMPORTANT */
        }

        th, td {
            border: 1px solid #333;
            padding: 3px;
            text-align: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th {
            background: #f2f2f2;
            font-weight: bold;
        }

        .filters td {
            border: none;
            text-align: left;
            padding: 2px;
            font-size: 10px;
        }

        .totals {
            font-weight: bold;
            background: #f9f9f9;
        }
    </style>
</head>

<body>

<h3>Invoice Report</h3>

<table class="filters">
    <tr>
        <td><strong>Customer:</strong></td>
        <td>{{ $customer ?? 'All' }}</td>
        <td><strong>From Date:</strong></td>
        <td>{{ $request->from_date ?? '-' }}</td>
        <td><strong>To Date:</strong></td>
        <td>{{ $request->to_date ?? '-' }}</td>
    </tr>
</table>

<table>
    <thead>
        <tr>
            <th style="width:8%">Ref No</th>
            <th style="width:8%">Invoice No</th>
            <th style="width:12%">Customer</th>
            <th style="width:14%">FBR Invoice No</th>
            <th style="width:8%">Date</th>
            <th style="width:6%">Time</th>
            <th style="width:10%">Before Tax</th>
            <th style="width:8%">Sales Tax</th>
            <th style="width:6%">Extra</th>
            <th style="width:6%">Further</th>
            <th style="width:10%">Grand Total</th>
        </tr>
    </thead>

    <tbody>
        @foreach($invoices as $invoice)
            <tr>
                <td>{{ $invoice->reference_no ?? '-' }}</td>
                <td>{{ $invoice->invoice_no }}</td>
                <td>{{ $invoice->customer->name ?? '-' }}</td>
                <td style="word-break: break-all;">
                    {{ $invoice->fbr_invoice_no ?? '-' }}
                </td>
                <td>{{ $invoice->date_of_supply }}</td>
                <td>{{ $invoice->time_of_supply }}</td>
                <td>{{ number_format($invoice->items->sum('value_of_goods'), 2) }}</td>
                <td>{{ number_format($invoice->items->sum('amount_of_saleTax'), 2) }}</td>
                <td>{{ number_format($invoice->items->sum('extra_tax'), 2) }}</td>
                <td>{{ number_format($invoice->items->sum('further_tax'), 2) }}</td>
                <td>{{ number_format($invoice->items->sum('total'), 2) }}</td>
            </tr>
        @endforeach

        <tr class="totals">
            <td colspan="6">TOTAL</td>
            <td>{{ number_format($totals['totalBeforeTax'], 2) }}</td>
            <td>{{ number_format($totals['saleTax'], 2) }}</td>
            <td>{{ number_format($totals['extraTax'], 2) }}</td>
            <td>{{ number_format($totals['furtherTax'], 2) }}</td>
            <td>{{ number_format($totals['grandTotal'], 2) }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>

