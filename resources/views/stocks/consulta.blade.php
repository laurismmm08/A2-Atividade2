<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Consulta de Ações') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('stocks.consultar') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="symbol" class="block text-gray-700 text-sm font-bold mb-2">
                                Símbolo da Ação (ex: PETR4)
                            </label>
                            <input type="text" name="symbol" id="symbol" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            Consultar
                        </button>
                    </form>

                    @if (isset($stock))
                        <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                            <h3 class="text-lg font-bold">Cotação da Ação</h3>
                            <p class="mt-2">
                                **Símbolo:** {{ $stock['symbol'] }}
                            </p>
                            <p>
                                **Nome da Empresa:** {{ $stock['longName'] }}
                            </p>
                            <p>
                                **Preço Atual:** R$ {{ number_format($stock['regularMarketPrice'], 2, ',', '.') }}
                            </p>
                            <p>
                                **Última Atualização:** {{ $stock['regularMarketTime'] }}
                            </p>
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