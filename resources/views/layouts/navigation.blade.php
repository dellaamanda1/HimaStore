<nav x-data="{ open: false }" class="bg-transparent border-b border-white/10">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo (HimaStore) -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3">
                        {{-- Icon kotak (boleh ganti kalau mau) --}}
                        <div class="h-10 w-10 rounded-2xl bg-white/10 backdrop-blur border border-white/10 grid place-items-center">
                            <svg class="h-6 w-6 text-purple-200" viewBox="0 0 24 24" fill="none">
                                <path d="M7 7h10v10H7V7Z" stroke="currentColor" stroke-width="1.6"/>
                                <path d="M9 9h6v6H9V9Z" stroke="currentColor" stroke-width="1.6" opacity=".8"/>
                            </svg>
                        </div>
                        <div class="leading-tight">
                            <p class="text-white font-semibold">HimaStore</p>
                            <p class="text-white/60 text-xs">Fashion • Merch • Lifestyle</p>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                        class="text-white/80 hover:text-white">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 rounded-xl
                                       bg-white/10 border border-white/10 backdrop-blur
                                       text-sm font-medium text-white/80 hover:text-white hover:bg-white/15
                                       focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="rounded-xl bg-zinc-950/90 border border-white/10 backdrop-blur shadow-xl overflow-hidden">
                            <x-dropdown-link :href="route('profile.edit')" class="text-white/80 hover:text-white hover:bg-white/10">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    class="text-white/80 hover:text-white hover:bg-white/10"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-xl
                           text-white/70 hover:text-white hover:bg-white/10
                           focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <div class="rounded-2xl bg-white/5 border border-white/10 backdrop-blur p-2">
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')"
                    class="text-white/80 hover:text-white">
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-white/10">
            <div class="px-4">
                <div class="font-medium text-base text-white">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-white/60">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1 px-4 pb-4">
                <div class="rounded-2xl bg-white/5 border border-white/10 backdrop-blur overflow-hidden">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-white/80 hover:text-white hover:bg-white/10">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-responsive-nav-link :href="route('logout')"
                            class="text-white/80 hover:text-white hover:bg-white/10"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
