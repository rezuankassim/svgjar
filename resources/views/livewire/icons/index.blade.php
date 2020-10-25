<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl px-6 py-4 space-y-4 sm:rounded-lg">
            <div class="flex items-center justify-end">
                <a href="{{ route('icons.create') }}" class="inline-flex items-center px-2 py-1 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest space-x-2 hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray disabled:opacity-25 transition ease-in-out duration-150">
                    <span>Add New Icon</span>
        
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>

            <div class="flex flex-col">
                <div>
                    <div class="w-1/4">
                        <x-input.text wire:model="search" placeholder="Search Icons..."></x-input.text>
                    </div>
                    
                </div>

                <div class="-my-0 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-4 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                        <div class="flex-col space-y-4">
                            <x-table>
                                <x-slot name="head">
                                    <x-table.heading 
                                        sortable
                                        :direction="$sortField === 'name' ? $sortDirection : null"
                                        wire:click="sortBy('name')"
                                    >Name</x-table.heading>

                                    <x-table.heading :direction="$sortField === 'content' ? $sortDirection : null">Display</x-table.heading>

                                    <x-table.heading 
                                        sortable
                                        :direction="$sortField === 'created_at' ? $sortDirection : null"
                                        wire:click="sortBy('created_at')"
                                    >Created At</x-table.heading>

                                    <x-table.heading />
                                </x-slot>

                                <x-slot name="body">
                                    @forelse ($icons as $icon)
                                        <x-table.row wire:loading.class.delay="opacity-50">
                                            <x-table.cell>{{ $icon->name }}</x-table.cell>

                                            <x-table.cell>{!! $icon->content !!}</x-table.cell>

                                            <x-table.cell>{{ $icon->date_for_humans }}</x-table.cell>
                                            
                                            <x-table.cell>
                                                <x-button.link wire:click="edit({{ $icon->id }})">Edit</x-button.link>
                                            </x-table.cell>
                                        </x-table.row>
                                    @empty
                                        <x-table.row>
                                            <x-table.cell colspan="3">
                                                <div class="flex justify-center items-center">
                                                    <span class="font-medium py-4 text-gray-500">No record found...</span>
                                                </div>
                                            </x-table.cell>
                                        </x-table.row>
                                    @endforelse
                                </x-slot>
                            </x-table>

                            <div>
                                {{ $icons->links() }}
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">Edit Icon</x-slot>
    
            <x-slot name="content">
                <x-input.group for="name" label="Name" :error="$errors->first('editing.name')">
                    <x-input.text id="name" wire:model="editing.name" />
                </x-input.group>

                <x-input.group for="content" label="Content" :error="$errors->first('editing.content')">
                    <x-input.textarea id="content" wire:model="editing.content" rows="5" />
                </x-input.group>
            </x-slot>
    
            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('showEditModal')">Cancel</x-button.secondary>
                <x-button.primary type="submit">Submit</x-button.primary> 
            </x-slot>
        </x-modal.dialog>
    </form>
</div>