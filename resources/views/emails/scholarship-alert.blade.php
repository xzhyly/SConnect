<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #1B2A47; padding: 30px; text-align: center; }
        .header h1 { color: #F5A623; margin: 0; font-size: 24px; }
        .header p { color: #fff; margin: 5px 0 0; font-size: 14px; }
        .body { padding: 30px; }
        .body h2 { color: #1B2A47; }
        .detail { background: #f9f9f9; border-left: 4px solid #F5A623; padding: 15px; margin: 15px 0; border-radius: 4px; }
        .detail p { margin: 5px 0; color: #333; font-size: 14px; }
        .btn { display: inline-block; margin-top: 20px; padding: 12px 30px; background: #F5A623; color: #1B2A47; text-decoration: none; border-radius: 5px; font-weight: bold; }
        .footer { background: #0F1C33; padding: 20px; text-align: center; color: #aaa; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>ScholarConnect</h1>
            <p>Camarines Norte State College</p>
        </div>
        <div class="body">
            <h2>Hi, {{ $user->name }}!</h2>
            <p>A new scholarship matching your profile is now available:</p>
            <div class="detail">
                <p><strong>Title:</strong> {{ $scholarship->title }}</p>
                <p><strong>Provider:</strong> {{ $scholarship->provider }}</p>
                <p><strong>Deadline:</strong> {{ $scholarship->deadline ? $scholarship->deadline->format('F d, Y') : 'Open' }}</p>
                <p><strong>Benefits:</strong> {{ $scholarship->benefits ?? 'See application link' }}</p>
                @if($scholarship->minimum_gwa)
                <p><strong>Minimum GWA:</strong> {{ $scholarship->minimum_gwa }}</p>
                @endif
                @if($scholarship->required_course)
                <p><strong>Required Course:</strong> {{ $scholarship->required_course }}</p>
                @endif
            </div>
            @if($scholarship->application_link)
            <a href="{{ $scholarship->application_link }}" class="btn">Apply Now</a>
            @endif
        </div>
        <div class="footer">
            <p>You received this because you enabled email notifications on ScholarConnect.</p>
            <p>&copy; {{ date('Y') }} ScholarConnect — CNSC IT 111</p>
        </div>
    </div>
</body>
</html>