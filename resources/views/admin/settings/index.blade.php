@extends('admin.layouts.master')

@section('title')
اعدادات الموقع
@endsection
@section('styles')
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/select2-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('admin/css/bootstrap-fileinput.css') }}">
        <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

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
                <a href="/admin/setting">اعدادات الموقع</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>

            </li>
        </ul>
    </div>

    <h1 class="page-title"> اعدادات الموقع
        <small>اعدادات الموقع</small>
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
                                        class="caption-subject font-blue-madison bold uppercase">اعدادات  الموقع</span>
                                </div>
                                <ul class="nav nav-tabs">
                                    <li class="active">
                                        <a href="#tab_1_1" data-toggle="tab">الاعدادات العامه للموقع</a>
                                    </li>

                                    <li>
                                        <a href="#tab_1_3"
                                           data-toggle="tab"> هنشوف بعدين دي ايه </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_2" data-toggle="tab">من نحن </a>
                                    </li>
                                    <li>
                                        <a href="#tab_1_6" data-toggle="tab">معلومات الادارة </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="portlet-body">
                                <div class="tab-content">
                                    <!-- PERSONAL INFO TAB -->
                                    <div class="tab-pane active" id="tab_1_1">
                                        <form role="form" action="{{url('admin/add/settings')}}" method="post"
                                              enctype="multipart/form-data">
                                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.phone_number')</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.phone_number') "
                                                           name="phone" value="{{$settings->phone}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">@lang('messages.whatsapp')</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.whatsapp') "
                                                           name="whatsapp" value="{{$settings->whatsapp}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.accept_tax')</label>
                                                <div class="col-md-9">


                                                    <input type="text" class="form-control"
                                                           placeholder="@lang('messages.accept_tax')"
                                                           name="accept_tax" value="{{$settings->accept_tax}}">


                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.accept_tax_en')</label>
                                                <div class="col-md-9">


                                                    <input type="text" class="form-control"
                                                           placeholder="@lang('messages.accept_tax_en')"
                                                           name="accept_tax_en" value="{{$settings->accept_tax_en}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.tax_price')</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.tax_price')"
                                                           name="tax" value="{{$settings->tax}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.tax_for_completed_order')%</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.tax_for_completed_order')"
                                                           name="tax_for_completed_order" value="{{$settings->tax_for_completed_order}}" >


                                                </div>
                                            </div>
                                                               <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.tax_for_completed_order_active')</label>
                                                <div class="col-md-9">


                                                    <input type="checkbox" id="activation-{{$settings->id}}"
                                                    onchange="testActive({{$settings->tax_for_completed_order_active}},{{$settings->id}})"
                                                    {{$settings->tax_for_completed_order_active == 1 ? 'checked' : ''}} data-toggle="toggle">


                                                </div>
                                              
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.cancel_order')</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.cancel_order')"
                                                           name="cancel_order" value="{{$settings->cancel_order}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label"> @lang('messages.search_range')</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.search_range') "
                                                           name="search_range"
                                                           value="{{$settings->search_range}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.count_of_order_in_period')</label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.count_of_order_in_period')"
                                                           name="count_of_order_in_period"
                                                           value="{{$settings->count_of_order_in_period}}">


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label"> @lang('messages.attendance_range') </label>
                                                <div class="col-md-9">


                                                    <input type="number" class="form-control"
                                                           placeholder="@lang('messages.attendance_range')"
                                                           name="shift_range" value="{{$settings->shift_range}}">


                                                </div>
                                            </div>


                                            <div class="margiv-top-10">
                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn green">@lang('messages.save')</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- END PERSONAL INFO TAB -->

                                    <!-- CHANGE PASSWORD TAB -->
                                    <div class="tab-pane" id="tab_1_3">
                                        <form action="{{route('store_TermsAndConditions')}}" method="post">
                                            <input type='hidden' name='_token' value='{{Session::token()}}'>

                                            <div class="form-group">
                                                <label class="col-md-3 control-label">@lang('messages.terms') </label>
                                                <div class="col-md-9">


                                                <textarea type="text" class="form-control"
                                                          name="terms_ar">{{$settings->terms_ar}}</textarea>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-md-3 control-label">@lang('messages.terms_en')</label>
                                                <div class="col-md-9">


                                                <textarea type="text" class="form-control"
                                                          name="term">{{$settings->term}}</textarea>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.condition') </label>
                                                <div class="col-md-9">


                                                <textarea type="text" class="form-control"
                                                          name="condition_ar">{{$settings->condition_ar}}</textarea>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.condition_en') </label>
                                                <div class="col-md-9">


                                                <textarea type="text" class="form-control"
                                                          name="condition">{{$settings->condition}}</textarea>


                                                </div>
                                            </div>
                                            <div class="margin-top-10">
                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn green">@lang('messages.save')</button>

                                                </div>
                                            </div>
                                        </form>
                                    </div>


                                    <!-- END CHANGE PASSWORD TAB -->


                                    <!-- PRIVACY SETTINGS TAB -->
                                    <div class="tab-pane" id="tab_1_2">
                                        <form action="{{route('store_aboutus')}}" method="post">
                                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.who_are_we') </label>
                                                <div class="col-md-9">


                                                <textarea type="text" class="form-control"
                                                          name="about_us_ar">{{$settings->about_us_ar}}</textarea>


                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.who_are_we_en') </label>
                                                <div class="col-md-9">


                                                <textarea type="text" class="form-control"
                                                          name="about_us">{{$settings->about_us}}</textarea>


                                                </div>
                                            </div>
                                            <div class="margin-top-10">
                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn green">@lang('messages.save')</button>

                                                </div>
                                            </div>
                                        </form>

                                    </div>


                                    <!-- PRIVACY SETTINGS TAB -->
                                    <div class="tab-pane" id="tab_1_6">
                                        <form action="{{route('store_companyInfo')}}" method="post">
                                            <input type='hidden' name='_token' value='{{Session::token()}}'>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.company_name') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="company_name"
                                                           placeholder="@lang('messages.company_name')"
                                                           value="{{$settings->company_name}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.company_name_en') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="company_name_en"
                                                           placeholder="@lang('messages.company_name_en')"
                                                           value="{{$settings->company_name_en}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.route_name') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="route_name" placeholder="@lang('messages.route_name')"
                                                           value="{{$settings->route_name}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.route_name_en') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="route_name_en"
                                                           placeholder="@lang('messages.route_name_en')"
                                                           value="{{$settings->route_name_en}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.city_name') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="city_name" placeholder="@lang('messages.city_name')"
                                                           value="{{$settings->city_name}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.city_name_en') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="city_name_en"
                                                           placeholder="@lang('messages.city_name_en')"
                                                           value="{{$settings->city_name_en}}">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.country_name') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="country_name"
                                                           placeholder="@lang('messages.country_name')"
                                                           value="{{$settings->country_name}}">
                                                </div>
                                            </div>              <div class="form-group">
                                                <label
                                                    class="col-md-3 control-label">@lang('messages.country_name_en') </label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control"
                                                           name="country_name_en"
                                                           placeholder="@lang('messages.country_name_en')"
                                                           value="{{$settings->country_name_en}}">
                                                </div>
                                            </div>


                                            <div class=" form-group " id="hide-map">


                                                <div class="content sections">


                                                    <div class="wrap-title d-flex justify-content-between mm">

                                                        <h6>

                                                            <i class="fas fa-map-marker-alt"></i> @lang('messages.specify_your_location')

                                                        </h6>

                                                        <a onclick="getLocation();"> <i
                                                                class="btn btn-primary ">   @lang('messages.specify_my_location')</i>

                                                        </a>

                                                    </div>


                                                    <input type="hidden" id="lat" name="latitude"
                                                           class="form-control mb-2"
                                                           readonly="yes" value="{{$settings->latitude}}" required/>

                                                    @if ($errors->has('latitude'))

                                                        <span class="help-block">

                                        <strong style="color: red;">{{ $errors->first('latitude') }}</strong>

                                    </span>

                                                    @endif

                                                    <input type="hidden" id="lng" name="longitude"
                                                           class="form-control mb-2"
                                                           readonly="yes" value="{{$settings->longitude}}" required/>

                                                    @if ($errors->has('longitude'))

                                                        <span class="help-block">

                                        <strong style="color: red;">{{ $errors->first('longitude') }}</strong>

                                    </span>

                                                    @endif

                                                    <div id="map"></div>

                                                </div>

                                            </div>
                                            <div class="margin-top-10">
                                                <div class="form-actions">
                                                    <button type="submit"
                                                            class="btn green">@lang('messages.save')</button>

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
        <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        function testActive(state, id){
            console.log(id);
            $.ajax({
                url: 'update/activeVatForCompleteOrder/'+id,
                type: 'GET',
                datatype: 'json',
                success: function (data) {
                    console.log(data);
                }
            });

        }
    </script>
    <script>

        function getLocation() {

            if (navigator.geolocation) {

                navigator.geolocation.getCurrentPosition(showPosition);

            } else {

                x.innerHTML = "Geolocation is not supported by this browser.";

            }

        }


        function showPosition(position) {

            lat = position.coords.latitude;

            lon = position.coords.longitude;


            document.getElementById('lat').value = lat; //latitude

            document.getElementById('lng').value = lon; //longitude

            latlon = new google.maps.LatLng(lat, lon)

            mapholder = document.getElementById('mapholder')

            //mapholder.style.height='250px';

            //mapholder.style.width='100%';


            var myOptions = {

                center: latlon,

                zoom: 14,

                mapTypeId: google.maps.MapTypeId.ROADMAP,

                mapTypeControl: false,

                navigationControlOptions: {

                    style: google.maps.NavigationControlStyle.SMALL

                }

            };

            var map = new google.maps.Map(document.getElementById("map"), myOptions);

            var marker = new google.maps.Marker({

                position: latlon,

                map: map,

                title: "You are here!"

            });

        }


    </script>


    <script type="text/javascript">

        var map;


        function initMap() {

            var latitude = {{$settings->latitude}}; // YOUR LATITUDE VALUE

            var longitude = {{$settings->longitude}}; // YOUR LONGITUDE VALUE
            //             var latitude = 24.774265; // YOUR LATITUDE VALUE

            // var longitude = 46.738586; // YOUR LONGITUDE VALUE

            var myLatLng = {

                lat: latitude,

                lng: longitude

            };

            map = new google.maps.Map(document.getElementById('map'), {

                center: myLatLng,

                zoom: 5,

                gestureHandling: 'true',

                zoomControl: false // disable the default map zoom on double click

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

            google.maps.event.addListener(map, 'click', function (event) {

                //Get the location that the user clicked.

                var clickedLocation = event.latLng;

                //If the marker hasn't been added.

                if (marker === false) {

                    //Create the marker.

                    marker = new google.maps.Marker({

                        position: clickedLocation,

                        map: map,

                        draggable: true //make it draggable

                    });

                    //Listen for drag events!

                    google.maps.event.addListener(marker, 'dragend', function (event) {

                        markerLocation();

                    });

                } else {

                    //Marker has already been added, so just change its location.

                    marker.setPosition(clickedLocation);

                }

                //Get the marker's location.

                markerLocation();

            });


            function markerLocation() {

                //Get location.

                var currentLocation = marker.getPosition();

                //Add lat and lng values to a field that we can save.

                document.getElementById('lat').value = currentLocation.lat(); //latitude

                document.getElementById('lng').value = currentLocation.lng(); //longitude

            }

        }


    </script>




    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAFUMq5htfgLMNYvN4cuHvfGmhe8AwBeKU&callback=initMap"
            async
            defer></script>
@endsection
