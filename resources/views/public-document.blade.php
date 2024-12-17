@extends('layouts.app')

@section('content')

<div class="container">

    <div class="col-md-12 text-center py-5 bg-info text-light">
        <h2>Stay Organized, Stay Productive With Vault</h2>
        <h4>Manage your data efficiently and achieve your goals effortlessly.</h4>
    </div>
    <!-- Search Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form class="row g-3 align-items-center" action="{{ route('public.document') }}" method="GET">

                        <!-- Search Input and Button -->
                        <div class="col-md-3 col-sm-6 d-flex align-items-center">
                            <input type="text" class="form-control me-2" placeholder="Search Here" name="search"
                                value="{{ $search }}">
                            <button type="submit" class="btn btn-info text-light">Search</button>
                        </div>

                        <!-- Category Dropdown and Button -->
                        <div class="col-md-3 col-sm-6 d-flex align-items-center">
                            <select name="category_id" id="category-select" class="form-control">
                                <option disabled value="" {{ empty($categorysearch) ? 'selected' : '' }}>
                                    Select Category</option>
                                @foreach ($categories as $category)
                                    <option {{ $category == $categorysearch ? 'selected' : '' }}
                                        value="{{ $category->id }}">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-info ms-2 text-light">Filter</button>
                        </div>

                        <div class="col-md-3 col-sm-6 d-flex align-items-center">
                            <select name="user" id="user-select" class="form-control">
                                <option disabled value="" {{ empty($usersearch) ? 'selected' : '' }}>Select Author</option>
                                @foreach ($SearchByuser as $user)
                                    <option {{ $user->id == $usersearch ? 'selected' : '' }} value="{{ $user->id }}">
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn btn-info ms-2 text-light">Filter</button>

                        </div>


                        <!-- Authentication Links -->
                        <div class="col-md-3 col-sm-12 text-end">
                            @auth
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="btn btn-success btn-login text-light">Dashboard</a>
                                @else
                                    <a href="{{ route('user.dashboard') }}"
                                        class="btn btn-success btn-login text-light">Dashboard</a>
                                @endif
                            @endauth

                            @guest
                                <a href="{{ route('login') }}" class="btn btn-success text-light me-2">Login</a>
                                <a href="{{ route('register') }}" class="btn btn-primary text-light">Register</a>
                            @endguest
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="col-md-2">
                @if ($search || $categorysearch || $usersearch)
                    <a href="{{ route('public.document') }}" class="btn btn-danger mb-2">Reset Filter</a>
                @endif



            </div>


            @if (count($alldocuments) > 0)



                @foreach ($alldocuments as $item)
                    <a href="{{ route('public.document.detail', $item->id) }}" class="text-primary mt-3">
                        <div class="card mb-3 shadow-sm">

                            <div class="card-body">
                                <!-- Header Section -->
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="card-title mb-0">{{ $item->user->name }}</h5>
                                    @if ($item->status === 'private')
                                        <span class="badge bg-success text-uppercase">{{ $item->status }}</span>
                                    @else
                                        <span class="badge bg-info text-uppercase">{{ $item->status }}</span>
                                    @endif
                                </div>
                                <small class="text-muted">{{ $item->created_at->format('M d, Y h:i A') }}</small> -
                                <small class="text-muted">{{ $item->created_at->diffForHumans() }}</small> <br>
                            
                                <!-- Category and Source -->
                                <div class="mt-2">
                                    <span class="badge bg-info text-uppercase">{{ $item->category->name }}</span>
                                    <br>
                                    <span class="badge bg-info text-uppercase">{{ $item->source }}</span>
                                </div>

                                <!-- Description -->
                                <p class="card-text mt-3 description">
                                    {!! \Illuminate\Support\Str::limit($item->description, 1000) !!}
                                </p>

                                <a href="{{ route('public.document.detail', $item->id) }}"
                                    class="text-primary mt-3">See more...</a>


                            </div>


                        </div>
                    </a>
                @endforeach
            @else
                <div class="col-md-12 text-center mt-5">
                    <h2>No Data Found</h2>
                </div>
            @endif

            {{ $alldocuments->appends($_GET)->links() }}

        </div>
    </div>
</div>

@endsection
