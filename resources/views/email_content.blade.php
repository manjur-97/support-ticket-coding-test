<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Notification</title>
</head>

<body>
    @if ($status == 'open')
        <p>{{ $description }}</p>
        <p>Customer ID: {{ $customer_id }} </p>
        <p>Customer Name: {{ $customer_name }} </p>
    @endif
    @if ($status == 'closed')
        <p>{{ $feedback }}</p>
        
    @endif



</body>

</html>
