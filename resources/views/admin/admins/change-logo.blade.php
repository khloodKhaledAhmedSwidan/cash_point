@extends('admin.layouts.master')

@section('title')
تغيير شعار الموقع
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
    <style>
        #map {
            height: 500px;
            width: 500px;
        }
    </style>
@endsection

@section('page_header')
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="/admin/home">لوحه التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/change-logo">تغيير شعار الموقع</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>

            </li>
        </ul>
    </div>

    <h1 class="page-title">تغيير شعار الموقع
    </h1>
@endsection

@section('content')


    @if (session('information'))
        <div class="alert alert-success">
            {{ session('information') }}
        </div>
    @endif
    @if (session('pass'))
        <div class="alert alert-success">
            {{ session('pass') }}
        </div>
    @endif
    @if (session('privacy'))
        <div class="alert alert-success">
            {{ session('privacy') }}
        </div>
    @endif
    @if(count($errors))
        <ul class="alert alert-danger">
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
    @endif
    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
                            <div class="portlet-title tabbable-line">
                                <div class="caption caption-md">
                                    <i class="icon-globe theme-font hide"></i>
                                    <span
                                        class="caption-subject font-blue-madison bold uppercase">تغيير شعار الموقع</span>
                                </div>

                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <form role="form" action="{{route('changeLogo.store')}}" method="post"
                                          enctype="multipart/form-data">
                                        <input type='hidden' name='_token' value='{{Session::token()}}'>
                                        <div class="portlet-body">

                                            <div class="tab-content">
                                                <!-- PERSONAL INFO TAB -->
                                                <div class="tab-pane active" id="tab_1_1">

                                                    <div class="form-body">
                                                        <div class="form-group ">
                                                            <label class="control-label col-md-3">الصورة</label>
                                                            <div class="col-md-9">
                                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                    <div class="fileinput-preview thumbnail"
                                                                         data-trigger="fileinput"
                                                                         style="width: 200px; height: 150px;">

                                                                        <img src="{{asset('/uploads/logo/'.$logo)}}"
                                                                             alt="">
                                                                    </div>
                                                                    <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختر صورة </span>
                                                                <span class="fileinput-exists">تغيير</span>
                                                                <input type="file" name="logo"> </span>
                                                                        <a href="javascript:;" class="btn red fileinput-exists"
                                                                           data-dismiss="fileinput"> حذف  </a>
                                                                    </div>
                                                                </div>
                                                                @if ($errors->has('logo'))
                                                                    <span class="help-block">
                                                        <strong style="color: red;">{{ $errors->first('logo') }}
                                                        </strong>
                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <div class="margiv-top-10">
                                            <div class="form-actions">
                                                <button type="submit" class="btn green" value="حفظ"
                                                        onclick="this.disabled=true;this.value='تم الارسال, انتظر...';this.form.submit();">حفظ</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END PROFILE CONTENT -->
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>

@endsection
