<?php

namespace App\Http\Controllers;

use App\Models\Icon;
use Illuminate\Http\Request;
use App\Http\Requests\Icons\StoreRequest;
use App\Http\Requests\Icons\UpdateRequest;

class IconController extends Controller
{
    public function index()
    {
        return view('icons.index');
    }

    public function create()
    {
        return view('icons.create');
    }

    public function store(StoreRequest $request)
    {
        $validated = $request->validated();

        Icon::create([
            'name' => $validated['name'],
            'content' => $validated['content'],
        ]);

        return redirect()->route('icons.index')->with('success', 'The record has been created.');
    }

    public function edit(Icon $icon)
    {
        return view('icons.edit', [
            'icon' => $icon
        ]);
    }

    public function update(UpdateRequest $request, Icon $icon)
    {
        $validated = $request->validated();

        $icon->update([
            'name' => $validated['name'],
            'content' => $validated['content']
        ]);

        return redirect()->route('icons.index')->with('success', 'The record has been updated.');
    }
}
