@props(['title' => 'Dashboard'])

<header class="navbar-glass sticky top-0 z-20 flex items-center justify-between gap-4 px-4 py-3 lg:px-8">
    <div class="flex items-center gap-3">
        <button
            @click="$dispatch('toggle-sidebar')"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-purple-700 transition hover:bg-purple-50 lg:hidden"
        >
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>
        <div>
            <x-breadcrumb :title="$title" />
            <h1 class="text-lg font-bold text-slate-800 lg:text-xl">{{ $title }}</h1>
        </div>
    </div>

    <div class="flex items-center gap-2 sm:gap-4">
        <x-search class="hidden sm:block" />

        <button class="relative flex h-10 w-10 items-center justify-center rounded-xl text-purple-700 transition hover:bg-purple-50">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
            </svg>
            <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-pink-500 ring-2 ring-white"></span>
        </button>

        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-2 rounded-xl py-1.5 pl-1.5 pr-3 transition hover:bg-purple-50">
                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gradient-to-br from-pink-500 to-purple-600 text-sm font-bold text-white shadow-sm">
                    {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                </div>
                <div class="hidden text-left sm:block">
                    <p class="text-sm font-semibold leading-tight text-slate-700">{{ Auth::user()->name ?? 'User' }}</p>
                    <p class="text-[11px] leading-tight text-slate-400">Administrator</p>
                </div>
                <svg class="h-4 w-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <div
                x-show="open"
                x-transition
                class="absolute right-0 z-30 mt-2 w-52 overflow-hidden rounded-2xl border border-purple-50 bg-white py-2 shadow-soft-xl"
                style="display: none;"
            >
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 px-4 py-2.5 text-sm text-slate-600 transition hover:bg-purple-50 hover:text-purple-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0" />
                    </svg>
                    Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex w-full items-center gap-2 px-4 py-2.5 text-left text-sm text-red-500 transition hover:bg-red-50">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>