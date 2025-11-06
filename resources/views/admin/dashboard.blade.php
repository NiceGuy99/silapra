<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Permintaan Mutasi Pasien') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card stats-card bg-primary bg-gradient text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Total Permintaan</h5>
                        <p class="display-4">{{ $totalOrders }}</p>
                        <i class="fas fa-hospital-user position-absolute end-0 bottom-0 mb-3 me-3 opacity-50 fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-warning bg-gradient text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Menunggu</h5>
                        <p class="display-4">{{ $pendingOrders }}</p>
                        <i class="fas fa-clock position-absolute end-0 bottom-0 mb-3 me-3 opacity-50 fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-info bg-gradient text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Dalam Proses</h5>
                        <p class="display-4">{{ $processingOrders }}</p>
                        <i class="fas fa-spinner position-absolute end-0 bottom-0 mb-3 me-3 opacity-50 fa-2x"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card stats-card bg-success bg-gradient text-white h-100">
                    <div class="card-body">
                        <h5 class="card-title">Selesai</h5>
                        <p class="display-4">{{ $completedOrders }}</p>
                        <i class="fas fa-check-circle position-absolute end-0 bottom-0 mb-3 me-3 opacity-50 fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders List -->
        <div class="card custom-shadow">
            <div class="card-body">
                <h5 class="card-title mb-3">Daftar Semua Permintaan</h5>
                <div class="table-responsive">
                    <table id="ordersListTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>No. RM</th>
                                <th>Nama Pasien</th>
                                <th>Asal Ruangan</th>
                                <th>Tujuan Ruangan</th>
                                <th>User Request</th>
                                <th>Asal Ruangan User</th>
                                <th>Tgl Permintaan</th>
                                <th>Tgl Diterima</th>
                                <th>Tgl Selesai</th>
                                <th>Status</th>
                                <th class="actions-col text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($allOrders as $order)
                            <tr>
                                <td>{{ $order->nomor_rm }}</td>
                                <td>{{ $order->nama_pasien }}</td>
                                <td>{{ $order->asal_ruangan_mutasi }}</td>
                                <td>{{ $order->tujuan_ruangan_mutasi }}</td>
                                <td>{{ $order->user_request }}</td>
                                <td><small class="text-muted">{{ $order->asal_ruangan_user_request }}</small></td>
                                <td>{{ optional($order->tanggal_permintaan)->format('d/m/Y H:i') ?: '-' }}</td>
                                <td>{{ optional($order->tanggal_diterima)->format('d/m/Y H:i') ?: '-' }}</td>
                                <td>{{ optional($order->tanggal_selesai)->format('d/m/Y H:i') ?: '-' }}</td>
                                <td>
                                    <span class="badge rounded-pill text-bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : ($order->status === 'process' ? 'info' : 'danger')) }}">
                                        {{ $order->status === 'pending' ? 'Menunggu' : ($order->status === 'process' ? 'Dalam Proses' : ($order->status === 'completed' ? 'Selesai' : ucfirst($order->status))) }}
                                    </span>
                                </td>
                                <td class="actions-col align-middle text-center">
                                    <div class="btn-group" role="group">
                                        @if($order->status === 'pending')
                                        <!-- Accept Button -->
                                        <form action="{{ route('orders.accept', $order->id) }}" method="POST" class="d-inline accept-form">
                                            @csrf
                                            @method('PATCH')
                                            <button type="button" class="btn btn-sm btn-success accept-order" title="Terima Order">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                        </form>
                                        @endif
                                        
                                        <!-- Edit Button -->
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        
                                        <!-- Delete Button -->
                                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-order" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data permintaan mutasi pasien</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>

<!-- Edit Order Modals -->
@foreach($allOrders as $order)
    @include('partials.edit_order_modal', ['order' => $order, 'officers' => $officers])
@endforeach

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize DataTable for Orders List
        if (typeof $.fn.DataTable !== 'undefined') {
            $('#ordersListTable').DataTable({
                responsive: true,
                order: [[6, 'desc']], // Sort by tanggal permintaan
                pageLength: 25,
                language: {
                    search: "<i class='fas fa-search'></i> Cari:",
                    lengthMenu: "_MENU_ data per halaman",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(difilter dari _MAX_ total data)",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia",
                    paginate: {
                        first: "Pertama",
                        last: "Terakhir",
                        next: "Selanjutnya",
                        previous: "Sebelumnya"
                    }
                }
            });
        }

        // Accept order confirmation (pending -> process)
        document.querySelectorAll('.accept-order').forEach(function(button){
            button.addEventListener('click', function(e){
                e.preventDefault();
                const form = this.closest('.accept-form');
                Swal.fire({
                    title: 'Terima Order?',
                    text: "Order ini akan diproses!",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Terima!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Delete confirmation using SweetAlert2
        document.querySelectorAll('.delete-order').forEach(function(button){
            button.addEventListener('click', function(e){
                e.preventDefault();
                const form = this.closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Success notification
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                timer: 2500,
                showConfirmButton: false
            });
        @endif

        // Error notification
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: "{{ session('error') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush