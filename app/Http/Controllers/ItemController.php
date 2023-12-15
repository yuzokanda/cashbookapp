<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ItemStoreRequest;

class ItemController extends Controller
{
    public function index()
    {
        $category_id= Category::where('user_id', Auth::id())->get();

        $periods = Item::select(DB::raw("DATE_FORMAT(date, '%Y-%m') as period"))
                ->where('user_id', Auth::id())
                ->groupBy('period')
                ->orderBy('period', 'desc')
                ->get()
                ->pluck('period');

        return Inertia::render('Items/Index', [
            'periods' => $periods,
            'category_id' => $category_id,
        ]);
    }

    public function getItemsByMonthly(Request $request, $data)
    {
        $items = Item::where('date','like', "%$data%")
                ->where('user_id', Auth::id())
                ->with('category')
                ->get();

        return response()->json($items);
    }

    public function create()
    {
        $category_id= Category::where('user_id', Auth::id())->get();

        return Inertia::render('Items/Create',[
            'category_id' => $category_id
        ]);
    }

    public function store(ItemStoreRequest $request)
    {
        $user_id = Auth::user()->id;

        Item::create([
            'user_id' => $user_id,
            'content' => $request->content,
            'amount' => $request->amount,
            'category_id' => $request->category_id,
            'date' => $request->date
        ]);

        return redirect()->route('items.index')->with('message', '支出項目が追加されました！');
    }

    public function edit(Item $item)
    {
        $category_id= Category::where('user_id', Auth::id())->get();

        return Inertia::render('Items/Edit', [
            'item' => $item,
            'category_id' => $category_id,
        ]);
    }

    public function update(ItemStoreRequest $request, Item $item)
    {
        $item->content = $request->content;
        $item->amount = $request->amount;
        $item->category_id = $request->category_id;
        $item->date = $request->date;
        $item->save();

        return redirect()->route('items.index')->with('message', '支出項目が編集されました！');
    }

    public function destroy(Item $item)
    {
        $item->delete();

        return redirect()->route('items.index')->with('message', '支出項目が削除されました！');
    }
}
