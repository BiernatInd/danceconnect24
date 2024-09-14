<!DOCTYPE html>
<html>

<head>
    <title>Welcome</title>
</head>

<body>
    <h1>Welcome, {{ $user->nickname }}!</h1>
    <p>Your account has been created successfully.</p>
    <p>Here are your login details:</p>
    <p>Email: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>
</body>

</html>