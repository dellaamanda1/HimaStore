<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ADMIN INTI --}}
            @if (auth()->user()->role === 'admin')
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded mb-6">
                    <h3 class="font-semibold text-lg mb-2">Admin Panel</h3>
                    <a
                        href="{{ route('admin.himas.index') }}"
                        class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Persetujuan Pendaftaran HIMA
                    </a>
                </div>
            @endif

            {{-- USER BIASA / PEMBELI --}}
            @if (auth()->user()->role === 'user')
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded mb-6">
                    <h3 class="font-semibold text-lg mb-2">User Dashboard</h3>

                    <p class="mb-4">Kamu login sebagai <b>pembeli</b>.</p>

                    {{-- jika belum apply HIMA --}}
                    @if (!auth()->user()->hima)
                        <a
                            href="{{ route('apply-hima.create') }}"
                            class="inline-block px-4 py-2 bg-black text-white rounded hover:bg-gray-800"
                        >
                            Daftar sebagai HIMA
                        </a>
                    @else
                        <a
                            href="{{ route('apply-hima.status') }}"
                            class="inline-block px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800"
                        >
                            Lihat Status Pengajuan HIMA
                        </a>
                    @endif
                </div>
            @endif

            {{-- HIMA --}}
            @if (auth()->user()->role === 'hima')
                <div class="bg-white dark:bg-gray-800 p-6 shadow rounded mb-6">
                    <h3 class="font-semibold text-lg mb-2">Dashboard HIMA</h3>

                    <p class="mb-4">
                        Selamat datang, <b>{{ auth()->user()->hima->name ?? 'HIMA' }}</b>
                    </p>

                    <a
                        href="{{ route('hima.dashboard') }}"
                        class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                    >
                        Masuk Dashboard HIMA
                    </a>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>