@extends('admin.layouts.master')

@section('title')
    || Edit Category
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include('admin.layouts.sidebar')


            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i>Edit Category</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">

                              <form action="{{ route('admin.category.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                                      
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name" value="{{ $category->name }}">
                                    </div>
            
                                      <button type="submit" class="btn btn-primary mt-3">Update</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

