<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Petugas') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-4 d-flex justify-content-between align-items-center">
                        <h3 class="text-lg font-semibold mb-0">Daftar Petugas</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createOfficerModal">
                            <i class="fas fa-plus me-2"></i> Tambah Petugas
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="card shadow-sm">
                        <div class="table-responsive p-3">
                            <table class="table table-hover align-middle mb-0" id="officersTable">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Petugas</th>
                                        <th>Status</th>
                                        <th>Dibuat</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($officers as $officer)
                                    <tr>
                                        <td>{{ $officer->id }}</td>
                                        <td>{{ $officer->name }}</td>
                                        <td>
                                            <span class="badge rounded-pill {{ $officer->is_active ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $officer->is_active ? 'Aktif' : 'Non-Aktif' }}
                                            </span>
                                        </td>
                                        <td>{{ $officer->created_at->format('d/m/Y H:i') }}</td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editOfficerModal{{ $officer->id }}" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('officers.toggle-status', $officer->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm {{ $officer->is_active ? 'btn-outline-warning' : 'btn-outline-success' }}" title="Toggle Status">
                                                        <i class="fas fa-{{ $officer->is_active ? 'ban' : 'check-circle' }}"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('officers.destroy', $officer->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-outline-danger delete-officer" title="Delete">
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

    <!-- Create Officer Modal -->
    <div class="modal fade" id="createOfficerModal" tabindex="-1" aria-labelledby="createOfficerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="createOfficerModalLabel">
                        <i class="fas fa-user-plus me-2"></i>Tambah Petugas Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('officers.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name" class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Masukkan nama petugas">
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Officer Modals -->
    @foreach($officers as $officer)
    <div class="modal fade" id="editOfficerModal{{ $officer->id }}" tabindex="-1" aria-labelledby="editOfficerModalLabel{{ $officer->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="editOfficerModalLabel{{ $officer->id }}">
                        <i class="fas fa-user-edit me-2"></i>Edit Petugas
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('officers.update', $officer->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name{{ $officer->id }}" class="form-label">Nama Petugas</label>
                            <input type="text" class="form-control" id="name{{ $officer->id }}" name="name" value="{{ $officer->name }}" required>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#officersTable').DataTable({
                responsive: true,
                order: [[0, 'asc']],
                pageLength: 10,
            });

            $('.delete-officer').click(function(e) {
                e.preventDefault();
                const form = $(this).closest('form');

                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Petugas ini akan dihapus permanen!",
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
    </script>
    @endpush
</x-admin-layout>
