<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        $now=date('Y-m');
        $items = Item::where('date','like', "%$now%")
                ->get();
        // $items = Item::all();

        return Inertia::render('Items/Index',['items' => $items]);
    }

    public function create()
    {
        return Inertia::render('Items/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'date' => 'required|date'
        ]);
        Item::create([
            'content' => $request->content,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => $request->date
        ]);

        // return back()->with('message', 'Item Created Successfully');
        return redirect()->route('items.index')->with('message', 'Item Created Successfully');
    }

    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => $item
        ]);
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'content' => 'required|string',
            'amount' => 'required|numeric',
            'category' => 'required|string',
            'date' => 'required|date'
        ]);

        $item->content = $request->content;
        $item->amount = $request->amount;
        $item->category = $request->category;
        $item->date = $request->date;
        $item->save();

        return redirect()->route('items.index')->with('message', 'Item Updated Successfully');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('message', 'Item Delete Successfully');
    }

    public function getData()
    {
        return Inertia::render('Items/Data');
    }

    public function getItemsByMonthly(Request $request, $data)
    {
        $items = Item::where('date','like', "%$data%")
                ->get();
        return response()->json($items);
    }
}
