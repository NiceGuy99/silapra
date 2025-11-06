<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')->get();
        return view('input_order', compact('orders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_rm' => 'required',
            'nama_pasien' => 'required',
            'asal_ruangan_mutasi' => 'required',
            'tujuan_ruangan_mutasi' => 'required',
            'user_request' => 'required',
            'asal_ruangan_user_request' => 'required'
        ]);

        $data = $request->all();
        $data['tanggal_permintaan'] = now();
        $data['status'] = 'pending';

        Order::create($data);
        return redirect()->route('orders.index')->with('success', 'Permintaan mutasi pasien berhasil dibuat.');
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'nomor_rm' => 'required',
            'nama_pasien' => 'required',
            'asal_ruangan_mutasi' => 'required',
            'tujuan_ruangan_mutasi' => 'required',
            'user_request' => 'required',
            'asal_ruangan_user_request' => 'required',
            'status' => 'required|in:pending,process,completed,cancelled'
        ]);

        $data = $request->all();
        
        // Update timestamps based on status changes
        if ($request->status === 'process' && is_null($order->tanggal_diterima)) {
            $data['tanggal_diterima'] = now();
        } elseif ($request->status === 'completed' && is_null($order->tanggal_selesai)) {
            $data['tanggal_selesai'] = now();
        }

        $order->update($data);
        return back()->with('success', 'Data mutasi pasien berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return back()->with('success', 'Data mutasi pasien berhasil dihapus.');
    }

    public function accept(Order $order)
    {
        // Validasi bahwa order dalam status pending
        if ($order->status !== 'pending') {
            return back()->with('error', 'Order tidak dapat diterima. Status harus "Menunggu".');
        }

        // Update status menjadi process dan set tanggal diterima
        $order->update([
            'status' => 'process',
            'tanggal_diterima' => now()
        ]);

        return back()->with('success', 'Order berhasil diterima dan sedang diproses!');
    }
}