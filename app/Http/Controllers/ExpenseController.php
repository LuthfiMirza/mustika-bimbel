<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ExpenseController extends Controller
{
    /**
     * Display expenses list filtered by month and category.
     */
    public function index(Request $request): View
    {
        $monthFilter = $request->query('month', now()->format('Y-m'));
        $categoryFilter = $request->query('category');

        $query = Expense::query()
            ->when($monthFilter && preg_match('/^\d{4}-\d{2}$/', $monthFilter), function ($q) use ($monthFilter) {
                $date = Carbon::createFromFormat('Y-m', $monthFilter);
                $q->whereYear('expense_date', $date->year)
                    ->whereMonth('expense_date', $date->month);
            })
            ->when($categoryFilter, fn($q) => $q->where('category', $categoryFilter));

        $totalFiltered = (int) (clone $query)->sum('amount');
        $expenses = $query->orderBy('expense_date', 'desc')->orderBy('id', 'desc')->paginate(15)->withQueryString();

        $allMonthTotal = (int) Expense::whereYear('expense_date', now()->year)
            ->whereMonth('expense_date', now()->month)
            ->sum('amount');
        $allTimeTotal = (int) Expense::sum('amount');
        $categories = Expense::CATEGORIES;

        return view('admin.expenses.index', compact(
            'expenses',
            'monthFilter',
            'categoryFilter',
            'totalFiltered',
            'allMonthTotal',
            'allTimeTotal',
            'categories'
        ));
    }

    /**
     * Store a new operational expense.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'expense_date' => ['required', 'date'],
            'category' => ['required', 'string', 'in:' . implode(',', Expense::CATEGORIES)],
            'description' => ['required', 'string', 'max:200'],
            'amount' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:Tunai,Transfer Bank,QRIS / E-Wallet'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $validated['recorded_by'] = Auth::user()?->name ?? 'Admin';
        Expense::create($validated);

        return back()->with('success', "Pengeluaran '{$validated['description']}' (Rp " . number_format($validated['amount'], 0, ',', '.') . ') berhasil dicatat!');
    }

    /**
     * Update an existing expense.
     */
    public function update(Request $request, Expense $expense): RedirectResponse
    {
        $validated = $request->validate([
            'expense_date' => ['required', 'date'],
            'category' => ['required', 'string', 'in:' . implode(',', Expense::CATEGORIES)],
            'description' => ['required', 'string', 'max:200'],
            'amount' => ['required', 'integer', 'min:1'],
            'payment_method' => ['required', 'string', 'in:Tunai,Transfer Bank,QRIS / E-Wallet'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $expense->update($validated);

        return back()->with('success', "Data pengeluaran '{$expense->description}' berhasil diperbarui.");
    }

    /**
     * Delete an expense record.
     */
    public function destroy(Expense $expense): RedirectResponse
    {
        $desc = $expense->description;
        $expense->delete();

        return back()->with('success', "Pengeluaran '{$desc}' telah dihapus.");
    }
}
