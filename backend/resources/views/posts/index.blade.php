<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="mb-4">
                        <a href="{{ route('posts.create') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('New Post') }}
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <strong class="font-bold">{{ __('Success!') }}</strong>
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <ul class="space-y-4">
                        @forelse ($posts as $post)
                            <li class="border rounded-md p-4">
                                <h3 class="text-lg font-semibold">
                                    <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                                </h3>
                                <p class="text-gray-600 text-sm">
                                    {{ __('Posted by') }}: {{ $post->user->username }}
                                    <br>
                                    {{ __('Created At') }}: {{ $post->created_at->format('Y-m-d H:i') }}
                                </p>
                                <p class="mt-2">{{ Str::limit($post->content, 100) }}</p>
                                <div class="mt-2">
                                    <a href="{{ route('posts.edit', $post) }}" class="text-indigo-600 hover:text-indigo-900">{{ __('Edit') }}</a>
                                    <form action="{{ route('posts.destroy', $post) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 ml-2" onclick="return confirm('{{ __('Are you sure you want to delete this post?') }}')">{{ __('Delete') }}</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="py-4">{{ __('No posts yet.') }}</li>
                        @endforelse
                    </ul>

                    <div class="mt-4">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>