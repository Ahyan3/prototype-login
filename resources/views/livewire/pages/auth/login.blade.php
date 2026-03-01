<?php

use App\Livewire\Forms\LoginForm;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div class="space-y-6">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login" class="space-y-6">
        <!-- Institutional Email -->
        <div>
            <x-input-label for="email" :value="__('Institutional Email')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <!-- Mail icon (Heroicons) -->
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <x-text-input
                    wire:model="form.email"
                    id="email"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                    type="email"
                    name="email"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="faculty@mabinicolleges.edu.ph"
                />
            </div>

            <x-input-error :messages="$errors->get('form.email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />

            <div class="relative mt-1">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <!-- Lock icon (Heroicons) -->
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-2.761 0-5 2.239-5 5h10c0-2.761-2.239-5-5-5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 11V9a5 5 0 00-10 0v2m-2 0h14a2 2 0 012 2v7a2 2 0 01-2 2H5a2 2 0 01-2-2v-7a2 2 0 012-2z" />
                    </svg>
                </div>

                <x-text-input
                    wire:model="form.password"
                    id="password"
                    class="block w-full pl-10 pr-3 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="••••••••"
                />
            </div>

            <x-input-error :messages="$errors->get('form.password')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between text-sm">
            <label class="flex items-center text-slate-600 dark:text-slate-400 cursor-pointer">
                <input
                    wire:model="form.remember"
                    id="remember"
                    type="checkbox"
                    class="rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500 h-4 w-4"
                    name="remember"
                />
                <span class="ml-2">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a
                    class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors"
                    href="{{ route('password.request') }}"
                    wire:navigate
                >
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 group">
            {{ __('Sign In') }}
            <!-- Optional arrow icon -->
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </x-primary-button>

        <!-- Optional Register link (if you want it here) -->
        <div class="text-center text-sm text-slate-500 dark:text-slate-400 pt-2">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" wire:navigate class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium">
                {{ __('Register') }}
            </a>
        </div>
    </form>
</div>