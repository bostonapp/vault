@extends('user.layouts.master')

@section('title')
    || Create Category
@endsection

@section('content')
    <section id="wsus__dashboard">
        <div class="container-fluid">

            @include('user.layouts.sidebar')


            <div class="row">
                <div class="col-xl-9 col-xxl-10 col-lg-9 ms-auto">
                    <div class="dashboard_content mt-2 mt-md-0">
                        <h3><i class="far fa-user"></i>Create Category</h3>
                        <div class="wsus__dashboard_profile">
                            <div class="wsus__dash_pro_area">

                              <form action="{{route('user.category.store')}}" method="POST">
                                @csrf
                                                      
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" class="form-control" name="name">
                                    </div>
            
                                      <button type="submit" class="btn btn-primary mt-3">Create</button>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

