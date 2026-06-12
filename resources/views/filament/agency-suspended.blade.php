<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('cabinet.agency_suspended_title') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 50%, #bbf7d0 100%);
            color: #1f2937;
        }
        .container {
            text-align: center;
            max-width: 480px;
            padding: 3rem 2rem;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08);
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
        }
        h1 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: #dc2626;
        }
        p {
            font-size: 1rem;
            line-height: 1.6;
            color: #6b7280;
            margin-bottom: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: #10b981;
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .btn:hover { background: #059669; }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">🚫</div>
        <h1>{{ __('cabinet.agency_suspended_title') }}</h1>
        <p>{{ __('cabinet.agency_suspended_body') }}</p>
        <a href="/" class="btn">{{ __('cabinet.go_home') }}</a>
    </div>
</body>
</html>
