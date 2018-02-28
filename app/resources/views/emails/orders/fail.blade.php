<!doctype html>
<html>
<head>
    <meta name="viewport" content="width=device-width">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<div>
    <p>Dear {{ $user_name  or 'user'}}, we have a problem with your order.</p>
    <p>Please contact with us by phone or email.</p>
</div>
<div>
    Description: {{ $description or 'Something is really bad. We can\'t find your order description.' }}
</div>
</body>
</html>
