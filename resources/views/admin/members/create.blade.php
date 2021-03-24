@extends('admin.layouts.master')

@section('title')
    اضافة عضوية
@endsection

@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
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
                <a href="{{url('/admin/members')}}">العضويات</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>اضافة عضوية</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> العضويات
        <small>اضافة عضوية</small>
    </h1>
@endsection

@section('content')



    <!-- END PAGE TITLE-->
    <!-- END PAGE HEADER-->
    <div class="row">
        <div class="col-md-12">

            <!-- BEGIN PROFILE CONTENT -->
            <div class="profile-content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="portlet light ">
      
                            <form role="form" action="{{route('members.store')}}" method="post" enctype="multipart/form-data">
                   
                                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                <div class="portlet-body">

                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">


                                            <div class="form-group">
                                                <label class="control-label">اسم العضوية</label>
                                                <input type="text" name="title" placeholder="اسم العضوية" class="form-control" value="{{old('title')}}" />
                                                @if ($errors->has('title'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('title') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">عدد النقاط </label>
                                                <input type="number" name="point" placeholder="عدد النقاط" class="form-control" value="{{old('point')}}" />
                                                @if ($errors->has('point'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('point') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                     
                                            <div class="form-group">
                                                <label class="control-label">الترتيب </label>
                                                <input type="number" name="type" placeholder="الترتيب" class="form-control" value="{{old('type')}}" />
                                                @if ($errors->has('type'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('type') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label-stripped">الاساسية</label>
                                                <input type="radio" name="main" value="1" checked>
                                                <span>نعم</span>
                                                <input type="radio" name="main" value="0" checked>
                                                <span>لا</span>
                                                @error('main')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('main') }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <!-- END PERSONAL INFO TAB -->

                                    </div>

                                </div>
                                <div class="margiv-top-10">
                                    <div class="form-actions">
                                        <button type="submit" class="btn green" value="حفظ" onclick="this.disabled=true;this.value='تم الارسال, انتظر...';this.form.submit();">حفظ</button>

                                    </div>
                                </div>
                            </form>
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
