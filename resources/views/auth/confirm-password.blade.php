<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Esta é uma área segura do aplicativo. Por favor confirme sua senha antes de continuar.') }}
    </div>

    <form method="POST" action="{{ route('confirm_password.show') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Senha')" />
            <x-text-input 
                id="password" 
                class="block mt-1 w-full"
                type="password"
                name="password"
                required 
                autocomplete="current-password" 
                placeholder="Senha" 
            />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirmar') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
