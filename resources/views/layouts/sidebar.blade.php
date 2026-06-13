<div
    class="bg-primary dark:bg-base-100 text-primary-content flex min-h-full flex-col items-start p-4 overflow-hidden is-drawer-close:overflow-visible transition-[width] duration-300 ease-in-out is-drawer-open:w-80 is-drawer-close:w-20">
    {{-- Logo --}}
    <div class="mb-6 flex items-center justify-center pt-2 w-full">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
            <x-ui.application-logo
                class="block h-10 w-auto fill-current text-primary-content transition-all duration-300" />
            <span class="font-bold text-xl whitespace-nowrap is-drawer-close:hidden">{{ config('app.name') }}</span>
        </a>
    </div>

    {{-- Menu Wrapper --}}
    <div class="flex-1 w-full overflow-y-auto overflow-x-hidden is-drawer-close:overflow-visible">
        <ul class="menu w-full gap-2 rounded-box bg-transparent p-0 text-primary-content shadow-none">
            {{-- Dashboard --}}
            <li>
                <a href="{{ route('dashboard') }}"
                    class="group flex items-center gap-4 {{ request()->routeIs('dashboard') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                    data-tip="{{ __('Dashboard') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 shrink-0">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Dashboard') }}</span>
                </a>
            </li>

            {{-- Petugas Menu --}}
            @if (Auth::user()->role->role_name === 'petugas')
                <li class="menu-title text-primary-content/70 uppercase mt-2 is-drawer-close:hidden">
                    {{ __('Permohonan') }}
                </li>
                <li class="md:hidden is-drawer-close:block my-divider"></li>
                <li>
                    <a href="{{ route('pse.index') }}"
                        class="{{ request()->routeIs('pse.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('PSE') }}">
                        <x-icons.pse class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('PSE') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subdomain.index') }}"
                        class="{{ request()->routeIs('subdomain.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Subdomain') }}">
                        <x-icons.subdomain class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Subdomain') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hosting.index') }}"
                        class="{{ request()->routeIs('hosting.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Hosting') }}">
                        <x-icons.hosting class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Hosting') }}</span>
                    </a>
                </li>
            @endif

            {{-- Verifikator 1 Menu --}}
            @if (Auth::user()->role->role_name === 'verifikator_1')
                <li class="menu-title text-primary-content/70 uppercase mt-2 is-drawer-close:hidden">
                    {{ __('Verifikasi Tahap 1') }}
                </li>
                <li class="md:hidden is-drawer-close:block my-divider"></li>
                <li>
                    <a href="{{ route('pse-verification.index') }}"
                        class="{{ request()->routeIs('pse-verification.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Verifikasi PSE') }}">
                        <x-icons.pse class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Verifikasi PSE') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subdomain-verification.index') }}"
                        class="{{ request()->routeIs('subdomain-verification.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Verifikasi Subdomain') }}">
                        <x-icons.subdomain class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Verifikasi Subdomain') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hosting-verification.index') }}"
                        class="{{ request()->routeIs('hosting-verification.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Verifikasi Hosting') }}">
                        <x-icons.hosting class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Verifikasi Hosting') }}</span>
                    </a>
                </li>
            @endif

            {{-- Verifikator 2 Menu --}}
            @if (Auth::user()->role->role_name === 'verifikator_2')
                <li class="menu-title text-primary-content/70 uppercase mt-2 is-drawer-close:hidden">
                    {{ __('Verifikasi Final') }}
                </li>
                <li class="md:hidden is-drawer-close:block my-divider"></li>
                <li>
                    <a href="{{ route('pse-verification2.index') }}"
                        class="{{ request()->routeIs('pse-verification2.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Verifikasi PSE') }}">
                        <x-icons.pse class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Verifikasi PSE') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('subdomain-verification2.index') }}"
                        class="{{ request()->routeIs('subdomain-verification2.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Verifikasi Subdomain') }}">
                        <x-icons.subdomain class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Verifikasi Subdomain') }}</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hosting-verification2.index') }}"
                        class="{{ request()->routeIs('hosting-verification2.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                        data-tip="{{ __('Verifikasi Hosting') }}">
                        <x-icons.hosting class="w-6 h-6 shrink-0" />
                        <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Verifikasi Hosting') }}</span>
                    </a>
                </li>
            @endif

            {{-- Laporan/Riwayat (Shared for Admin, Eksekutif, & Verifikators) --}}
            @php
                $roleName = Auth::user()->role->role_name;
                $canSeeReports = in_array($roleName, ['verifikator_1', 'verifikator_2', 'admin', 'eksekutif']);
                $canSeeHistory = in_array($roleName, ['verifikator_1', 'verifikator_2']);
                $canSeeUsers = in_array($roleName, ['verifikator_1', 'verifikator_2', 'admin']);
                $canSeeOpd = in_array($roleName, ['admin']);
            @endphp

            @if ($canSeeReports)
                <li class="menu-title text-primary-content/70 uppercase mt-2 is-drawer-close:hidden">
                    {{ __('Laporan') }}
                </li>
                <li class="md:hidden is-drawer-close:block my-divider"></li>
                @if ($canSeeUsers)
                    <li>
                        <a href="{{ route('user.index') }}"
                            class="{{ request()->routeIs('user.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                            data-tip="{{ __('Pengguna') }}">
                            <x-icons.user class="w-6 h-6 shrink-0" />
                            <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Pengguna') }}</span>
                        </a>
                    </li>
                @endif
                @if ($canSeeOpd)
                    <li>
                        <a href="{{ route('opd.index') }}"
                            class="{{ request()->routeIs('opd.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                            data-tip="{{ __('OPD') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                            </svg>
                            <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('OPD') }}</span>
                        </a>
                    </li>
                @endif
                @if ($canSeeHistory)
                    <li>
                        <a href="{{ route('verification.history') }}"
                            class="{{ request()->routeIs('verification.history') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                            data-tip="{{ __('Riwayat Verifikasi') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Riwayat Verifikasi') }}</span>
                        </a>
                    </li>
                @endif
                @if (in_array($roleName, ['verifikator_1', 'verifikator_2', 'admin', 'eksekutif']))
                    <li>
                        <a href="{{ route('issuance.index') }}"
                            class="{{ request()->routeIs('issuance.*') ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right z-50"
                            data-tip="{{ __('Rekap & Penerbitan') }}">
                            <x-icons.issuance class="w-6 h-6 shrink-0" />
                            <span class="is-drawer-close:hidden whitespace-nowrap">{{ __('Rekap & Penerbitan') }}</span>
                        </a>
                    </li>
                @endif
            @endif
        </ul>
    </div>

    {{-- Profile Section (Bottom) --}}
    <div class="mt-auto w-full pt-4 border-t border-primary-content/20">
        <div class="dropdown dropdown-top w-full">
            <div tabindex="0" role="button" data-tip="{{ __('Profil') }}"
                class="{{ request()->routeIs('user.show') && request('user') == Auth::user()->uuid ? 'active bg-primary-content/20' : '' }} is-drawer-close:tooltip is-drawer-close:tooltip-right flex items-center gap-3 p-1 rounded-lg hover:bg-base-content/20 transition-colors w-full cursor-pointer">
                {{-- Avatar profil pengguna --}}
                <div class="avatar placeholder">
                    <div
                        class="{{ request()->routeIs('user.show') && request('user') == Auth::user()->uuid ? 'active bg-transparent' : 'bg-primary-content/20' }} text-primary-content rounded-full w-10 p-2">
                        <x-icons.user class="w-full h-full" />
                    </div>
                </div>
                {{-- Nama dan role pengguna --}}
                <div class="flex flex-col text-left overflow-hidden is-drawer-close:hidden">
                    <span class="text-sm font-bold truncate cursor-help tooltip" data-tip="{{ Auth::user()->name }}">
                        {{ Str::limit(Auth::user()->name, 30) }}
                    </span>
                    <span class="text-xs opacity-70 truncate">{{ __(Str::headline(Auth::user()->role->role_name ?? 'User')) }}</span>
                </div>
                {{-- Chevron --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ms-auto opacity-70 is-drawer-close:hidden"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                </svg>
            </div>
            {{-- Dropdown Menu --}}
            <ul tabindex="0"
                class="dropdown-content z-20 menu p-2 shadow bg-primary-content/80 text-primary rounded-box w-52 mb-9">
                <li>
                    <a href="{{ route('user.show', Auth::user()->uuid) }}" class="gap-3">
                        <x-icons.user class="w-5 h-5" />
                        {{ __('Profil') }}
                    </a>
                </li>
                <li>
                    @php
                        $isEn = app()->getLocale() === 'en';
                        $nextLang = $isEn ? 'id' : 'en';
                        $showLabel = $isEn ? 'Indonesia (ID)' : 'English (EN)';
                    @endphp
                    <a href="{{ route('lang.switch', $nextLang) }}" class="gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                        {{ __('Ganti ke') }} {{ $showLabel }}
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
                        @csrf
                    </form>
                    <button type="submit" form="logout-form" class="gap-3 w-full text-left">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                        </svg>

                        {{ __('Keluar') }}
                    </button>
                </li>
            </ul>
        </div>
    </div>
</div>
