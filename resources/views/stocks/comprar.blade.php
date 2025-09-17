<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Comprar Ações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">


                    <form action="{{ route('stocks.comprar') }}" method="POST">
                        @csrf

                        <div class="flex items-end gap-x-4">

                            <div class="flex-grow">
                                <label for="symbol" class="block text-gray-700 text-sm font-bold mb-2">
                                    Símbolo da Ação (ex: PETR4)
                                </label>
                                <input type="text" name="symbol" id="symbol" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                            </div>


                            <div class="w-32">
                                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">
                                    Quantidade
                                </label>
                                <input type="number" name="quantity" id="quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1" required>
                            </div>


                            <div>
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Comprar
                                </button>
                            </div>

                        </div>
                    </form>

                    @if (session('success'))
                    <div class="mt-8 p-4 bg-green-100 rounded-lg text-green-700">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="mt-8 p-4 bg-red-100 rounded-lg text-red-700">
                        {{ session('error') }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>