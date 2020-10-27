<?php

namespace App\Http\Livewire\DataTable;


trait WithCachedRows
{
    protected $useCache = false;

    public function useCachedRows()
    {
        $this->useCache = true;
    }

    public function remember($callback)
    {
        if ($this->useCache && cache()->has($this->id)) {
            return cache()->get($this->id);
        }


        $result = $callback();

        cache()->put($this->id, $result);

        return $result;
    }
}