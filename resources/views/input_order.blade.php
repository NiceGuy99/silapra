<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Orders Management') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <h3 class="text-lg font-semibold mb-0">Manage Orders</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOrderModal">
                            <i class="fas fa-plus me-2"></i> Create New Order
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Orders Table -->
                    <div class="card shadow-sm">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-middle mb-0" id="ordersTable">
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
                                        <th>Tgl Selesai</th>
                                        <th>Status</th>
                                        <th class="actions-col text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
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
                                        <td>{{ optional($order->tanggal_selesai)->format('d/m/Y H:i') ?: '-' }}</td>
                                        <td class="align-middle">
                                            <span class="badge rounded-pill text-bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'warning' : ($order->status === 'process' ? 'info' : 'danger')) }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                    <td class="actions-col align-middle text-center">
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $order->id }}" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
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
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Order Modal -->
<div class="modal fade" id="createOrderModal" tabindex="-1" aria-labelledby="createOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h5 class="modal-title" id="createOrderModalLabel">
                    <i class="fas fa-plus-circle me-2"></i>Buat Permintaan Mutasi Pasien
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_rm" class="form-label">Nomor RM</label>
                                <input type="text" class="form-control" id="nomor_rm" name="nomor_rm" 
                                    required placeholder="Masukkan nomor RM">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pasien" class="form-label">Nama Pasien</label>
                                <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" 
                                    required placeholder="Masukkan nama pasien">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="asal_ruangan_mutasi" class="form-label">Asal Ruangan Mutasi</label>
                                <select class="form-select" id="asal_ruangan_mutasi" name="asal_ruangan_mutasi" required>
                                    <option value="">Pilih Asal Ruangan</option>
                                    <option value="RANAP URANUS">RANAP URANUS</option>
                                    <option value="RANAP JUPITER">RANAP JUPITER</option>
                                    <option value="RANAP MARS">RANAP MARS</option>
                                    <option value="RANAP MERKURIUS">RANAP MERKURIUS</option>
                                    <option value="RANAP VENUS">RANAP VENUS</option>
                                    <option value="ISOLASI">ISOLASI</option>
                                    <option value="KAMAR OPERASI">KAMAR OPERASI</option>
                                    <option value="ICU">ICU</option>
                                    <option value="NICU">NICU</option>
                                    <option value="PICU">PICU</option>
                                    <option value="TRANSIT IGD">TRANSIT IGD</option>
                                    <option value="RADIOLOGI">RADIOLOGI</option>
                                    <option value="LABORATORIUM">LABORATORIUM</option>
                                    <option value="MNE">MNE</option>
                                    <option value="PERISTI">PERISTI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tujuan_ruangan_mutasi" class="form-label">Tujuan Ruangan Mutasi</label>
                                <select class="form-select" id="tujuan_ruangan_mutasi" name="tujuan_ruangan_mutasi" required>
                                    <option value="">Pilih Tujuan Ruangan</option>
                                    <option value="RANAP URANUS">RANAP URANUS</option>
                                    <option value="RANAP JUPITER">RANAP JUPITER</option>
                                    <option value="RANAP MARS">RANAP MARS</option>
                                    <option value="RANAP MERKURIUS">RANAP MERKURIUS</option>
                                    <option value="RANAP VENUS">RANAP VENUS</option>
                                    <option value="ISOLASI">ISOLASI</option>
                                    <option value="KAMAR OPERASI">KAMAR OPERASI</option>
                                    <option value="ICU">ICU</option>
                                    <option value="NICU">NICU</option>
                                    <option value="PICU">PICU</option>
                                    <option value="TRANSIT IGD">TRANSIT IGD</option>
                                    <option value="RADIOLOGI">RADIOLOGI</option>
                                    <option value="LABORATORIUM">LABORATORIUM</option>
                                    <option value="MNE">MNE</option>
                                    <option value="PERISTI">PERISTI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Pilih Petugas (Opsional)</label>
                                <div class="d-flex gap-3">
                                    @foreach($officers as $officer)
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="officer_id" id="officer{{ $officer->id }}" value="{{ $officer->id }}">
                                            <label class="form-check-label" for="officer{{ $officer->id }}">
                                                {{ $officer->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="officer_id" id="officerNone" value="" checked>
                                        <label class="form-check-label" for="officerNone">
                                            Tidak Ada
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Permintaan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#ordersTable').DataTable({
            responsive: true,
            order: [[0, 'desc']],
            pageLength: 10,
            language: {
                search: "<i class='fas fa-search'></i> Search:",
                lengthMenu: "_MENU_ orders per page",
            }
        });

        // Delete confirmation using SweetAlert2
        $('.delete-order').click(function(e) {
            e.preventDefault();
            const form = $(this).closest('form');
            
            Swal.fire({
                title: 'Are you sure?',
                text: "This order will be permanently deleted!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        // Auto format currency input
        $('#total_price').on('input', function() {
            let value = $(this).val();
            value = value.replace(/\D/g, "");
            $(this).val(value);
        });

        // Show success message with SweetAlert2
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: "{{ session('success') }}",
                timer: 3000,
                showConfirmButton: false
            });
        @endif
    });
</script>
@endpush

<!-- Edit Order Modals -->
@foreach($orders as $order)
    @include('partials.edit_order_modal', ['order' => $order])
@endforeach
</x-app-layout>