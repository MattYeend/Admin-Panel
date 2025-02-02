<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.store') }}">
                    @csrf

                    <div>
                        <x-label for="title" :value="__('Title')" />
                        <select id="title" name="title" autocomplete="title" required 
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="" disabled selected>{{ __('Select a title') }}</option>
                            <option value="Mr.">{{ __('Mr.') }}</option>
                            <option value="Ms.">{{ __('Ms.') }}</option>
                            <option value="Mrs.">{{ __('Mrs.') }}</option>
                            <option value="Miss.">{{ __('Miss.') }}</option>
                            <option value="Dr.">{{ __('Dr.') }}</option>
                            <option value="Prof.">{{ __('Prof.') }}</option>
                        </select>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="first_name" value="{{ __('First Name') }}" />
                        <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="first_name" />
                    </div>

                    <div class="mt-4">
                        <x-label for="last_name" value="{{ __('Last Name') }}" />
                        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autofocus autocomplete="last_name" />
                    </div>

                    <div class="mb-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="role" :value="__('Role')" />
                        <select name="role" id="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="user">User</option>
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Create User') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
