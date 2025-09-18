<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Desktop Sidebar - Keep as is -->
        <flux:sidebar fixed stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900 hidden lg:flex">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route(auth()->user()->role== 'user' ? 'user.dashboard' : 'shep.dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Utama')" class="grid">
                    <flux:navlist.item icon="home" :href="route(auth()->user()->role== 'user' ? 'user.dashboard' : 'shep.dashboard')" :current="request()->routeIs(auth()->user()->role== 'user' ? 'user.dashboard' : 'shep.dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" :href="route(auth()->user()->role== 'user' ? 'user.mou.index' : 'shep.mou.index')" :current="request()->routeIs(auth()->user()->role== 'user' ? 'user.mou.index' : 'shep.mou.index')" wire:navigate>{{ __('List MoU') }}</flux:navlist.item>
                    <flux:navlist.item icon="information-circle" :href="route('about.index')" :current="request()->routeIs('about.index')" wire:navigate>{{ __('Tentang Program') }}</flux:navlist.item>
                </flux:navlist.group>
                @if(auth()->user()->role === 'shep')                  
                <flux:navlist.group :heading="__('Shep')" class="grid">
                    <flux:navlist.item icon="users" :href="route('shep.user.index')" :current="request()->routeIs('shep.user.index')" wire:navigate>{{ __('Pengguna') }}</flux:navlist.item>
                    <flux:navlist.item icon="building-office" :href="route('shep.maindealer.index')" :current="request()->routeIs('shep.maindealer.index')" wire:navigate>{{ __('Main Dealer') }}</flux:navlist.item>
                    <flux:navlist.item icon="academic-cap" :href="route('shep.school.index')" :current="request()->routeIs('shep.school.index')" wire:navigate>{{ __('Sekolah') }}</flux:navlist.item>
                </flux:navlist.group>   
                @endif               
            </flux:navlist>

            <flux:spacer />

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Custom Mobile Sidebar - Hidden by default -->
        <div id="mobile-sidebar" class="lg:hidden fixed inset-y-0 left-0 z-50 w-64 bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700 transform -translate-x-full transition-transform duration-300 ease-in-out hidden">
            <!-- Mobile Sidebar Content - Full Height -->
            <div class="flex flex-col h-full px-4 py-4">
                <!-- Close Button and Logo -->
                <div class="flex items-center justify-between mb-6">
                    <a href="{{ route(auth()->user()->role== 'user' ? 'user.dashboard' : 'shep.dashboard') }}" class="flex items-center space-x-2" wire:navigate>
                        <x-app-logo />
                    </a>
                    <button id="mobile-sidebar-close" class="p-2 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Navigation - Flex grow to push user info to bottom -->
                <div class="flex-1 overflow-y-auto">
                    <nav class="space-y-1">
                        <!-- Utama Section -->
                        <div class="mb-4">
                            <h3 class="text-xs font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider mb-2">{{ __('Utama') }}</h3>
                            
                            <a href="{{ route(auth()->user()->role== 'user' ? 'user.dashboard' : 'shep.dashboard') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs(auth()->user()->role== 'user' ? 'user.dashboard' : 'shep.dashboard') ? 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"></path>
                                </svg>
                                {{ __('Dashboard') }}
                            </a>

                            <a href="{{ route(auth()->user()->role== 'user' ? 'user.mou.index' : 'shep.mou.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs(auth()->user()->role== 'user' ? 'user.mou.index' : 'shep.mou.index') ? 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75"></path>
                                </svg>
                                {{ __('List MoU') }}
                            </a>
                            <a href="{{ route('about.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('about.index') ? 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700' : '' }}"
                               wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                </svg>
                                {{ __('Tentang Program') }}
                            </a>
                        </div>

                        @if(auth()->user()->role === 'shep')
                        <!-- Shep Section -->
                        <div>
                            <h3 class="text-xs font-semibold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider mb-2">{{ __('Shep') }}</h3>
                            
                            <a href="{{ route('shep.user.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('shep.user.index') ? 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"></path>
                                </svg>
                                {{ __('Pengguna') }}
                            </a>

                            <a href="{{ route('shep.maindealer.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('shep.maindealer.index') ? 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"></path>
                                </svg>
                                {{ __('Main Dealer') }}
                            </a>

                            <a href="{{ route('shep.school.index') }}" 
                               class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 {{ request()->routeIs('shep.school.index') ? 'bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700' : '' }}"
                               wire:navigate>
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"></path>
                                </svg>
                                {{ __('Sekolah') }}
                            </a>
                        </div>
                        @endif
                    </nav>
                </div>

                <!-- Mobile User Profile at Bottom -->
                <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4 mt-4">
                        <div class="flex items-center space-x-3 mb-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-zinc-200 dark:bg-zinc-700 rounded-lg flex items-center justify-center">
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white">{{ auth()->user()->initials() }}</span>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1">
                                <p class="text-sm font-medium text-zinc-900 dark:text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                        </div>
                        
                        <div class="space-y-1">
                            <a href="{{ route('settings.profile') }}" class="flex items-center px-3 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg" wire:navigate>
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                {{ __('Settings') }}
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center px-3 py-2 text-sm text-zinc-700 dark:text-zinc-200 hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-lg text-left">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile Backdrop -->
        <div id="mobile-sidebar-backdrop" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40 hidden"></div>

        <!-- Mobile Header with Custom Toggle -->
        <flux:header class="lg:hidden">
            <button id="mobile-sidebar-toggle" class="p-2 text-zinc-500 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
        <x-toaster-hub />

        <!-- Custom Mobile Sidebar JavaScript -->
