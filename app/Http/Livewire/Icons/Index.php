<?php

namespace App\Http\Livewire\Icons;

use App\Models\Icon;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $sortField;
    public $sortDirection = 'asc';
    public $showEditModal = false;
    public $showFilters = false;
    public $filters = [
        'search' => null,
        'created-date-min' => null,
        'created-date-max' => null,
    ];
    public Icon $editing;

    protected $queryString = ['sortField', 'sortDirection'];

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

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
    
        $this->sortField = $field;
    }

    public function makeBlankIcon()
    {
        return Icon::make();
    }

    public function create()
    {
        if ($this->editing->getKey()) $this->editing = $this->makeBlankIcon();

        $this->showEditModal = true;
    }

    public function edit(Icon $icon)
    {
        if ($this->editing->isNot($icon)) $this->editing = $icon;

        $this->showEditModal = true;

        $this->resetValidation();
    }

    public function save()
    {
        $this->validate();

        $this->editing->save();

        $this->showEditModal = false;

        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset('filters');
    }

    public function render()
    {
        return view('livewire.icons.index', [
            'icons' => Icon::query()
                ->when($this->filters['created-date-min'], fn($query, $date) => $query->where('created_at', '>=', Carbon::createFromFormat('d/m/Y', $date)->startOfDay()))
                ->when($this->filters['created-date-max'], fn($query, $date) => $query->where('created_at', '<=', Carbon::createFromFormat('d/m/Y', $date)->startOfDay()))
                ->when($this->filters['search'], fn($query, $search) => $query->search('name', $search))
                ->when($this->sortField, fn ($query) => $query->orderBy($this->sortField, $this->sortDirection))
                ->paginate(10),
        ]);
    }
}
