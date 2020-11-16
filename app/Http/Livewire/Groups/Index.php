<?php

namespace App\Http\Livewire\Groups;

use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithPerPagePagination;
use App\Http\Livewire\DataTable\WithSorting;
use App\Models\Group;
use Carbon\Carbon;
use Livewire\Component;

class Index extends Component
{
    use WithSorting;
    use WithCachedRows;
    use WithBulkActions;
    use WithPerPagePagination;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $isCreating = true;
    public $showFilters = false;
    public Group $editing;
    public $filters = [
        'search' => null,
        'created-date-min' => null,
        'created-date-max' => null,
    ];

    protected $rules = [
        'editing.name' => ['required', 'min:3'],
        'editing.url' => ['nullable', 'min:3'],
    ];

    public function mount()
    {
        $this->editing = $this->makeBlankGroup();
    }

    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function makeBlankGroup()
    {
        return Group::make();
    }

    public function toggleShowFilters()
    {
        $this->useCachedRows();

        $this->showFilters = ! $this->showFilters;
    }

    public function create()
    {
        $this->useCachedRows();

        if ($this->editing->getKey()) {
            $this->editing = $this->makeBlankGroup();
        }

        $this->isCreating = true;
        $this->showEditModal = true;
    }

    public function edit(Group $group)
    {
        $this->useCachedRows();
        
        if ($this->editing->isNot($group)) {
            $this->editing = $group;
        }

        $this->isCreating = false;
        $this->showEditModal = true;

        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $this->editing->save();

        $this->showEditModal = false;

        $this->resetValidation();

        $this->notify(json_encode([
            'message' => 'Yay! Everything worked!',
            'submessage' => 'A group has been created successfully.',
        ]));
    }

    public function hideEditModal()
    {
        $this->showEditModal = false;
    }

    public function hideDeleteModal()
    {
        $this->showDeleteModal = false;
    }

    public function exportSelected()
    {
        $this->reset(['selectAll', 'selectPage']);

        return response()->streamDownload(function () {
            echo $this->selectedRowsQuery->toCsv();
        }, 'icons.csv');
    }

    public function deleteSelected()
    {
        $this->reset(['selectAll', 'selectPage', 'showDeleteModal']);

        $this->selectedRowsQuery->delete();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function getRowsQueryProperty()
    {
        $query = Group::query()
            ->when($this->filters['created-date-min'], fn ($query, $date) => $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $date)->startOfDay()))
            ->when($this->filters['created-date-max'], fn ($query, $date) => $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $date)->endOfDay()))
            ->when($this->filters['search'], fn ($query, $search) => $query->search('name', $search));

        return $this->applySorting($query);
    }

    public function getRowsProperty()
    {
        return $this->remember(function () {
            return $this->applyPagination($this->rowsQuery);
        });
    }

    public function render()
    {
        return view('livewire.groups.index', [
            'groups' => $this->rows
        ]);
    }
}
