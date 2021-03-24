@extends('admin.layouts.master')

@section('title')
    قيمة دفع الأشتراك
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/admin/home">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/payment_value">قيمة دفع الأشتراك</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل قيمة دفع الأشتراك</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> قيمة دفع الأشتراك
        <small>تعديل قيمة دفع الأشتراك</small>
    </h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @include('flash::message')
    <div class="row">

        <div class="col-md-8">
            <!-- BEGIN TAB PORTLET-->
            @if(count($errors))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            @endif
            <form action="{{url('admin/payment_value/store')}}" method="post">
                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                <!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->

                    <div class="row">
                        <!-- BEGIN SAMPLE FORM PORTLET-->
                        <div class="portlet light bordered table-responsive">
                            <div class="portlet-body form">
                                <div class="form-horizontal" role="form">
                                    <div class="form-body">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">قيمة دفع الأشتراك</label>
                                            <div class="col-md-9">
                                                <select name="value" class="form-control">
                                                    <option disabled selected> اختر  قيمة الأشتراك </option>
                                                    @for($i=1; $i<100 ; $i++)
                                                        <option value="{{$i}}" @if($payment->value == $i) selected @endif> {{$i}} ريال </option>
                                                    @endfor
                                                </select>
{{--                                                <input type="text" class="form-control" placeholder="قيمة دفع الأشتراك " name="value" value="{{$payment->value}} ريال">--}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <!-- END SAMPLE FORM PORTLET-->


                    </div>


                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->







                <div class="form-actions">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-9">
                            <button type="submit" class="btn green">حفظ</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END TAB PORTLET-->





        </div>
    </div>

@endsection

@section('scripts')

    <script src="{{ URL::asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script>

        CKEDITOR.replace('description2');
    </script>




@endsection
