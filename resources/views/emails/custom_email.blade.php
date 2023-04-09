<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom Email</title>
</head>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f6f6f6;
            color:black;
        }
        .email-container {
        max-width: 600px;
        margin: 0 auto;
        padding: 20px;
        background-color: #ffffff;
        box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        border-radius: 5px;
    }

    .header {
        text-align: center;
        padding: 20px 0;
        background-color: #f6f6f6;
        border-bottom: 1px solid #dddddd;
    }

    .header h1 {
        margin: 0;
        font-size: 24px;
        color: #333;
    }

    .content {
        padding: 20px;
        font-size: 16px;
        color: #333;
        line-height: 1.5;
    }

    .footer {
        text-align: center;
        padding: 20px 0;
        background-color: #f6f6f6;
        border-top: 1px solid #dddddd;
    }

    .footer p {
        margin: 0;
        font-size: 14px;
        color: #777;
    }

    a {
        color: #3498db;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }
</style>
<body>
    @php
        $nameParts = explode(' ', $user->name);
        $firstName = array_shift($nameParts);
    @endphp
    <p>Hi {{ $firstName }},</p>

    This is some 

    {!! $fields->message !!}

    <br/>

    {!! $signature !!}
</body>
</html>