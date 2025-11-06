<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Role Selection -->
        <div class="mt-4">
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                <option value="user">User</option>
                <option value="petugas">Petugas</option>
                <option value="admin">Admin</option>
            </select>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Asal Ruangan -->
        <div class="mt-4">
            <x-input-label for="asal_ruangan" :value="__('Asal Ruangan')" />
            <select id="asal_ruangan" name="asal_ruangan" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                <option value="">Pilih Asal Ruangan</option>
                <option value="RANAP URANUS">RANAP URANUS</option>
                <option value="RANAP JUPITER">RANAP JUPITER</option>
                <option value="RANAP MARS">RANAP MARS</option>
                <option value="RANAP MERKURIUS">RANAP MERKURIUS</option>
                <option value="RANAP VENUS">RANAP VENUS</option>
                <option value="ISOLASI">ISOLASI</option>
                <option value="KAMAR OPERASI">KAMAR OPERASI</option>
                <option value="ICU">ICU</option>
                <option value="NICU">NICU</option>
                <option value="PICU">PICU</option>
                <option value="TRANSIT IGD">TRANSIT IGD</option>
                <option value="RADIOLOGI">RADIOLOGI</option>
                <option value="LABORATORIUM">LABORATORIUM</option>
                <option value="MNE">MNE</option>
                <option value="PERISTI">PERISTI</option>
            </select>
            <x-input-error :messages="$errors->get('asal_ruangan')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
