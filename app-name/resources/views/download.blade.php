<!DOCTYPE html>
<html>
<head>
    <title>Download PDF</title>
</head>
<body>
    <h2>Click to download invoice as PDF</h2>
    <form action="{{ route('download.pdf') }}" method="GET">
        <button type="submit">Download PDF</button>
    </form>
</body>
</html>
