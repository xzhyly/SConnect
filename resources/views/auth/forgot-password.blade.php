<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — ScholarConnect</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #F4F6F9;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-box {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.08);
            padding: 2.5rem;
            width: 100%;
            max-width: 440px;
        }

        .icon-circle {
            width: 64px;
            height: 64px;
            background: #FEF3C7;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.25rem;
        }

        .icon-circle i {
            font-size: 1.8rem;
            color: #F5A623;
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #1B2A47;
            text-align: center;
            margin-bottom: 0.5rem;
        }

        .card-subtitle {
            font-size: 0.85rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .info-box {
            background: #F4F6F9;
            border-radius: 10px;
            padding: 1.1rem 1.25rem;
            margin-bottom: 1.5rem;
        }

        .info-box p {
            font-size: 0.85rem;
            color: #444;
            margin: 0;
            line-height: 1.6;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.75rem 1rem;
            background: #fff;
            border-radius: 10px;
            border: 1.5px solid #E5E7EB;
            margin-bottom: 0.75rem;
            font-size: 0.85rem;
            color: #1B2A47;
            font-weight: 500;
        }

        .contact-item i {
            color: #F5A623;
            font-size: 1.1rem;
        }

        .btn-back {
            background: #1B2A47;
            color: #fff;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.65rem;
            border-radius: 10px;
            border: none;
            width: 100%;
            text-decoration: none;
            display: block;
            text-align: center;
            transition: background 0.2s;
        }

        .btn-back:hover {
            background: #0F1C33;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="card-box">
        <div class="icon-circle">
            <i class="bi bi-shield-lock-fill"></i>
        </div>
        <div class="card-title">Forgot Password?</div>
        <div class="card-subtitle">
            Password reset is managed by the system administrator.<br>
            Please contact us through any of the following:
        </div>

        <div class="contact-item">
            <i class="bi bi-envelope-fill"></i>
            admin@scholarconnect.edu.ph
        </div>
        <div class="contact-item">
            <i class="bi bi-telephone-fill"></i>
            (054) 123-4567
        </div>
        <div class="contact-item">
            <i class="bi bi-geo-alt-fill"></i>
            Camarines Norte State College, Daet
        </div>

        <div class="info-box">
            <p>
                <i class="bi bi-info-circle-fill" style="color:#F5A623;"></i>
                Please provide your <strong>full name</strong> and <strong>registered email address</strong> when
                contacting the administrator.
            </p>
        </div>

        <a href="{{ route('login') }}" class="btn-back">
            <i class="bi bi-arrow-left"></i> Back to Login
        </a>
    </div>
</body>

</html>
