<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Personal Assistant</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }
        
        .login-image {
            background-image: url('https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }
        
        .login-image::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
        }

        .brand-text {
            position: relative;
            z-index: 2;
            color: white;
            top: 40%;
            padding: 0 4rem;
        }

        .login-form-container {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #ffffff;
        }

        .login-wrapper {
            width: 100%;
            max-width: 420px;
            padding: 20px;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            background-color: #f8f9fa;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background-color: #fff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }

        .btn-primary-custom {
            background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%);
            border: none;
            border-radius: 12px;
            padding: 14px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.2s;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>
<body>

    <div class="container-fluid g-0">
        <div class="row g-0">
            
            <div class="col-lg-7 d-none d-lg-block login-image">
                <div class="brand-text">
                    <h1 class="display-4 fw-bold mb-3">Focus on your<br>Goals.</h1>
                    <p class="lead text-white-50">Manajemen tugas, ibadah, dan lifestyle mahasiswa rantau.</p>
                </div>
            </div>

            <div class="col-lg-5 login-form-container">
                <div class="login-wrapper">
                    
                    <div class="text-center mb-5">
                        <h2 class="fw-bold text-dark">Selamat Datang!</h2>
                        <p class="text-muted">Silahkan Login...</p>
                    </div>

                    <form action="{{ route('login') }}" method="POST">
                        @csrf

                        <div class="form-floating mb-3">
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   placeholder="name@example.com" 
                                   required>
                            <label for="email"><i class="bi bi-envelope me-2"></i>Email </label>
                            
                            @error('email')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-floating mb-4">
                            <input type="password" 
                                   class="form-control" 
                                   id="password" 
                                   name="password" 
                                   placeholder="Password" 
                                   required>
                            <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary-custom text-white">
                                MASUK SEKARANG <i class="bi bi-arrow-right ms-2"></i>
                            </button>
                        </div>

                    </form>

                    <div class="text-center mt-5">
                        <p class="small text-muted">Belum punya akun? <a href="{{ route('register') }}" class="text-primary fw-bold text-decoration-none">Daftar disini</a></p>
                        <p class="small text-muted mt-4">&copy; 2025 Kelompok 9 WAD - Telkom University</p>
                    </div>

                </div>
            </div>
            
        </div>
    </div>

</body>
</html>