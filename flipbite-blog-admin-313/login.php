<?php
require_once __DIR__ . '/auth.php';

// Already logged in? Don't show the login form again — go straight in.
if (!empty($_SESSION['flipbite_admin_logged_in'])) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
        session_regenerate_id(true);
        $_SESSION['flipbite_admin_logged_in'] = true;
        header('Location: index.php');
        exit;
    }
    $error = 'Wrong username or password.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login | FlipBite</title>
  <meta name="robots" content="noindex, nofollow">
  <link rel="icon" type="image/png" href="/flipbite-logo.png">
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style type="text/tailwindcss">
    @theme { --font-sans: 'Inter', sans-serif; }

      .fade-in-up { animation: fadeInUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; transform: translateY(24px); }
      .delay-100 { animation-delay: 100ms; }
      .delay-200 { animation-delay: 200ms; }
      .float-slow { animation: float 6s ease-in-out infinite; }
      .float-fast { animation: float 4s ease-in-out infinite; }
      .pulse-glow { animation: pulseGlow 4s ease-in-out infinite alternate; }
      .lock-bob { animation: lockBob 3.5s ease-in-out infinite; }
      .shake { animation: shake 0.5s cubic-bezier(.36,.07,.19,.97); }

      @keyframes fadeInUp { to { opacity: 1; transform: translateY(0); } }
      @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-15px); } }
      @keyframes pulseGlow { 0% { opacity: 0.3; transform: scale(1); } 100% { opacity: 0.6; transform: scale(1.1); } }
      @keyframes lockBob { 0%, 100% { transform: translateY(0) rotate(0deg); } 50% { transform: translateY(-6px) rotate(-2deg); } }
      @keyframes shake { 10%, 90% { transform: translateX(-1px); } 20%, 80% { transform: translateX(2px); } 30%, 50%, 70% { transform: translateX(-4px); } 40%, 60% { transform: translateX(4px); } }

      .glass-card {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(16, 185, 129, 0.15);
      }
    </style>
