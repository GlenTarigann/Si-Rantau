<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Personal Assistant</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7fe;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 20px;
        }

        .register-card {
            background: #ffffff;
            padding: 2.5rem;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(26, 35, 126, 0.1);
            width: 100%;
            max-width: 450px;
            border-top: 5px solid #1A237E;
        }

        .register-header h2 {
            color: #1A237E;
            font-weight: 700;
        }

        .form-control:focus {
            border-color: #1A237E;
            box-shadow: 0 0 0 3px rgba(26, 35, 126, 0.15);
        }

        .btn-primary-custom {
            background-color: #1A237E;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            background-color: #0d145a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 35, 126, 0.3);
        }

        .input-group-text {
            background-color: transparent;
            color: #1A237E;
        }

        .text-link {
            color: #1A237E;
            text-decoration: none;
            font-weight: 600;
        }
    </style>
</head>
<body>

    <div class="register-card">
        <div class="text-center mb-4">
            <h2 class="mb-1">Buat Akun</h2>
            <p class="text-muted small">Bergabunglah untuk hidup lebih terencana</p>
        </div>

        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label small fw-bold">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="" required>
                </div>
                @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label small fw-bold">Email Mahasiswa</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="" required>
                </div>
                @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="" required>
                </div>
                @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>

            <button type="submit" class="btn btn-primary-custom w-100 text-white mb-3">
                DAFTAR SEKARANG 
            </button>
        </form>

        <div class="text-center">
            <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-link">Login disini</a></p>
        </div>
    </div>

</body>
</html>