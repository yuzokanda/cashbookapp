<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index()
    {
        $periods = Item::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as period"))
                ->where('user_id', Auth::id())
                ->groupBy('period')
                ->orderBy('period', 'desc')
                ->get()
                ->pluck('period');

        return Inertia::render('Items/Index', [
            'periods' => $periods
        ]);
    }

    public function getItemsByMonthly(Request $request, $data)
    {
        \Log::debug($data);
        $items = Item::where('date','like', "%$data%")
                ->where('user_id', Auth::id())
                ->get();

        return response()->json($items);
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

        $user_id = Auth::user()->id;

        Item::create([
            'user_id' => $user_id,
            'content' => $request->content,
            'amount' => $request->amount,
            'category' => $request->category,
            'date' => $request->date
        ]);

        return redirect()->route('items.index')->with('message', 'Item Created Successfully');
    }

    public function edit(Item $item)
    {
        return Inertia::render('Items/Edit', [
            'item' => $item,
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

        // return Inertia::render('Items/Index');
        // return redirect()->route('getData');
        return redirect()->route('items.index')->with('message', 'Item Delete Successfully');
    }
}
