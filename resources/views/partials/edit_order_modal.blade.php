@php
    /**
     * Partial: Edit Order Modal
     * Expects: $order (Order model instance)
     */
@endphp

<div class="modal fade" id="editOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="editOrderModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOrderModalLabel{{ $order->id }}">Edit Order #{{ $order->id }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('orders.update', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nomor_rm{{ $order->id }}" class="form-label">Nomor RM</label>
                                <input type="text" class="form-control" id="nomor_rm{{ $order->id }}" name="nomor_rm" value="{{ $order->nomor_rm }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="nama_pasien{{ $order->id }}" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien{{ $order->id }}" name="nama_pasien" value="{{ $order->nama_pasien }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="asal_ruangan_mutasi{{ $order->id }}" class="form-label">Asal Ruangan Mutasi</label>
                            <input type="text" class="form-control" id="asal_ruangan_mutasi{{ $order->id }}" name="asal_ruangan_mutasi" value="{{ $order->asal_ruangan_mutasi }}" required>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tujuan_ruangan_mutasi{{ $order->id }}" class="form-label">Tujuan Ruangan Mutasi</label>
                                <select class="form-select" id="tujuan_ruangan_mutasi{{ $order->id }}" name="tujuan_ruangan_mutasi" required>
                                    <option value="">Pilih Tujuan Ruangan</option>
                                    <option value="RANAP URANUS" {{ $order->tujuan_ruangan_mutasi == 'RANAP URANUS' ? 'selected' : '' }}>RANAP URANUS</option>
                                    <option value="RANAP JUPITER" {{ $order->tujuan_ruangan_mutasi == 'RANAP JUPITER' ? 'selected' : '' }}>RANAP JUPITER</option>
                                    <option value="RANAP MARS" {{ $order->tujuan_ruangan_mutasi == 'RANAP MARS' ? 'selected' : '' }}>RANAP MARS</option>
                                    <option value="RANAP MERKURIUS" {{ $order->tujuan_ruangan_mutasi == 'RANAP MERKURIUS' ? 'selected' : '' }}>RANAP MERKURIUS</option>
                                    <option value="RANAP VENUS" {{ $order->tujuan_ruangan_mutasi == 'RANAP VENUS' ? 'selected' : '' }}>RANAP VENUS</option>
                                    <option value="ISOLASI" {{ $order->tujuan_ruangan_mutasi == 'ISOLASI' ? 'selected' : '' }}>ISOLASI</option>
                                    <option value="KAMAR OPERASI" {{ $order->tujuan_ruangan_mutasi == 'KAMAR OPERASI' ? 'selected' : '' }}>KAMAR OPERASI</option>
                                    <option value="ICU" {{ $order->tujuan_ruangan_mutasi == 'ICU' ? 'selected' : '' }}>ICU</option>
                                    <option value="NICU" {{ $order->tujuan_ruangan_mutasi == 'NICU' ? 'selected' : '' }}>NICU</option>
                                    <option value="PICU" {{ $order->tujuan_ruangan_mutasi == 'PICU' ? 'selected' : '' }}>PICU</option>
                                    <option value="TRANSIT IGD" {{ $order->tujuan_ruangan_mutasi == 'TRANSIT IGD' ? 'selected' : '' }}>TRANSIT IGD</option>
                                    <option value="RADIOLOGI" {{ $order->tujuan_ruangan_mutasi == 'RADIOLOGI' ? 'selected' : '' }}>RADIOLOGI</option>
                                    <option value="LABORATORIUM" {{ $order->tujuan_ruangan_mutasi == 'LABORATORIUM' ? 'selected' : '' }}>LABORATORIUM</option>
                                    <option value="MNE" {{ $order->tujuan_ruangan_mutasi == 'MNE' ? 'selected' : '' }}>MNE</option>
                                    <option value="PERISTI" {{ $order->tujuan_ruangan_mutasi == 'PERISTI' ? 'selected' : '' }}>PERISTI</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="user_request{{ $order->id }}" class="form-label">User Request</label>
                            <input type="text" class="form-control" id="user_request{{ $order->id }}" name="user_request" value="{{ $order->user_request }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="asal_ruangan_user_request{{ $order->id }}" class="form-label">Asal Ruangan User</label>
                            <input type="text" class="form-control" id="asal_ruangan_user_request{{ $order->id }}" name="asal_ruangan_user_request" value="{{ $order->asal_ruangan_user_request }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="status{{ $order->id }}" class="form-label">Status</label>
                            <select class="form-control" id="status{{ $order->id }}" name="status" required>
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="process" {{ $order->status == 'process' ? 'selected' : '' }}>Process</option>
                                <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
