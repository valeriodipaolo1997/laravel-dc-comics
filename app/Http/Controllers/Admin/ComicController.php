<?php

namespace App\Http\Controllers\Admin;


use App\Models\Comic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use function PHPUnit\Framework\isNull;

class ComicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comics = Comic::orderBy('id')->paginate(10);
        return view('admin.comics.index', compact('comics'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.comics.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $val_data = $request->validate([
            'title' => 'bail|required|min:5|max:100',
            'series' => 'bail|required|min:10|max:100',
            'thumb' => 'required|image'
        ]);

        if ($request->has('thumb')) {
            $file_path =  Storage::put('products_image', $request->thumb);
            $val_data['thumb'] = $file_path;
        }

        Comic::create($val_data);

        return to_route('comics.index')->with('message', 'Welldone! Comic created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Comic $comic)
    {
        if ($comic) {
            return view('admin.comics.show', compact('comic'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Comic $comic)
    {
        return view('admin.comics.edit', compact('comic'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comic $comic)
    {
        
        $val_data = $request->validate([
            'title' => 'bail|required|min:5|max:100',
            'series' => 'bail|required|min:10|max:100',
            'thumb' => 'required|image'
        ]);

        if ($request->has('thumb') && $comic->thumb) {

            Storage::delete($comic->thumb);

            $newImageFile = $request->thumb;
            $file_path = Storage::put('comic_image', $newImageFile);
            $val_data['thumb'] = $file_path;
        }

        $comic->update($val_data);

        return to_route('comics.index')->with('message', 'Welldone! Comic updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comic $comic)
    {
        if (!isNull($comic->thumb)) {
            Storage::delete($comic->thumb);
        }
        $comic->delete();

        return to_route('comics.index')->with('message', 'Welldone! Comic deleted successfully');
    }
}
