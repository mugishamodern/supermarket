<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReportController extends Controller
{
    public function export(Request $request)
    {
        $reportType = $request->input('report_type', 'sales');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        switch ($reportType) {
            case 'products':
                // Product Performance Report
                $query = \App\Models\OrderItem::with('product')
                    ->whereHas('order', function ($q) use ($startDate, $endDate) {
                        if ($startDate) {
                            $q->whereDate('created_at', '>=', $startDate);
                        }
                        if ($endDate) {
                            $q->whereDate('created_at', '<=', $endDate);
                        }
                        $q->where('status', '!=', 'cancelled');
                    });
                $items = $query->get();

                // Aggregate by product
                $performance = [];
                foreach ($items as $item) {
                    $pid = $item->product_id;
                    if (!isset($performance[$pid])) {
                        $performance[$pid] = [
                            'name' => $item->product->name ?? 'Unknown',
                            'total_sold' => 0,
                            'total_revenue' => 0,
                        ];
                    }
                    $performance[$pid]['total_sold'] += $item->quantity;
                    $performance[$pid]['total_revenue'] += $item->price * $item->quantity;
                }

                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="product_performance_' . date('Y-m-d_H-i-s') . '.csv"',
                ];

                $callback = function () use ($performance) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, ['Product Name', 'Total Sold', 'Total Revenue']);
                    foreach ($performance as $row) {
                        fputcsv($file, [
                            $row['name'],
                            $row['total_sold'],
                            number_format($row['total_revenue'], 2),
                        ]);
                    }
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);

            case 'inventory':
                // Inventory Status Report
                $products = \App\Models\Product::all();
                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="inventory_status_' . date('Y-m-d_H-i-s') . '.csv"',
                ];
                $callback = function () use ($products) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, ['Product Name', 'Stock Quantity', 'Status']);
                    foreach ($products as $product) {
                        fputcsv($file, [
                            $product->name,
                            $product->stock_quantity,
                            $product->status ?? 'active',
                        ]);
                    }
                    fclose($file);
                };
                return Response::stream($callback, 200, $headers);

            case 'sales':
            default:
                $query = Order::with(['user', 'items.product']);
                if ($startDate) {
                    $query->whereDate('created_at', '>=', $startDate);
                }
                if ($endDate) {
                    $query->whereDate('created_at', '<=', $endDate);
                }
                $orders = $query->get();

                $headers = [
                    'Content-Type' => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="sales_report_' . date('Y-m-d_H-i-s') . '.csv"',
                ];

                $callback = function () use ($orders) {
                    $file = fopen('php://output', 'w');
                    // CSV headers
                    fputcsv($file, ['Order ID', 'Customer', 'Total', 'Status', 'Date']);

                    // CSV rows
                    foreach ($orders as $order) {
                        fputcsv($file, [
                            $order->id,
                            $order->user->name,
                            number_format($order->total_amount, 2),
                            ucfirst($order->status),
                            $order->created_at->format('Y-m-d H:i:s'),
                        ]);
                    }

                    fclose($file);
                };

                return Response::stream($callback, 200, $headers);
        }
    }
}