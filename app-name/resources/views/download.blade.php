<!DOCTYPE html>
<html>
<head>
    <title>Download PDF</title>
</head>
<body>
    <h2>Click to trigger invoice generation (PDF will be saved)</h2>
    <form action="{{ route('download.pdf') }}" method="GET">
        <button type="submit">Generate Invoice PDF</button>
    </form>
</body>
</html>
