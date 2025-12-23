@extends('admin.maindesign')
@section('page-title', 'View Categories')

@section('view_category')
<div class="container my-4">
    <div class="card shadow-sm p-3 mx-auto" style="max-width: 1100px;">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">All Categories</h4>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                Add Category
            </a>
        </div>

        {{-- Success message --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('success') }}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="table-responsive mt-3">
            <table class="table table-striped table-bordered align-middle text-center mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 60px;">No.</th>
                        <th class="text-start ps-3">Category Name</th>
                        <th style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $key => $cat)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td class="text-start ps-3">{{ $cat->category }}</td>
                            <td>
                                <a href="{{ route('admin.categories.delete', $cat->id) }}"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Are you sure you want to delete this category?');">
                                    <i class="bi bi-trash text-white"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
