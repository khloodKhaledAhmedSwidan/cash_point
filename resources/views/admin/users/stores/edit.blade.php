@extends('admin.layouts.master')

@section('title')
    تعديل المتجر
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
                <a href="/admin/home">لوحة التحكم</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <a href="/admin/users/stores">المتاجر</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>تعديل المتجر</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> المتاجر
        <small>تعديل المتجر</small>
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
                                    <span class="caption-subject font-blue-madison bold uppercase">حساب الملف الشخصي</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">المعلومات الشخصية</a>
                                    </li>
                                    <li >
                                        <a href="#tab_1_6" data-toggle="tab">باقي بيانات المتجر</a>
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
                                        <form role="form" action="/admin/update/user/{{$user->id}}" method="post" enctype="multipart/form-data">
                                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                


                                 
                                  
                                            <div class="form-group">
                                                <label class="control-label">اسم المتجر</label>
                                                <input type="text" name="name" placeholder="اسم المتجر" class="form-control" value="{{$user->name}}" />
                                                @if ($errors->has('name'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">اختر الدولة</label>
                                         
                                                   <select name="country_id" class="form-control" required>
                                                   <option selected disabled> اختر الدولة  </option>
                                                   @foreach(App\Models\Country::get() as $country)
                                                      <option value="{{$country->id}}" @if($country->id == $country->country_id) selected @endif> {{$country->name}} </option>
                                                   @endforeach
                                                   </select>
                                                    @if ($errors->has('country_id'))
                                                        <span class="help-block">
                                                           <strong style="color: red;">{{ $errors->first('country_id') }}</strong>
                                                        </span>
                                                    @endif
                                               
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">رقم الهاتف</label>
                                                <input type="number" name="phone" placeholder="رقم الهاتف" class="form-control" value="{{$user->phone}}" />
                                                @if ($errors->has('phone'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label class="control-label">اختر القسم</label>
                                         
                                                   <select name="category_id" class="form-control" required>
                                                   <option selected disabled> اختر القسم  </option>
                                                   @foreach(App\Models\Category::get() as $category)
                                                      <option value="{{$category->id}}" @if($category->id == $category->category_id) selected @endif> {{$category->name}} </option>
                                                   @endforeach
                                                   </select>
                                                    @if ($errors->has('category_id'))
                                                        <span class="help-block">
                                                           <strong style="color: red;">{{ $errors->first('category_id') }}</strong>
                                                        </span>
                                                    @endif
                                               
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label">نسبة العمولة</label>
                                                <input type="number" name="commission" placeholder="نسبة العمولة" class="form-control" value="{{$user->commission}}" />
                                                @if ($errors->has('commission'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('commission') }}</strong>
                                                    </span>
                                                @endif
                                            </div>


                                            <div class="form-group">
                                                <label class="control-label"> النقطة بالريال </label>
                                                <input type="number" name="point_equal_SR" placeholder="النقطة بالريال " class="form-control" value="{{$user->point_equal_SR}}" />
                                                @if ($errors->has('point_equal_SR'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('point_equal_SR') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                
                               
                                        
                                            <div class="form-group">
                                                <label class="control-label"> وصف المتجر </label>
                                                <textarea type="text" name="description" placeholder="  وصف المتجر" class="form-control" value="{{old('description')}}" >{{$user->description}}</textarea>
                                                @if ($errors->has('description'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('description') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">الترتيب</label>
                                                <input type="number" name="arranging" placeholder="الترتيب " class="form-control" value="{{$user->arranging}}" />
                                                @if ($errors->has('arranging'))
                                                    <span class="help-block">
                                                       <strong style="color: red;">{{ $errors->first('arranging') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-body">
                                                <div class="form-group ">
                                                    <label class="control-label col-md-3">لوجو المتجر</label>
                                                    <div class="col-md-3">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail"
                                                                 data-trigger="fileinput"
                                                                 style="width: 200px; height: 150px;">
                                                                <img src="{{asset('uploads/users/'.$user->logo)}}"
                                                                     alt="">
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new">لوجو المتجر </span>
                                                                <span class="fileinput-exists">تغيير </span>
                                                                <input type="file" name="logo"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                                   data-dismiss="fileinput">ازالة </a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('logo'))
                                                            <span class="help-block">
                                                        <strong style="color: red;">{{ $errors->first('logo') }}
                                                        </strong>
                                                    </span>
                                                        @endif
                                                    </div>


                                                    <div class="form-group ">
                                                        <label class="control-label col-md-3">صورة السجل التجاري</label>
                                                        <div class="col-md-3">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="fileinput-preview thumbnail"
                                                                     data-trigger="fileinput"
                                                                     style="width: 200px; height: 150px;">
                                                                    <img src="{{asset('uploads/users/trades/'.$user->trade_register)}}"
                                                                         alt="">
                                                                </div>
                                                                <div>
                                                                <span class="btn red btn-outline btn-file">
                                                                    <span class="fileinput-new">السجل التجاري </span>
                                                                    <span class="fileinput-exists">تغيير </span>
                                                                    <input type="file" name="trade_register"> </span>
                                                                    <a href="javascript:;" class="btn red fileinput-exists"
                                                                       data-dismiss="fileinput">ازالة </a>
                                                                </div>
                                                            </div>
                                                            @if ($errors->has('trade_register'))
                                                                <span class="help-block">
                                                            <strong style="color: red;">{{ $errors->first('trade_register') }}
                                                            </strong>
                                                        </span>
                                                            @endif
                                                        </div>
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


                                    <div class="tab-pane" id="tab_1_6">
                                        <form action="/admin/update/remainInfo/{{$user->id}}" method="post">
                                            <input type = 'hidden' name = '_token' value = '{{Session::token()}}'>
                                            <div class="form-body">
                                                <div class="form-group ">
                                                    <label class="control-label col-md-4">اسلايدر المطعم  </label>
                                                    <div class="col-md-8">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail"
                                                                 data-trigger="fileinput"
                                                                 style="width: 200px; height: 150px;">
                                                                {{-- <img src="{{asset('uploads/sliders/'.$user->trade_register)}}"
                                                                     alt=""> --}}
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> اسلايدر المطعم </span>
                                                                <span class="fileinput-exists">تغيير </span>
                                                                <input type="file" name="sliders[]"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                                   data-dismiss="fileinput">ازالة </a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('sliders'))
                                                            <span class="help-block">
                                                        <strong style="color: red;">{{ $errors->first('sliders') }}
                                                        </strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                    
                                            </div>
                                            <div class="form-body">
                                                <div class="form-group ">
                                                    <label class="control-label col-md-4">ارفق العقد  </label>
                                                    <div class="col-md-8">
                                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                                            <div class="fileinput-preview thumbnail"
                                                                 data-trigger="fileinput"
                                                                 style="width: 200px; height: 150px;">
                                                                {{-- <img src="{{asset('uploads/sliders/'.$user->trade_register)}}"
                                                                     alt=""> --}}
                                                                     {{-- <a href="{{asset('/uploads/users/files/'.$user->file)}}">مشاهده العقد</a> --}}
                                                                     <iframe
                        src="{{asset('/uploads/users/files/'.$user->file)}}"
                        frameBorder="0"
                        scrolling="auto"
                        height="100%"
                        width="100%"
                    ></iframe>
                                                            </div>
                                                            <div>
                                                            <span class="btn red btn-outline btn-file">
                                                                <span class="fileinput-new"> ارفق العقد </span>
                                                                <span class="fileinput-exists">تغيير </span>
                                                                <input type="file" name="file"> </span>
                                                                <a href="javascript:;" class="btn red fileinput-exists"
                                                                   data-dismiss="fileinput">ازالة </a>
                                                            </div>
                                                        </div>
                                                        @if ($errors->has('file'))
                                                            <span class="help-block">
                                                        <strong style="color: red;">{{ $errors->first('file') }}
                                                        </strong>
                                                    </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                    
                    
                    
                                            <div class=" form-group " id="hide-map">
                    
                    
                                                <div class="content sections">
                    
                    
                                                    <div class="wrap-title d-flex justify-content-between mm">
                    
                                                        {{--                    <h6>--}}
                    
                                                        {{--                        <i class="fas fa-map-marker-alt"></i> @lang('messages.specify_your_location')--}}
                    
                                                        {{--                    </h6>--}}
                    
                                                        <a onclick="getLocation();" > <i
                                                                class="btn btn-primary ">حدد موقعي</i>
                    
                                                        </a>
                    
                                                    </div>
                    
                    
                                                    <input type="hidden" id="lat" name="latitude" class="form-control mb-2"
                                                           readonly="yes" value="{{$user->latitude}}" required/>
                    
                                                    @if ($errors->has('latitude'))
                    
                                                        <span class="help-block">
                    
                                <strong style="color: red;">{{ $errors->first('latitude') }}</strong>
                    
                            </span>
                    
                                                    @endif
                    
                                                    <input type="hidden" id="lng" name="longitude" class="form-control mb-2"
                                                           readonly="yes" value="{{$user->longitude}}" required/>
                    
                                                    @if ($errors->has('longitude'))
                    
                                                        <span class="help-block">
                    
                                <strong style="color: red;">{{ $errors->first('longitude') }}</strong>
                    
                            </span>
                    
                                                    @endif
                    
                                                    <div id="map"></div>
                    
                                                </div>
                                            <div class="margin-top-10">
                                                <div class="form-actions">
                                                    <button type="submit" class="btn green">حفظ</button>
                    
                                                </div>
                                            </div>
                                        </form>
                                    </div>

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
        function getLocation()
        {
            if (navigator.geolocation)
            {
                navigator.geolocation.getCurrentPosition(showPosition);
            }
            else{x.innerHTML="Geolocation is not supported by this browser.";}
        }

        function showPosition(position)
        {
            lat= position.coords.latitude;
            lon= position.coords.longitude;

            document.getElementById('lat').value = lat; //latitude
            document.getElementById('lng').value = lon; //longitude
            latlon=new google.maps.LatLng(lat, lon)
            mapholder=document.getElementById('mapholder')
            //mapholder.style.height='250px';
            //mapholder.style.width='100%';

            var myOptions={
                center:latlon,zoom:14,
                mapTypeId:google.maps.MapTypeId.ROADMAP,
                mapTypeControl:false,
                navigationControlOptions:{style:google.maps.NavigationControlStyle.SMALL}
            };
            var map = new google.maps.Map(document.getElementById("map"),myOptions);
            var marker=new google.maps.Marker({position:latlon,map:map,title:"You are here!"});
        }

    </script>
    <script type="text/javascript">
        var map;

        function initMap() {
            var latitude = {{$user->longitude}}; // YOUR LATITUDE VALUE
            var longitude = {{$user->latitude}}; // YOUR LONGITUDE VALUE
            var myLatLng = {lat: latitude, lng: longitude};
            map = new google.maps.Map(document.getElementById('map'), {
                center: myLatLng,
                zoom: 5,
                gestureHandling: 'true',
                zoomControl: false// disable the default map zoom on double click
            });

            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                //title: 'Hello World'

                // setting latitude & longitude as title of the marker
                // title is shown when you hover over the marker
                title: latitude + ', ' + longitude
            });

            //Listen for any clicks on the map.
            google.maps.event.addListener(map, 'click', function(event) {
                //Get the location that the user clicked.
                var clickedLocation = event.latLng;
                //If the marker hasn't been added.
                if(marker === false){
                    //Create the marker.
                    marker = new google.maps.Marker({
                        position: clickedLocation,
                        map: map,
                        draggable: true //make it draggable
                    });
                    //Listen for drag events!
                    google.maps.event.addListener(marker, 'dragend', function(event){
                        markerLocation();
                    });
                } else{
                    //Marker has already been added, so just change its location.
                    marker.setPosition(clickedLocation);
                }
                //Get the marker's location.
                markerLocation();
            });

            function markerLocation(){
                //Get location.
                var currentLocation = marker.getPosition();
                //Add lat and lng values to a field that we can save.
                document.getElementById('lat').value = currentLocation.lat(); //latitude
                document.getElementById('lng').value = currentLocation.lng(); //longitude
            }
        }
    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFUMq5htfgLMNYvN4cuHvfGmhe8AwBeKU&callback=initMap" async
            defer></script>
@endsection
