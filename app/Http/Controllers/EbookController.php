<?php

namespace App\Http\Controllers;

use App\Http\Requests\EbookStoreRequest;
use App\Http\Requests\EbookUpdateRequest;
use App\Models\Category;
use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $max_price = Ebook::max('price');
        $categories = Category::select('name')->get();
        return view('backend.ebook.index',compact('max_price','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id','name')->get();
        return view('backend.ebook.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EbookStoreRequest $request)
    {
        $filePath = $request->file('file_path')->store('ebooks/files', 'public');
        $thumbnailPath = $request->file('thumbnail')->store('ebooks/thumbnails', 'public');
        
        $ebook = new Ebook();
        $ebook->category_id = $request->category_id;
        $ebook->title = $request->title;
        $ebook->author = $request->author;
        $ebook->price = $request->price;
        $ebook->description = $request->description;
        $ebook->file_path = $filePath;
        $ebook->thumbnail = $thumbnailPath;
        $ebook->save();
        return response()->json(['message' => 'Success add ebook.'],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Ebook $ebook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ebook $ebook)
    {
        $categories = Category::select('id','name')->get();
        return view('backend.ebook.edit',compact('ebook','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EbookUpdateRequest $request, Ebook $ebook)
    {
        $ebook->category_id = $request->category_id;
        $ebook->title = $request->title;
        $ebook->author = $request->author;
        $ebook->price = $request->price;
        $ebook->description = $request->description;

        if ($request->hasFile('file_path')) {
            if (Storage::disk('public')->exists($ebook->file_path)) {
                Storage::disk('public')->delete($ebook->file_path);
            }
            $ebook->file_path = $request->file('file_path')->store('ebooks/files', 'public');
        }

        if ($request->hasFile('thumbnail')) {
            if (Storage::disk('public')->exists($ebook->thumbnail)) {
                Storage::disk('public')->delete($ebook->thumbnail);
            }
            $ebook->thumbnail = $request->file('thumbnail')->store('ebooks/thumbnails', 'public');
        }
        $ebook->save();
        return response()->json(['message' => 'Success update ebook.'],201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ebook $ebook)
    {
        //
    }

    /**
     * Datatable
     */
    public function datatable(Request $request)
    {
        $ebooks = Ebook::select('ebooks.id','categories.name as categoryName','title','price','author')->orderBy('ebooks.created_at','DESC')->join('categories','categories.id','=','ebooks.category_id');
        $ebooks->when($request->categoryName && $request->categoryName != '*', function ($query) use ($request) {
            $query->where('categories.name', 'LIKE', '%' . $request->categoryName . '%');
        });
        $ebooks->when($request->title, function ($query) use ($request) {
            $query->where('title', 'LIKE', '%' . $request->title . '%');
        });
        if ($request->range_price != null && $request->range_price !== '0;0') {
            list($minPrice, $maxPrice) = explode(';', $request->range_price);
            $ebooks->whereBetween('price', [$minPrice, $maxPrice]);
        }

        return DataTables::of($ebooks)
            ->addColumn('no', '')
            ->addColumn('action', 'backend.ebook.action')
            ->rawColumns(['action'])
            ->make(true);
    }
}
