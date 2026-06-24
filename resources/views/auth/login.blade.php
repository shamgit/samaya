<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>ERP System – Dashboard</title>
<!-- Favicon -->
<link rel="shortcut icon" href="{{ asset('assets/img/favicon.png')}}">
<link rel="preconnect" href="https://fonts.googleapis.com"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<!-- CSS Global -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet"/>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<style>
  /* ── RESET ── */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
  :root {
    --bg:         #eef0ec;
    --white:      #ffffff;
    --text:       #111111;
    --muted:      #6b7280;
    --border:     #d1d5db;
    --green-acc:  #A8E063;
    --green-dark: #1a2e00;
   --font:       'Poppins', sans-serif;
    --radius-lg:  28px;
    --radius-pill:50px;
    --shadow-card:0 20px 60px rgba(0,0,0,0.09);
    --transition: 0.2s ease;
  }
  body {
    font-family: var(--font);
    background: var(--bg);
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    height:100vh;
  }

  /* ── WRAPPER ── */
  .login-wrapper {
    width: 100%;
    max-width: 1100px;
    display: grid;
    grid-template-columns: 1.3fr 1fr;
    gap: 40px;
    align-items: center;
  }

  /* ═══════════════════════
     LEFT PANEL
  ═══════════════════════ */
  .left-panel { padding: 20px 0 20px 0px; }

  /* Brand */
  .brand {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 50px;
  }
  

  /* Hero text */
  .hero-title {
    font-size: clamp(40px, 5vw, 60px);
    font-weight: 600;
    color: var(--text);
    line-height: 1.05;
    letter-spacing: -2px;
    margin-bottom: 16px;
  }
  .hero-subtitle {
    font-size: 16px;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 18px;
  }
  .hero-desc {
    font-size: 14px;
    color: var(--muted);
    line-height: 1.7;
    
  }


  .error-text {
      color: red;
  }

  /* ═══════════════════════
     RIGHT PANEL – CARD
  ═══════════════════════ */
  .login-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: 42px 30px 20px;
    box-shadow: var(--shadow-card);
    width: 100%;
  }

  .card-title-text {
    font-size: 26px; font-weight: 800; color: var(--text);
    text-align: center; margin-bottom: 8px; letter-spacing: -0.5px;
  }
  .card-subtitle {
    font-size: 14px; color: var(--muted); text-align: center; margin-bottom: 36px;
  }

  /* Form fields */
  .field-wrap {
    position: relative; margin-bottom: 16px;
  }
  .form-control-pill {
    width: 100%;
    padding: 12px 48px 12px 20px;
    border: 1.5px solid var(--border);
    border-radius: var(--radius-pill);
    background: var(--white);
    font-family: var(--font);
    font-size: 14px;
    font-weight: 500;
    color: var(--text);
    outline: none;
    transition: border-color var(--transition), box-shadow var(--transition);
  }
  .form-control-pill::placeholder { color: #9ca3af; font-weight: 400; }
  .form-control-pill:focus {
    border-color: #6b7280;
    box-shadow: 0 0 0 3px rgba(168,224,99,0.2);
  }
  .form-control-pill.is-invalid {
    border-color: #ef4444;
    box-shadow: 0 0 0 3px rgba(239,68,68,0.12);
  }

  /* Password toggle */
  .pwd-toggle {
    position: absolute; right: 18px; top: 50%; transform: translateY(-50%);
    background: none; border: none; cursor: pointer;
    color: #9ca3af; font-size: 16px; padding: 4px;
    transition: color var(--transition);
    display: flex; align-items: center;
  }
  .pwd-toggle:hover { color: var(--text); }

  /* Forgot link */
  .forgot-link {
    display: block; text-align: center;
    font-size: 13.5px; font-weight: 600; color: var(--text);
    text-decoration: none; margin: 12px 0 28px;
    transition: color var(--transition);
  }
  .forgot-link:hover { color: var(--muted); }

  /* Login button */
  .btn-login {
    width: 100%;
    padding: 13px 20px;
    background: #111111;
    color: var(--green-acc);
    font-family: var(--font);
    font-size: 16px;
    font-weight: 700;
    border: none;
    border-radius: var(--radius-pill);
    cursor: pointer;
    letter-spacing: 0.2px;
    transition: background var(--transition), transform 0.15s ease, box-shadow var(--transition);
  }
  .btn-login:hover {
    background: #222222;
    transform: translateY(-1px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.2);
  }
  .btn-login:active { transform: translateY(0); }
  .btn-login:disabled {
    opacity: 0.6; cursor: not-allowed; transform: none;
  }

  /* Loading spinner inside button */
  .btn-login .spinner {
    display: none; width: 18px; height: 18px; border-radius: 50%;
    border: 2px solid rgba(168,224,99,0.3); border-top-color: var(--green-acc);
    animation: spin 0.7s linear infinite; margin: 0 auto;
  }
  .btn-login.loading .btn-text { display: none; }
  .btn-login.loading .spinner { display: block; }
  @keyframes spin { to { transform: rotate(360deg); } }

  /* Error message */
  .error-msg {
    display: none; align-items: center; gap: 6px;
    padding: 10px 16px; background: #fef2f2;
    border: 1px solid #fecaca; border-radius: 12px;
    font-size: 13px; font-weight: 600; color: #dc2626; margin-bottom: 16px;
  }
  .error-msg.show { display: flex; }

  /* Divider */
  .or-divider {
    display: flex; align-items: center; gap: 12px;
    margin: 24px 0 20px; font-size: 12px; font-weight: 600; color: var(--muted);
  }
  .or-divider::before, .or-divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  /* SSO Button */
  .btn-sso {
    width: 100%; padding: 13px 20px;
    background: transparent; color: var(--text);
    font-family: var(--font); font-size: 14px; font-weight: 600;
    border: 1.5px solid var(--border); border-radius: var(--radius-pill);
    cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px;
    transition: all var(--transition);
  }
  .btn-sso:hover { background: var(--bg); border-color: #9ca3af; }

  /* Footer note */
  .card-footer-note {
    text-align: center; margin-top: 28px;
    font-size: 12px; color: var(--muted);
  }

  /* ═══════════════════════
     DECORATIVE BG BLOBS
  ═══════════════════════ */
  .blob {
    position: fixed; border-radius: 50%; pointer-events: none; z-index: 0;
    filter: blur(60px); opacity: 0.35;
  }
  .blob-1 { width: 340px; height: 340px; background: #A8E063; top: -80px; left: -80px; }
  .blob-2 { width: 280px; height: 280px; background: #c5f07a; bottom: -60px; right: 20%; }

  /* ═══════════════════════
     RESPONSIVE
  ═══════════════════════ */

  /* Tablet: stack vertically */
  @media (max-width: 860px) {
    .login-wrapper {
      grid-template-columns: 1fr;
      max-width: 480px;
      gap: 32px;
    }
    .left-panel { padding: 0; text-align: center; }
    .brand { justify-content: center; margin-bottom: 24px; }
    .hero-desc { margin: 0 auto; }
    .feature-pills { justify-content: center; }
    .login-card { padding: 40px 32px 36px; }
  }

  /* Mobile */
  @media (max-width: 480px) {
    body { padding: 16px 12px; align-items: flex-start; padding-top: 32px; }
    .hero-title { font-size: 36px; letter-spacing: -1px; }
    .hero-subtitle { font-size: 14px; }
    .login-card { padding: 32px 22px 28px; border-radius: 20px; }
    .card-title-text { font-size: 22px; }
    .form-control-pill { padding: 13px 44px 13px 18px; font-size: 14px; }
    .btn-login { padding: 14px; font-size: 15px; }
    .feature-pills { display: none; }
  }

  /* Very small */
  @media (max-width: 360px) {
    .hero-title { font-size: 30px; }
    .login-card { padding: 28px 16px 24px; }
  }
  
</style>
</head>
<body>

<!-- Background blobs -->
<div class="blob blob-1"></div>
<div class="blob blob-2"></div>

<div class="login-wrapper" style="position:relative;z-index:1;">

  <!-- ═══════════ LEFT PANEL ═══════════ -->
  <div class="left-panel">

    <!-- Brand -->
    <div class="brand">
       <img src="{{ asset('assets/img/logo.png')}}" >
    </div>

    <!-- Hero -->
    <h1 class="hero-title">Hey, Hello!</h1>
    <p class="hero-subtitle">Welcome to the ERP System</p>
    <p class="hero-desc">
      Streamline purchasing with a centralized platform for managing payroll, sales, vendors, purchase requests, approvals, and inventory.
    </p>


  </div>

  <!-- ═══════════ RIGHT PANEL ═══════════ -->
  <div class="login-card">

    <h2 class="card-title-text">Welcome Back</h2>
    <p class="card-subtitle">Please enter your credentials to continue.</p>

    <!-- Error message -->
    <div class="error-msg" id="errorMsg">
      <i class="bi bi-exclamation-circle-fill"></i>
      <span id="errorText">Invalid email or password.</span>
    </div>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="field-wrap">

                <x-input-label for="email" :value="__('Email')" />

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="form-control-pill"
                    placeholder="Enter Email"
                >

                <x-input-error :messages="$errors->get('email')" class="error-text" />

            </div>

            <!-- Password -->
            <div class="field-wrap">

                <x-input-label for="password" :value="__('Password')" />

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    class="form-control-pill"
                    placeholder="Password"
                    autocomplete="current-password"
                >

                <x-input-error :messages="$errors->get('password')" class="error-text" />

                <!-- Toggle Button -->
                <button
                    type="button"
                    class="pwd-toggle"
                    id="pwdToggle"
                >
                    <i class="bi bi-eye-slash text-center mt-4" id="pwdIcon"></i>
                </button>

            </div>

            <!-- Remember -->
            <!-- <div class="remember-wrap">
                <label>
                    <input type="checkbox" name="remember">
                    Remember me
                </label>
            </div> -->

            <!-- Forgot password -->
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
            @endif

            <!-- Login button -->
            <button type="submit" class="btn-login">
            <span class="btn-text">Login</span>
            </button>

            <!-- OR divider -->
            <!-- <div class="or-divider">or</div> -->

            <p class="forgot-link d-flex gap-2 justify-content-center mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="fw-bold">
                    Sign Up
                </a>
            </p>
            <!-- SSO -->
            <!-- <button type="button" class="btn-sso">
                <svg width="18" height="18" viewBox="0 0 48 48" fill="none">
                <path d="M43.6 20.1H42V20H24v8h11.3C33.7 32.7 29.3 36 24 36c-6.6 0-12-5.4-12-12s5.4-12 12-12c3.1 0 5.8 1.1 7.9 3l5.7-5.7C34.5 6.5 29.5 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.6-.4-3.9z" fill="#FFC107"/>
                <path d="M6.3 14.7l6.6 4.8C14.7 16 19.1 13 24 13c3.1 0 5.8 1.1 7.9 3l5.7-5.7C34.5 6.5 29.5 4 24 4 16.3 4 9.7 8.4 6.3 14.7z" fill="#FF3D00"/>
                <path d="M24 44c5.4 0 10.2-2 13.8-5.2l-6.4-5.4C29.5 35.3 26.9 36 24 36c-5.3 0-9.7-3.3-11.3-8L6.1 33.3C9.5 39.6 16.3 44 24 44z" fill="#4CAF50"/>
                <path d="M43.6 20.1H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4 5.4l6.4 5.4C43 35 44 29.8 44 24c0-1.3-.1-2.6-.4-3.9z" fill="#1976D2"/>
                </svg>
                Continue with Google
            </button> -->

        </form>
         <p class="card-footer-note">
            Protected by enterprise-grade security &nbsp;·&nbsp; <a href="#" style="color:inherit;font-weight:600;">Privacy Policy</a>
         </p>
    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
	@if(session('toast_error'))
		Swal.fire({
			icon: 'error',
			title: 'error',
			text: "{{ session('toast_error') }}",
			confirmButtonColor: '#d33'
		});
	@endif

	@if(session('toast_success'))
		Swal.fire({
			icon: 'success',
			title: 'Downgrade Successful',
			text: "{{ session('toast_success') }}",
			confirmButtonColor: '#3085d6'
		});
	@endif
</script>
<script>
    const pwdToggle = document.getElementById('pwdToggle');
    const password = document.getElementById('password');
    const pwdIcon = document.getElementById('pwdIcon');

    pwdToggle.addEventListener('click', function () {

        if (password.type === 'password') {

            password.type = 'text';

            pwdIcon.classList.remove('bi-eye-slash');
            pwdIcon.classList.add('bi-eye');

        } else {

            password.type = 'password';

            pwdIcon.classList.remove('bi-eye');
            pwdIcon.classList.add('bi-eye-slash');
        }
    });
</script>
</body>
</html>