<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('icons.update', ['icon' => $icon]) }}" method="POST">
                @csrf
                @method('patch')

                <div class="bg-white overflow-hidden shadow-xl px-6 py-4 space-y-4 sm:rounded-t-lg">
                    <div class="flex">
                        <div class="w-1/3">
                            <h2 class="text-xl font-semibold">Icon</h2>

                            <span class="text-sm text-gray-400">Make sure that the information for the icon is correct.</span>
                        </div>
        
                        <div class="w-2/3 space-y-2">
                            <label class="block w-2/3">
                                <span class="text-gray-700 font-semibold">Name</span>

                                <input name="name" class="form-input mt-1 block w-full @error('name') border-red-500 @enderror" placeholder="Jane Doe" value="{{ $icon->name }}">

                                @error('name')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </label>

                            <label class="block w-full">
                                <span class="text-gray-700 font-semibold">Content</span>

                                <textarea name="content" class="form-textarea mt-1 block w-full @error('content') border-red-500 @enderror" rows="3" placeholder="Enter some long form content.">{{ $icon->content }}</textarea>

                                @error('content')
                                    <span class="text-sm text-red-500">{{ $message }}</span>
                                @enderror
                            </label>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-end shadow-xl rounded-b-lg px-6 py-4 bg-gray-100">
                    <button type="submit" class="inline-flex items-center px-2 py-1 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest space-x-2 hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:shadow-outline-indigo disabled:opacity-25 transition ease-in-out duration-150">
                        <span>Submit</span>
            
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>