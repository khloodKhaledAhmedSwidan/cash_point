@extends('admin.layouts.master')

@section('title')
    الاقتراحات
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
                <a href="{{url('/admin/suggestions')}}">الإقتراحات</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>عرض الإقتراحات </span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">عرض الإقتراحات
        <small>عرض جميع الإقتراحات</small>
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
                            <th> الاقتراح</th>
                            <th>  للتواصل مع المستخدم   </th>
                        
                            <th> العمليات </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $i=0 ?>
                        @foreach($suggestions as $suggestion)
                            <tr class="odd gradeX">
                                <td>
                                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                                        <input type="checkbox" class="checkboxes" value="1" />
                                        <span></span>
                                    </label>
                                </td>
                                <td><?php echo ++$i ?></td>
                                <td> {{App\User::find($suggestion->user_id)->name}} </td>
                                <td>
                                    
              <!-- Button trigger modal -->
              <a type="button"  data-toggle="modal" data-target="#exampleModalLong{{$suggestion->id}}">
                {{ str_limit($suggestion->description , 50) }}
            </a>

            <!-- Modal -->
            <div class="modal fade" id="exampleModalLong{{$suggestion->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{App\User::find($suggestion->user_id)->name}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            {{$suggestion->description}}
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        
        
        </td>


        @php

        // $result = substr(\App\User::find($contact->user_id)->phone, 1);
        // $phone = '00966' . $result;


$country = App\User::find($suggestion->user_id)->country_id;
$code = App\Models\Country::find($country)->code;

        $phone = $code .\App\User::find($suggestion->user_id)->phone;
                            @endphp
                
                                <td>
                                    
                                    <a href="https://api.whatsapp.com/send?phone={{$phone}}">
                                        <i class="fa fa-whatsapp fa-1x" aria-hidden="true"></i>
                                        {{App\User::find($suggestion->user_id)->phone}}
                                          </a>
                                    
                      
                                
                                </td>

                      




                                <td>
                                 
                                      
                             
                                 
                                        
                             
                                                <a class="delete_user btn btn-danger" data="{{ $suggestion->id }}" data_name="{{ App\User::find($suggestion->user_id)->name }}" >
                                                    <i class="fa fa-key"></i> مسح
                                                </a>
                                  

                                        
                            
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

    <script>
        $(document).ready(function() {
            var CSRF_TOKEN = $('meta[name="X-CSRF-TOKEN"]').attr('content');

            $('body').on('click', '.delete_user', function() {
                var id = $(this).attr('data');

                var swal_text = 'حذف ' + $(this).attr('data_name') + '؟';
                var swal_title = 'هل أنت متأكد من الحذف ؟';

                swal({
                    title: swal_title,
                    text: swal_text,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-warning",
                    confirmButtonText: "تأكيد",
                    cancelButtonText: "إغلاق",
                    closeOnConfirm: false
                }, function() {

                    window.location.href = "{{ url('/') }}" + "/admin/delete/"+id+"/suggestion";


                });

            });

        });
    </script>

@endsection
