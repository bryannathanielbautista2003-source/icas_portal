<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ICAS LMS Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .role-btn { transition: all 0.2s ease-in-out; }
        .green-input::placeholder { color: rgba(255,255,255,0.7); }
    </style>
</head>
<body class="min-h-screen bg-cover bg-center bg-no-repeat relative" style="background-image: url('{{ asset('images/green.png') }}');">

<div class="mx-auto flex min-h-screen w-full max-w-5xl items-center justify-center px-4 py-8">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <img src="{{ asset('images/icas-logo.png') }}" alt="ICAS Logo" class="mx-auto h-24 w-auto object-contain">

            <p class="mt-2 text-[#388e3c] text-sm font-medium">CREATE YOUR ACCOUNT AND START USING PORTAL</p>
        </div>

        <div class="rounded-[2rem] bg-[#52af59] p-8 shadow-xl border border-white/20 text-white">
            <div class="mb-8 text-center border-b border-white/20 pb-4">
                <h2 class="text-xl font-bold text-white">Register</h2>
                <p class="mt-2 text-sm text-white/80">Sign up as a student, faculty, or admin.</p>
            </div>

            @if($errors->any())
                <div class="bg-red-50 text-red-600 text-xs p-3 rounded-xl mb-5 border border-red-100 text-left">
                    <ul class="list-disc pl-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" id="registerForm">
                @csrf
                <input type="hidden" name="role" id="selected-role" value="{{ old('role', 'student') }}">

                <div class="flex items-center gap-2 rounded-full bg-black/10 p-1 mb-6">
                    <button type="button" onclick="setRole('student')" id="btn-student" class="role-btn flex-1 flex items-center justify-center gap-2 rounded-full px-4 py-3 text-sm font-semibold bg-white text-[#52af59] shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Student
                    </button>
                    <button type="button" onclick="setRole('faculty')" id="btn-faculty" class="role-btn flex-1 flex items-center justify-center gap-2 rounded-full px-4 py-3 text-sm font-semibold text-white/80">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
                        Faculty
                    </button>
                    <button type="button" onclick="setRole('admin')" id="btn-admin" class="role-btn flex-1 flex items-center justify-center gap-2 rounded-full px-4 py-3 text-sm font-semibold text-white/80">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        Admin
                    </button>
                </div>

                <div class="space-y-4">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-white/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <input type="text" name="name" placeholder="Full name" value="{{ old('name') }}" class="green-input w-full rounded-2xl border border-white/30 bg-white/20 pl-11 pr-4 py-3 text-sm text-white outline-none transition focus:border-white focus:ring-2 focus:ring-white/50" required>
                    </div>
                    
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-white/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <input type="email" name="email" placeholder="your.email@school.edu" value="{{ old('email') }}" class="green-input w-full rounded-2xl border border-white/30 bg-white/20 pl-11 pr-4 py-3 text-sm text-white outline-none transition focus:border-white focus:ring-2 focus:ring-white/50" required>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-white/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <input type="password" name="password" placeholder="Create password" class="green-input w-full rounded-2xl border border-white/30 bg-white/20 pl-11 pr-4 py-3 text-sm text-white outline-none transition focus:border-white focus:ring-2 focus:ring-white/50" required>
                    </div>

                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-white/80">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <input type="password" name="password_confirmation" placeholder="Confirm password" class="green-input w-full rounded-2xl border border-white/30 bg-white/20 pl-11 pr-4 py-3 text-sm text-white outline-none transition focus:border-white focus:ring-2 focus:ring-white/50" required>
                    </div>
                </div>

                <button type="submit" class="mt-6 w-full rounded-2xl bg-[#388e3c] px-4 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-lg shadow-[#388e3c]/20 transition hover:bg-[#2e7d32] active:scale-[0.98]">
                    <span class="inline-flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                            <circle cx="10" cy="7" r="4" />
                            <path d="M20 8v6m3-3h-6" />
                        </svg>
                        Register
                    </span>
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-white/80">Already registered? <a href="{{ route('login') }}" class="font-bold text-white hover:text-white/80 transition">Sign in</a></p>
        </div>
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

document.addEventListener('DOMContentLoaded', function () {
    setRole('{{ old('role', 'student') }}');
});
</script>
</body>
</html>
