@extends('admin.maindesign')
@section('page-title', 'Update Category')

@section('update_category')

<div class="card shadow-sm p-4">

     {{-- Display errors --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Success message --}}
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert"><strong>{{ session('success') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif


    {{-- Update Form --}}
    <form action="{{ route('admin.postupdatecategory', $category->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="category_name" class="form-label">Category Name</label>
            <input type="text"
                   name="category"
                   class="form-control"
                   value="{{ $category->category }}"
                   id="category"
                   required>
        </div>

        <button type="submit" class="btn btn-success px-4">Update</button>
        <a href="{{ route('admin.viewcategory') }}" class="btn btn-secondary px-4">Back</a>
    </form>

</div>

@endsection
