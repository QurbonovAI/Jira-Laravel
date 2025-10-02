<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JIRA Clone - Ro'yxatdan o'tish</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f4f5f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .register-container {
            background: #ffffff;
            padding: 30px;
            border-radius: 3px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        .register-container h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #dfe1e6;
            border-radius: 3px;
            font-size: 14px;
        }
        .form-group input[type="checkbox"] {
            width: auto;
            margin-right: 5px;
        }
        .btn-primary {
            background: #0052cc;
            color: white;
            padding: 8px 16px;
            border-radius: 3px;
            text-decoration: none;
            font-size: 14px;
            display: block;
            text-align: center;
            border: none;
            cursor: pointer;
        }
        .btn-primary:hover {
            background: #0747a6;
        }
        .alert-danger {
            background: #ffebe6;
            color: #bf2600;
            border-left: 4px solid #ff5630;
            padding: 15px;
            border-radius: 3px;
            margin-bottom: 20px;
        }
        .text-red-500 {
            color: #bf2600;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Ro'yxatdan o'tish</h2>
        @if ($errors->any())
            <div class="alert-danger">
                @foreach ($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="full_name">To'liq ism</label>
                <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required>
                @error('full_name')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">Parol</label>
                <input type="password" id="password" name="password" required>
                @error('password')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password_confirmation">Parolni tasdiqlash</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="is_admin"> Admin sifatida ro'yxatdan o'tish
                </label>
            </div>
            <button type="submit" class="btn-primary">Ro'yxatdan o'tish</button>
        </form>
    </div>
</body>
</html>