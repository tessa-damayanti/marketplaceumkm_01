<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #fbf7f2; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h2 style="color: #5c4432; text-align: center;">Reset Password Anda</h2>
        <p style="color: #7b6858; line-height: 1.6;">Halo,
            Kami menerima permintaan untuk mereset password akun Anda di Velora. Jika Anda tidak merasa melakukan permintaan ini, Anda dapat mengabaikan email ini.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $resetUrl }}" style="background-color: #a78d78; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 8px; font-weight: bold; display: inline-block;">Reset Password</a>
        </div>
        
        <p style="color: #7b6858; line-height: 1.6; font-size: 14px;">Atau copy dan paste link berikut ke browser Anda:<br>
        <a href="{{ $resetUrl }}" style="color: #8f7561; word-break: break-all;">{{ $resetUrl }}</a></p>
        
</body>
</html>