<script>
function initializeMobileSidebar() {
    const mobileToggle = document.getElementById('mobile-sidebar-toggle');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileBackdrop = document.getElementById('mobile-sidebar-backdrop');
    const mobileClose = document.getElementById('mobile-sidebar-close');

    // Check if elements exist before adding listeners
    if (!mobileToggle || !mobileSidebar || !mobileBackdrop || !mobileClose) {
        console.log('Mobile sidebar elements not found');
        return;
    }

    function openMobileSidebar() {
        console.log('Opening mobile sidebar');
        mobileSidebar.classList.remove('hidden');
        // Small delay to ensure display:block is applied before transform
        setTimeout(() => {
            mobileSidebar.classList.remove('-translate-x-full');
            mobileSidebar.classList.add('translate-x-0');
        }, 10);
        mobileBackdrop.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeMobileSidebar() {
        console.log('Closing mobile sidebar');
        mobileSidebar.classList.add('-translate-x-full');
        mobileSidebar.classList.remove('translate-x-0');
        // Wait for transition to complete before hiding
        setTimeout(() => {
            mobileSidebar.classList.add('hidden');
        }, 300);
        mobileBackdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Remove existing event listeners to prevent duplicates
    const newMobileToggle = mobileToggle.cloneNode(true);
    mobileToggle.parentNode.replaceChild(newMobileToggle, mobileToggle);
    
    const newMobileClose = mobileClose.cloneNode(true);
    mobileClose.parentNode.replaceChild(newMobileClose, mobileClose);
    
    const newMobileBackdrop = mobileBackdrop.cloneNode(true);
    mobileBackdrop.parentNode.replaceChild(newMobileBackdrop, mobileBackdrop);

    // Add event listeners to new elements
    document.getElementById('mobile-sidebar-toggle').addEventListener('click', function(e) {
        e.preventDefault();
        console.log('Mobile sidebar toggle clicked');
        openMobileSidebar();
    });

    document.getElementById('mobile-sidebar-close').addEventListener('click', function(e) {
        e.preventDefault();
        closeMobileSidebar();
    });

    // Close on backdrop click
    document.getElementById('mobile-sidebar-backdrop').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMobileSidebar();
        }
    });

    // Close on escape key (only attach once to document)
    if (!document.hasEscapeListener) {
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeMobileSidebar();
            }
        });
        document.hasEscapeListener = true;
    }

    // Handle window resize (only attach once)
    if (!document.hasResizeListener) {
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                closeMobileSidebar();
            }
        });
        document.hasResizeListener = true;
    }
}

// Initialize on DOM ready
document.addEventListener('DOMContentLoaded', initializeMobileSidebar);

// Re-initialize after Livewire navigation
document.addEventListener('livewire:navigated', function() {
    console.log('Livewire navigated, reinitializing mobile sidebar');
    initializeMobileSidebar();
});

// Fallback for older Livewire versions
document.addEventListener('turbo:load', function() {
    console.log('Turbo loaded, reinitializing mobile sidebar');
    initializeMobileSidebar();
});
</script>

        @stack('scripts')
    </body>
</html>