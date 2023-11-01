<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ArtistController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArtistLogController;
use App\Http\Controllers\WahArtistController;
use App\Http\Controllers\WahServiceController;
use App\Http\Controllers\UserBookingController;
use App\Http\Controllers\WahCategoryController;
use App\Http\Controllers\WahLocationController;
use App\Http\Controllers\ArtistStatusController;
use App\Http\Controllers\AssignArtistController;
use App\Http\Controllers\TodaysBookingController;
use App\Http\Controllers\WahSubServiceController;
use App\Http\Controllers\WahServicePriceController;
use App\Http\Controllers\WahBookingActionController;
use App\Http\Controllers\WahArtistEquipmentController;
use App\Http\Controllers\WahArtistWwuRequestController;

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




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user', [UserController::class, 'index'])->name('user.list');
    Route::get('/user/status/{id}', [UserController::class, 'status'])->name('user.status');


    Route::get('/wah/dashboard/data',[UserBookingController::class, 'index'])->name('bookings');
    Route::get('wah-artist', [WahArtistController::class,'index'])->name('wah.artist');
    Route::get('wah-artist/log', [ArtistLogController::class,'index'])->name('wah.artist.log');
    Route::get('wah/user-details/{user_id}', [ArtistController::class,'userDetails'])->name('wah.user.details');
    Route::get('wah-artist-details/{id}', [WahArtistController::class,'artistDetails'])->name('wah.artist.details');
    Route::get('wah-artist/assign/{order_id}', [AssignArtistController::class,'showArtist'])->name('wah.artist.assign');
    Route::get('wah/pre-booking-image/{order_id}', [ArtistController::class,'preBookingImage'])->name('wah.pre.booking.images');
    Route::get('wah-artist/assign/send-notification/{order_id}', [AssignArtistController::class,'sendNotification'])->name('wah.artist.assign.send.notification');
    Route::get('wah/user/booking', [ArtistController::class,'bookings'])->name('wah.bookings');
    Route::get('wah/user/booking/reschedule/{id}', [ArtistController::class,'rescheduleBooking'])->name('wah.bookings.reschedule');
    Route::get('wah/user/booking/action/{order_id}', [ArtistController::class,'bookingAction'])->name('wah.booking.action');
    Route::patch('wah/user/booking/reschedule/update', [ArtistController::class,'updateRescheduleBooking'])->name('wah.bookings.reschedule.update');

    Route::post('wah/booking/action/artist-status/{order_id}', [WahBookingActionController::class,'updateArtistAction'])->name('wah.booking.artist.action');
    Route::post('wah/booking/action/booking-status/{order_id}', [WahBookingActionController::class,'updateBookingAction'])->name('wah.booking.status.action');

    Route::get('/wah/user/booking/filter', [ArtistController::class,'wahBookingFilter'])->name('wah.bookings.filter');
    Route::get('wah-artist/location', [WahLocationController::class,'index'])->name('wah.location');

    Route::get('wah-artist/location/edit/{id}', [WahLocationController::class,'edit'])->name('wah.location.edit');
    Route::get('wah-artist/location/delete/{id}', [WahLocationController::class,'delete'])->name('wah.location.delete');
    Route::post('wah-artist/location/store', [WahLocationController::class,'store'])->name('wah.location.store');
    Route::patch('wah-artist/location/update/{id}', [WahLocationController::class,'update'])->name('wah.location.update');

    Route::get('wah-category', [WahCategoryController::class,'index'])->name('wah.category');
    Route::get('wah-category/edit/{id}', [WahCategoryController::class,'edit'])->name('wah.category.edit');
    Route::get('wah-category/delete/{id}', [WahCategoryController::class,'delete'])->name('wah.category.delete');
    Route::post('wah-category/store', [WahCategoryController::class,'store'])->name('wah.category.store');
    Route::patch('wah-category/update/{id}', [WahCategoryController::class,'update'])->name('wah.category.update');

    Route::get('wah-service', [WahServiceController::class,'index'])->name('wah.service');
    Route::get('wah-service/ps/{id}', [WahServiceController::class,'updatePS'])->name('wah.service.update.ps');
    Route::post('wah-service/store', [WahServiceController::class,'store'])->name('wah.service.store');
    Route::get('wah-service/edit/{id}', [WahServiceController::class,'edit'])->name('wah.service.edit');
    Route::get('wah-service/delete/{id}', [WahServiceController::class,'delete'])->name('wah.service.delete');
    Route::patch('wah-service/update/{id}', [WahServiceController::class,'update'])->name('wah.service.update');


    Route::get('wah-sub-services', [WahSubServiceController::class,'index'])->name('wah.sub.services');
    Route::get('wah-sub-services/edit/{id}', [WahSubServiceController::class,'edit'])->name('wah.sub.services.edit');
    Route::get('wah-sub-services/delete/{id}', [WahSubServiceController::class,'delete'])->name('wah.sub.services.delete');
    Route::post('wah-sub-services/store', [WahSubServiceController::class,'store'])->name('wah.sub.services.store');
    Route::patch('wah-sub-services/update/{id}', [WahSubServiceController::class,'update'])->name('wah.sub.services.update');

    Route::get('wah-artist/equipment', [WahArtistEquipmentController::class,'index'])->name('wah.equipment');
    Route::get('wah-artist/equipment/edit/{id}', [WahArtistEquipmentController::class,'edit'])->name('wah.equipment.edit');
    Route::get('wah-artist/equipment/delete/{id}', [WahArtistEquipmentController::class,'delete'])->name('wah.equipment.delete');
    Route::post('wah-artist/equipment/store', [WahArtistEquipmentController::class,'store'])->name('wah.equipment.store');
    Route::patch('wah-artist/equipment/update/{id}', [WahArtistEquipmentController::class,'update'])->name('wah.equipment.update');


    Route::get('wah-artist/wwu-request', [WahArtistWwuRequestController::class,'index'])->name('wah.artist.wwu');

    Route::get('artist-on-map', [ArtistController::class,'showAllArtistInMap'])->name('wah.artist.on.map');

    Route::get('wah/payment/status', [PaymentController::class,'index'])->name('pay-status');
    Route::get('wah/payment/status/{id}', [PaymentController::class,'index']);
    Route::get('wah/payment/check', [PaymentController::class,'checkpaymentStatus'])->name('check-status');
    Route::post('wah/payment/update', [PaymentController::class,'updatePaymentStatus'])->name('pay-update');

    Route::get('wah-artist/service-price/{sub_service_id}', [WahServicePriceController::class,'index'])->name('wah.service.price');
    Route::get('wah-artist/service-price/delete/{id}', [WahServicePriceController::class,'delete'])->name('wah.service.price.delete');
    Route::get('wah-artist/service-price/edit/{id}', [WahServicePriceController::class,'edit'])->name('wah.service.price.edit');
    Route::post('wah-artist/service-price/store', [WahServicePriceController::class,'store'])->name('wah.service.price.store');
    Route::patch('wah-artist/service-price/update/{id}', [WahServicePriceController::class,'update'])->name('wah.service.price.update');

    Route::get('wah-artist', [WahArtistController::class,'index'])->name('wah.artist');
    Route::get('wah-artist/delete/{id}', [WahArtistController::class,'softDelete'])->name('wah.artist.delete');
    Route::get('wah-artist/force-delete/{id}', [WahArtistController::class,'delete'])->name('wah.artist.force.delete');
    Route::get('wah-artist/re-store/{id}', [WahArtistController::class,'restore'])->name('wah.artist.restore');
    Route::get('wah-artist-details/{id}', [WahArtistController::class,'artistDetails'])->name('wah.artist.details');
    Route::get('wah-artist/create/step-one/{id?}', [WahArtistController::class,'createStepOne'])->name('wah.artist.create');
    Route::get('wah-artist/create/step-two/{id}', [WahArtistController::class,'createStepTwo'])->name('wah.artist.create.step.two');
    Route::get('wah-artist/create/step-three/{id}', [WahArtistController::class,'createStepThree'])->name('wah.artist.create.step.three');
    Route::get('wah-artist/create/step-four/{id}', [WahArtistController::class,'createStepFour'])->name('wah.artist.create.step.four');
    Route::get('wah-artist/create/step-fifth/{id}', [WahArtistController::class,'createStepFive'])->name('wah.artist.create.step.five');
    Route::get('wah-artist/update/status/{id}', [WahArtistController::class,'updateArtistStatus'])->name('wah.artist.update.status');
    Route::get('wah-artist/update/is-booking-status/{id}', [WahArtistController::class,'updateArtistIsBookingStatus'])->name('wah.artist.update.is.booking.status');
    Route::patch('wah-artist/store-step-one-update/{id}', [WahArtistController::class,'storeStepOneUpdate'])->name('wah.artist.store.step.one.update');

    // Artist status module
    Route::post('wah-artist/block/{artist_id}', [ArtistStatusController::class,'blockArtist'])->name('wah.block.artist');
    Route::post('wah-artist/block/update/{artist_id}', [ArtistStatusController::class,'updateBlockArtist'])->name('wah.update.block.artist');
    Route::get('wah-artist/block/un-block/{artist_id}', [ArtistStatusController::class,'unBlockArtist'])->name('wah.un.block.artist');
});

require __DIR__ . '/auth.php';
