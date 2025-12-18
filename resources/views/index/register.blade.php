@extends('layouts.guest')

@section('title', 'Register - Finance Tracker')

@section('content')
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
                <div class="form-wrapper position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                        <i class="fa-regular fa-user"></i>
                    </span>
                    
                    <input type="text" class="form-control ps-5" id="name" name="name" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
                </div>
            </div>
        
            <div class="mb-3">
                <label for="email" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">ALAMAT EMAIL</label>
                <div class="form-wrapper position-relative">
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                        <i class="fa-regular fa-envelope"></i>
                    </span>
        
                    <input type="email" class="form-control ps-5" id="email" name="email" placeholder="nama@email.com" value="{{ old('email') }}" required>
                </div>
            </div>
        
            <div class="mb-3">
                <label for="password" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">PASSWORD</label>
                <div class="form-wrapper position-relative">
                    
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                        <i class="fa-solid fa-lock"></i>
                    </span>
        
                    <input type="password" 
                           class="form-control ps-5 pe-5" 
                           id="password" 
                           name="password" 
                           placeholder="Minimal 8 karakter" 
                           required>
                    
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" 
                          onclick="toggleRegister('password', 'iconPass')" 
                          style="cursor: pointer; z-index: 10;">
                        <i class="fa-solid fa-eye" id="iconPass"></i>
                    </span>
                </div>
            </div>
        
            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-bold" style="font-size: 12px; color: var(--muted);">KONFIRMASI PASSWORD</label>
                <div class="form-wrapper position-relative">
                    
                    <span class="position-absolute top-50 start-0 translate-middle-y ms-3 text-muted">
                        <i class="fa-solid fa-check-double"></i>
                    </span>
        
                    <input type="password" 
                           class="form-control ps-5 pe-5" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Ulangi password" 
                           required>
                    
                    <span class="position-absolute top-50 end-0 translate-middle-y me-3 text-muted" 
                          onclick="toggleRegister('password_confirmation', 'iconConfirm')" 
                          style="cursor: pointer; z-index: 10;">
                        <i class="fa-solid fa-eye" id="iconConfirm"></i>
                    </span>
                </div>
            </div>
        
            <button type="submit" class="btn btn-login btn-primary shadow-sm w-100 py-2 rounded-3 fw-bold border-0">
                DAFTAR SEKARANG
            </button>
        
            <div class="text-center mt-4" style="font-size: 14px; color: var(--muted);">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="link-register">Login disini</a>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
<script>
    function toggleRegister(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>
@endpush