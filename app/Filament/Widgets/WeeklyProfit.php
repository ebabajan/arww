<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
 
use App\Models\Expense;
use App\Models\Collection;
use App\Models\Profit;
use Carbon\Carbon;
use Filament\Widgets\Concerns\CanPoll;

class WeeklyProfit extends ChartWidget
{

   // use CanPolll;

    protected static ?string $heading = 'Weekly Profits';
    protected int | string | array $columnSpan = 2;

    protected function getData(): array
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $weeklyProfits = [];
        $weeklyLabels = [];

        // Loop through each month of the year up to the current month
        for ($month = 1; $month <= $currentMonth; $month++) {
            $startOfMonth = Carbon::create($currentYear, $month, 1)->startOfMonth();
            $endOfMonth = Carbon::create($currentYear, $month, 1)->endOfMonth();

            // Calculate weekly profits for the current month
            $currentWeekStart = $startOfMonth->copy();
            while ($currentWeekStart->lessThanOrEqualTo($endOfMonth)) {
                $currentWeekEnd = $currentWeekStart->copy()->endOfWeek();

                // Fetch the sum of expenses for the current week
                $weeklyExpenses = Expense::whereBetween('date_expense', [$currentWeekStart, $currentWeekEnd])
                    ->sum('amount');

                // Fetch the sum of profit for the current week from collections
                $weeklyProfit = Profit::whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
                    ->sum('profit');

                // Calculate the weekly profit
                $weeklyNetProfit = $weeklyProfit - $weeklyExpenses;

                $weeklyLabels[] = $currentWeekStart->format('d-m-Y') . ' to ' . $currentWeekEnd->format('d-m-Y');
                $weeklyProfits[] = $weeklyNetProfit;

                $currentWeekStart->addWeek();
            }
        }

        return [
            'datasets' => [
                [
                    'label' => 'Weekly Profit',
                    'data' => $weeklyProfits,
                ],
            ],
            'labels' => $weeklyLabels,
        ];
    }
    protected function getType(): string
    {
        return 'line';
    }
}
