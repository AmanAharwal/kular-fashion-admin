<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\Tag;
use App\Models\Product;
use App\Models\ProductType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Gate::allows('view collections')) {
            abort(403);
        }

        $collections = Collection::all();
        return view('collections.index', compact('collections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('create collections')) {
            abort(403);
        }

        $conditionDependencies = [
            'tags' => Tag::select('id', 'name as value')->where('status', 'Active')->get(),
            'ProductTypes' => ProductType::select('id', 'name as value')->where('status', 'Active')->whereNull('deleted_at')->get(),
            'maxProductPrice' => Product::max('price') ?? 9999,
        ];

        return view('collections.create', compact('conditionDependencies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!Gate::allows('create collections')) {
            abort(403);
        }

        Collection::create([
            'name' => $request->collection_name,
            'include_conditions' => json_encode($request->include),
            'exclude_conditions' => json_encode($request->exclude),
            'summary' => $request->summary,
            'description' => $request->description,
            'heading' => $request->heading,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ]);

        return redirect()->route('collections.index')->with('success', 'Collection Added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Collection $collection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Collection $collection)
    {
        if (!Gate::allows('edit collections')) {
            abort(403);
        }

        $conditionDependencies = [
            'tags' => Tag::select('id', 'name as value')->where('status', 'Active')->get(),
            'ProductTypes' => ProductType::select('id', 'name as value')->where('status', 'Active')->whereNull('deleted_at')->get(),
            'maxProductPrice' => Product::max('price') ?? 9999,
        ];

        return view('collections.edit', compact('collection', 'conditionDependencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Collection $collection)
    {
        $collection->update([
            'name' => $request->collection_name,
            'include_conditions' => json_encode($request->include),
            'exclude_conditions' => json_encode($request->exclude),
            'summary' => $request->summary,
            'description' => $request->description,
            'heading' => $request->heading,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
        ]);

        return redirect()->back()->with("success","Collection Updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Collection $collection)
    {
        if(!Gate::allows('delete collections')) {
            abort(403);
        }
        $collection->delete();

        return response()->json([
            'success' => true,
            'message' => 'Collection deleted successfully.'
        ]);
    }

    public function checkCollectionName(Request $request)
    {
        $query = Collection::where('name', $request->name);

        if ($request->has('id')) {
            $query->where('id', '!=', $request->id);
        }

        $existingCollection = $query->first();

        if ($existingCollection) {
            return response()->json(['message' => 'Collection name already exists.'], 400);
        }

        return response()->json(['success' => 'Collection name is available.']);
    }
}
