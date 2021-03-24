@extends('admin.layouts.master')

@section('title')
    اضافة اسلايدر
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
                <a href="{{url('/admin/sliders')}}">الاسلايدر</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>اضافة اسلايدر</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> الاسلايدر
        <small>اضافة اسلايدر</small>
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
      
                            <form role="form" action="{{route('sliders.store')}}" method="post" enctype="multipart/form-data">
                   
                                <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                <div class="portlet-body">

                                    <div class="tab-content">
                                        <!-- PERSONAL INFO TAB -->
                                        <div class="tab-pane active" id="tab_1_1">


                                            <div class="form-group">
                                                <label class="control-label">اللينك </label>
                                                <input type="text" name="link" placeholder="اللينك " class="form-control" value="{{old('link')}}" />
                                                @if ($errors->has('link'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('link') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                      


                                                <div class="form-group">
                                                    <label class="control-label">اختر متجر</label>
                                             
                                                       <select name="user_id" class="form-control" required>
                                                       <option selected disabled> اختر متجر  </option>
                                                       @foreach(App\User::where('type','2')->get() as $user)
                                                          <option value="{{$user->id}}"> {{$user->name}} </option>
                                                       @endforeach
                                                       </select>
                                                        @if ($errors->has('user_id'))
                                                            <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('user_id') }}</strong>
                                                            </span>
                                                        @endif
                                                   
                                                </div>
                                             
                                      
                                            <div class="form-body">
                                                <div class="form-group ">
                                                    <label class="control-label col-md-3">الصورة </label>
                                                    <div class="col-md-9">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختر الصورة </span>
                                                                <span class="fileinput-exists"> تغيير </span>
                                                                <input type="file" name="image"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> إزالة </a>



                                                            </div>
                                                        </div>
                                                        @if ($errors->has('image'))
                                                            <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('image') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                </div>
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
