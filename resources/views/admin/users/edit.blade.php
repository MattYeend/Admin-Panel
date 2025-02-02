<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-label for="title" :value="__('Title')" />
                        <select id="title" name="title" autocomplete="title" required 
                            class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="" disabled {{ old('title') ? '' : 'selected' }}>{{ __('Select a title') }}</option>
                            <option value="Mr." {{ old('title', $user->title ?? '') == 'Mr.' ? 'selected' : '' }}>{{ __('Mr.') }}</option>
                            <option value="Ms." {{ old('title', $user->title ?? '') == 'Ms.' ? 'selected' : '' }}>{{ __('Ms.') }}</option>
                            <option value="Mrs." {{ old('title', $user->title ?? '') == 'Mrs.' ? 'selected' : '' }}>{{ __('Mrs.') }}</option>
                            <option value="Miss." {{ old('title', $user->title ?? '') == 'Miss.' ? 'selected' : '' }}>{{ __('Miss.') }}</option>
                            <option value="Dr." {{ old('title', $user->title ?? '') == 'Dr.' ? 'selected' : '' }}>{{ __('Dr.') }}</option>
                            <option value="Prof." {{ old('title', $user->title ?? '') == 'Prof.' ? 'selected' : '' }}>{{ __('Prof.') }}</option>
                        </select>
                        @error('title')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="first_name" value="{{ __('First Name') }}" />
                        <x-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name', $user->first_name ?? '')" required autofocus autocomplete="first_name" />
                        @error('first_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mt-4">
                        <x-label for="last_name" value="{{ __('Last Name') }}" />
                        <x-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name', $user->last_name ?? '')" required autofocus autocomplete="last_name" />
                        @error('last_name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <div class="mb-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ $user->email }}" required />
                    </div>

                    <div class="mb-4">
                        <x-label for="password" :value="__('New Password (Optional)')" />
                        <x-input id="password" class="block mt-1 w-full" type="password" name="password" />
                    </div>

                    <div class="mb-4">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />
                        <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" />
                    </div>

                    <div class="mb-4">
                        <x-label for="role" :value="__('Role')" />
                        <select name="role" id="role" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                            <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Update User') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
