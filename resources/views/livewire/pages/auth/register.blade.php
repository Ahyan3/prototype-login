<?php

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $first_name = '';
    public string $last_name = '';
    public string $student_id = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $terms = false;

    public function register(): void
    {
        $validated = $this->validate([
            'first_name'          => ['required', 'string', 'max:255'],
            'last_name'           => ['required', 'string', 'max:255'],
            'student_id'          => ['required', 'string', 'max:50', 'unique:'.User::class.',student_id'], // adjust if you have this column
            'email'               => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password'            => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'terms'               => ['required', 'accepted'],
        ]);

        // Combine first + last name for the 'name' field (or modify your User model)
        $validated['name'] = trim("{$validated['first_name']} {$validated['last_name']}");
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create([
            'name'        => $validated['name'],
            'first_name'  => $validated['first_name'],
            'last_name'   => $validated['last_name'],
            'student_id'  => $validated['student_id'],
            'email'       => $validated['email'],
            'password'    => $validated['password'],
        ]);

        event(new Registered($user));
        Auth::login($user);

        $this->redirect(RouteServiceProvider::HOME, navigate: true);
    }
}; ?>

<div class="space-y-8 text-center">
    <form wire:submit="register" class="space-y-6">
        <!-- Names Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2 text-left">
                <x-input-label for="first_name" :value="__('First Name')" class="text-sm font-semibold text-slate-900 dark:text-slate-100" />
                <x-text-input
                    wire:model="first_name"
                    id="first_name"
                    class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                    type="text"
                    placeholder="Enter First Name"
                    required
                    autofocus
                    autocomplete="given-name"
                />
                <x-input-error :messages="$errors->get('first_name')" class="text-sm text-red-600 dark:text-red-400" />
            </div>

            <div class="space-y-2 text-left">
                <x-input-label for="last_name" :value="__('Last Name')" class="text-sm font-semibold text-slate-900 dark:text-slate-100" />
                <x-text-input
                    wire:model="last_name"
                    id="last_name"
                    class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                    type="text"
                    placeholder="Enter Last Name"
                    required
                    autocomplete="family-name"
                />
                <x-input-error :messages="$errors->get('last_name')" class="text-sm text-red-600 dark:text-red-400" />
            </div>
        </div>

        <!-- Student ID + Email Row -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="space-y-2 text-left">
                <x-input-label for="student_id" :value="__('Student ID')" class="text-sm font-semibold text-slate-900 dark:text-slate-100" />
                <x-text-input
                    wire:model="student_id"
                    id="student_id"
                    class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                    type="text"
                    placeholder="Enter Student ID"
                    required
                    autocomplete="off"
                />
                <x-input-error :messages="$errors->get('student_id')" class="text-sm text-red-600 dark:text-red-400" />
            </div>

            <div class="space-y-2 text-left">
                <x-input-label for="email" :value="__('Institutional Email')" class="text-sm font-semibold text-slate-900 dark:text-slate-100" />
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <x-text-input
                        wire:model="email"
                        id="email"
                        class="block w-full pl-10 px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                        type="email"
                        placeholder="faculty@mabinicolleges.edu.ph"
                        required
                        autocomplete="username"
                    />
                </div>
                <x-input-error :messages="$errors->get('email')" class="text-sm text-red-600 dark:text-red-400" />
            </div>
        </div>

        <!-- Password -->
        <div class="space-y-2 text-left">
            <x-input-label for="password" :value="__('Password')" class="text-sm font-semibold text-slate-900 dark:text-slate-100" />
            <x-text-input
                wire:model="password"
                id="password"
                class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                type="password"
                placeholder="At least 8 characters"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" class="text-sm text-red-600 dark:text-red-400" />
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2 text-left">
            <x-input-label for="password_confirmation" :value="__('Re-enter Password')" class="text-sm font-semibold text-slate-900 dark:text-slate-100" />
            <x-text-input
                wire:model="password_confirmation"
                id="password_confirmation"
                class="block w-full px-4 py-3 rounded-lg border border-slate-300 dark:border-slate-600 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-slate-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100"
                type="password"
                placeholder="Re-enter"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-sm text-red-600 dark:text-red-400" />
        </div>

        <!-- Terms Checkbox + Button -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 pt-4">
            <label class="flex items-center gap-3 cursor-pointer text-sm text-slate-600 dark:text-slate-300">
                <input
                    wire:model="terms"
                    type="checkbox"
                    class="w-5 h-5 rounded border-slate-300 dark:border-slate-600 text-blue-600 focus:ring-blue-500"
                />
                <span>I agree with <a href="#" class="text-blue-600 hover:underline">Terms of Use</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a></span>
            </label>

            <button
                type="submit"
                class="w-full md:w-auto px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-md hover:shadow-lg transition-all min-w-[160px]"
            >
                Create Account
            </button>
        </div>

        <!-- Already have account? -->
        <div class="text-center pt-6 mt-2 border-t border-slate-200 dark:border-slate-700">
            <span class="text-sm text-slate-500 dark:text-slate-400">Already have an account? </span>
            <a
                href="{{ route('login') }}"
                wire:navigate
                class="text-sm font-bold text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
            >
                Sign In
            </a>
        </div>
    </form>
</div>