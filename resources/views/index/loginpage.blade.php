<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Finance Tracker</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <link rel="stylesheet" href="{{ asset('dist/css/login.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="card login-card border-0">
    
        <div class="login-header">
            <i class="fa-solid fa-wallet"></i>
            <h2>Welcome Back!</h2>
            <p>Silakan login untuk mengelola keuangan Anda.</p>
        </div>
    
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size: 14px; border-radius: 10px;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form method="POST" action="{{ route('login') }}">
            @csrf
    
            <div class="mb-4">
                <label for="email" class="form-label fw-bold" style="font-size: 13px; color: var(--muted);">EMAIL ADDRESS</label>
                <div class="form-wrapper">
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required autofocus>
                </div>
            </div>
    
            <div class="mb-4">
                <label for="password" class="form-label fw-bold" style="font-size: 13px; color: var(--muted);">PASSWORD</label>
                
                <div class="form-wrapper position-relative">
                    <input type="password" 
                           class="form-control" 
                           id="password" 
                           name="password" 
                           placeholder="••••••••" 
                           required 
                           style="padding-right: 45px;">
                    
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" 
                          onclick="togglePassword()" 
                          style="cursor: pointer; z-index: 10;">
                        <i class="fa-solid fa-eye" id="toggleIcon"></i>
                    </span>
                </div>
            </div>
    
            <div class="d-flex justify-content-between align-items-center mb-4" style="font-size: 13px;">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                    <label class="form-check-label text-muted" for="remember_me">
                        Ingat Saya
                    </label>
                </div>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-decoration-none text-muted hover-primary">
                        Lupa Password?
                    </a>
                @endif
            </div>
    
            <button type="submit" class="btn btn-login btn-primary shadow-sm">
                LOGIN SEKARANG
            </button>
    
            <div class="text-center mt-4" style="font-size: 14px; color: var(--muted);">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="link-register">Daftar disini</a>
            </div>
        </form>
      </div>
    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

      <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            // Cek tipe input saat ini
            if (passwordInput.type === 'password') {
                // Ubah jadi text (Show)
                passwordInput.type = 'text';
                // Ganti icon jadi mata dicoret
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                // Kembalikan jadi password (Hide)
                passwordInput.type = 'password';
                // Kembalikan icon jadi mata biasa
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
      </script>

</body>
</html>