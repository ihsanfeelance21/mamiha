<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Login - Administrator Access</title>
    
    <link rel="stylesheet" href="<?= base_url('css/app.css') ?>">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center overflow-hidden text-gray-300 bg-[#14181d] bg-[radial-gradient(circle_at_top_left,#1a2026_0%,#0f1216_100%)]">

    <div class="fixed -bottom-[20%] -right-[10%] w-[80%] h-[80%] bg-[radial-gradient(circle,rgba(16,185,129,0.15)_0%,rgba(16,185,129,0)_65%)] blur-[100px] -z-10"></div>
    <main class="w-full max-w-md px-6 z-10">
        <div class="relative rounded-3xl p-10 overflow-hidden bg-white/[0.04] backdrop-blur-[20px] border border-white/5 shadow-[0_0_60px_rgba(16,185,129,0.15),inset_0_0_20px_rgba(255,255,255,0.01)]">
            
            <div class="absolute inset-0 bg-gradient-to-br from-white/[0.06] via-white/[0.01] to-transparent pointer-events-none"></div>
            
            <header class="flex flex-col items-center mb-8 relative z-10">
                <div class="w-24 h-24 mb-4 rounded-2xl border-2 border-emerald-500/30 flex items-center justify-center bg-black/20 overflow-hidden p-3 shadow-lg shadow-emerald-500/10">
                    <img src="<?= base_url('uploads/pengaturan/logo.png') ?>" 
                         alt="Logo" 
                         class="w-full h-full object-contain filter drop-shadow-md"
                         onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name=Admin&background=10b981&color=fff';">
                </div>
                
                <h1 class="text-xl text-gray-400 font-normal">Welcome back, <span class="text-gray-200 font-semibold">Administrator</span></h1>
            </header>
            <?php if (session()->getFlashdata('error')) : ?>
                <div class="relative z-10 bg-red-500/10 text-red-400 p-4 rounded-xl text-xs mb-6 border border-red-500/20 flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-base"></i>
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>
            <form action="<?= base_url('login/process') ?>" method="POST" class="space-y-5 relative z-10">
                <?= csrf_field() ?>
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-emerald-500/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <input type="text" id="username" name="username" placeholder="Username" required
                        class="block w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-gray-500 text-gray-200 bg-black/25 border border-emerald-500/25 focus:ring-0 focus:border-emerald-500/70 focus:shadow-[0_0_15px_rgba(16,185,129,0.2)] focus:outline-none transition-all duration-300" />
                </div>
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-emerald-500/70" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <input type="password" id="password" name="password" placeholder="Password" required
                        class="block w-full pl-11 pr-4 py-3 rounded-xl text-sm placeholder-gray-500 text-gray-200 bg-black/25 border border-emerald-500/25 focus:ring-0 focus:border-emerald-500/70 focus:shadow-[0_0_15px_rgba(16,185,129,0.2)] focus:outline-none transition-all duration-300" />
                </div>
                
                <div class="flex items-center justify-between text-xs">
                    <div class="flex items-center">
                        <input type="checkbox" id="remember-me" name="remember-me" 
                            class="h-4 w-4 rounded bg-black/30 border-emerald-500/40 text-emerald-500 focus:ring-emerald-500 focus:ring-offset-0 checked:bg-emerald-500 checked:border-emerald-500 transition-colors" />
                        <label for="remember-me" class="ml-2 block text-gray-400 cursor-pointer hover:text-gray-300 transition-colors">
                            Remember me
                        </label>
                    </div>
                    <div class="text-xs">
                        <a href="#" class="font-medium text-emerald-500 hover:text-emerald-400 transition-colors">
                            Forgot password?
                        </a>
                    </div>
                </div>
                
                <div class="pt-4">
                    <button type="submit"
                        class="w-full py-3 px-4 rounded-full text-white font-bold text-sm tracking-widest uppercase focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 focus:ring-offset-[#14181d] bg-gradient-to-b from-emerald-500 to-emerald-600 shadow-[0_10px_30px_rgba(16,185,129,0.15)] hover:-translate-y-[1px] hover:shadow-[0_12px_35px_rgba(16,185,129,0.25)] transition-all duration-200 active:scale-[0.98]">
                        LOGIN
                    </button>
                </div>
            </form>
            </div>
    </main>
    </body>
</html>