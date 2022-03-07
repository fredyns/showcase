<?php

namespace App\Http\Controllers\Api;

use App\Models\Entry;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EntryResource;
use App\Http\Resources\EntryCollection;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\EntryStoreRequest;
use App\Http\Requests\EntryUpdateRequest;

class EntryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Entry::class);

        $search = $request->get('search', '');

        $entries = Entry::search($search)
            ->latest()
            ->paginate();

        return new EntryCollection($entries);
    }

    /**
     * @param \App\Http\Requests\EntryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(EntryStoreRequest $request)
    {
        $this->authorize('create', Entry::class);

        $validated = $request->validated();
        if ($request->hasFile('file')) {
            $validated['file'] = $request->file('file')->store('public');
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('public');
        }

        $validated['json'] = json_decode($validated['json'], true);

        $entry = Entry::create($validated);

        return new EntryResource($entry);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Entry $entry)
    {
        $this->authorize('view', $entry);

        return new EntryResource($entry);
    }

    /**
     * @param \App\Http\Requests\EntryUpdateRequest $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function update(EntryUpdateRequest $request, Entry $entry)
    {
        $this->authorize('update', $entry);

        $validated = $request->validated();

        if ($request->hasFile('file')) {
            if ($entry->file) {
                Storage::delete($entry->file);
            }

            $validated['file'] = $request->file('file')->store('public');
        }

        if ($request->hasFile('image')) {
            if ($entry->image) {
                Storage::delete($entry->image);
            }

            $validated['image'] = $request->file('image')->store('public');
        }

        $validated['json'] = json_decode($validated['json'], true);

        $entry->update($validated);

        return new EntryResource($entry);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Entry $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Entry $entry)
    {
        $this->authorize('delete', $entry);

        if ($entry->file) {
            Storage::delete($entry->file);
        }

        if ($entry->image) {
            Storage::delete($entry->image);
        }

        $entry->delete();

        return response()->noContent();
    }
}
