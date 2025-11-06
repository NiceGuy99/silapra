<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Officer;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'process')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        $recentOrders = Order::with('officer')->latest()->take(10)->get();
        $allOrders = Order::with('officer')->latest()->get();
        $officers = Officer::where('is_active', true)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'processingOrders',
            'completedOrders',
            'recentOrders',
            'allOrders',
            'officers'
        ));
    }

    public function completedOrders()
    {
        $completedOrders = Order::with('officer')
            ->where('status', 'completed')
            ->orderBy('tanggal_selesai', 'desc')
            ->get();
        $officers = Officer::where('is_active', true)->get();

        return view('admin.completed_orders', compact('completedOrders', 'officers'));
    }

    public function acceptedOrders()
    {
        $acceptedOrders = Order::with('officer')
            ->where('status', 'process')
            ->orderBy('tanggal_diterima', 'desc')
            ->get();
        $officers = Officer::where('is_active', true)->get();

        return view('admin.accepted_orders', compact('acceptedOrders', 'officers'));
    }
}