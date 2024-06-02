<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class BranchExpenses extends Widget
{
    protected static string $view = 'filament.widgets.branch-expenses';
    protected int | string | array $columnSpan = 1;
    
    protected function getViewData(): array
    {
        // Get the start and end of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Fetch the sum of expenses by each branch for the current month
        $expenses = Expense::select('branch_id', DB::raw('SUM(amount) as total_expenses'))
                           ->whereBetween('date_expense', [$startOfMonth, $endOfMonth])
                           ->groupBy('branch_id')
                           ->with('branch')
                           ->get();

        // Calculate the total expenses across all branches
        $totalExpenses = $expenses->sum('total_expenses');

        return [
            'expenses' => $expenses,
            'startOfMonth' => $startOfMonth->format('d/m/Y'),
            'endOfMonth' => $endOfMonth->format('d/m/Y'),
            'totalExpenses' => $totalExpenses,
        ];
    }
}
