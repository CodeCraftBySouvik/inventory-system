<aside class="w-64 bg-gray-800 text-white min-h-screen">

    <div class="p-4 text-2xl font-bold border-b border-gray-700">
        Inventory System
    </div>

    <nav class="mt-4">

        <a href="{{ route('dashboard') }}"
           class="block py-3 px-4 hover:bg-gray-700">
            Dashboard
        </a>

        <a href="{{ route('products.index') }}"
           class="block py-3 px-4 hover:bg-gray-700">
            Products
        </a>

        <a href="{{ route('stocks.index') }}"
           class="block py-3 px-4 hover:bg-gray-700">
            Stocks
        </a>

        <a href="{{ route('sales.create') }}"
           class="block py-3 px-4 hover:bg-gray-700">
            Sales Create
        </a>

       <a href="{{ route('sales.index') }}"
        class="block py-3 px-4 hover:bg-gray-700">
             Invoices
        </a>

    </nav>

</aside>