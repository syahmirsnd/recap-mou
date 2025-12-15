<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Models\MainDealer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public ?int $main_dealer_id = null;

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
            'main_dealer_id' => ['required', 'exists:main_dealers,id'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        $this->redirect(route('login', absolute: false), navigate: true);
    }

    public function render()
    {
        return view('livewire.auth.register', [
            'mainDealers' => MainDealer::orderBy('md_name')->get(),
        ]);
    }
}
