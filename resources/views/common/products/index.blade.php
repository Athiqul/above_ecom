@extends('layouts.backend_master')
@section('title')
   Products| Above Ecommerce
@endsection
@section('need-css')
    <link href="{{ asset('backend/assets/plugins/datatable/css/dataTables.bootstrap5.min.css') }}" rel="stylesheet">
    <link href="
    https://cdn.jsdelivr.net/npm/sweetalert2@11.10.0/dist/sweetalert2.min.css
    " rel="stylesheet">
@endsection
@section('main')

        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Products</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{Auth::user()->role=='admin'? route('admin.dashboard'):route('vendor.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">All Product <span class="badge rounded-pill bg-danger">{{ count($products) }}</span></li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="d-flex justify-content-between">
            <h6 class="mb-0 text-uppercase ">Products List</h6>
            <a href="{{Auth::user()->role=='admin'? route('product.add'):route('vendor.product.add') }}" class="btn btn-primary ">Add Product</a>
        </div>

        <hr>
        <div class="card">
            <div class="card-body">
                @include('assets.alert')
                <div class="table-responsive">
                    <div id="example_wrapper" class="dataTables_wrapper dt-bootstrap5">

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="example" class="table table-striped table-bordered dataTable"
                                    style="width: 100%;" role="grid" aria-describedby="example_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending" style="width: 106px;">
                                                SL.</th>
                                            <th class="sorting_asc" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-sort="ascending"
                                                aria-label="Name: activate to sort column descending" style="width: 106px;">
                                                Product Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 170px;">Image</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 73px;">Selling Price</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                                style="width: 27px;">Discount</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 67px;">Vendor</th>
                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 67px;">Status</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 52px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                @foreach ($products as $key=>$item )
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ ++$key }}</td>
                                    <td class="sorting_1">{{ $item->product_name }}</td>
                                    <td>
                                        <img src="{{$item->main_image==null? asset('uploads/no_image.jpg'):asset('uploads/products/'.$item->main_image) }}" style="height: 50px;width:70px;" alt="{{ $item->product_name }}">
                                    </td>
                                    <td>{{ $item->selling_price }}</td>
                                     @php
                                         $amount=$item->selling_price-$item->discount_price;
                                         $percentage=round(($amount/$item->selling_price)*100);
                                     @endphp
                                    <td class="text-center"> <span class="badge rounded-pill bg-danger">{{$percentage  }}%</span></td>
                                    <td>{{ $item->vendor->name??'' }}</td>
                                    <td> <span class="rounded-pill badge {{ $item->status=='1'?'bg-success':'bg-warning' }}">{{ $item->status=='1'?'Active':'Inactive' }}</span></td>
                                    <td>
                                        <a href="{{Auth::user()->role=='admin'? route('product.edit',$item->id) :route('vendor.product.edit',$item->id) }}" class="btn btn-secondary" title="Edit"><i class="fadeIn animated bx bx-pencil"></i></a>

                                        <a href="{{ route('brand.edit',$item->id) }}" class="btn btn-primary" title="View"><i class="fadeIn animated bx bx-link-external"></i></a>

                                        <a data-id="{{ $item->id }}" title="{{ $item->status=='1'?'Make Inactive':'Make Active' }}" class="status btn {{ $item->status=='1'?'bg-warning':'bg-info' }}"><i class="fadeIn animated bx {{ $item->status=='1'?'bx-dislike':'bx-like' }}" ></i></a>

                                        <a href="{{Auth::user()->role=='admin'? route('product.delete',$item->id): route('vendor.product.delete',$item->id) }}"  title="Delete" data-id="{{ $item->id }}" class="delete btn btn-danger"><i class="fadeIn animated bx bx-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach






                                    </tfoot>
                                </table>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>



@endsection
@section('need-js')
    <script src="{{ asset('backend/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ asset('backend/assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script>
      $(function(){
    $(document).on('click','.status',function(e){
        e.preventDefault();
        //console.log($(this).attr('data-id'));
        @php
            $url=Auth::user()->role=='admin'?URL::to('/admin/product-manage/status-product'):URL::to('/vendor/product-manage/status-product');
        @endphp
        var link = "{{ $url }}" +'/'+$(this).attr("data-id");




                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Change status of this product?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Change it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Changed!',
                        'Product status changed.',
                        'success'
                      )
                    }
                  })


    });

  });


  $(function(){
    $(document).on('click','.delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Delete This Data?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                      )
                    }
                  })


    });

  });
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
@endsection
