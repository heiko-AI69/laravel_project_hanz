<x-app-layout>
    <x-slot name="header">
        <h2 style="color: white; font-weight: bold; font-size: 24px; text-align: center;">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-pink overflow-hidden shadow-sm sm:rounded-lg">
                <div class= "table-container">
                    <header class="p-4 flex justify-between items-center">
                        <form action="" method="GET" class="flex items-center space-x-2">
                            <input
                                type="text"
                                name="search"
                                class="form-input border border-gray-300 rounded-lg p-2 mr-2"
                                placeholder="Search products..."
                                value="{{ request('search') }}">
                            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-red-700">Search</button>
                        </form>
                        <a href="{{ route('product.create') }}" class="flex flex-row gap-2 bg-yellow-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                         New Product
                        </a>
                    </header>
                    <table class="min-w-full border-collapse border border-green-200 bg-white shadow-md rounded-lg overflow-hidden">
                        <thead>
                            <tr class="bg-gray-200 text-left text-gray-600 uppercase text-sm leading-normal">
                                <th class="py-3 px-6">Image</th>
                                <th class="py-3 px-6">Product Name</th>
                                <th class="py-3 px-6">Category</th>
                                <th class="py-3 px-6">Price</th>
                                <th class="py-3 px-6">Stocks</th>
                                <th class="py-3 px-6">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                            <tr class="border-b border-gray-100">
                                <td class="py-3 py-6">
                                    <img src="{{ asset('storage/Uploads/Product Images/' . $product->product_image) }}"  class="w-10 h-10 rounded-full">
                                </td>
                                <td class="py-3 px-6">{{ $product->product_name }}</td>
                                <td class="py-3 px-6">{{ $product->category->category_name }}</td>
                                <td class="py-3 px-6">{{ $product->price }}</td>
                                <td class="py-3 px-6">{{ $product->stocks }}</td>
                                <td class="py-3 px-6 flex space-x-2">
                                    <a title="EDIT" href="{{ route('product.edit', $product->product_id) }}" class="bg-blue-500 text-white py-1 px-4 rounded hover:bg-blue-600 transition duration-3">
                                        EDIT
                                    </a>
                                    <form action="{{ route('product.delete', $product->product_id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                                type="submit"
                                                title="DELETE"
                                                class="bg-red-500 text-white py-1 px-4 rounded hover:bg-red-600 transition duration-300"
                                                onclick="return confirm('Are you sure you want to delete this product?');">
                                                DELETE
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if (session('message'))
        <script>
            document.addEventListener('DOMContentLoaded', function(){
                showToast("{{ session('type') }}", "{{ session('message') }}");
            });
        </script>
    @endif
</x-app-layout>
