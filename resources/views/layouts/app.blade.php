<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GC PBI - Beranda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-60 bg-blue-900 text-white flex flex-col h-full shrink-0 relative">
        <div class="px-6 py-6 border-b border-blue-800 flex items-center gap-3">
            <img src="{{ asset('logo/logo-bps.svg') }}" alt="Logo BPS" class="h-8 w-auto filter drop-shadow-sm">
            <h1 class="text-2xl font-bold tracking-wider">GC PBI</h1>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') ? 'bg-blue-800 text-white font-medium' : 'text-blue-100 hover:bg-blue-800/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                    </path>
                </svg>
                Dashboard
            </a>
            <a href="{{ route('import.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-colors {{ request()->routeIs('import.*') ? 'bg-blue-800 text-white font-medium' : 'text-blue-100 hover:bg-blue-800/50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                </svg>
                Import Data
            </a>
        </nav>

        @if(isset($latestImport) && $latestImport)
            <div class="p-4 mx-4 mb-6 relative bottom-0 bg-blue-800/50 rounded-lg text-sm border border-blue-700">
                <p class="text-blue-200 text-xs uppercase font-semibold mb-1">Dataset Aktif</p>
                <p class="truncate font-medium" title="{{ $latestImport->original_name }}">
                    {{ $latestImport->original_name }}
                </p>
                <p class="text-blue-300 text-xs mt-1">{{ number_format($latestImport->total_rows) }} baris data</p>
                <p class="text-blue-300 text-xs">{{ $latestImport->imported_at->format('d M Y H:i') }}</p>
            </div>
        @endif
    </aside>

    <!-- Main Content -->
    <main class="flex-1 h-full overflow-y-auto p-6 relative">
        @yield('content')
    </main>
</body>

</html>