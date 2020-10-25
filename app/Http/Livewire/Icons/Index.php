<?php

namespace App\Http\Livewire\Icons;

use App\Models\Icon;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search;
    public $sortField;
    public $sortDirection = 'asc';
    public $showEditModal = false;
    public Icon $editing;

    protected $queryString = ['sortField', 'sortDirection'];

    protected $rules = [
        'editing.name' => 'required',
        'editing.content' => ['required', 'starts_with:<svg'],
    ];

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
    
        $this->sortField = $field;
    }

    public function edit(Icon $icon)
    {
        $this->editing = $icon;

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

    public function render()
    {
        return view('livewire.icons.index', [
            'icons' => Icon::query()
                        ->search('name', $this->search)
                        ->when($this->sortField, function ($query) {
                            $query->orderBy($this->sortField, $this->sortDirection);
                        })
                        ->paginate(10),
        ]);
    }
}
