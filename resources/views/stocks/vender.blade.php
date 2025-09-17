<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Vender Ações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">                    

                    @if ($holdings->isEmpty())
                    <p>Você não possui nenhuma ação para vender.</p>
                    @else

                    <form action="{{ route('stocks.vender') }}" method="POST">
                        @csrf


                        <div class="flex items-end gap-x-4">


                            <div class="flex-grow">
                                <label for="holding_id" class="block text-gray-700 text-sm font-bold mb-2">
                                    Selecione a Ação
                                </label>
                                <select name="holding_id" id="holding_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="">-- Escolha uma Ação --</option>
                                    @foreach ($holdings as $holding)
                                    <option value="{{ $holding->id }}">{{ $holding->stock_symbol }} ({{ $holding->quantity }} ações)</option>
                                    @endforeach
                                </select>
                            </div>


                            <div class="w-40">
                                <label for="quantity" class="block text-gray-700 text-sm font-bold mb-2">
                                    Quantidade a Vender
                                </label>
                                <input type="number" name="quantity" id="quantity" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" min="1" required>
                            </div>


                            <div>
                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Vender
                                </button>
                            </div>

                        </div>
                    </form>
                    @endif

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