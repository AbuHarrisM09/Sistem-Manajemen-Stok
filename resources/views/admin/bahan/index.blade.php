@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>📦 Data Bahan</h2>
        <a href="{{ route('admin.bahan.create') }}" class="btn btn-primary">+ Tambah Bahan</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nama Bahan</th>
                    <th>Satuan</th>
                    <th>Stok Minimum</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bahans as $bahan)
                <tr>
                    <td>{{ $bahan->nama_bahan }}</td>
                    <td>{{ $bahan->satuan }}</td>
                    <td>{{ $bahan->stok_minimum }}</td>
                    <td>
                        <a href="{{ route('admin.bahan.edit', $bahan) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.bahan.destroy', $bahan) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin hapus {{ $bahan->nama_bahan }}?')">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Belum ada data bahan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection