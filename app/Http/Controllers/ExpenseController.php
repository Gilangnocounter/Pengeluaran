<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with('category')
            ->where('user_id', Auth::id())
            ->latest();

        // search by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // filter by date range
        if ($request->filled('from')) {
            $query->where('date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('date', '<=', $request->to);
        }

        $expenses = $query->paginate(15);
        $categories = Category::all();

        return view('expenses.index', compact('expenses', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $validated['user_id'] = Auth::id();

        Expense::create($validated);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran ditambahkan.');
    }

    public function edit(Expense $expense)
    {
        $categories = Category::all();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'amount' => 'required|numeric|min:0',
            'date' => 'required|date',
            'description' => 'nullable|string|max:1000',
        ]);

        $expense->update($validated);

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran diperbarui.');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        return redirect()->route('expenses.index')->with('success', 'Pengeluaran dihapus.');
    }

    public function show(Expense $expense)
    {
        return view('expenses.show', compact('expense'));
    }
}
