<nav x-data="{ open: false }" class="bg-[#030303] border-b border-purple-900/50 shadow-[0_4px_20px_rgba(147,51,234,0.15)] relative">
    
    <div class="absolute top-0 left-0 w-full h-[2px] bg-gradient-to-r from-purple-700 via-pink-600 to-rose-400"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-purple-500 drop-shadow-[0_0_8px_rgba(147,51,234,0.5)]" />
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Painel') }}
                    </x-nav-link>
                    
                    <x-nav-link :href="route('banco.index')" :active="request()->routeIs('banco.*')">
                        {{ __('Banco') }}
                    </x-nav-link>

                    <x-nav-link :href="route('fichas.index')" :active="request()->routeIs('fichas.*')">
                        {{ __('Biblioteca') }}
                    </x-nav-link>

                    <x-nav-link :href="route('inventario.index')" :active="request()->routeIs('inventario.*')">
                        {{ __('Meu Deck') }}
                    </x-nav-link>

                    <x-nav-link :href="route('rng.index')" :active="request()->routeIs('rng.*')">
                        {{ __('RNG') }}
                    </x-nav-link>

                    <x-nav-link :href="route('chibis.index')" :active="request()->routeIs('chibis.*')">
                        {{ __('Chibis') }}
                    </x-nav-link>

                    <x-nav-link :href="route('passe.index')" :active="request()->routeIs('passe.*')">
                        {{ __('Passe de Batalha') }}
                    </x-nav-link>

                    <!-- Link Administrativo (Só aparece para Ficheiros e Conselheiros) -->
<!-- Menu Dropdown Admin (Só aparece para Staff) -->
@if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
    <div class="hidden sm:flex sm:items-center sm:ms-6">
        <x-dropdown align="right" width="48">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-bold rounded-md text-red-500 hover:text-red-400 focus:outline-none transition ease-in-out duration-150 mt-1">
                    <div>⚙️ Admin</div>
                    <div class="ms-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </x-slot>

            <x-slot name="content" class="bg-[#09090b] border border-gray-800">
                <!-- Categoria: Passe de Batalha -->
                <div class="block px-4 py-2 text-[0.65rem] text-gray-500 font-black uppercase tracking-widest bg-gray-900 border-b border-gray-800">
                    Passe de Batalha
                </div>
                <x-dropdown-link :href="route('admin.passes.index')" class="text-pink-500 hover:bg-gray-800 hover:text-pink-400 font-bold transition">
                    {{ __('Gerenciar Temporadas') }}
                </x-dropdown-link>
                <x-dropdown-link :href="route('admin.passes.verificacoes')" class="text-yellow-500 hover:bg-gray-800 hover:text-yellow-400 font-bold transition">
                    {{ __('Auditoria de Missões') }}
                </x-dropdown-link>
                
                <!-- Futuramente, você pode adicionar: -->
                <!--
                <div class="block px-4 py-2 text-[0.65rem] text-gray-500 font-black uppercase tracking-widest bg-gray-900 border-b border-t border-gray-800">
                    Sistema de Chibis
                </div>
                <x-dropdown-link href="#" class="text-indigo-500 hover:bg-gray-800 hover:text-indigo-400 font-bold">
                    {{ __('Gerenciar Gacha') }}
                </x-dropdown-link>
                -->
            </x-slot>
        </x-dropdown>
    </div>
@endif
                    
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-purple-900/50 text-sm leading-4 font-bold rounded-md text-gray-300 bg-[#09090b] hover:text-purple-400 hover:border-purple-500 focus:outline-none focus:border-purple-500 transition ease-in-out duration-150 shadow-[0_0_10px_rgba(147,51,234,0.1)]">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4 text-purple-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-purple-400 hover:bg-purple-900/30 focus:outline-none focus:bg-purple-900/30 focus:text-purple-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-[#09090b] border-b border-purple-900/50">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Painel') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('banco.index')" :active="request()->routeIs('banco.*')">
                {{ __('Banco') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('fichas.index')" :active="request()->routeIs('fichas.*')">
                {{ __('Biblioteca') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('inventario.index')" :active="request()->routeIs('inventario.*')">
                {{ __('Meu Deck') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('rng.index')" :active="request()->routeIs('rng.*')">
    {{ __('Destino (RNG)') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('chibis.index')" :active="request()->routeIs('chibis.*')">
                {{ __('Chibis') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('passe.index')" :active="request()->routeIs('passe.*')">
                {{ __('Passe de Batalha') }}
            </x-responsive-nav-link>

            <!-- Link Administrativo (Só aparece para Ficheiros e Conselheiros) -->
<!-- Admin no Celular -->
@if(Auth::user()->patente === 'Ficheiro' || Auth::user()->patente === 'Conselheiro')
    <div class="pt-4 pb-1 border-t border-gray-800">
        <div class="px-4 text-xs text-gray-500 font-black uppercase tracking-widest mb-2">
            ⚙️ Administração
        </div>
        
        <div class="px-4 text-[0.65rem] text-gray-600 font-bold uppercase tracking-wider mb-1 mt-2">
            Passe de Batalha
        </div>
        <div class="space-y-1">
            <x-responsive-nav-link :href="route('admin.passes.index')" :active="request()->routeIs('admin.passes.index')" class="text-pink-500 font-bold">
                {{ __('Gerenciar Temporadas') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.passes.verificacoes')" :active="request()->routeIs('admin.passes.verificacoes')" class="text-yellow-500 font-bold">
                {{ __('Auditoria de Missões') }}
            </x-responsive-nav-link>
        </div>
    </div>
@endif
        </div>

        <div class="pt-4 pb-1 border-t border-purple-900/50">
            <div class="px-4">
                <div class="font-bold text-base text-purple-400">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>