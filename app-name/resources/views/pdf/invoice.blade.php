<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; padding: 20px; }
        h1 { text-align: center; color: #333; }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <p><strong>Name:</strong> {{ $customer['name'] }}</p>
    <p><strong>Email:</strong> {{ $customer['email'] }}</p>
    <p><strong>Invoice ID:</strong> {{ $customer['invoice_id'] }}</p>
    <p><strong>Amount:</strong> ${{ $customer['amount'] }}</p>
    <p><strong>Date:</strong> {{ $customer['date'] }}</p>
</body>
</html>