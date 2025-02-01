<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between mb-4">
                    <h3 class="text-lg font-semibold">{{ __('Users List') }}</h3>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">
                        {{ __('Create User') }}
                    </a>
                </div>

                <table class="min-w-full bg-white border border-gray-300">
                    <thead>
                        <tr class="w-full bg-gray-100 border-b">
                            <th class="py-2 px-4 border-r">#</th>
                            <th class="py-2 px-4 border-r">{{ __('Name') }}</th>
                            <th class="py-2 px-4 border-r">{{ __('Email') }}</th>
                            <th class="py-2 px-4 border-r">{{ __('Role') }}</th>
                            <th class="py-2 px-4">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr class="border-b">
                                <td class="py-2 px-4 border-r">{{ $loop->iteration }}</td>
                                <td class="py-2 px-4 border-r">{{ $user->name }}</td>
                                <td class="py-2 px-4 border-r">{{ $user->email }}</td>
                                <td class="py-2 px-4 border-r">{{ ucfirst($user->role) }}</td>
                                <td class="py-2 px-4 flex space-x-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">
                                        {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">
                                            {{ __('Delete') }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
