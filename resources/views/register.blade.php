<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Personal Assistant</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Poppins', sans-serif; overflow-x: hidden; }
        
        .register-image {
            background-image: url('https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            height: 100vh;
            position: relative;
        }
        
        .register-image::before {
            content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0;
            background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.4) 100%);
        }

        .brand-text {
            position: relative; z-index: 2; color: white; top: 40%; padding: 0 4rem;
        }

        .form-container {
            min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #fff;
        }

        .register-wrapper { width: 100%; max-width: 450px; padding: 20px; }
        
        .form-control, .form-select {
            border-radius: 12px; padding: 12px 15px; background-color: #f8f9fa; border: 2px solid transparent;
        }
        .form-control:focus, .form-select:focus {
            background-color: #fff; border-color: #4f46e5; box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
        }
        .btn-primary-custom {
            background: linear-gradient(90deg, #4f46e5 0%, #3b82f6 100%);
            border: none; border-radius: 12px; padding: 14px; font-weight: 600; color: white;
        }
        .btn-primary-custom:hover { transform: translateY(-2px); box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3); }
    </style>
</head>
<body>

<div class="container-fluid g-0">
    <div class="row g-0">
        
        <div class="col-lg-5 form-container">
            <div class="register-wrapper">
                
                <div class="mb-4">
                    <h2 class="fw-bold text-dark">Buat Akun Baru </h2>
                    <p class="text-muted">Mulai atur hidup kuliahmu lebih terencana.</p>
                </div>

                <form action="{{ route('register') }}" method="POST">
                    @csrf

                    <div class="form-floating mb-3">
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Nama" value="{{ old('name') }}" required>
                        <label for="name"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                        <label for="email"><i class="bi bi-envelope me-2"></i>Email Mahasiswa</label>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Password" required>
                        <label for="password"><i class="bi bi-lock me-2"></i>Password (Min. 8 Karakter)</label>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary-custom">
                            DAFTAR SEKARANG
                        </button>
                    </div>

                </form>

                <div class="text-center mt-4">
                    <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}" class="text-primary fw-bold text-decoration-none">Login disini</a></p>
                </div>

            </div>
        </div>

        <div class="col-lg-7 d-none d-lg-block register-image">
            <div class="brand-text">
                <h1 class="display-4 fw-bold mb-3">Join the<br>Community. ✨</h1>
                <p class="lead text-white-50">Bergabunglah dengan ribuan mahasiswa rantau lainnya yang lebih produktif.</p>
            </div>
        </div>
        
    </div>
</div>

</body>
</html>