<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use App\Models\Expense;
use App\Models\Collection;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class MonthlyProfit extends Widget
{
    protected static string $view = 'filament.widgets.monthly-profit';
    protected string|int|array $columnSpan = 1;

    protected function getViewData(): array
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $monthlyProfits = [];
        $totalYearlyProfit = 0;

        // Loop through each month of the year up to the current month
        for ($month = 1; $month <= $currentMonth; $month++) {
            $startOfMonth = Carbon::create($currentYear, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth();

            // Fetch the sum of expenses for the current month
            $totalExpenses = Expense::whereBetween('date_expense', [$startOfMonth, $endOfMonth])
                ->sum('amount');

            // Fetch the sum of collections (income) for the current month
            $totalIncome = Collection::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('profit');

            // Calculate the profit by subtracting expenses from collections
            $monthlyProfit = $totalIncome - $totalExpenses;

            $monthlyProfits[] = [
                'month' => $startOfMonth->format('F'),
                'profit' => $monthlyProfit,
            ];

            $totalYearlyProfit += $monthlyProfit;
        }

        return [
            'monthlyProfits' => $monthlyProfits,
            'totalYearlyProfit' => $totalYearlyProfit,
        ];
    }
}
