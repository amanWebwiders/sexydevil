<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('front.index');
// });

Route::prefix('/admin')->name('admin.')->namespace('App\Http\Controllers\Admin')->group(function () {
    Route::get('/', 'AuthController@login')->name('login');
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::post('/do-login', 'AuthController@doLogin')->name('do-login');
    Route::get('/forgot-password', 'AuthController@forgotPassword')->name('forgot-password');
    Route::post('/send-password', 'AuthController@sendPassword')->name('send-password');

    Route::middleware(['adminauth'])->group(function () {
        Route::resource('agencies', 'AgencyController');
        // Inside your admin route group
        Route::delete('agencies/media/{id}', 'AgencyController@deleteMedia')->name('agencies.media.delete');

        Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/my-profile', 'DashboardController@myProfile')->name('my-profile');
        Route::get('/update-password', 'DashboardController@adminPassword')->name('update-password');
        Route::post('/change-password', 'DashboardController@changePassword')->name('change-password');
        Route::post('/profile-update', 'DashboardController@updateProfile')->name('profile-update');
        Route::get('/edit-profile', 'DashboardController@editProfile')->name('edit-profile');
        Route::get('contact-list', 'DashboardController@contactList')->name('contact-list');
        Route::post('/contact/status/{id}', 'DashboardController@updateStatus')->name('contact-status');

        Route::get('/occupation', 'OccupationController@index')->name('occupation');
        Route::post('/submit-occupation', 'OccupationController@storeOccupation')->name('storeOccupation');

        Route::get('/user-list', 'UserController@index')->name('user');
        Route::get('/incomingadvertiser-list', 'UserController@advertiseList')->name('incoming.advertiser');
        Route::get('/advertiser-list', 'UserController@advertiseapproveList')->name('advertiser');
        Route::post('/users/block/{id}', 'UserController@block')->name('users.block');
        Route::post('/users/unblock/{id}', 'UserController@unblock')->name('users.unblock');
        Route::post('/submit-user', 'UserController@store')->name('submit-user');
        Route::get('/user-deatil/{id}', 'UserController@show')->name('userdetail');
        Route::post('/users/accept/{id}', 'UserController@accept')->name('users.accept');
        Route::post('/users/reject/{id}', 'UserController@reject')->name('users.reject');
        Route::post('/users/delete/{id}', 'UserController@delete')->name('users.delete');
        Route::get('/user/{id}/edit', 'UserController@showDetail')->name('edit-user');
        Route::patch('/user/update/{id}', 'UserController@update')->name('update-user');
        Route::post('/purchase-plan', 'UserController@planAssign')->name('purchase.plan');

        // Route::post('user/{id}', 'UserController@delete')->name('userdelete');
        // Route::get('/client-list', 'UserController@clientList')->name('client');
        // Route::get('/client-detail/{id}', 'UserController@clientDetail')->name('client-detail');
        Route::get('/transaction-history', 'UserController@transactionHistory')->name('transaction-history');
        Route::get('/boost-transaction-history', 'UserController@boosttransactionHistory')->name('boost-transaction-history');
        Route::post('photos/upload', 'UserController@uploadPhoto')->name('photos.upload');
        Route::post('/photo/delete', 'UserController@deletePhoto')->name('photo.delete');
        Route::post('video/upload', 'UserController@uploadVideo')->name('videos.upload');
        Route::post('/delete-video', 'UserController@deleteVideo')->name('video.delete');
        Route::post('/availability/save', 'UserController@saveAvailability')->name('availability.save');
        Route::post('/rate/save', 'UserController@saveRate')->name('rate.save');
        /* Admin Boost*/
        Route::get('/boost-users', 'BoostController@index')->name('boost.index');
        Route::post('fetchModels', 'BoostController@fetchModels')->name('fetchModels');
        Route::post('addFeatureDevil', 'BoostController@addFeatureDevil')->name('addFeatureDevil');
        Route::post('fetchFeatureDevils', 'BoostController@fetchFeatureDevils')->name('fetchFeatureDevils');
        Route::match(["get", "post"],'manually-boost-request', 'BoostController@manuallyBoostRequest')->name('manually-boost-request');
        Route::match(["get", "post"],'manually-boost-request-action', 'BoostController@manuallyBoostRequestAction')->name('manually-boost-request-action');
        //plan 
        Route::get('plan', 'PlanController@get')->name('plan');
        Route::post('priceHideShow', 'PlanController@priceHideShow')->name('priceHideShow');
        Route::post('plan/{id}', 'PlanController@delete')->name('plandelete');
        Route::post('plan', 'PlanController@add')->name('plan.add');
        Route::patch('plan/edit/{id}', 'PlanController@update')->name('plan.update');
        Route::get('plan/{id}', 'PlanController@show')->name('plan.show');
        /* Terms & conditions */
        Route::get('terms-conditions', 'TermsConditionsController@adminTerms')->name('terms-conditions');
        Route::get('privacy-policy', 'TermsConditionsController@adminPrivacy')->name('privacy-policy');
        Route::get('contact-page-content', 'TermsConditionsController@contactPageContent')->name('contact-page-content');
        Route::get('location-seo-content', 'TermsConditionsController@locationSeoContent')->name('location-seo-content');
        Route::post('location-seo-content', 
        'TermsConditionsController@locationSeoContentStore')->name('location-seo-content');

        Route::post('get-location-seo-content', 
        'TermsConditionsController@getLocationSeoContent')->name('get-location-seo-content');

        Route::get('getStates', 'TermsConditionsController@loadStates')->name('get-states');
        Route::get('getCities', 'TermsConditionsController@loadCities')->name('get-cities');

        Route::post('terms-conditions-update', 'TermsConditionsController@adminTermsUpdate')->name('terms-conditions-update');
        Route::post('contact-page-content-action', 'TermsConditionsController@contactPageContentUpdate')->name('contact-page-content-action');
        /* Image / video approval*/
         Route::match(["get", "post"],'image-approval', 'ImageVideoApprovalController@ImageApproval')->name('image-approval');
         Route::match(["get", "post"],'image-approval-action', 'ImageVideoApprovalController@ImageApprovalAction')->name('image-approval-action');

         Route::match(["get", "post"], 'video-approval', 'ImageVideoApprovalController@VideoApproval')->name('video-approval');
         Route::match(["get", "post"], 'video-approval-action', 'ImageVideoApprovalController@VideoApprovalAction')->name('video-approval-action');
         Route::match(["get", "post"], 'video-convert', 'ImageVideoApprovalController@VideoConvert')->name('video-convert');
    });
});

