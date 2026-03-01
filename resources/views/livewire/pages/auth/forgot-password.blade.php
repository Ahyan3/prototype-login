<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            return;
        }

        $this->reset('email');
        session()->flash('status', __($status));
    }
}; ?>

<div class="space-y-8 text-center">
    <!-- Instructional text -->
    <div class="text-sm text-slate-600 dark:text-slate-300 max-w-sm mx-auto">
        {{ __('Enter your institutional email and we\'ll send you a link to reset your password.') }}
    </div>

    <!-- Session / Success Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="space-y-6">
        <!-- Institutional Email -->
        <div class="space-y-2 text-left">
            <x-input-label for="email" :value="__('Institutional Email')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />

            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <!-- Mail icon (consistent with login) -->
                    <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>

                <x-text-input
                    wire:model="email"
                    id="email"
                    class="block w-full pl-10 pr-4 py-2.5 border border-slate-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                    type="email"
                    name="email"
                    required
                    autofocus
                    placeholder="faculty@mabinicolleges.edu.ph"
                />
            </div>

            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-600 dark:text-red-400" />
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg shadow-md hover:shadow-lg transition-all"
        >
            {{ __('Send Reset Link') }}
        </button>
    </form>

    <!-- Back to Login -->
    <div class="text-center text-sm pt-4">
        <span class="text-slate-500 dark:text-slate-400">{{ __('Remember your password?') }}</span>
        <a
            href="{{ route('login') }}"
            wire:navigate
            class="ml-1 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium transition-colors"
        >
            {{ __('Back to Sign In') }}
        </a>
    </div>
</div>