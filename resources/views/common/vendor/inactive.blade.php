@extends('layouts.backend_master')
@section('title')
    Inactive Vendors| Above Ecommerce
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
            <div class="breadcrumb-title pe-3">Inactive Vendors</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Inactive Vendors List</li>
                    </ol>
                </nav>
            </div>

        </div>
        <!--end breadcrumb-->
        <div class="d-flex justify-content-between">
            <h6 class="mb-0 text-uppercase ">Inactive Vendor List</h6>

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
                                                Vendor Name</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Position: activate to sort column ascending"
                                                style="width: 170px;">Mobile</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 73px;">Email</th>

                                                <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Office: activate to sort column ascending"
                                                style="width: 73px;">Image</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Age: activate to sort column ascending"
                                                style="width: 27px;">Created</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Start date: activate to sort column ascending"
                                                style="width: 67px;">Last Update</th>
                                            <th class="sorting" tabindex="0" aria-controls="example" rowspan="1"
                                                colspan="1" aria-label="Salary: activate to sort column ascending"
                                                style="width: 52px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                @foreach ($items as $key=>$item )
                                <tr role="row" class="odd">
                                    <td class="sorting_1">{{ ++$key }}</td>
                                    <td class="sorting_1">{{ $item->name }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>
                                        <img src="{{$item->image==null? asset('uploads/no_image.jpg'):asset('uploads/profile/'.$item->image) }}" style="height: 50px;width:70px;" alt="{{ $item->image }}">
                                    </td>
                                    <td>{{date('h:i:s:a d-m-Y',strtotime($item->created_at))  }}</td>
                                    <td>{{ date('h:i:s:a d-m-Y',strtotime($item->created_at)) }}</td>
                                    <td>
                                        <a href="{{ route('vendor.profile.details',$item->id) }}" class="btn btn-secondary">View</a>
                                        <a href="{{ route('vendor.status.change',$item->id) }}" id="delete" class="btn {{ $item->status=='active'?'btn-danger':'btn-success' }}">Make Active</a>
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
    $(document).on('click','#delete',function(e){
        e.preventDefault();
        var link = $(this).attr("href");


                  Swal.fire({
                    title: 'Are you sure?',
                    text: "Active This User?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Active it!'
                  }).then((result) => {
                    if (result.isConfirmed) {
                      window.location.href = link
                      Swal.fire(
                        'Deleted!',
                        'Vendor User has been Activated.',
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
