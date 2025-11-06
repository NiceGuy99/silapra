<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
$totalOrders = Order::count();
    $pendingOrders = Order::where('status', 'pending')->count();
    $processingOrders = Order::where('status', 'process')->count();
    $completedOrders = Order::where('status', 'completed')->count();

    $recentOrders = Order::latest()->take(10)->get();
    $allOrders = Order::latest()->get(); // Tambahkan ini

        return view('admin.dashboard', compact(
        'totalOrders',
        'pendingOrders',
        'processingOrders',
        'completedOrders',
        'recentOrders',
        'allOrders'
    ));
    }

    public function acceptedRequests()
    {
        $acceptedOrders = Order::where('status', 'process')
            ->latest('tanggal_diterima')
            ->get();

        return view('admin.accepted_requests', compact('acceptedOrders'));
    }
}