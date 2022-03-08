<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>You've got a new message!</h2>

    <h4>Name: {{ $new_lead->name }}</h4>

    <h4>Email: {{ $new_lead->email }}</h4>

    <p>{{ $new_lead->message }}</p>
</body>
</html>