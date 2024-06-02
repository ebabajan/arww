<x-filament::widget>
    <x-filament::card>
        <table class="min-w-full bg-white">
            <thead>
                <tr>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Month</th>
                    <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-left text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Profit</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($monthlyProfits as $monthlyProfit)
                    <tr>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ $monthlyProfit['month'] }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">{{ number_format($monthlyProfit['profit'], 2) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 font-bold">Total Yearly Profit</td>
                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200 font-bold">{{ number_format($totalYearlyProfit, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </x-filament::card>
</x-filament::widget>
