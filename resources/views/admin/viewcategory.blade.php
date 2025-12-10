@extends('admin.maindesign')
@section('page-title', 'View Categories')

@section('view_category')
<div class="card shadow-sm p-4">
    <h4 class="mb-3">All Categories</h4>
 {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="table-responsive mt-3 pe-5">
        <table class="table table-striped table-bordered align-middle text-center">
            <thead class="table-dark">
                <tr>
                    <th style="width: 70px;">ID</th>
                    <th>Category Name</th>
                    <th style="width: 180px;">Actions</th>
                </tr>
            </thead>

            <tbody>

                @foreach ($categories as $cat)
                    <tr>
                        <td class="fw-bold">{{ $cat->id }}</td>
                        <td class="text-start ps-3">{{ $cat->category }}</td>

                        <td>
                            <a href="{{ route('admin.updatecategory', $cat->id) }}" class="btn btn-sm btn-primary px-3 me-1">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="{{ route('admin.deletecategory', $cat->id) }}"
                            class="btn btn-sm btn-danger px-3"
                            onclick="return confirm('Are you sure you want to delete this category?');">
                                <i class="bi bi-trash text-white"></i>
                            </a>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

</div>
@endsection
