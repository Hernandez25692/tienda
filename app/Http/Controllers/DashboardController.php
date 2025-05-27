<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            $totalPedidos = Pedido::count();
            $pendientes = Pedido::where('estado', 'pendiente')->count();
            $entregados = Pedido::where('estado', 'entregado')->count();
            $totalIngresos = Pedido::sum('total');

            $clientesHoy = User::count();
            $pedidosHoy = Pedido::whereDate('created_at', today())->count();

            // Calcular días entre primer y último pedido
            $dias = Pedido::selectRaw('DATEDIFF(MAX(created_at), MIN(created_at)) as dias')->value('dias') ?? 1;
            $promedioPedidosDiarios = round($totalPedidos / max($dias, 1));

            // Ingresos últimos 6 meses
            $ingresosMensuales = Pedido::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as mes'),
                DB::raw('SUM(total) as total')
            )
                ->groupBy('mes')
                ->orderBy('mes', 'desc')
                ->limit(6)
                ->get()
                ->reverse();

            // Producto más vendido (respetando ONLY_FULL_GROUP_BY)
            $productoTopData = DB::table('pedido_producto')
                ->select('productos.id', DB::raw('SUM(pedido_producto.cantidad) as total_vendidos'))
                ->join('productos', 'productos.id', '=', 'pedido_producto.producto_id')
                ->groupBy('productos.id')
                ->orderByDesc('total_vendidos')
                ->first();

            $productoTop = null;
            if ($productoTopData) {
                $productoTop = Producto::with('imagenes')->find($productoTopData->id);
                $productoTop->total_vendidos = $productoTopData->total_vendidos;
            }

            $ultimosPedidos = Pedido::latest()->take(5)->get();

            return view('dashboard', compact(
                'totalPedidos',
                'pendientes',
                'entregados',
                'totalIngresos',
                'clientesHoy',
                'pedidosHoy',
                'promedioPedidosDiarios',
                'ingresosMensuales',
                'productoTop',
                'ultimosPedidos'
            ));
        }

        // CLIENTE
        $misPedidos = Pedido::where('user_id', $user->id)->latest()->take(5)->get();
        $sugerencias = Producto::where('visible', true)
            ->where('disponible', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('dashboard', compact('misPedidos', 'sugerencias'));
    }
}