//Front Route Module 
Route::namespace('App\Http\Controllers\Front')->group(function () {
    //Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/', 'HomeController@landing')->name('landing');

    Route::get('/user-login', 'HomeController@Login')->name('user-login');
    Route::get('/user-signup', 'HomeController@Signup')->name('signup');
    Route::get('/user-signupadvertiser', 'HomeController@SignupAdveriser')->name('user-signupadvertiser');
    Route::get('/user-forgot-password', 'HomeController@userForgotPassword')->name('user-forgot-password');
    Route::get('/about-us', 'HomeController@aboutUs')->name('about-us');
    Route::get('/contact-us', 'HomeController@contactUs')->name('contact-us');
    Route::post('/user.register', 'HomeController@Register')->name('user.register');
    Route::get('/get-states/{country_id}', 'DashboardController@getStates')->name(name: 'getstates');
    Route::get('/get-cities/{state_id}', 'DashboardController@getCities')->name('getcities');
    Route::get('/get-citiesbycountry/{country_id}', 'DashboardController@getCitiesCountry')->name('getcitiesCountry');
    Route::get('/getcurrency/{id}', 'DashboardController@getCurrency')->name('getcurrency');
    Route::get('/reels/{city?}', 'NewStoryController@reels')->name('reels');
    Route::post('/reels', 'NewStoryController@reelSearch')->name('home.reels');

    Route::get('/getsubcategory/{category_id}', 'DashboardController@getSubCategory')->name('getsubcategory');
    Route::match(['get', 'post'],'/model-search/{city?}', 'ModelController@search')->name('model.search');
    Route::get('/terms-condition', 'HomeController@termsConditions')->name('terms');
    Route::get('/get-cities-users', 'HomeController@getCitiesUsers')->name('getCitiesUsers');

    /* Route::get('/terms-condition', function () {
        return view('front.terms'); // users/terms.blade.php
    })->name('terms'); */

    Route::post('/review/store', 'ModelController@storeReview')->name('review.store');
    Route::post('/chunk-upload', 'NewStoryController@chunkUpload')->name('chunk.upload');
    Route::post('/comments', 'NewStoryController@commentstore')->name('comments.store');
    Route::post('/toggle-like', 'NewStoryController@toggleLike')->name('like.toggle');
    Route::post('/comments/{id}/like', 'NewStoryController@like')->name('comments.like');
    Route::post('/comments/{id}/reply', 'NewStoryController@reply')->name('comments.reply');
    Route::match(['get', 'post'], '/new-escorts/{city?}', 'ModelController@newEscort')->name('new.escorts');
    Route::match(['get', 'post'], '/active-escorts/{city?}', 'ModelController@activeEscort')->name('active.escorts');
    Route::match(['get', 'post'], '/lowcost-escorts/{city?}', 'ModelController@lowcostEscort')->name('lowcost.escorts');
    Route::match(['get', 'post'], '/recommend-escorts/{city?}', 'ModelController@recommendEscort')->name('recommend.escorts');
    Route::get('/sitemap.xml', 'SitemapController@index')->name('sitemap');
    Route::get('/robots.txt', function () {
        $robotsPath = public_path('robots.txt');
        if (file_exists($robotsPath)) {
            return response(file_get_contents($robotsPath), 200)
                ->header('Content-Type', 'text/plain');
        }
        return response("User-agent: *\nDisallow: /admin\nSitemap: " . url('/sitemap.xml'), 200)
            ->header('Content-Type', 'text/plain');
    })->name('robots');

    // Legacy & Alias 301 Redirects for Technical SEO & GSC
    Route::get('/home', fn() => redirect()->to(url('/'), 301));
    Route::get('/terms-and-conditions', fn() => redirect()->to(route('terms'), 301));
    Route::get('/terms-conditions', fn() => redirect()->to(route('terms'), 301));
    Route::get('/gallery', fn() => redirect()->to(route('reels'), 301));
});

