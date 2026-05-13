@extends('layouts.app')

@section('title', 'Create Sales')

@section('page-title', 'Create Sales Invoice')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-lg max-w-xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">
        Create Invoice
    </h2>

    <form id="saleForm">

        @csrf

        {{-- Product --}}
        <div class="mb-4">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Select Product
            </label>

            <select
                id="product_id"
                class="w-full border border-gray-300 rounded-md px-3 py-2">

                <option value="">
                    Select Product
                </option>

                @foreach($products as $product)

                    <option
                        value="{{ $product->id }}"
                        data-price="{{ $product->price }}"
                        data-stock="{{ $product->stock->quantity ?? 0 }}">

                        {{ $product->product_name }}
                        (Stock: {{ $product->stock->quantity ?? 0 }})

                    </option>

                @endforeach

            </select>

        </div>

        {{-- Quantity --}}
        <div class="mb-4">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Quantity
            </label>

            <input
                type="number"
                id="quantity"
                class="w-full border border-gray-300 rounded-md px-3 py-2">

        </div>

        {{-- Total --}}
        <div class="mb-6">

            <label class="block text-sm font-medium text-gray-700 mb-1">
                Total Amount
            </label>

            <input
                type="text"
                id="total_amount"
                readonly
                class="w-full bg-gray-100 border border-gray-300 rounded-md px-3 py-2">

        </div>

        <button
            type="submit"
            class="bg-blue-600 hover:bg-blue-700 px-5 py-2 rounded-lg">

            Submit

        </button>

    </form>

</div>

@endsection

@section('script')

<script>

    const productSelect =
        document.getElementById('product_id');

    const quantityInput =
        document.getElementById('quantity');

    const totalInput =
        document.getElementById('total_amount');

    function calculateTotal()
    {
        let option =
            productSelect.options[productSelect.selectedIndex];

        let price =
            option.getAttribute('data-price') || 0;

        let quantity =
            quantityInput.value || 0;

        totalInput.value = price * quantity;
    }

    productSelect.addEventListener('change', calculateTotal);

    quantityInput.addEventListener('keyup', calculateTotal);

    document.getElementById('saleForm')
    .addEventListener('submit', function(e)
    {
        e.preventDefault();

        fetch('/sales/store', {

            method: 'POST',

            headers: {

                'Content-Type': 'application/json',

                'Accept': 'application/json',

                'X-CSRF-TOKEN':
                    document.querySelector('meta[name="csrf-token"]').content

            },

            body: JSON.stringify({

                product_id:
                    document.getElementById('product_id').value,

                quantity:
                    document.getElementById('quantity').value

            })

        })

        .then(async response => {

            let data = await response.json();

            if(!response.ok)
            {
                throw data;
            }

            return data;

        })

        .then(data => {

            Swal.fire({

                icon: 'success',

                title: 'Success',

                text: data.message,

                timer: 2000,

                showConfirmButton: false

            });

            setTimeout(() => {

                window.location.href = "{{ route('sales.index') }}";

            }, 2000);

        })

        .catch(error => {

            Swal.fire({

                icon: 'error',

                title: 'Error',

                text: error.message

            });

        });

    });

</script>

@endsection