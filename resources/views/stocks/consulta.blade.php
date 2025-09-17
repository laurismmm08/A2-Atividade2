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

                        <div class="flex items-end gap-x-4">
                            <div class="flex-grow relative">
                                <label for="symbol" class="block text-gray-700 text-sm font-bold mb-2">
                                    Símbolo da Ação (ex: PETR4, VALE3)
                                </label>
                                <input type="text" name="symbol" id="stock-search" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                
                                <div id="results" class="absolute w-full mt-1 bg-white border border-gray-300 rounded-md shadow-lg z-10 hidden">
                                    </div>
                            </div>
                            <div>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    Consultar
                                </button>
                            </div>
                        </div>
                    </form>

                    @if (isset($stock))
                    <div class="mt-8 p-4 bg-gray-100 rounded-lg">
                        <h3 class="text-lg font-bold mb-4">Cotação da Ação</h3>
                        <table class="w-full text-left">
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 pr-4 font-semibold text-gray-700">Símbolo</td>
                                    <td class="py-2 text-gray-900">{{ $stock['symbol'] }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 pr-4 font-semibold text-gray-700">Nome da Empresa</td>
                                    <td class="py-2 text-gray-900">{{ $stock['longName'] }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 pr-4 font-semibold text-gray-700">Preço Atual</td>
                                    <td class="py-2 text-gray-900">R$ {{ number_format($stock['regularMarketPrice'], 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="py-2 pr-4 font-semibold text-gray-700">Última Atualização</td>
                                    <td class="py-2 text-gray-900">{{ $stock['regularMarketTime'] }}</td>
                                </tr>
                            </tbody>
                        </table>
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.getElementById('stock-search');
            const resultsDiv = document.getElementById('results');

            searchInput.addEventListener('input', function () {
                const query = this.value;

                if (query.length > 1) { // Só busca se tiver mais de 1 caractere
                    fetch(`/api/search-stocks?query=${query}`)
                        .then(response => response.json())
                        .then(data => {
                            resultsDiv.innerHTML = '';
                            if (data.length > 0) {
                                resultsDiv.classList.remove('hidden');
                                data.forEach(stock => {
                                    const resultItem = document.createElement('div');
                                    resultItem.textContent = stock;
                                    resultItem.classList.add('p-2', 'hover:bg-gray-200', 'cursor-pointer');
                                    resultItem.addEventListener('click', function() {
                                        searchInput.value = stock;
                                        resultsDiv.classList.add('hidden');
                                    });
                                    resultsDiv.appendChild(resultItem);
                                });
                            } else {
                                resultsDiv.classList.add('hidden');
                            }
                        })
                        .catch(error => console.error('Erro na busca:', error));
                } else {
                    resultsDiv.classList.add('hidden');
                }
            });

            document.addEventListener('click', function(event) {
                if (!resultsDiv.contains(event.target) && event.target !== searchInput) {
                    resultsDiv.classList.add('hidden');
                }
            });
        });
    </script>
</x-app-layout>