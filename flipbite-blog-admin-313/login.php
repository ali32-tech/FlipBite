<?php
require_once __DIR__ . '/auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username === ADMIN_USERNAME && password_verify($password, ADMIN_PASSWORD_HASH)) {
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
  <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <style type="text/tailwindcss">
    @theme { --font-sans: 'Inter', sans-serif; }
  </style>
</head>
<body class="bg-[#fafafa] font-sans antialiased text-[#0f172a] min-h-screen flex items-center justify-center px-4">
  <div class="w-full max-w-[400px]">
    <div class="text-center mb-[32px]">
      <div class="w-[48px] h-[48px] mx-auto mb-[16px]">
        <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-full">
          <path d="M20 4L36 20L20 36L4 20L20 4Z" fill="url(#g)" fill-opacity="0.15" stroke="url(#g)" stroke-width="3" stroke-linejoin="round"/>
          <path d="M12 20L20 12L28 20" stroke="#10B981" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M16 24L20 20L24 24" stroke="#3B82F6" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
          <circle cx="20" cy="20" r="2" fill="#10B981"/>
          <defs><linearGradient id="g" x1="4" y1="4" x2="36" y2="36"><stop stop-color="#10B981"/><stop offset="1" stop-color="#3B82F6"/></linearGradient></defs>
        </svg>
      </div>
      <h1 class="text-[22px] font-bold">FlipBite Admin</h1>
    </div>

    <form method="POST" class="bg-white border border-[#e2e8f0] rounded-[20px] p-[32px] shadow-[0_10px_40px_rgba(0,0,0,0.04)] flex flex-col gap-[16px]">
      <?php if ($error): ?>
        <div class="bg-[#FEF2F2] border border-[#FECACA] text-[#DC2626] text-[14px] font-medium px-[16px] py-[12px] rounded-[12px]"><?= htmlspecialchars($error) ?></div>
      <?php endif; ?>
      <div>
        <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Username</label>
        <input type="text" name="username" required autofocus
          class="w-full px-[16px] py-[12px] rounded-[12px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
      </div>
      <div>
        <label class="block text-[13px] font-bold text-[#475569] mb-[6px]">Password</label>
        <input type="password" name="password" required
          class="w-full px-[16px] py-[12px] rounded-[12px] border border-[#e2e8f0] text-[15px] focus:outline-none focus:border-[#10B981]">
      </div>
      <button type="submit"
        class="mt-[8px] bg-[#111827] text-white py-[12px] rounded-[12px] font-medium text-[15px] hover:bg-[#1E293B] transition-colors">
        Log In
      </button>
    </form>
  </div>
</body>
</html>
