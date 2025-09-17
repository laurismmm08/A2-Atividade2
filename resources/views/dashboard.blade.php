<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 flex justify-center">
        <div class="max-w-2xl w-full sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="bg-indigo-100 border-l-4 border-indigo-500 text-indigo-700 p-8 rounded mb-6 text-center">
                    <p class="font-bold text-2xl mb-2">Você já está logado!</p>
                    <p class="text-lg">
                    Aproveite para consultar, comprar ou vender suas ações. 
                    Com a <span class="font-semibold">Finance APP</span>, suas transações são seguras.
                    </p>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
