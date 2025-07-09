<p>Hello {{ $customer['name'] }},</p>

<p>Your invoice for {{ $customer['date'] }} has been generated.</p>

<p>Invoice ID: {{ $customer['invoice_id'] }}</p>
<p>Amount: ${{ $customer['amount'] }}</p>

<p>Thank you!</p>
