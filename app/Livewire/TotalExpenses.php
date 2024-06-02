<?php

namespace App\Livewire;
use Livewire\Component;
use App\Models\Expense;

class TotalExpenses extends Component
{
    public $totalExpenses;

    public function mount()
    {
        $this->totalExpenses = Expense::sum('amount');
    }

    public function render()
    {
        return view('livewire.total-expenses');
    }
}