Route::get('/user-email-verify', 'App\Http\Controllers\Front\UserAuthController@userEmailVerify')->name('user-email-verify');
Route::get('/choose', 'App\Http\Controllers\Front\UserAuthController@choose')->name('choose');
Route::post('/resend-verification', 'App\Http\Controllers\Front\UserAuthController@resendVerification')->name('resend-verification');


Route::prefix('/user')->name('user.')->namespace('App\Http\Controllers\Front')->group(function () {
    Route::post('/login', 'HomeController@loginSubmit')->name('loginSubmit');
    Route::post('/send-password', 'HomeController@sendPassword')->name('send-password');
    Route::post('contact', 'HomeController@saveContactusUserData')->name('contact.store');
    Route::get('profile/{id}', 'HomeController@modelDetail')->name('profile.show')->middleware('block.countries');
    Route::get('/agencies/{city?}', 'AgencyController@index')->name('agencies');
    Route::get('/agency-detail/{id}', 'AgencyController@detail')->name('agency-detail');
    Route::post('/favourite-submit', 'UserAuthController@wishlistSubmit')->name('wishlistSubmit');
    Route::get('/user-email-verification/{token}', 'App\Http\Controllers\Front\UserAuthController@userEmailVerification')->name('user-email-verification');
    Route::middleware(['user'])->group(function () {

        Route::get('/email-verification', 'App\Http\Controllers\Front\UserAuthController@emailVerification')->name('email-verification');

        // Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('/edit-profile', 'DashboardController@profile')->name('profile');
        Route::get('/logout', 'HomeController@logout')->name('logout');
        Route::get('/my-application', 'HomeController@application')->name('my-application');
        Route::get('/update-password', 'DashboardController@Password')->name('update-password');
        Route::post('/change-password', 'HomeController@changePassword')->name('change-password');
        Route::post('/update-profile', 'DashboardController@updateProfile')->name('update-profile');
        Route::get('/logout', 'UserAuthController@logout')->name('logout');
        Route::get('/pricing-af', 'HomeController@pricingAfter')->name('pricing-af');
        Route::get('/pricing', 'HomeController@pricing')->name('pricing');
        Route::get('/waiting', 'HomeController@waiting')->name('waiting');
        Route::post('/purchase-plan', 'UserAuthController@purchasePlan')->name('purchase.plan');
        Route::get('/photo', 'DashboardController@Photo')->name('photo');
        Route::post('photos/upload', 'DashboardController@uploadPhoto')->name('photos.upload');
        Route::post('photos/updateOrder', 'DashboardController@updatePhotoOrder')->name('photos.updateOrder');
        Route::post('/photo/hideShowImage', 'DashboardController@hideShowImage')->name('photo.hideShowImage');
        Route::post('/photo/markAsProfile', 'DashboardController@markAsProfile')->name('photo.markAsProfile');
        Route::post('/photo/delete', 'DashboardController@delete')->name('photo.delete');
        Route::get('/video', 'DashboardController@Video')->name('video');
        Route::post('video/upload', 'DashboardController@uploadVideo')->name('videos.upload');
        Route::post('/delete-video', 'DashboardController@deleteVideo')->name('video.delete');
        Route::get('/availabilities', 'DashboardController@Availabilities')->name('availabilities');
        Route::post('/availability/save', 'DashboardController@saveAvailability')->name('availability.save');
        Route::get('/rate', 'DashboardController@Rate')->name('rate');
        Route::post('/rate/save', 'DashboardController@saveRate')->name('rate.save');
        Route::get('/favourite-list', 'UserAuthController@favouriteList')->name('favouriteList');
        Route::get('/manually-boost', 'UserAuthController@manuallyBoost')->name('manually-boost');
        Route::post('/manually-boost', 'UserAuthController@manuallyBoostRequestStore')->name('manually-boost.post');
        Route::get('/boost-my-profile', 'UserAuthController@manuallyBoostProcess')->name('boost-my-profile');


        Route::post('/remove-all-favourites', 'UserAuthController@removeAllFavourites')->name('removeAllFavourites');
        Route::get('/news-stories', 'NewStoryController@index')->name('newsStories');
        Route::post('/newsStories.store', 'NewStoryController@newsStoriesSave')->name('newsStories.store');
        Route::post('/news/delete', 'NewStoryController@destroy')->name('news.destroy');
        Route::post('/boost-activate', 'UserAuthController@ajaxBoostActivate')->name('boost.activate');
    });
});
Route::namespace('App\Http\Controllers\Front')->group(function () {
    Route::get('/{city?}', 'HomeController@index')->name('home');
});