</head>
<body class="bg-[#fafafa] font-sans antialiased text-[#0f172a] min-h-screen flex items-center justify-center px-4 overflow-hidden relative">

  <!-- Cinematic lighting -->
  <div class="absolute top-[-10%] left-1/2 -translate-x-1/2 w-[800px] h-[600px] bg-white rounded-full blur-[120px] opacity-100 pointer-events-none"></div>
  <div class="absolute top-[15%] left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-[#A7F3D0] rounded-full blur-[150px] pulse-glow pointer-events-none -z-10"></div>

  <!-- Floating decorative dots -->
  <div class="absolute top-[20%] left-[12%] w-[10px] h-[10px] rounded-full bg-[#3B82F6]/40 float-slow pointer-events-none"></div>
  <div class="absolute top-[70%] left-[10%] w-[14px] h-[14px] rounded-full bg-[#10B981]/30 float-fast pointer-events-none"></div>
  <div class="absolute top-[25%] right-[10%] w-[12px] h-[12px] rounded-full bg-[#10B981]/30 float-fast pointer-events-none"></div>
  <div class="absolute top-[75%] right-[14%] w-[10px] h-[10px] rounded-full bg-[#3B82F6]/40 float-slow pointer-events-none"></div>

  <div class="w-full max-w-[420px] relative z-10">

    <!-- Badge + heading -->
    <div class="fade-in-up text-center mb-[32px]">
      <div class="inline-flex items-center gap-[8px] bg-white/60 backdrop-blur-sm border border-[#e2e8f0] px-[16px] py-[8px] rounded-full mb-[24px] shadow-sm">
        <div class="w-[8px] h-[8px] bg-[#10B981] rounded-full animate-pulse"></div>
        <span class="text-[#0f172a] text-[12px] font-bold uppercase tracking-[0.15em]">Restricted Access</span>
      </div>
      <h1 class="text-[28px] font-extrabold tracking-tight">FlipBite Admin</h1>
      <p class="text-[#475569] text-[15px] mt-[6px]">Sign in to manage blog posts</p>
    </div>

    <!-- Lock icon -->
    <div class="fade-in-up delay-100 flex justify-center mb-[24px]">
      <div class="relative w-[72px] h-[72px] flex items-center justify-center">
        <span class="absolute inset-0 rounded-full border-2 border-[#10B981]/40"></span>
        <div class="lock-bob relative w-[64px] h-[64px] rounded-full bg-gradient-to-br from-[#10B981] to-[#3B82F6] flex items-center justify-center shadow-[0_10px_30px_rgba(16,185,129,0.35)]">
          <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="11" width="18" height="11" rx="2"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
        </div>
      </div>
    </div>

    <!-- Login card -->
    <form method="POST" id="login-form" class="fade-in-up delay-200 glass-card rounded-[24px] p-[32px] shadow-[0_20px_60px_rgba(15,23,42,0.08)] flex flex-col gap-[18px] <?= $error ? 'shake' : '' ?>">
      <?php if ($error): ?>
        <div class="flex items-center gap-[8px] bg-[#FEF2F2] border border-[#FECACA] text-[#DC2626] text-[14px] font-medium px-[16px] py-[12px] rounded-[12px]">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <div>
        <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Username</label>
        <div class="relative">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-[14px] top-1/2 -translate-y-1/2 pointer-events-none">
            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
          </svg>
          <input type="text" name="username" required autofocus placeholder="Enter your username"
            class="w-full pl-[42px] pr-[16px] py-[12px] rounded-[12px] border border-[#e2e8f0] text-[15px] bg-white focus:outline-none focus:border-[#10B981] focus:ring-[3px] focus:ring-[#10B981]/10 transition-all">
        </div>
      </div>

      <div>
        <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Password</label>
        <div class="relative">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-[14px] top-1/2 -translate-y-1/2 pointer-events-none">
            <rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/>
          </svg>
          <input type="password" name="password" id="password-input" required placeholder="Enter your password"
            class="w-full pl-[42px] pr-[44px] py-[12px] rounded-[12px] border border-[#e2e8f0] text-[15px] bg-white focus:outline-none focus:border-[#10B981] focus:ring-[3px] focus:ring-[#10B981]/10 transition-all">
          <button type="button" id="toggle-password" tabindex="-1"
            class="absolute right-[12px] top-1/2 -translate-y-1/2 text-[#94A3B8] hover:text-[#475569] transition-colors">
            <svg id="eye-open" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"/><circle cx="12" cy="12" r="3"/>
            </svg>
            <svg id="eye-closed" class="hidden" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a21.62 21.62 0 0 1 5.06-6.06M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a21.6 21.6 0 0 1-2.18 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>
            </svg>
          </button>
        </div>
      </div>

      <button type="submit"
        class="mt-[8px] inline-flex items-center justify-center gap-[8px] bg-[#111827] text-white py-[13px] rounded-[12px] font-medium text-[15px] hover:bg-[#1E293B] hover:-translate-y-[1px] transition-all duration-300 shadow-[0_10px_30px_rgba(15,23,42,0.15)] group">
        Log In
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="group-hover:translate-x-[3px] transition-transform"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </button>
    </form>

    <p class="fade-in-up delay-200 text-center text-[#94A3B8] text-[13px] mt-[24px]">Private area &middot; FlipBite Agency</p>
  </div>

  <script>
    const toggleBtn = document.getElementById('toggle-password');
    const passwordInput = document.getElementById('password-input');
    const eyeOpen = document.getElementById('eye-open');
    const eyeClosed = document.getElementById('eye-closed');
    toggleBtn.addEventListener('click', () => {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      eyeOpen.classList.toggle('hidden', isPassword);
      eyeClosed.classList.toggle('hidden', !isPassword);
    });
  </script>
</body>
</html>
