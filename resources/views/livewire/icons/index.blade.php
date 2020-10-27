<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl px-6 py-6 space-y-4 sm:rounded-lg">
            <div class="flex flex-col">
                <!-- Top bar -->
                <div class="flex justify-between items-center">
                    <div class="flex space-x-2">
                        <div class="w-64">
                            <x-input.text wire:model="filters.search" class="w-full h-10" placeholder="Search Icons..."></x-input.text>
                        </div>
                        

                        <x-button.link wire:click="$toggle('showFilters')">@if($showFilters) Hide @endif Advanced Search</x-button.link>
                    </div>
                    
                    <div class="flex items-center space-x-2">
                        <x-dropdown label="Bulk Actions">
                            <x-dropdown.item type="button" wire:click="exportSelected" class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-cool-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>

                                <span>Export</span>
                            </x-dropdown.item>

                            <x-dropdown.item type="button" wire:click="$toggle('showDeleteModal')" class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-cool-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>

                                <span>Delete</span>
                            </x-dropdown.item>
                        </x-dropdown>

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

                <!-- Table -->
                <div class="-my-0 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="pt-4 align-middle inline-block min-w-full space-y-4 sm:px-6 lg:px-8">
                        <div class="flex-col space-y-4">
                            <x-table>
                                <x-slot name="head">
                                    <x-table.heading class="pr-0">
                                        <x-input.checkbox wire:model="selectPage" />
                                    </x-table.heading>

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
                                    @if ($selectPage)
                                        <x-table.row class="bg-cool-gray-200" wire:key="row-icon-message">
                                            <x-table.cell colspan="5">            
                                                @unless($selectAll)
                                                    <div>
                                                        <span>You've selected <strong>{{ $icons->count() }}</strong> icons, do you want to select all <strong>{{ $icons->total() }}</strong>?</span>

                                                        <x-button.link wire:click="selectAll" class="ml-2 text-blue-500 hover:text-blue-700 focus:text-blue-700">Select All</x-button.link>
                                                    </div>
                                                @else
                                                    <span>You've selected all <strong>{{ $icons->total() }}</strong> icons.</span>
                                                @endunless
                                            </x-table.cell>
                                        </x-table.row>
                                    @endif
                                    
                                    @forelse ($icons as $icon)
                                        <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-icon-{{ $icon->id }}">
                                            <x-table.cell class="pr-0">
                                                <x-input.checkbox wire:model="selected" value="{{ $icon->id }}" />
                                            </x-table.cell>

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

    <!-- Edit Modal -->
    <form wire:submit.prevent="save">
        <x-modal.dialog wire:model.defer="showEditModal">
            <x-slot name="title">@if ($isCreating) Add @else Edit @endif Icon</x-slot>
    
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

    <!-- Delete modal -->
    <form wire:submit.prevent="deleteSelected">
        <x-modal.confirmation wire:model.defer="showDeleteModal">
            <x-slot name="title">Are you sure?</x-slot>
    
            <x-slot name="content">This will delete the records and this action is irreversable.</x-slot>
    
            <x-slot name="footer">
                <x-button.secondary wire:click="$toggle('showDeleteModal')">No</x-button.secondary>
                <x-button.primary type="submit">Yes, I am sure.</x-button.primary>
            </x-slot>
        </x-modal.confirmation>
    </form>
</div>