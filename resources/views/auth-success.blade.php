<!DOCTYPE html>
<html>
<head>
    <title>Authentication Success</title>
    <style>
        body { font-family: Arial; padding: 50px; }
        .box { border: 2px solid green; padding: 20px; background: #e8f5e9; }
    </style>
</head>
<body>
    <div class="box">
        <h1>✓ Google Authentication Working!</h1>
        
        <h2>User Information:</h2>
        <p><strong>Name:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>ID:</strong> {{ $user->id }}</p>
        
        <hr>
        
        <p style="color: green; font-weight: bold;">
            Google OAuth is working correctly! ✓
        </p>
        
        <a href="/login" style="padding: 10px 20px; background: blue; color: white; text-decoration: none;">
            Back to Login
        </a>
    </div>
</body>
</html>