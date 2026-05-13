@extends('layouts.app')

@section('title', 'Stocks')

@section('page-title', 'Stock Management')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold text-gray-700">
            Stock List
        </h2>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead>

                <tr class="bg-gray-100 text-gray-700">

                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Product</th>
                    <th class="p-3 text-left">Code</th>
                    <th class="p-3 text-left">Current Stock</th>
                    <th class="p-3 text-center">Action</th>

                </tr>

            </thead>

            <tbody>

                @forelse($products as $index => $product)

                    <tr class="border-b hover:bg-gray-50 transition duration-200">

                        <td class="p-3">
                            {{ $index + 1 }}
                        </td>

                        <td class="p-3 font-medium">
                            {{ $product->product_name }}
                        </td>

                        <td class="p-3">
                            {{ $product->product_code }}
                        </td>

                        <td class="p-3">
                            {{ $product->stock->quantity ?? 0 }}
                        </td>

                        <td class="p-3 text-center">

                            <div class="flex justify-center gap-2">

                                <button
                                   onclick="openStockModal(
                                    {{ $product->id }},
                                    {{ $product->stock->id ?? 'null' }},
                                    {{ $product->stock->quantity ?? 0 }}
                                )"
                                    class="bg-blue-600 hover:bg-blue-700 px-4 py-1 rounded-lg transition shadow">

                                    Add Stock

                                </button>
                               <input type="hidden" id="stock_id">     
                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5"
                            class="text-center p-5 text-gray-500">

                            No Stock Found

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

{{-- Modal --}}
<div id="stockModal"
     class="fixed inset-0 hidden z-50 bg-black/50 flex items-center justify-center">

    <div id="modalContent"
         class="bg-white w-[450px] rounded-lg shadow-xl opacity-0 scale-95 transition-all duration-300">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b">

            <h2 class="text-lg font-semibold text-gray-800">
                Add Stock
            </h2>

            <button
                onclick="closeModal()"
                class="text-gray-400 hover:text-black text-2xl">

                &times;

            </button>

        </div>

        {{-- Form --}}
        <form id="stockForm">

            @csrf

            <input type="hidden" id="product_id">

            <div class="p-5 space-y-4">

                <div>

                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Quantity
                    </label>

                    <input
                        type="number"
                        id="quantity"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">

                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 px-5 py-4 border-t bg-gray-50 rounded-b-lg">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="bg-gray-500 hover:bg-gray-600  px-4 py-2 rounded-md">

                    Cancel

                </button>

                <button
                    type="submit"
                    class="bg-blue-600 hover:bg-blue-700  px-4 py-2 rounded-md">

                    Save

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@section('script')

<script>

    function openStockModal(productId, stockId = null, quantity = '')
   {
        document.getElementById('product_id').value = productId;

        document.getElementById('stock_id').value = stockId ?? '';

        document.getElementById('quantity').value = quantity;

        const modal = document.getElementById('stockModal');

        const content = document.getElementById('modalContent');

        modal.classList.remove('hidden');

        setTimeout(() => {

            content.classList.remove('opacity-0', 'scale-95');

            content.classList.add('opacity-100', 'scale-100');

        }, 10);
    }

    function closeModal()
    {
        const modal = document.getElementById('stockModal');

        const content = document.getElementById('modalContent');

        content.classList.remove('opacity-100', 'scale-100');

        content.classList.add('opacity-0', 'scale-95');

        setTimeout(() => {

            modal.classList.add('hidden');

        }, 300);
    }

   document.getElementById('stockForm')
    .addEventListener('submit', function(e)
    {
        e.preventDefault();

        let stock_id = document.getElementById('stock_id').value;

        let product_id = document.getElementById('product_id').value;

        let quantity = document.getElementById('quantity').value;

        let url = stock_id
            ? `/stocks/${stock_id}`
            : '/stocks';

        let method = stock_id
            ? 'PUT'
            : 'POST';

        fetch(url, {

            method: method,

            headers: {

                'Content-Type': 'application/json',

                'X-CSRF-TOKEN':
                    document.querySelector('meta[name="csrf-token"]').content

            },

            body: JSON.stringify({

                product_id: product_id,

                quantity: quantity

            })

        })

        .then(response => response.json())

        .then(data => {

            Swal.fire({

                icon: 'success',

                title: 'Success',

                text: data.message,

                timer: 2000,

                showConfirmButton: false

            });

            closeModal();

            setTimeout(() => {

                location.reload();

            }, 2000);

        })

        .catch(error => {

            Swal.fire({

                icon: 'error',

                title: 'Error',

                text: 'Something went wrong'

            });

        });

    });

</script>

@endsection