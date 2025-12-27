@extends('layouts.admin_main')
@section('page-title', 'View Categories')

@section('content')
<div class="container-fluid py-4">
    <div class="card border-0 shadow-sm mx-auto" style="max-width: 1100px;">
        
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom-0">
            <h5 class="mb-0 fw-bold" style="color: var(--forest);">All Categories</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-gold px-4">
                <i class="bi bi-plus-lg me-1"></i> Add Category
            </a>
        </div>

        <div class="card-body">
            {{-- Success message --}}
            @if (session('success'))
                <div class="alert alert-success border-0 small shadow-sm alert-dismissible fade show" role="alert" id="auto-close-alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close" style="font-size: 0.6rem;"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr style="font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px;">
                            <th class="ps-4" style="width: 80px;">No.</th>
                            <th>Category Name</th>
                            <th class="text-end pe-4" style="width: 150px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $key => $cat)
                            <tr>
                                <td class="ps-4 fw-bold text-muted">{{ $key + 1 }}</td>
                                <td class="fw-medium" style="color: var(--forest);">{{ $cat->category }}</td>
                                <td class="text-end pe-4">
                                    <div class="d-flex justify-content-end gap-2">
                                        {{-- Delete Button (Using Form for safety) --}}
                                        <form action="{{ route('admin.categories.delete', $cat->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                    onclick="return confirm('Are you sure you want to delete this category?');">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-5 text-muted">
                                    <i class="bi bi-folder-x fs-1 d-block mb-2"></i>
                                    No categories found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection