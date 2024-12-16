@extends('admin.layouts.master')

@section('title')
    || My Documents
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include('admin.layouts.sidebar')


            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">

                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i>Category</h3>
                        <div class="create-button">
                            <a href="{{ route('admin.category.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>
                                Create Category</a>
                        </div>
                        <div class="wsus__dashboard_profile">




                            <div class="wsus__dash_pro_area mb-3">

                                <div class="container my-4">

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>

                                                    <th>#</th>
                                                    <th>Category Name</th>
                                                    <th>Created At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Static Category Data -->
                                                @foreach ($categories as $index => $category)
                                                    <tr>

                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $category->name }}</td>
                                                        <td>{{ $category->created_at->format('M d, Y h:i A') }}</td>
                                                        <td>
                                                            <a href="{{ route('admin.category.edit', $category->id) }}"
                                                                class="btn btn-warning btn-sm">Edit</a>
                                                            <a href="{{ route('admin.category.destroy', $category->id) }}"
                                                                class="delete-item btn btn-danger btn-sm">Delete</a>
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
        </div>
    </section>
@endsection
