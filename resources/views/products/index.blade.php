@extends('layouts.app')

@section('title', 'Products')

@section('page-title', 'Product List')

@section('content')

<div class="bg-white p-6 rounded-2xl shadow-lg">

    <div class="flex justify-between items-center mb-6">

        <h2 class="text-2xl font-bold text-gray-700">
            Product List
        </h2>

        <button
            onclick="openAddModal()"
            class="btn btn-sm btn-outline-primary hover:bg-blue-700  px-5 py-2 rounded-lg transition duration-300 shadow">
            + Add Product
        </button>

    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">

        <table class="w-full border-collapse">

            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 text-left">ID</th>
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Code</th>
                    <th class="p-3 text-left">Price</th>
                    <th class="p-3 text-center">Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($products as $index => $product)

                    <tr class="border-b hover:bg-gray-50 transition duration-200">

                        <td class="p-3">{{ $index + 1 }}</td>

                        <td class="p-3 font-medium">{{ $product->product_name }}</td>

                        <td class="p-3">{{ $product->product_code }}</td>

                        <td class="p-3">₹{{ $product->price }}</td>

                        <td class="p-3 text-center">
                            <div class="flex justify-center gap-2">

                                <button
                                    onclick="editProduct(
                                        {{ $product->id }},
                                        '{{ addslashes($product->product_name) }}',
                                        '{{ addslashes($product->product_code) }}',
                                        '{{ $product->price }}'
                                    )"
                                    class="btn btn-sm btn-outline-info hover:bg-yellow-600  px-4 py-1 rounded-lg transition">
                                    Edit
                                </button>

                                <button
                                    onclick="deleteProduct({{ $product->id }})"
                                    class="btn btn-sm btn-outline-danger hover:bg-red-600  px-4 py-1 rounded-lg transition">
                                    Delete
                                </button>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center p-5 text-gray-500">
                            No Products Found
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

        <div class="mt-6">
            {{ $products->links() }}
        </div>

    </div>

</div>

{{-- Modal --}}
<div id="productModal"
     class="fixed inset-0 hidden z-50 bg-black/50 flex items-center justify-center">

    <div id="modalContent"
         class="bg-white w-[450px] rounded-lg shadow-xl opacity-0 scale-95 transition-all duration-300">

        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-4 border-b">

            <h2 id="modalTitle" class="text-lg font-semibold text-gray-800">
                Add Product
            </h2>

            <button onclick="closeModal()" class="text-gray-400 hover:text-black text-2xl">
                &times;
            </button>

        </div>

        {{-- Form --}}
        <form id="productForm">

            @csrf

            <input type="hidden" id="product_id">

            <div class="p-5 space-y-4">

                {{-- Product Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Product Name
                    </label>
                    <input
                        type="text"
                        id="product_name"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <small id="name_error" class="text-red-500 text-sm"></small>
                </div>

                {{-- Product Code --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Product Code
                    </label>
                    <input
                        type="text"
                        id="product_code"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <small id="code_error" class="text-red-500 text-sm"></small>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Price
                    </label>
                    <input
                        type="number"
                        id="price"
                        class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-300">
                    <small id="price_error" class="text-red-500 text-sm"></small>
                </div>

            </div>

            {{-- Footer --}}
            <div class="flex justify-end gap-2 px-5 py-4 border-t bg-gray-50 rounded-b-lg">

                <button
                    type="button"
                    onclick="closeModal()"
                    class="bg-gray-500 hover:bg-gray-600  px-4 py-2 rounded-md">
                    Close
                </button>

                <button
                    type="submit"
                    id="saveBtn"
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

    let updateMode = false;

    // Open Add Modal
    function openAddModal() {
        updateMode = false;
        document.getElementById('modalTitle').innerText = 'Add Product';
        document.getElementById('productForm').reset();
        document.getElementById('product_id').value = '';
        clearErrors();
        showModal();
    }

    // Open Edit Modal
    function editProduct(id, name, code, price) {
        updateMode = true;
        document.getElementById('modalTitle').innerText = 'Edit Product';
        document.getElementById('product_id').value = id;
        document.getElementById('product_name').value = name;
        document.getElementById('product_code').value = code;
        document.getElementById('price').value = price;
        clearErrors();
        showModal();
    }

    // Show Modal
    function showModal() {
        const modal   = document.getElementById('productModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('opacity-0', 'scale-95');
            content.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    // Close Modal
    function closeModal() {
        const modal   = document.getElementById('productModal');
        const content = document.getElementById('modalContent');
        content.classList.remove('opacity-100', 'scale-100');
        content.classList.add('opacity-0', 'scale-95');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    // Clear Errors
    function clearErrors() {
        ['name_error', 'code_error', 'price_error'].forEach(id => {
            document.getElementById(id).innerText = '';
        });
        ['product_name', 'product_code', 'price'].forEach(id => {
            const el = document.getElementById(id);
            el.classList.remove('border-red-500');
            el.classList.add('border-gray-300');
        });
    }

    // Show field error helper
    function showFieldError(fieldId, errorId, message) {
        document.getElementById(errorId).innerHTML =
            `<span class="text-red-500">${message}</span>`;
        const el = document.getElementById(fieldId);
        el.classList.remove('border-gray-300');
        el.classList.add('border-red-500');
    }

    // Form Submit
    document.getElementById('productForm').addEventListener('submit', function(e) {

        e.preventDefault();
        clearErrors();

        const product_name = document.getElementById('product_name').value.trim();
        const product_code = document.getElementById('product_code').value.trim();
        const price        = document.getElementById('price').value.trim();

        let hasError = false;

        // Frontend Validation
        if (product_name === '') {
            showFieldError('product_name', 'name_error', 'Product name is required');
            hasError = true;
        }

        if (product_code === '') {
            showFieldError('product_code', 'code_error', 'Product code is required');
            hasError = true;
        }

        if (price === '') {
            showFieldError('price', 'price_error', 'Price is required');
            hasError = true;
        } else if (parseFloat(price) <= 0) {
            showFieldError('price', 'price_error', 'Price must be greater than 0');
            hasError = true;
        }

        if (hasError) return;

        // Disable save button to prevent double submit
        const saveBtn = document.getElementById('saveBtn');
        saveBtn.disabled = true;
        saveBtn.innerText = 'Saving...';

        const id     = document.getElementById('product_id').value;
        const url    = updateMode ? `/products/${id}` : `/products`;
        const method = updateMode ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_name, product_code, price })
        })
        .then(async response => {

            const text = await response.text();
            let data;

            try {
                data = JSON.parse(text);
            } catch (e) {
                console.error('Non-JSON response:', text);
                throw new Error('Server returned an unexpected response');
            }

            // Handle Laravel validation errors
            if (response.status === 422) {
                const errors = data.errors || {};

                if (errors.product_name) showFieldError('product_name', 'name_error', errors.product_name[0]);
                if (errors.product_code) showFieldError('product_code', 'code_error', errors.product_code[0]);
                if (errors.price)        showFieldError('price',        'price_error', errors.price[0]);

                return Promise.reject('validation');
            }

            if (!response.ok) {
                throw new Error(data.message || 'Request failed');
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
            closeModal();
            setTimeout(() => location.reload(), 1500);
        })
        .catch(error => {
            if (error === 'validation') return;
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Something went wrong!'
            });
        })
        .finally(() => {
            saveBtn.disabled = false;
            saveBtn.innerText = 'Save';
        });

    });

    // Delete Product
    function deleteProduct(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        })
        .then(result => {
            if (result.isConfirmed) {
                fetch(`/products/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept':       'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(async response => {
                    const text = await response.text();
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch(e) {
                        throw new Error('Unexpected server response');
                    }
                    if (!response.ok) throw new Error(data.message || 'Delete failed');
                    return data;
                })
                .then(data => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1500);
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Could not delete product'
                    });
                });
            }
        });
    }

</script>
@endsection