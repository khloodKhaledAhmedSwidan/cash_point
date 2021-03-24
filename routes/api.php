<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::group(['middleware' =>  'cors'], function () {
        Route::post( '/register-mobile', [
            'uses' => 'Api\AuthController@registerMobile',
            'as'   => 'register-mobile'
        ] );
        Route::post( '/phone-verification', [
            'uses' => 'Api\AuthController@register_phone_post',
            'as'   => 'register_phone_post'
        ] );
        Route::post( '/resend-code', [
            'uses' => 'Api\AuthController@resend_code',
            'as'   => 'resend_code'
        ] );
        /*user register*/
        Route::post( '/user-register-mobile', [
            'uses' => 'Api\AuthUserController@registerMobile',
            'as'   => 'user-register-mobile'
        ] );
        Route::post( '/user-phone-verification', [
            'uses' => 'Api\AuthUserController@register_phone_post',
            'as'   => 'user-register_phone_post'
        ] );
        Route::post( '/user-resend-code', [
            'uses' => 'Api\AuthUserController@resend_code',
            'as'   => 'user-resend_code'
        ] );
        Route::post( '/user-register', [
            'uses' => 'Api\AuthUserController@register',
            'as'   => 'register'
        ] );


// ==============================auth :client ==============================

Route::post('/client-register-mobile', [
    'uses' => 'Api\Client\AuthController@registerMobile',
    'as' => 'client-register-mobile'
]);
Route::post('/client-phone-verification', [
    'uses' => 'Api\Client\AuthController@register_phone_post',
    'as' => 'client-register_phone_post'
]);

Route::post('/client-resend-code', [
    'uses' => 'Api\Client\AuthController@resend_code',
    'as' => 'client-resend_code'
]);
Route::post('/client-register', [
    'uses' => 'Api\Client\AuthController@register',
    'as' => 'client_register'
]);
        // ======================== auth :store ===============================
        Route::post( '/login', [
            'uses' => 'Api\Store\AuthController@login',
            'as'   => 'store-login'
        ] );
        Route::post( '/forget-password', [
            'uses' => 'Api\Store\AuthController@forgetPassword',
            'as'   => 'forgetPassword'
        ] );
        Route::post( '/confirm-reset-code', [
            'uses' => 'Api\Store\AuthController@confirmResetCode',
            'as'   => 'store-confirmResetCode'
        ] );
        Route::post( '/reset-password', [
            'uses' => 'Api\Store\AuthController@resetPassword',
            'as'   => 'store-resetPassword'
        ] );







 

        Route::get( '/terms_and_conditions', [
            'uses' => 'Api\ProfileController@terms_and_conditions',
            'as'   => 'terms_and_conditions'
        ] );

        Route::get( '/about_us', [
            'uses' => 'Api\ProfileController@about_us',
            'as'   => 'about_us'
        ] );
        Route::get( '/app_intro', [
            'uses' => 'Api\ProfileController@app_intro',
            'as'   => 'app_intro'
        ] );
        Route::get( '/get_payment_value', [
            'uses' => 'Api\UserController@get_payment_value',
            'as'   => 'get_payment_value'
        ] );
        Route::post( '/upload_excel_file', [
            'uses' => 'Api\UserController@upload_excel_file',
            'as'   => 'upload_excel_file'
        ] );



//================================ cash_point ==========================
// ========================  GENERAL ===========================
     //==========================countries ================================


Route::get('countries','Api\General\GeneralController@countries');


     // ====================== banks ========================


     Route::get('banks','Api\General\GeneralController@banks');


          // ====================== categories ========================


          Route::get('categories','Api\General\GeneralController@categories');


// ================== settings data ============================================

Route::get('general-data','Api\General\GeneralController@generalData');


// =========================== sliders ===========================
Route::get('general-slider','Api\General\GeneralController@generalSlider');

    });



