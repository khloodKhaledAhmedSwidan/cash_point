@extends('admin.layouts.master')

@section('title')
طلبات الاستبدال المؤكده
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/datatables.bootstrap-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/sweetalert.css') }}">
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/admin/home">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="{{url('/admin/comfirm-bank-replacementpoint')}}">طلبات الاستبدال المؤكده</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>طلبات الاستبدال المؤكده </span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">طلبات الاستبدال المؤكده
        <small>عرض جميع طلبات الاستبدال المؤكده</small>
    </h1>
@endsection

@section('content')
@include('flash::message')
    <div class="row">
        <div class="col-lg-12">
            <!-- BEGIN EXAMPLE TABLE PORTLET-->
            <div class="portlet light bordered table-responsive">
                <div class="portlet-body">
                    <div class="table-toolbar">
                        <div class="row">
                            <div class="col-lg-6">
                         <a class="btn btn-info btn-sm" style="margin-left: 0.5rem;" href="{{route('replacement_confirmingBank')}}">مؤكد</a>
                         <a class="btn btn-info btn-sm" style="margin-left: 0.5rem;" href="{{route('replacement_unconfirmingBank')}}">غير مؤكد</a>

                            </div>

                        </div>
                    </div>
                    <table class="table table-striped table-bordered table-hover table-checkable order-column" id="sample_1">
                        <thead>
                        <tr>
                            <th>
                                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                    <input type="checkbox" class="group-checkable" data-set="#sample_1 .checkboxes" />
                                    <span></span>
                                </label>
                            </th>
                            <th></th>
                            <th> الاسم</th>
                            <th>النقاط</th>
                            <th> الكاش</th>
                            <th>  البنك    </th>
                            <th>  حساب الايبان    </th>
                  
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach( $points as  $point)
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td><?php echo ++$i ?></td>
                                <td> {{App\User::find($point->user_id)->name}} </td>
                                <td>
                               {{$point->pull}}
                                    </td>
                                    @php
                                    $country_id = App\User::where('id',$point->user_id)->first()->country_id;
                                  $currency =      App\Models\Country::where('id',$country_id)->first()->currency;
                                    @endphp
                                    <td>
                                        {{$point->cash}} {{$currency}}
                                             </td>
                                             <td>
                                                {{App\Models\Bank::where('id',$point->bank_id)->first()->name}} 
                                                     </td>
                                                     <td>
                                               {{$point->bank_account}}
                                                             </td>




                
                       

        

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END EXAMPLE TABLE PORTLET-->
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ URL::asset('admin/js/datatable.js') }}"></script>
    <script src="{{ URL::asset('admin/js/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/datatables.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('admin/js/table-datatables-managed.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/sweetalert.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/ui-sweetalert.min.js') }}"></script>

 

@endsection
