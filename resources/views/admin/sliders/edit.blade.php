@extends('admin.layouts.master')

@section('title')
    تعديل الاسلايدر
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
                <a href="/admin/sliders">الاسلايدر</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل الاسلايدر</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> الاسلايدر
        <small>تعديل الاسلايدر</small>
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
                
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        <form role="form" action="{{route('sliders.update',$slider->id)}}" method="post" enctype="multipart/form-data">
                                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
@method('PUT')
<div class="form-group">
    <label class="control-label">اللينك </label>
    <input type="text" name="link" placeholder="اللينك " class="form-control" value="{{$slider->link}}" />
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
              <option value="{{$user->id}}" @if($user->id == $slider->user_id) selected @endif>{{$user->name}} </option>
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
                                                    <label class="control-label col-md-3">الصورة</label>
                                                    <div class="col-md-9">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail"
                                                                 data-trigger="fileinput"
                                                                 style="width: 200px; height: 150px;">
                                                                <img src="{{asset('uploads/sliders/'.$slider->image)}}"
                                                                     alt="">
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new">اختر صورة </span>
                                                                <span class="fileinput-exists">@lang('messages.change') </span>
                                                                <input type="file" name="image"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                                   data-dismiss="fileinput">ازالة </a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('image'))
                                                            <span class="help-block">
                                                        <strong style="color: red;">{{ $errors->first('image') }}
                                                        </strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
              
                                            <div class="margiv-top-10">
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
    <script>
        $(document).ready(function() {
            // for get regions
            $('select[name="city_id"]').on('change', function() {
                var id = $(this).val();
                if (id) {
                    $.ajax({
                        url: '/admin/get/regions/' + id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('#choose_region').empty();
                            $('#places').empty();
                            $('#choose_city').empty();

                            $('select[name="c"]').append('<option value>اختر المنطقة</option>');
                            $.each(data['regions'], function (index, regions) {

                                $('select[name="region_id"]').append('<option value="' + regions.id + '">' + regions.name + '</option>');

                            });
                            $('select[name="places"]').append('<option value>اختر المنطقة</option>');
                            $.each(data['regions'], function (index, regions) {

                                $('select[name="places"]').append('<option value="' + regions.id + '">' + regions.name + '</option>');

                            });


                        }
                    });
                }else{
                    $('#choose_region').empty();
                    $('#places').empty();
                    $('#choose_city').empty();
                }
            });


            $( "body" ).on( "change", "input[type=radio][name=multi_place]", function() {
                // $( this ).after( "<p>Another paragraph! " + (++count) + "</p>" );

                all_payment_status = $(this).val();
                var id = $(this).val();
                if (id == "1") {

                    $('#multi_placce').show();



                }else{
                    $('#multi_placce').hide();


                }


            });
        });
    </script>
@endsection
