@extends('admin.layouts.master')

@section('title')
    من نحن
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
                <a href="/admin/pages/about">من نحن</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل من نحن</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> من نحن
        <small>تعديل من نحن</small>
    </h1>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
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
            <form action="{{url('admin/add/pages/about')}}" method="post" enctype="multipart/form-data">
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
                                    <label class="col-md-3 control-label">العنوان</label>
                                    <div class="col-md-9">


                                            <input type="text" class="form-control" placeholder="العنوان" name="title" value="{{$settings->title}}">


                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">المحتوي</label>
                                    <div class="col-md-9">


                                        <textarea type="text" class="form-control" placeholder="المحتوي" name="content" >{{$settings->content}}</textarea>


                                    </div>
                                </div>
                                <div class="form-body">
                                    <div class="form-group">
                                        <label class="control-label col-md-3"> صور  من نحن </label>

                                        <div class="col-md-9">
                                            @foreach($photos as $image)
                                                <div class="col-sm-3 img_{{ $image->id }}">
                                                    <p><img src="{{ URL::to('uploads/abouts/'.$image->photo) }}" class="img-fluid" height="150" width="150" id="file_name"></p>
                                                    <a  id="{{ $image->id }}"  style="color: white;text-decoration: none;" class="delete_image hideDiv btn btn-danger">
                                                        <i class="glyphicon glyphicon-trash "></i> مسح</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="col-md-9">
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
                                                </div>
                                                <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اختر الصورة </span>
                                                                <span class="fileinput-exists"> تغيير </span>
                                                                <input type="file" name="photo"> </span>
                                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> إزالة </a>



                                                </div>
                                            </div>
                                            @if ($errors->has('photo'))
                                                <span class="help-block">
                                                               <strong style="color: red;">{{ $errors->first('photo') }}</strong>
                                                            </span>
                                            @endif
                                        </div>

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
    <script src="{{ URL::asset('admin/js/select2.full.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/components-select2.min.js') }}"></script>
    <script src="{{ URL::asset('admin/js/bootstrap-fileinput.js') }}"></script>
    <script src="{{ URL::asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script>

        CKEDITOR.replace('description2');
    </script>


    <script>
        $(".delete_image").click(function(){
            var id = $(this).attr('id');
            var url = '{{ route("imageAboutRemove", ":id") }}';

            url = url.replace(':id', id);

            //alert(image_id );
            $.ajax({
                url: url,
                type: 'GET',
                success: function(result) {
                    if (!result.message)
                    {
                        $(".img_"+id).fadeOut('1000');
                    }

                }
            });
        });
    </script>


@endsection
