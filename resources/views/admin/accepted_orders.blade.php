<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Permintaan Diterima') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Semua Permintaan yang Diterima (Sedang Diproses)</h3>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-middle mb-0" id="acceptedOrdersTable">
                                <thead>
                                    <tr>
                                        <th>No. RM</th>
                                        <th>Nama Pasien</th>
                                        <th>Asal Ruangan</th>
                                        <th>Tujuan Ruangan</th>
                                        <th>User Request</th>
                                        <th>Asal Ruangan User</th>
                                        <th>Petugas</th>
                                        <th>Tgl Permintaan</th>
                                        <th>Tgl Diterima</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($acceptedOrders as $order)
                                    <tr>
                                        <td>{{ $order->nomor_rm }}</td>
                                        <td>{{ $order->nama_pasien }}</td>
                                        <td>{{ $order->asal_ruangan_mutasi }}</td>
                                        <td>{{ $order->tujuan_ruangan_mutasi }}</td>
                                        <td>{{ $order->user_request }}</td>
                                        <td>{{ $order->asal_ruangan_user_request }}</td>
                                        <td>{{ $order->officer ? $order->officer->name : '-' }}</td>
                                        <td>{{ optional($order->tanggal_permintaan)->format('d/m/Y H:i') ?: '-' }}</td>
                                        <td>{{ optional($order->tanggal_diterima)->format('d/m/Y H:i') ?: '-' }}</td>
                                        <td>
                                            <span class="badge rounded-pill bg-info">
                                                Process
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Order Modals -->
    @foreach($acceptedOrders as $order)
        @include('partials.edit_order_modal', ['order' => $order])
    @endforeach

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#acceptedOrdersTable').DataTable({
                responsive: true,
                order: [[8, 'desc']], // Sort by received date
                pageLength: 10,
            });
        });
    </script>
    @endpush
</x-admin-layout>
