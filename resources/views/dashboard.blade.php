<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ===================== --}}
            {{-- ADMIN INTI --}}
            {{-- ===================== --}}
            @auth
                @if (auth()->user()->role === 'admin')
                    <div class="bg-white dark:bg-gray-800 p-6 shadow rounded">
                        <h3 class="font-semibold text-lg mb-4">Admin Panel</h3>

                        <a
                            href="{{ route('admin.himas.index') }}"
                            class="inline-block px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                        >
                            Persetujuan Pendaftaran HIMA
                        </a>
                    </div>
                @endif

                {{-- ===================== --}}
                {{-- USER BIASA / PEMBELI --}}
                {{-- ===================== --}}
                @if (auth()->user()->role === 'user')
                    <div class="bg-white dark:bg-gray-800 p-6 shadow rounded">
                        <h3 class="font-semibold text-lg mb-2">Dashboard Pembeli</h3>

                        <p class="mb-4">
                            Kamu login sebagai <b>pembeli</b>.
                        </p>

                        {{-- TOMBOL BELANJA --}}
                        <a
                            href="{{ route('products.index') }}"
                            class="inline-block px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700 mr-2"
                        >
                            Belanja Produk
                        </a>

                        {{-- DAFTAR / STATUS HIMA --}}
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

                {{-- ===================== --}}
                {{-- HIMA --}}
                {{-- ===================== --}}
                @if (auth()->user()->role === 'hima')
                    <div class="bg-white dark:bg-gray-800 p-6 shadow rounded">
                        <h3 class="font-semibold text-lg mb-2">Dashboard HIMA</h3>

                        <p class="mb-4">
                            Selamat datang,
                            <b>{{ optional(auth()->user()->hima)->name ?? 'HIMA' }}</b>
                        </p>

                        <a
                            href="{{ route('hima.products.index') }}"
                            class="inline-block px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700"
                        >
                            Kelola Produk HIMA
                        </a>
                    </div>
                @endif
            @endauth

        </div>
    </div>
</x-app-layout>
