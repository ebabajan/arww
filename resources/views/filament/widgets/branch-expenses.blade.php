<x-filament::widget>
    <x-filament::card>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-l leading-4 font-medium text-gray-500 uppercase tracking-wider">Expenses of the Month</th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-l leading-4 font-medium text-gray-500 uppercase tracking-wider">Branch Name</th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-l leading-4 font-medium text-gray-500 uppercase tracking-wider">Total Expenses</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                            {{ $startOfMonth }} - {{ $endOfMonth }}
                        </td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $expense->branch->name }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ number_format($expense->total_expenses, 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap font-bold">
                        Total
                    </td>
                    <td class="px-6 py-4 whitespace-no-wrap "></td>
                    <td class="px-6 py-4 whitespace-no-wrap font-bold">
                        {{ number_format($totalExpenses, 2) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </x-filament::card>
</x-filament::widget>
