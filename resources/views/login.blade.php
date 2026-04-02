<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ICAS LMS Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .role-btn { transition: all 0.2s ease-in-out; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4 bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{ asset('images/green.png') }}');">

<div class="text-center w-full max-w-sm">
    
    <div class="text-center mb-8">
        <img src="{{ asset('images/icas-logo.png') }}" alt="ICAS Philippines Logo" class="mx-auto h-24 w-auto object-contain">
        <p class="mt-2 text-[#388e3c] text-sm font-bold">LEARNING MANAGEMENT SYSTEM</p>
    </div>

    <div class="bg-[#52af59] p-8 rounded-[2rem] shadow-xl border border-white/20">
        <h2 class="text-xl font-bold mb-6 text-white text-center">Sign In</h2>

        @if(session('status'))
            <div class="bg-white/90 text-emerald-700 text-xs p-3 rounded-xl mb-4 text-left border border-white">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 text-red-600 text-xs p-3 rounded-xl mb-4 text-left border border-red-100">
                <ul class="list-disc pl-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <input type="hidden" name="role" id="selected-role" value="{{ old('role', 'student') }}">

            <div class="flex bg-black/10 rounded-full p-1 mb-6">
                <button type="button" onclick="setRole('student')" id="btn-student" 
                    class="role-btn flex-1 flex items-center justify-center gap-2 py-2 text-sm font-semibold rounded-full bg-white shadow-sm text-[#52af59]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Student
                </button>
                <button type="button" onclick="setRole('faculty')" id="btn-faculty" 
                    class="role-btn flex-1 flex items-center justify-center gap-2 py-2 text-sm font-semibold rounded-full text-white/80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                    Faculty
                </button>
                <button type="button" onclick="setRole('admin')" id="btn-admin" 
                    class="role-btn flex-1 flex items-center justify-center gap-2 py-2 text-sm font-semibold rounded-full text-white/80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    Admin
                </button>
            </div>

            <div class="space-y-4">
                <style>
                    .green-input::placeholder { color: rgba(255,255,255,0.7); }
                </style>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white/80">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <input type="email" name="email" placeholder="email@school.edu" autocomplete="off"
                        value="{{ old('email') }}"
                        class="green-input w-full p-3 pl-10 bg-white/20 border border-white/30 rounded-xl focus:ring-2 focus:ring-white outline-none transition-all text-sm text-white" required>
                </div>
                
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-white/80">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <input type="password" name="password" placeholder="••••••" 
                        class="green-input w-full p-3 pl-10 bg-white/20 border border-white/30 rounded-xl focus:ring-2 focus:ring-white outline-none transition-all text-sm text-white" required>
                </div>
            </div>

            <button type="submit" class="w-full bg-[#388e3c] text-white flex items-center justify-center gap-2 py-3 rounded-xl font-bold mt-6 hover:bg-[#2e7d32] transform active:scale-[0.98] transition-all shadow-lg shadow-[#388e3c]/20">
                Sign In
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-white/80">Not registered? <a href="{{ route('register') }}" class="font-bold text-white hover:text-white/80 transition">Sign up</a></p>

        <button type="button" onclick="fillDemo()" class="text-white/70 mt-4 text-sm font-medium hover:text-white transition-all active:opacity-50">
            Use demo credentials
        </button>
    </div>
</div>

<script>
function setRole(role) {
    document.getElementById('selected-role').value = role;
    document.querySelectorAll('.role-btn').forEach(btn => {
        btn.classList.remove('bg-white', 'shadow-sm', 'text-[#52af59]');
        btn.classList.add('text-white/80');
    });
    const activeBtn = document.getElementById('btn-' + role);
    activeBtn.classList.add('bg-white', 'shadow-sm', 'text-[#52af59]');
    activeBtn.classList.remove('text-white/80');
}
function fillDemo() {
    const currentRole = document.getElementById('selected-role').value;
    const emailInput = document.querySelector('input[name="email"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const demoData = {
        'student': 'student@school.edu',
        'faculty': 'faculty@school.edu',
        'admin':   'admin@school.edu'
    };
    emailInput.value = demoData[currentRole];
    passwordInput.value = "password123";
}
document.addEventListener('DOMContentLoaded', function () {
    setRole('{{ old('role', 'student') }}');
});
</script>
</body>
</html>