<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Holding;
use App\Models\Transaction;

class StockController extends Controller
{
    /**
     * Display a form to search for a stock.
     */
    public function showConsultaForm()
    {
        return view('stocks.consulta');
    }

    /**
     * Consult a stock price from brapi.dev API.
     */
    public function consultar(Request $request)
    {
        $symbol = strtoupper($request->input('symbol'));

        $brapi_api_url = "https://brapi.dev/api/quote/{$symbol}?modules=summaryProfile,financialData";

        try {
            $response = Http::get($brapi_api_url);

            if ($response->successful()) {
                $data = $response->json();
                
                // Validação robusta para verificar se os resultados existem e não estão vazios
                if (!isset($data['results']) || empty($data['results'])) {
                     return back()->with('error', 'Código de ação não encontrado ou inválido.');
                }

                $stock = $data['results'][0];

                return view('stocks.consulta', compact('stock'));
            } else {
                return back()->with('error', 'Não foi possível consultar a cotação da ação. Tente novamente mais tarde.');
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Ocorreu um erro ao conectar com a API. Verifique sua conexão e tente novamente.');
        }
    }

    /**
     * Display a form to buy stocks.
     */
    public function showCompraForm()
    {
        return view('stocks.comprar');
    }

    /**
     * Process the stock purchase.
     */
    public function comprar(Request $request)
    {
        $user = Auth::user();

        // 1. Validação da requisição
        $request->validate([
            'symbol' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $symbol = strtoupper($request->input('symbol'));
        $quantity = $request->input('quantity');

        // 2. Consulta do preço da ação na API brapi
        $brapi_api_url = "https://brapi.dev/api/quote/{$symbol}?modules=financialData";
        $response = Http::get($brapi_api_url);

        if (!$response->successful() || !isset($response->json()['results'][0])) {
            return back()->with('error', 'Código de ação não encontrado ou inválido.')->withInput();
        }

        $stockData = $response->json()['results'][0];
        $currentPrice = $stockData['regularMarketPrice'];
        $totalCost = $currentPrice * $quantity;

        // 3. Verifica o saldo do usuário
        $userWallet = $user->wallet;

        if ($userWallet->cash_balance < $totalCost) {
            return back()->with('error', 'Saldo insuficiente para realizar a compra.')->withInput();
        }

        // 4. Atualiza o saldo e o portfólio
        $userWallet->cash_balance -= $totalCost;
        $userWallet->save();

        $holding = $user->holdings()->firstOrCreate(
            ['stock_symbol' => $symbol],
            [
                'quantity' => 0,
                'purchase_price' => $currentPrice,
            ]
        );
        $holding->quantity += $quantity;
        $holding->save();
        

        // 5. Registra a transação
        $transaction = new Transaction([
            'stock_symbol' => $symbol,
            'quantity' => $quantity,
            'price' => $currentPrice,
            'user_id' => $user->id,
            'type' => 'buy',
        ]);
        $transaction->save();

        return back()->with('success', 'Ação comprada com sucesso!');
    }

    /**
     * Display the sell form with user's holdings.
     */
    public function showVendaForm()
    {
        $user = Auth::user();
        $holdings = $user->holdings;

        return view('stocks.vender', compact('holdings'));
    }

    /**
     * Process the stock sale.
     */
    public function vender(Request $request)
    {
        $user = Auth::user();

        // 1. Validação da requisição
        $request->validate([
            'holding_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $quantityToSell = $request->input('quantity');

        // 2. Encontra a posição da ação que o usuário quer vender
        $holding = $user->holdings()->find($request->input('holding_id'));

        // Validação: a posição de ações deve existir
        if (!$holding) {
            return back()->with('error', 'Ação não encontrada em sua carteira.')->withInput();
        }

        // Validação: a quantidade a vender não pode ser maior do que a que o usuário possui
        if ($holding->quantity < $quantityToSell) {
            return back()->with('error', 'Quantidade insuficiente para realizar a venda.')->withInput();
        }

        $symbol = $holding->stock_symbol;

        // 3. Consulta o preço da ação na API brapi
        $brapi_api_url = "https://brapi.dev/api/quote/{$symbol}?modules=financialData";
        $response = Http::get($brapi_api_url);

        if (!$response->successful() || !isset($response->json()['results'][0])) {
            return back()->with('error', 'Não foi possível obter a cotação atual da ação. Tente novamente mais tarde.');
        }

        $stockData = $response->json()['results'][0];
        $currentPrice = $stockData['regularMarketPrice'];
        $totalReceived = $currentPrice * $quantityToSell;

        // 4. Atualiza o saldo e o portfólio
        $userWallet = $user->wallet;
        $userWallet->cash_balance += $totalReceived;
        $userWallet->save();

        $holding->quantity -= $quantityToSell;
        // Se a quantidade de ações chegar a zero, remove a posição
        if ($holding->quantity <= 0) {
            $holding->delete();
        } else {
            $holding->save();
        }

        // 5. Registra a transação
        $transaction = new Transaction([
            'stock_symbol' => $symbol,
            'quantity' => $quantityToSell,
            'price' => $currentPrice,
            'user_id' => $user->id,
            'type' => 'sell',
        ]);
        $transaction->save();

        return back()->with('success', 'Ação vendida com sucesso!');
    }

    /**
     * Display the transaction history for the authenticated user.
     */
    public function showHistorico()
    {
        $user = Auth::user();
        $transactions = $user->transactions()->latest()->get();

        return view('stocks.historico', compact('transactions'));
    }
}