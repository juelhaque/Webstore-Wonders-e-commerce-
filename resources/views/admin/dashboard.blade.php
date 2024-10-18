@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            @include('admin.message')
            <div class="row mb-2">
                <div class="col-sm-12 text-center">
                    <h1><strong>Webstrore Wonders</strong></h1>
                    <h5><strong>Administrative Panel</strong></h5>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4 col-6 text-center">
                    <div class="small-box card">
                        <div class="inner">
                            <h4><b>Total Orders</b></h4>
                            <h3>{{$orders}}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{route('orders.index')}}" style="background: #8eabce" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <div class="small-box card">
                        <div class="inner">
                            <h4><b>Total Users</b></h4>
                            <h3>{{$customers}}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="#" style="background: #8eabce" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <div class="small-box card">
                        <div class="inner">
                            <h4><b>Total Products</b></h4>
                            <h3>{{$products}}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('products.index')}}" style="background: #8eabce" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <div class="small-box card">
                        <div class="inner">
                            <h4><b>Total Category</b></h4>
                            <h3>{{$categories}}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('categories.index')}}" style="background: #8eabce" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <div class="small-box card">
                        <div class="inner">
                            <h4><b>Total Sub Category</b></h4>
                            <h3>{{$subCategories}}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('sub-categories.index')}}" style="background: #8eabce" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-4 col-6 text-center">
                    <div class="small-box card">
                        <div class="inner">
                            <h4><b>Total Brands</b></h4>
                            <h3>{{$brands}}</h3>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('brands.index')}}" style="background: #8eabce" class="small-box-footer text-dark">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>
        </div>
        <!-- /.card -->
    </section>
    <!-- /.content -->
@endsection

@section('customjs')
    <script>
        console.log('hello');
    </script>
@endsection