//==================== visitors  && clients =================
Route::post('stores','Api\General\GeneralController@allStores');
Route::post('store','Api\General\GeneralController@store');
Route::post('all-stores','Api\General\GeneralController@stores');

    Route::group(['middleware' => ['auth:api', 'cors']], function () {


// ========================== store =====================================================


Route::post( '/change_password', [
    'uses' => 'Api\Store\AuthController@changePassword',
    'as'   => 'changePassword'
] );


Route::post('/change-phone-number', [
    'uses' => 'Api\Store\AuthController@change_phone_number',
    'as' => 'store_change_phone_number'
]);


Route::post('/check_code_change_phone', [
    'uses' => 'Api\Store\AuthController@check_code_changeNumber',
    'as' => 'store_check_code_change_email'
]);


Route::get('/get-all-data', 'Api\Store\AuthController@getAllData');

Route::post('/store-read-membership-num','Api\General\TransactionController@readMembershipNum');
Route::post('/store-read-qrcode','Api\General\TransactionController@readQrcode');
Route::post('/add-points','Api\General\TransactionController@addPoints');
Route::post('/confirm-transaction','Api\General\TransactionController@confirmTransaction');
Route::get('/my-profile','Api\Client\ClientController@myProfile');
Route::get('/last-login','Api\Store\StoreController@lastLogin');

Route::post('/contact-us','Api\General\GeneralController@contactUs');
// ==============================client app ===========================================
Route::post('client-edit-profile','Api\Client\AuthController@editProfile');
Route::post('client-rate','Api\General\TransactionController@clientRate');
Route::get('/qr-client-data/{phone}', 'Api\Client\AuthController@qrClientData');
Route::post('/suggest-store','Api\Client\SuggetionController@suggestStore');
Route::post('/replace-points','Api\Client\ClientController@replacePoints');



//========================store app ==============================
Route::post('store-edit-profile','Api\Store\StoreController@editProfile');
Route::post('add-sliders','Api\Store\SliderController@addSliders');
Route::post('edit-slider','Api\Store\SliderController@editSlider');
Route::post('delete-slider','Api\Store\SliderController@deleteSlider');
Route::get('sliders','Api\Store\SliderController@sliders');
Route::get('my-payments','Api\Store\StoreController@mypayments');
Route::post('pay-off-commissions','Api\Client\ClientController@payOffCommissions');
//==========================all transaction ===============================
Route::get('all-order','Api\General\TransactionController@allOrder');
        /*notification*/

        Route::get('list-notifications', 'Api\General\NotificationController@listNotification');
        Route::post('delete_Notification', 'Api\General\NotificationController@deleteNotification');

        Route::post( '/contact_us', [
            'uses' => 'Api\ProfileController@contact_us',
            'as'   => 'contact_us'
        ] );
        Route::post( '/user_change_data', [
            'uses' => 'Api\AuthController@change_email',
            'as'   => 'user_change_data'
        ] );
        Route::post( '/user_check_code_change_email', [
            'uses' => 'Api\AuthController@check_code_changeNumber',
            'as'   => 'user_check_code_change_email'
        ] );
        /*notification*/

        Route::get( '/get_my_subscription', [
            'uses' => 'Api\ProfileController@get_my_subscription',
            'as'   => 'get_my_subscription'
        ] );

        //=============================   Use payment  route   ==============
        Route::post( '/user_converted_to_paid', [
            'uses' => 'Api\UserController@postPayment',
            'as'   => 'user_converted_to_paid'
        ] );


        //============================  backup routes ====================================
        Route::post( '/create_backup', [
            'uses' => 'Api\BackupController@create_backup',
            'as'   => 'create_backup'
        ] );
        Route::get( '/get_backups', [
            'uses' => 'Api\BackupController@get_backups',
            'as'   => 'get_backups'
        ] );
        Route::post( '/store_backup_data/{id}', [
            'uses' => 'Api\BackupController@store_backup_data',
            'as'   => 'store_backup_data'
        ] );
        Route::post( '/create_class/{backup_id}', [
            'uses' => 'Api\BackupController@create_class',
            'as'   => 'create_class'
        ] );
        Route::post( '/create_student/{class_id}', [
            'uses' => 'Api\BackupController@create_student',
            'as'   => 'create_student'
        ] );
        Route::post( '/create_subject/{class_id}', [
            'uses' => 'Api\BackupController@create_subject',
            'as'   => 'create_subject'
        ] );
        Route::get( '/get_backup_data/{id}', [
            'uses' => 'Api\BackupController@get_backup_data',
            'as'   => 'get_backup_data'
        ] );
        //============================  backup routes ====================================
//    ===========refreshToken ====================

        Route::post('/refresh-device-token', [
            'uses' => 'Api\DetailsController@refreshDeviceToken',
            'as'   => 'refreshDeviceToken'
        ] );
        Route::post('/refreshToken', [
            'uses' => 'Api\DetailsController@refreshToken',
            'as'   => 'refreshToken'
        ] );
        //===============   logout   ========================

        Route::post('/logout', [
            'uses' => 'Api\AuthController@logout',
            'as'   => 'logout'
        ] );






    });


    //======================user app ====================
    Route::group(['middleware' => ['auth:api', 'cors']], function () {

        /*notification*/
        Route::get('/user-list-notifications', 'Api\ApiController@listNotifications');
        Route::post('/user-delete_Notifications/{id}', 'Api\ApiController@delete_Notifications');


        /*notification*/

        // order ============
        Route::post('/order', 'Api\OrderController@order_post');
        Route::get('/user-accept-offer/{id}', 'Api\OrderController@accept_sawaq_offers_price');
        Route::get('/user-refuse-offer/{id}', 'Api\OrderController@delete_sawaq_offers_price');
        Route::get('/offers', 'Api\ProfileController@sawaq_offers_price');
        Route::get('/get-order', 'Api\ProfileController@my_order');
        Route::get('/get-driver/{id}', 'Api\SawaqController@get_driver');
        Route::get('/get-user/{id}', 'Api\SawaqController@get_user');

        Route::get('/order-details/{id}', 'Api\ProfileController@order_details');
        Route::get('/order-offer/{id}', 'Api\ProfileController@order_offers');
        Route::post('/rate-driver/{id}', 'Api\ProfileController@rate_driver_user');




        //===============logout========================

        Route::post('/user-logout', [
            'uses' => 'Api\AuthUserController@logout',
            'as'   => 'user-logout'
        ] );




    });

});
