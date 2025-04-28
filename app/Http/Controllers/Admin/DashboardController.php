<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = Carbon::now()->startOfMonth();
        $previousMonth = Carbon::now()->subMonth();

        // Get statistics
        $totalProducts = Product::count();
        $newProductsCount = Product::where('created_at', '>=', $startOfMonth)->count();
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        // Calculate revenue
        $monthlyRevenue = Order::where('created_at', '>=', $startOfMonth)
            ->where('status', '!=', 'cancelled')
            ->sum('total');
            
        $lastMonthRevenue = Order::whereBetween('created_at', [$previousMonth->startOfMonth(), $previousMonth->endOfMonth()])
            ->where('status', '!=', 'cancelled')
            ->sum('total');
            
        $revenueChange = $lastMonthRevenue > 0 
            ? round((($monthlyRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100, 2)
            : 100;
            
        // Get recent orders
        $recentOrders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Get low stock products
        $lowStockProducts = Product::where('stock', '<', 10)
            ->orderBy('stock', 'asc')
            ->take(5)
            ->get();
            
        return view('admin.dashboard', compact(
            'totalProducts',
            'newProductsCount',
            'totalOrders',
            'pendingOrders',
            'monthlyRevenue',
            'revenueChange',
            'recentOrders',
            'lowStockProducts'
        ));
    }
}