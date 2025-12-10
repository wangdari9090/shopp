@extends('admin.maindesign')
{{-- @section('page-title', 'Add Category') --}}

@section('dashboard')
     <div class="row mb-4 justify-content-center" style="max-width: 1200px; margin: auto;">
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-center shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <h4 class="mb-1">120</h4>
                <p class="text-muted small mb-0">Total Posts</p>
            </div>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-center shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <h4 class="mb-1">200</h4>
                <p class="text-muted small mb-0">Total Posts</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-center shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <h4 class="mb-1">8</h4>
                <p class="text-muted small mb-0">Categories</p>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 mb-3">
        <div class="card text-center shadow-sm" style="border-radius: 10px;">
            <div class="card-body p-3">
                <h4 class="mb-1">340</h4>
                <p class="text-muted small mb-0">Users</p>
            </div>
        </div>
    </div>
</div>


<div class="card shadow-sm" style="max-width: 1200px; margin: auto;">
    <div class="card-header text-white" style="background:#2C3E50;">
        Recent Posts
    </div>
    <div class="card-body p-0">
        <table class="table mb-0">
            <thead class="table-light">
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Date</th>
                    <th style="width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>How to Stay Healthy in the Digital Age</td>
                    <td>Health</td>
                    <td>2025-01-20</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>

                <tr>
                    <td>Top 10 Superfoods</td>
                    <td>Health</td>
                    <td>2025-01-18</td>
                    <td>
                        <button class="btn btn-sm btn-primary">Edit</button>
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection
