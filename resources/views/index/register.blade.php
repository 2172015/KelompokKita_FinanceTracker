<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard - Finance Tracker</title>
  
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  
  <link rel="stylesheet" href="{{ asset('dist/css/login.css') }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>    
    <div class="card login-card border-0">
    
        <div class="login-header">
            <i class="fa-solid fa-user-plus"></i>
            <h2 style="font-size: 24px; font-weight: 700;">Buat Akun Baru</h2>
            <p style="font-size: 14px; color: var(--muted);">Mulai atur keuangan Anda hari ini.</p>
        </div>
    
        @if ($errors->any())
            <div class="alert alert-danger py-2" style="font-size: 13px; border-radius: 10px;">
                <ul class="mb-0 ps-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    
        <form method="POST" action="{{ route('register') }}">
            @csrf
    
            <div class="mb-3">
                <label for="name" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">NAMA LENGKAP</label>
                <div class="form-wrapper">
                    <input type="text" class="form-control" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                    <i class="fa-regular fa-user input-icon"></i>
                </div>
            </div>
    
            <div class="mb-3">
                <label for="email" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">ALAMAT EMAIL</label>
                <div class="form-wrapper">
                    <input type="email" class="form-control" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                    <i class="fa-regular fa-envelope input-icon"></i>
                </div>
            </div>
    
            <div class="mb-3">
                <label for="password" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">PASSWORD</label>
                <div class="form-wrapper">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 8 karakter" required>
                    <i class="fa-solid fa-lock input-icon"></i>
                </div>
            </div>
    
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">KONFIRMASI PASSWORD</label>
                <div class="form-wrapper">
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password" required>
                    <i class="fa-solid fa-check-double input-icon"></i>
                </div>
            </div>
    
            <button type="submit" class="btn-login shadow-sm">
                DAFTAR SEKARANG
            </button>
    
            <div class="text-center mt-4" style="font-size: 14px; color: var(--muted);">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="link-register">Login disini</a>
            </div>
        </form>
      </div>
    
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>