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
        // Fetch orders (you can add filters based on $request->query() or $request->all())
        $orders = Order::with(['user', 'items.product'])->get();

        // Generate CSV content
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