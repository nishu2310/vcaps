<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->input('title', '');
        $price = $request->input('price', '');

        $count = Item::all();
        $query = Item::query();

        if (!empty($title)) {
            $query->where('title', 'like', '%' . $title . '%');
        }

        if (!empty($price)) {
            $query->where('price', $price);
        }

        $products = $query->orderBy('id','DESC')->paginate(10);
        $products->appends(['title' => $title, 'price' => $price]);

        return view('items.index', compact('products', 'title', 'price','count'));
    }
    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required',
            'details' => 'required',
            'price' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:8192',  // Image is required and must be a valid image file
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $imageName);
            $imageUrl = asset('uploads/' . $imageName);

        }    
        $item = new Item();
        $item->title = $request->title;
        $item->details = $request->details;
        $item->price = $request->price;
        $item->image = isset($imageName) ? $imageName : null;
        $item->save();
        
        return redirect()
                ->back()
                ->with('success', 'Item Added successfully!');
    }
}
