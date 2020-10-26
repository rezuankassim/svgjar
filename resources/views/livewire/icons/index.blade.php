<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl px-6 py-6 space-y-4 sm:rounded-lg">
            <div class="flex flex-col">
                <div class="flex justify-between items-center">
                    <div class="flex space-x-2 w-full">
                        <div class="w-64">
                            <x-input.text wire:model="filters.search" class="w-full h-10" placeholder="Search Icons..."></x-input.text>
                        </div>
                        

                        <x-button.link wire:click="$toggle('showFilters')">@if($showFilters) Hide @endif Advanced Search</x-button.link>
                    </div>
                    
                    <div>
                        <x-button.primary wire:click="create">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        </x-button.primary>
                    </div>
                </div>

                <!-- Advance Search -->
                <div>
                    @if ($showFilters)
                        <div class="relative bg-gray-100 shadow-inner rounded-lg p-4 mt-2">
                            <div class="pt-2 grid grid-flow-rows auto-rows-max grid-cols-2 gap-2">
                                <x-input.group inline for="filter-created-date-min" label="Minimum Created Date">
                                    <x-input.date wire:model.lazy="filters.created-date-min" id="filter-created-date-min" placeholder="DD/MM/YYYY" />
                                </x-input.group>
            
                                <x-input.group inline for="filter-created-date-max" label="Maximum Created Date">
                                    <x-input.date wire:model.lazy="filters.created-date-max" id="filter-created-date-max" placeholder="DD/MM/YYYY" />
                                </x-input.group>
                            </div>

                            <x-button.link wire:click="resetFilters" class="absolute top-0 right-0 px-4 py-2">Reset Filters</x-button.link>
                        </div>
                    @endif
                </div>

                <div class="-my-0 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="py-4 align-middle inline-block min-w-full space-y-4 sm:px-6 lg:px-8">
                        <div class="flex-col space-y-4">
                            <x-table>
                                <x-slot name="head">
                                    <x-table.heading 
                                        sortable
                                        :direction="$sortField === 'name' ? $sortDirection : null"
                                        wire:click="sortBy('name')"
                                        class="w-full"
                                    >Name</x-table.heading>

                                    <x-table.heading :direction="$sortField === 'content' ? $sortDirection : null">Display</x-table.heading>

                                    <x-table.heading 
                                        sortable
                                        :direction="$sortField === 'created_at' ? $sortDirection : null"
                                        wire:click="sortBy('created_at')"
                                    >Created Date</x-table.heading>

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
                        </div>  

                        @if($icons->hasPages())
                            <div>
                                {{ $icons->links() }}
                            </div>
                        @endif    
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