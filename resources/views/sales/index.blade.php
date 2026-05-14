@extends('layouts.app')

@section('title', 'Invoices')

@section('page-title', 'Invoice List')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold text-gray-700">
            Invoice List
        </h2>

        <a href="{{ route('sales.create') }}"
           class="btn btn-sm btn-outline-primary hover:bg-blue-700 px-5 py-2 rounded-lg transition duration-300 shadow">
            + Create Invoice
        </a>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Invoice No</th>
                    <th class="p-3 text-left">Date</th>
                    <th class="p-3 text-left">Total Amount</th>
                    <th class="p-3 text-left">Created By</th>
                </tr>
            </thead>

            <tbody>

                @forelse($sales as $index => $sale)

                    <tr class="border-b hover:bg-gray-50 transition duration-200">

                        <td class="p-3">{{ $index + 1 }}</td>

                        <td class="p-3 font-medium">
                            {{ $sale->invoice_no }}
                        </td>

                        <td class="p-3">
                            {{ $sale->sale_date }}
                        </td>

                        <td class="p-3">
                            ₹{{ number_format($sale->total_amount, 2) }}
                        </td>

                        <td class="p-3">
                            {{ $sale->user->name ?? 'N/A' }}
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center p-5 text-gray-500">
                            No Invoices Found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

@endsection