<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GC PBI - Beranda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-slate-50 flex flex-col h-screen overflow-hidden font-sans text-slate-800"
    x-data="{ showImportModal: false }">
    <!-- Top Navigation Header -->
    <header
        class="bg-white/90 backdrop-blur-md border-b border-gray-200 px-6 py-4 flex justify-between items-center z-30 shrink-0 shadow-sm relative">
        <div class="flex items-center gap-3">
            <img src="{{ asset('logo/logo-bps.svg') }}" alt="Logo BPS" class="h-8 w-auto filter drop-shadow-sm">
            <h1 class="text-xl font-bold tracking-wider text-blue-900 border-l-2 border-gray-300 pl-3">GC PBI</h1>
        </div>

        <div class="flex items-center gap-4">
            @if(isset($latestImport) && $latestImport)
                <div
                    class="hidden md:flex items-center gap-2 px-4 py-2 bg-slate-50 border border-slate-200 rounded-full text-sm shadow-inner truncate max-w-sm">
                    <div
                        class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_8px_rgba(52,211,153,0.8)] shrink-0">
                    </div>
                    <span class="text-slate-500 font-medium shrink-0">Dataset Aktif:</span>
                    <span class="font-bold text-slate-800 truncate"
                        title="{{ $latestImport->original_name }}">{{ $latestImport->original_name }}</span>
                </div>
            @endif

            @unless(request()->routeIs('dashboard'))
                <a href="{{ route('dashboard') }}"
                    class="px-5 py-2.5 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium rounded-full shadow-sm transition-all flex items-center gap-2 text-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            @endunless
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto relative bg-slate-50 flex flex-col">
        <div class="flex-1 py-2 px-6 md:px-8 lg:px-10">
            <!-- Render Session Alerts (Global) -->
            <div class="max-w-7xl mx-auto my-4">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show"
                        class="p-4 border-l-4 border-green-400 bg-green-50 rounded-r-xl flex items-start shadow-sm justify-between">
                        <div class="flex">
                            <svg class="h-5 w-5 text-green-400 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-sm text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-green-800"><svg class="w-4 h-4"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                @endif

                @if (session('error') || $errors->any())
                    <div x-data="{ show: true }" x-show="show"
                        class="p-4 border-l-4 border-red-400 bg-red-50 rounded-r-xl flex items-start shadow-sm justify-between">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-500 mt-0.5 mr-3 shrink-0" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                @if(session('error'))
                                    <p class="text-sm text-red-800 font-medium">{{ session('error') }}</p>
                                @endif
                                @if($errors->any())
                                    <ul class="text-sm text-red-700 list-disc list-inside mt-1">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-800 mt-0.5"><svg class="w-4 h-4"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg></button>
                    </div>
                @endif
            </div>

            @yield('content')
        </div>

        <!-- Footer -->
        <footer class="py-6 border-t border-slate-200 text-center text-sm text-slate-500 bg-white/50 shrink-0">
            <p>&copy; 2026 - BPS Kabupaten Ogan Ilir.</p>
        </footer>
    </main>
</body>

</html>