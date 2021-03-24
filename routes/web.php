<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
//    \Illuminate\Support\Facades\Artisan::call('check::commission');
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
/*admin panel routes*/

Route::get('/check-status/{id?}/{id1?}', 'Api\Client\ClientController@fatooraStatus');

Route::get('/fatoora/success', function(){
    return view('fatoora');
})->name('fatoora-success');

Route::get('/admin/home', ['middleware'=> 'auth:admin', 'uses'=>'AdminController\HomeController@index'])->name('admin.home');

Route::get('remove_about_photo/{id}', 'AdminController\PageController@remove_about_photo')->name('imageAboutRemove');
Route::get('remove_intro_photo/{id}', 'AdminController\PageController@remove_intro_photo')->name('imageIntroRemove');


Route::prefix('admin')->group(function () {

    Route::get('login', 'AdminController\Admin\LoginController@showLoginForm')->name('admin.login');
    Route::post('login', 'AdminController\Admin\LoginController@login')->name('admin.login.submit');
    Route::get('password/reset', 'AdminController\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('password/email', 'AdminController\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::get('password/reset/{token}', 'AdminController\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');
    Route::post('password/reset', 'AdminController\Admin\ResetPasswordController@reset')->name('admin.password.update');
    Route::post('logout', 'AdminController\Admin\LoginController@logout')->name('admin.logout');

    Route::get('get/regions/{id}', 'AdminController\HomeController@get_regions');



    Route::group(['middleware'=> ['web','auth:admin']],function(){

        Route::get('setting','AdminController\SettingController@index')->name('settings.index');
        Route::post('add/settings','AdminController\SettingController@store');



        Route::get('pages/about','AdminController\PageController@about');
        Route::post('add/pages/about','AdminController\PageController@store_about');


        Route::get('pages/terms','AdminController\PageController@terms');
        Route::post('add/pages/terms','AdminController\PageController@store_terms');


        //==================================== banks ===================================================
        Route::resource('banks', 'AdminController\BankController');
        Route::get('delete/{id}/bank','AdminController\BankController@destroy');




//=================================== replace point :bank =>Confirming
Route::get('/comfirm-bank-replacementpoint','AdminController\ReplacementController@comfirmReplacement')->name('replacement_confirmingBank');
Route::get('/uncomfirm-bank-replacementpoint','AdminController\ReplacementController@uncomfirmReplacement')->name('replacement_unconfirmingBank');
Route::get('confirmation/{id}', 'AdminController\ReplacementController@is_confirm')->name('confirm_bank');

        // =============== change logo ==================================
        Route::get('/change-logo', 'AdminController\SettingController@changeLogo')->name('change_logo');
        Route::post('change-logo', 'AdminController\SettingController@LogoImage')->name('changeLogo.store');

        // =============================== suggestions =============================================
        Route::get('/suggestions','AdminController\SuggestionController@index')->name('suggestions.index');
        Route::get('delete/{id}/suggestion','AdminController\SuggestionController@destroy');


        // =============================== contacts =============================================
        Route::get('/contacts','AdminController\ContactController@index')->name('contacts.index');
        Route::get('delete/{id}/contact','AdminController\ContactController@destroy');

        //==================================== members ===================================================
        Route::resource('members', 'AdminController\MemberController');
        Route::get('delete/{id}/member','AdminController\MemberController@destroy');
        

        //==================================== countries ===================================================
            Route::resource('countries', 'AdminController\CountryController');
            Route::get('delete/{id}/country','AdminController\CountryController@destroy');



        //==================================== Categories ===================================================
        Route::resource('categories', 'AdminController\CategoryController');
        Route::get('delete/{id}/category','AdminController\CategoryController@destroy');




         //==================================== sliders ===================================================
          Route::resource('sliders', 'AdminController\SliderController');
         Route::get('delete/{id}/slider','AdminController\SliderController@destroy');

 //========================== users:stores ==================================
 Route::get('users/stores','AdminController\UserController@index');
 Route::get('add/store','AdminController\UserController@create');
 Route::post('add/store','AdminController\UserController@store');
 Route::get('edit/store/{id}','AdminController\UserController@edit');
 Route::post('update/store/{id}','AdminController\UserController@update');
 Route::post('update/privacy/{id}','AdminController\UserController@update_privacy');
 Route::post('update/pass/{id}','AdminController\UserController@update_pass');
 Route::post('update/remainInfo/{id}','AdminController\UserController@remainInfo');

 Route::get('edit/userAccount/{id}','AdminController\UserController@edit_account');
 Route::post('update/userAccount/{id}','AdminController\UserController@update_account');



 Route::get('delete/{id}/user','AdminController\UserController@destroy');




        // ============= send notifications =========================
        Route::get('general-notifications', 'AdminController\NotificationController@generalNotificationPage')->name('notifications.generalPage');
        Route::post('general-notificationsSend', 'AdminController\NotificationController@generalNotification')->name('notifications.general');
        Route::get('category-notifications', 'AdminController\NotificationController@categoryNotificationPage')->name('notifications.categoryPage');
        Route::post('category-notificationsSend', 'AdminController\NotificationController@categoryNotification')->name('notifications.category');
        Route::get('user-notifications', 'AdminController\NotificationController@userNotificationPage')->name('notifications.userPage');
        Route::post('user-notificationsSend', 'AdminController\NotificationController@userNotification')->name('notifications.user');



 

        //============================= Start Payment Value ======================================
        Route::get('payment_value/create','AdminController\PageController@create')->name('payment_value');
        Route::post('payment_value/store','AdminController\PageController@store')->name('storePayment_value');
        //============================= End Payment Value ======================================


        Route::get('parteners','AdminController\SettingController@parteners')->name('parteners');

//        ===================================users============================================

        Route::get('users','AdminController\UserController@index');
        Route::get('add/user','AdminController\UserController@create');
        Route::post('add/user','AdminController\UserController@store');
        Route::get('edit/user/{id}','AdminController\UserController@edit');
        Route::get('edit/userAccount/{id}','AdminController\UserController@edit_account');
        Route::post('update/userAccount/{id}','AdminController\UserController@update_account');
        Route::post('update/user/{id}','AdminController\UserController@update');
        Route::post('update/pass/{id}','AdminController\UserController@update_pass');
        Route::post('update/privacy/{id}','AdminController\UserController@update_privacy');
        Route::get('delete/{id}/user','AdminController\UserController@destroy');
//        ===========================school===========================================

        Route::get('school','AdminController\SchoolController@index');
        Route::get('add/school','AdminController\SchoolController@create');
        Route::post('add/school','AdminController\SchoolController@store');
        Route::get('edit/school/{id}','AdminController\SchoolController@edit');
        Route::post('update/school/{id}','AdminController\SchoolController@update');
        Route::get('delete/{id}/school','AdminController\SchoolController@destroy');

        Route::get('intros','AdminController\IntroController@index')->name('Intro');
        Route::get('add/intros','AdminController\IntroController@create')->name('createIntro');
        Route::post('add/intros','AdminController\IntroController@store')->name('storeIntro');
        Route::get('edit/intros/{id}','AdminController\IntroController@edit')->name('editIntro');
        Route::post('update/intros/{id}','AdminController\IntroController@update')->name('updateIntro');
        Route::get('delete/{id}/intros','AdminController\IntroController@destroy')->name('deleteIntro');


       // ======================================== Admin Email ============================================
        Route::get('edit/admin_email','AdminController\SettingController@edit')->name('editAdminEmail');
        Route::post('update/admin_email/{id}','AdminController\SettingController@update')->name('updateAdminEmail');

        //===============================================================


        // Admins Route
        Route::resource('admins', 'AdminController\AdminController');

        Route::get('/profile', [
            'uses' => 'AdminController\AdminController@my_profile',
            'as' => 'my_profile' // name
        ]);
        Route::post('/profileEdit', [
            'uses' => 'AdminController\AdminController@my_profile_edit',
            'as' => 'my_profile_edit' // name
        ]);
        Route::get('/profileChangePass', [
            'uses' => 'AdminController\AdminController@change_pass',
            'as' => 'change_pass' // name
        ]);
        Route::post('/profileChangePass', [
            'uses' => 'AdminController\AdminController@change_pass_update',
            'as' => 'change_pass' // name
        ]);

        Route::get('/admin_delete/{id}', [
            'uses' => 'AdminController\AdminController@admin_delete',
            'as' => 'admin_delete' // name
        ]);

    });



});
