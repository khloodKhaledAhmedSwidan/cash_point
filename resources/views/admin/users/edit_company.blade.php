@extends('admin.layouts.master')

@section('title')
    تعديل مستخدم
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
                <a href="/admin/user/3">المستخدمين</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل المستخدمين</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> المستخدمين
        <small>تعديل المستخدمين</small>
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
                                            <span class="caption-subject font-blue-madison bold uppercase">حساب الملف الشخصي</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab">المعلومات الشخصية</a>
                                            </li>

                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab">تغيير كلمة المرور</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_4" data-toggle="tab">اعدادات الخصوصية</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                @if(count($errors))
                                                    <ul class="alert alert-danger">
                                                        @foreach($errors->all() as $error)
                                                            <li>{{$error}}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                                <form role="form" action="/admin/update/user/{{$user->id}}/3" method="post" enctype="multipart/form-data">
                                                    <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                                    <div class="form-group">
                                                        <label class="control-label">الاسم</label>
                                                        <input type="text" name="name" placeholder="الاسم" class="form-control" value="{{$user->name}}" />
                                                        @if ($errors->has('name'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">البريد الالكتروني</label>
                                                        <input type="text" name="email" placeholder="البريد الالكتروني" class="form-control" value="{{$user->email}}" />
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('email') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">رقم الهاتف</label>

                                                        <div class=" input-group select2-bootstrap-append">
                                                            <select  name="code" class="form-control select2-allow-clear">
                                                                @foreach($countries as $country)
                                                                    <option value="{{$country->code}}" {{old('code')== $country->id ? 'selected' : ''}}>{{$country->code}}</option>
                                                                @endforeach


                                                            </select>
                                                            @if ($errors->has('code'))
                                                                <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('code') }}</strong>
                                                            </span>
                                                            @endif
                                                            <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                    </span>
                                                        </div>
                                                        <input type="text" name="phone_number" placeholder="رقم الهاتف" class="form-control" value="{{$user->phone_number}}" />
                                                        @if ($errors->has('phone_number'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('phone_number') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">اسم الشركة</label>
                                                        <input type="text" name="company_name" placeholder="الاسم" class="form-control" value="{{$user->company_name}}" />
                                                        @if ($errors->has('company_name'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('company_name') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>


                                                    <div class="form-group">
                                                        <label class="control-label">رقم السجل التجاري</label>
                                                        <input type="number" name="commercial_number" placeholder="رقم السجل التجاري" class="form-control" value="{{$user->commercial_number}}" />
                                                        @if ($errors->has('commercial_number'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('commercial_number') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">التاريخ</label>
                                                        <input type="date" name="commercial_end_date" placeholder="التاريخ" class="form-control" value="{{$user->commercial_end_date}}" />
                                                        @if ($errors->has('commercial_end_date'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('commercial_end_date') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>




                                                    <div class="form-group">
                                                        <label for="gender" class="control-label">اختر الدولة</label>

                                                        <div class=" input-group select2-bootstrap-append">
                                                            <select  name="country" class="form-control select2-allow-clear" id="choose_country">
                                                                <option value>اختر الدولة</option>
                                                                @foreach($countries as $country)
                                                                    @if($country->parent_id == null)
                                                                        <option value="{{$country->id}}" {{ $user->country_id == $country->id ? 'selected' : '' }}>{{$country->name}}</option>
                                                                    @endif
                                                                @endforeach

                                                            </select>
                                                            @if ($errors->has('country'))
                                                                <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('country') }}</strong>
                                                            </span>
                                                            @endif
                                                            <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                    </span>
                                                        </div>

                                                    </div>
                                                    <div class="form-group" >
                                                        <label for="gender" class="control-label">اختر المنطقة</label>

                                                        <div class=" input-group select2-bootstrap-append">
                                                            <select  name="region" class="form-control select2-allow-clear" id="choose_region">
                                                                <option value>اختر المنطقة</option>
                                                                @foreach(\App\Country::where('parent_id',$user->country_id)->get() as $region)
                                                                    <option  value="{{$region->id}}" {{$user->region_id== $region->id ? 'selected' : ''}}>{{$region->name}}</option>
                                                                @endforeach

                                                            </select>
                                                            @if ($errors->has('region'))
                                                                <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('region') }}</strong>
                                                            </span>
                                                            @endif
                                                            <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                    </span>
                                                        </div>

                                                    </div>
                                                    <div class="form-group" >
                                                        <label for="gender" class="control-label">اختر المدينة</label>

                                                        <div class=" input-group select2-bootstrap-append">
                                                            <select  name="city" class="form-control select2-allow-clear" id="choose_city">
                                                                <option value>اختر المدينة</option>
                                                                @foreach(\App\Country::where('parent_id',$user->region_id)->get() as $city)
                                                                    <option  value="{{$city->id}}" {{$user->city_id== $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                                                @endforeach

                                                            </select>
                                                            @if ($errors->has('city'))
                                                                <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('city') }}</strong>
                                                            </span>
                                                            @endif
                                                            <span class="input-group-btn">
                                                        <button class="btn btn-default" type="button" data-select2-open="single-append-text">
                                                            <span class="glyphicon glyphicon-search"></span>
                                                        </button>
                                                    </span>
                                                        </div>

                                                    </div>





                                                    <div class="margiv-top-10">
                                                        <div class="form-actions">
                                                            <button type="submit" class="btn green">حفظ</button>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->

                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_3">
                                                <form action="/admin/update/pass/{{$user->id}}" method="post">
                                                    <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>

                                                    <div class="form-group">
                                                        <label class="control-label">كلمة المرور الجديدة</label>
                                                        <input type="password" name="password" class="form-control" />
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('password') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="control-label">إعادة كلمة المرور</label>
                                                        <input type="password" name="password_confirmation" class="form-control" />
                                                        @if ($errors->has('password_confirmation'))
                                                            <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('password_confirmation') }}</strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                    <div class="margin-top-10">
                                                        <div class="form-actions">
                                                            <button type="submit" class="btn green">حفظ</button>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                            <!-- PRIVACY SETTINGS TAB -->
                                            <div class="tab-pane" id="tab_1_4">
                                                <form action="/admin/update/privacy/{{$user->id}}" method="post">
                                                    <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                                    <table class="table table-light table-hover">

                                                        <tr>
                                                            <td> تفعيل المستخدم</td>
                                                            <td>
                                                                <div class="mt-radio-inline">
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="active" value="1" {{ $user->active == "1" ? 'checked' : '' }}/> نعم
                                                                        <span></span>
                                                                    </label>
                                                                    <label class="mt-radio">
                                                                        <input type="radio" name="active" value="0" {{$user->active == "0" ? 'checked' : '' }}/> لا
                                                                        <span></span>
                                                                    </label>
                                                                    @if ($errors->has('active'))
                                                                        <span class="help-block">
                                                                       <strong style="color: red;">{{ $errors->first('active') }}</strong>
                                                                    </span>
                                                                    @endif
                                                                </div>
                                                            </td>
                                                        </tr>


                                                    </table>
                                                    <div class="margin-top-10">
                                                        <div class="form-actions">
                                                            <button type="submit" class="btn green">حفظ</button>

                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                            <!-- END PRIVACY SETTINGS TAB -->
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
    <script src=" {{ URL::asset('admin/js/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src=" {{ URL::asset('admin/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src=" {{ URL::asset('admin/js/form-repeater.min.js') }}" type="text/javascript"></script>
@endsection