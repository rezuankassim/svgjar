<?php

namespace App\Http\Livewire\Icons;

use Carbon\Carbon;
use App\Models\Icon;
use Livewire\Component;
use App\Http\Livewire\DataTable\WithSorting;
use App\Http\Livewire\DataTable\WithCachedRows;
use App\Http\Livewire\DataTable\WithBulkActions;
use App\Http\Livewire\DataTable\WithPerPagePagination;

class Index extends Component
{
    use WithSorting;
    use WithCachedRows;
    use WithBulkActions;
    use WithPerPagePagination;

    public $showEditModal = false;
    public $showDeleteModal = false;
    public $showPermissionModal = false;
    public $isCreating = true;
    public $showFilters = false;
    public $filters = [
        'search' => null,
        'created-date-min' => null,
        'created-date-max' => null,
    ];
    public $selectedPermissions = [];
    public Icon $editing;

    // protected $queryString = ['sortField', 'sortDirection'];

    protected $rules = [
        'editing.name' => 'required',
        'editing.content' => ['required', 'starts_with:<svg'],
    ];

    public function mount()
    {
        $this->editing = $this->makeBlankIcon();
    }
    
    public function updatedFilters()
    {
        $this->resetPage();
    }

    public function makeBlankIcon()
    {
        return Icon::make();
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
            $this->editing = $this->makeBlankIcon();
        }

        $this->isCreating = true;
        $this->showEditModal = true;
    }

    public function edit(Icon $icon)
    {
        $this->useCachedRows();
        
        if ($this->editing->isNot($icon)) {
            $this->editing = $icon;
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
            'submessage' => 'A icon has been created successfully.',
        ]));
    }

    public function hide($model)
    {
        $this->useCachedRows();

        $this->dispatchBrowserEvent('close', [
            'id' => md5($model)
        ]);
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
        $query = Icon::query()
            ->when($this->filters['created-date-min'], fn ($query, $date) => $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $date)->startOfDay()))
            ->when($this->filters['created-date-max'], fn ($query, $date) => $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $date)->startOfDay()))
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
        return view('livewire.icons.index', [
            'icons' => $this->rows,
        ]);
    }
}
