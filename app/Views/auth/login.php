<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #083a23;
        }

        /* Green-900 */
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bg-glow {
            background: radial-gradient(circle, rgba(0, 168, 89, 0.15) 0%, rgba(8, 58, 35, 0) 70%);
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen p-4 overflow-hidden relative">
    <div class="absolute top-1/4 right-1/3 w-96 h-96 bg-glow rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 left-10 w-64 h-64 bg-glow rounded-full blur-2xl"></div>

    <div class="max-w-4xl w-full grid md:grid-cols-2 items-center gap-12 relative z-10">
        <div class="hidden md:block">
            <h1 class="text-white text-7xl font-bold leading-tight tracking-tighter">Welcome<br>Back .!</h1>
            <div class="w-20 h-1.5 bg-[#00A859] mt-8 rounded-full shadow-[0_0_15px_rgba(0,168,89,0.5)]"></div>
        </div>

        <div class="glass p-10 rounded-4xl shadow-2xl">
            <div class="mb-10">
                <h2 class="text-white text-3xl font-bold mb-2">Login</h2>
                <p class="text-green-100/40 text-sm italic">Glad you're back.!</p>
            </div>

            <?php if (session()->getFlashdata('error')) : ?>
                <div class="bg-red-500/10 text-red-400 p-4 rounded-xl text-xs mb-6 border border-red-500/20 flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('login/process') ?>" method="POST" class="space-y-6">
                <div class="relative group">
                    <input type="text" name="username" placeholder="Username" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:border-[#00A859] focus:ring-1 focus:ring-[#00A859] transition-all">
                </div>
                <div class="relative group">
                    <input type="password" name="password" placeholder="Password" required
                        class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-white placeholder-gray-500 focus:outline-none focus:border-[#00A859] focus:ring-1 focus:ring-[#00A859] transition-all">
                </div>

                <div class="flex items-center justify-between text-[11px] px-1">
                    <label class="flex items-center text-gray-400 cursor-pointer hover:text-white transition-colors">
                        <input type="checkbox" class="mr-2 w-4 h-4 rounded border-white/10 bg-white/5 accent-[#00A859]"> Remember me
                    </label>
                    <span class="text-gray-500 cursor-not-allowed">Forgot password?</span>
                </div>

                <button type="submit"
                    class="w-full bg-[#00A859] hover:bg-[#008f4c] text-white font-bold py-4 rounded-2xl shadow-lg shadow-green-900/20 transition-all transform active:scale-[0.98]">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>

</html>