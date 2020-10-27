<?php

namespace App\Http\Livewire\DataTable;

trait WithSorting
{
    public $sortField;
    public $sortDirection = 'asc';

    public function sortBy($field)
    {
        $this->sortDirection = $this->sortField === $field
            ? $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'
            : 'asc';
    
        $this->sortField = $field;
    }

    public function applySorting($query)
    {
        return $query->when($this->sortField, fn ($query) => $query->orderBy($this->sortField, $this->sortDirection));
    }
}