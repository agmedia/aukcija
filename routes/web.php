<?php

use App\Actions\Fortify\ForgotPasswordController;
use App\Http\Controllers\Back\Catalog\AttributesController;
use App\Http\Controllers\Back\Catalog\GroupsController;
use App\Http\Controllers\Back\Catalog\AuctionController;
use App\Http\Controllers\Back\Catalog\BidController;
use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Back\Marketing\BlogController;
use App\Http\Controllers\Back\Settings\App\CurrencyController;
use App\Http\Controllers\Back\Settings\App\GeoZoneController;
use App\Http\Controllers\Back\Settings\App\OrderStatusController;
use App\Http\Controllers\Back\Settings\App\PaymentController;
use App\Http\Controllers\Back\Settings\App\ShippingController;
use App\Http\Controllers\Back\Settings\App\TaxController;
use App\Http\Controllers\Back\Settings\FaqController;
use App\Http\Controllers\Back\Settings\HistoryController;
use App\Http\Controllers\Back\Settings\PageController;
use App\Http\Controllers\Back\Settings\QuickMenuController;
use App\Http\Controllers\Back\Settings\SettingsController;
use App\Http\Controllers\Back\Settings\SystemController;
use App\Http\Controllers\Back\UserController;
use App\Http\Controllers\Back\Widget\WidgetController;
use App\Http\Controllers\Back\Widget\WidgetGroupController;
use App\Http\Controllers\Front\CatalogRouteController;
use App\Http\Controllers\Front\CustomerController;
use App\Http\Controllers\Front\HomeController;
use Illuminate\Support\Facades\Route;


/*******************************************************************************
*                                Copyright : AGmedia                           *
*                              email: filip@agmedia.hr                         *
*******************************************************************************/

/**
 * BACK ROUTES
 */
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified', \App\Http\Middleware\NoCustomer::class])->prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CATALOG
    Route::prefix('catalog')->group(function () {
        // KATEGORIJE
        Route::get('auctions', [AuctionController::class, 'index'])->name('auctions');
        Route::get('auction/create', [AuctionController::class, 'create'])->name('auctions.create');
        Route::post('auction', [AuctionController::class, 'store'])->name('auctions.store');
        Route::get('auction/{auction}/edit', [AuctionController::class, 'edit'])->name('auctions.edit');
        Route::patch('auction/{auction}', [AuctionController::class, 'update'])->name('auctions.update');
        Route::delete('auction/{auction}', [AuctionController::class, 'destroy'])->name('auctions.destroy');
        // PONUDE
        Route::get('bids', [BidController::class, 'index'])->name('bids');
        Route::get('bid/create', [BidController::class, 'create'])->name('bids.create');
        Route::post('bid', [BidController::class, 'store'])->name('bids.store');
        Route::get('bid/{bid}/edit', [BidController::class, 'edit'])->name('bids.edit');
        Route::patch('bid/{bid}', [BidController::class, 'update'])->name('bids.update');
        Route::delete('bid/{bid}', [BidController::class, 'destroy'])->name('bids.destroy');
        // Atttributes
        Route::get('attributes', [AttributesController::class, 'index'])->name('attributes');
        Route::get('attribute/create', [AttributesController::class, 'create'])->name('attributes.create');
        Route::post('attribute', [AttributesController::class, 'store'])->name('attributes.store');
        Route::get('attribute/{attributes}/edit', [AttributesController::class, 'edit'])->name('attributes.edit');
        Route::patch('attribute/{attributes}', [AttributesController::class, 'update'])->name('attributes.update');
        Route::delete('attribute/{attributes}', [AttributesController::class, 'destroy'])->name('attributes.destroy');
        // Groups
        Route::get('groups', [GroupsController::class, 'index'])->name('groups');
        Route::get('groups/create', [GroupsController::class, 'create'])->name('groups.create');
        Route::post('group', [GroupsController::class, 'store'])->name('groups.store');
        Route::get('group/{groups}/edit', [GroupsController::class, 'edit'])->name('groups.edit');
        Route::patch('group/{groups}', [GroupsController::class, 'update'])->name('groups.update');
        Route::delete('group/{groups}', [GroupsController::class, 'destroy'])->name('groups.destroy');
    });

    // MARKETING
    Route::prefix('marketing')->group(function () {
        // BLOG
        Route::get('blogs', [BlogController::class, 'index'])->name('blogs');
        Route::get('blog/create', [BlogController::class, 'create'])->name('blogs.create');
        Route::post('blog', [BlogController::class, 'store'])->name('blogs.store');
        Route::get('blog/{blog}/edit', [BlogController::class, 'edit'])->name('blogs.edit');
        Route::patch('blog/{blog}', [BlogController::class, 'update'])->name('blogs.update');
        Route::delete('blog/{blog}', [BlogController::class, 'destroy'])->name('blogs.destroy');
    });

    // KORISNICI
    Route::get('users', [UserController::class, 'index'])->name('users');
    Route::get('user/create', [UserController::class, 'create'])->name('users.create');
    Route::post('user', [UserController::class, 'store'])->name('users.store');
    Route::get('user/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::patch('user/{user}', [UserController::class, 'update'])->name('users.update');

    // WIDGETS
    Route::prefix('widgets')->group(function () {
        Route::get('/', [WidgetController::class, 'index'])->name('widgets');
        Route::get('create', [WidgetController::class, 'create'])->name('widget.create');
        Route::post('/', [WidgetController::class, 'store'])->name('widget.store');
        Route::get('{widget}/edit', [WidgetController::class, 'edit'])->name('widget.edit');
        Route::patch('{widget}', [WidgetController::class, 'update'])->name('widget.update');
        // GROUP
        Route::prefix('groups')->group(function () {
            Route::get('create', [WidgetGroupController::class, 'create'])->name('widget.group.create');
            Route::post('/', [WidgetGroupController::class, 'store'])->name('widget.group.store');
            Route::get('{widget}/edit', [WidgetGroupController::class, 'edit'])->name('widget.group.edit');
            Route::patch('{widget}', [WidgetGroupController::class, 'update'])->name('widget.group.update');
        });
    });

    // POSTAVKE
    Route::prefix('settings')->group(function () {

        // API
        Route::get('api', [ApiController::class, 'index'])->name('api.index');
        //
        Route::get('system', [SystemController::class, 'index'])->name('system.index');

        // INFO PAGES
        Route::get('pages', [PageController::class, 'index'])->name('pages');
        Route::get('page/create', [PageController::class, 'create'])->name('pages.create');
        Route::post('page', [PageController::class, 'store'])->name('pages.store');
        Route::get('page/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::patch('page/{page}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('page/{page}', [PageController::class, 'destroy'])->name('pages.destroy');

        // FAQ
        Route::get('faqs', [FaqController::class, 'index'])->name('faqs');
        Route::get('faq/create', [FaqController::class, 'create'])->name('faqs.create');
        Route::post('faq', [FaqController::class, 'store'])->name('faqs.store');
        Route::get('faq/{faq}/edit', [FaqController::class, 'edit'])->name('faqs.edit');
        Route::patch('faq/{faq}', [FaqController::class, 'update'])->name('faqs.update');
        Route::delete('faq/{faq}', [FaqController::class, 'destroy'])->name('faqs.destroy');
        //
        Route::prefix('application')->group(function () {
            // GEO ZONES
            Route::get('geo-zones', [GeoZoneController::class, 'index'])->name('geozones');
            Route::get('geo-zone/create', [GeoZoneController::class, 'create'])->name('geozones.create');
            Route::post('geo-zone', [GeoZoneController::class, 'store'])->name('geozones.store');
            Route::get('geo-zone/{geozone}/edit', [GeoZoneController::class, 'edit'])->name('geozones.edit');
            Route::patch('geo-zone/{geozone}', [GeoZoneController::class, 'store'])->name('geozones.update');
            Route::delete('geo-zone/{geozone}', [GeoZoneController::class, 'destroy'])->name('geozones.destroy');
            //
            Route::get('order-statuses', [OrderStatusController::class, 'index'])->name('order.statuses');
            //
            Route::get('shippings', [ShippingController::class, 'index'])->name('shippings');
            Route::get('payments', [PaymentController::class, 'index'])->name('payments');
            Route::get('taxes', [TaxController::class, 'index'])->name('taxes');
            Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies');
        });

        // HISTORY
        Route::get('history', [HistoryController::class, 'index'])->name('history');
        Route::get('history/log/{history}', [HistoryController::class, 'show'])->name('history.show');
    });

    // SETTINGS
    Route::get('/clean/cache', [QuickMenuController::class, 'cache'])->name('cache');
    Route::get('maintenance/on', [QuickMenuController::class, 'maintenanceModeON'])->name('maintenance.on');
    Route::get('maintenance/off', [QuickMenuController::class, 'maintenanceModeOFF'])->name('maintenance.off');
});


/**
 * API Routes
 */
Route::prefix('api/v2')->group(function () {
    // SEARCH
    Route::get('pretrazi', [CatalogRouteController::class, 'search'])->name('api.front.search');

    Route::get('/auctions/autocomplete', [\App\Http\Controllers\Api\v2\ProductController::class, 'autocomplete'])->name('auctions.autocomplete');
    Route::post('/auctions/image/delete', [\App\Http\Controllers\Api\v2\ProductController::class, 'destroyImage'])->name('auctions.destroy.image');
    Route::post('/auctions/change/status', [\App\Http\Controllers\Api\v2\ProductController::class, 'changeStatus'])->name('auctions.change.status');
    Route::post('auctions/update-item/single', [\App\Http\Controllers\Api\v2\ProductController::class, 'updateItem'])->name('auctions.update.item');
    Route::post('auctions/delete/action', [\App\Http\Controllers\Api\v2\ProductController::class, 'destroyAction'])->name('auctions.destroy.action');
    //
    Route::post('auctions/user/bid', [\App\Http\Controllers\Front\BidController::class, 'store'])->name('auctions.user.bid.api');
    Route::post('auctions/user/bid/destroy', [BidController::class, 'destroyApi'])->name('auctions.user.bid.api.destroy');

    Route::post('/blogs/destroy/api', [BlogController::class, 'destroyApi'])->name('blogs.destroy.api');
    Route::post('/blogs/upload/image', [BlogController::class, 'uploadBlogImage'])->name('blogs.upload.image');
    //
    Route::post('system/notifications/status', [SystemController::class, 'notificationStatus'])->name('system.notifications.status.api');
    Route::get('system/notifications/test', [SystemController::class, 'notificationTest'])->name('system.notifications.test');
    Route::post('system/notification/single/delete/by-user', [CustomerController::class, 'readOneNotification'])->name('system.notifications.delete.single');

    Route::post('user/details/settings', [CustomerController::class, 'changeSettings'])->name('user.change.settings');

    // FILTER
    Route::prefix('filter')->group(function () {
        Route::post('/getCategories', [FilterController::class, 'categories']);
        Route::post('/getProducts', [FilterController::class, 'products']);
        Route::post('/getAuthors', [FilterController::class, 'authors']);
        Route::post('/getPublishers', [FilterController::class, 'publishers']);
    });

    // SETTINGS
    Route::prefix('settings')->group(function () {
        // FRONT SETTINGS LIST
        Route::get('/get', [SettingsController::class, 'get']);
        // WIDGET
        Route::prefix('widget')->group(function () {
            Route::post('destroy', [WidgetController::class, 'destroy'])->name('widget.destroy');
            Route::get('get-links', [WidgetController::class, 'getLinks'])->name('widget.api.get-links');
        });
        // API
        Route::prefix('api')->group(function () {
            Route::post('import', [ApiController::class, 'import'])->name('api.api.import');
            Route::post('upload/excel', [ApiController::class, 'upload'])->name('api.api.upload');
        });
        // APPLICATION SETTINGS
        Route::prefix('app')->group(function () {
            // GEO ZONE
            Route::prefix('geo-zone')->group(function () {
                Route::post('get-state-zones', 'Back\Settings\Store\GeoZoneController@getStateZones')->name('geo-zone.get-state-zones');
                Route::post('store', 'Back\Settings\Store\GeoZoneController@store')->name('geo-zone.store');
                Route::post('destroy', 'Back\Settings\Store\GeoZoneController@destroy')->name('geo-zone.destroy');
            });
            // ORDER STATUS
            Route::prefix('auction-status')->group(function () {
                Route::post('store', [OrderStatusController::class, 'store'])->name('api.auction.status.store');
                Route::post('destroy', [OrderStatusController::class, 'destroy'])->name('api.auction.status.destroy');

                Route::post('change', [OrderController::class, 'api_status_change'])->name('api.auction.status.change');
                Route::post('send/gls', [OrderController::class, 'api_send_gls'])->name('api.auction.send.gls');
            });
            // PAYMENTS
            Route::prefix('payment')->group(function () {
                Route::post('store', [PaymentController::class, 'store'])->name('api.payment.store');
                Route::post('destroy', [PaymentController::class, 'destroy'])->name('api.payment.destroy');
            });
            // SHIPMENTS
            Route::prefix('shipping')->group(function () {
                Route::post('store', [ShippingController::class, 'store'])->name('api.shipping.store');
                Route::post('destroy', [ShippingController::class, 'destroy'])->name('api.shipping.destroy');
            });
            // TAXES
            Route::prefix('taxes')->group(function () {
                Route::post('store', [TaxController::class, 'store'])->name('api.taxes.store');
                Route::post('destroy', [TaxController::class, 'destroy'])->name('api.taxes.destroy');
            });
            // CURRENCIES
            Route::prefix('currencies')->group(function () {
                Route::post('store', [CurrencyController::class, 'store'])->name('api.currencies.store');
                Route::post('store/main', [CurrencyController::class, 'storeMain'])->name('api.currencies.store.main');
                Route::post('destroy', [CurrencyController::class, 'destroy'])->name('api.currencies.destroy');
            });
            // TOTALS
            /*Route::prefix('totals')->group(function () {
                Route::post('store', 'Back\Settings\Store\TotalController@store')->name('totals.store');
                Route::post('destroy', 'Back\Settings\Store\TotalController@destroy')->name('totals.destroy');
            });*/
        });
    });
});


/*******************************************************************************
 *                                Copyright : AGmedia                           *
 *                              email: filip@agmedia.hr                         *
 *******************************************************************************/
/**
 * CUSTOMER BACK ROUTES
 */
Route::middleware(['auth:sanctum', 'verified'])->prefix('moj-racun')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('moj.racun');
    Route::patch('/snimi/{user}', [CustomerController::class, 'save'])->name('moj.racun.snimi');
    Route::get('/narudzbe', [CustomerController::class, 'orders'])->name('moj.racun.narudzbe');
    Route::get('/notifikacije', [CustomerController::class, 'notifications'])->name('moj.racun.notifikacije');
    Route::get('/detalji', [CustomerController::class, 'details'])->name('moj.racun.detalji');
    //
    Route::get('notifications/delete/by-user', [CustomerController::class, 'markNotificationsAsRead'])->name('moj.racun.read.notifications');
});
/**
 * FRONT ROUTES
 */
//Route::get('/', function () {return view('welcome');});
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/kontakt', [HomeController::class, 'contact'])->name('kontakt');
Route::post('/kontakt/posalji', [HomeController::class, 'sendContactMessage'])->name('poruka');
Route::get('/faq', [CatalogRouteController::class, 'faq'])->name('faq');
//
Route::get('pretrazi', [CatalogRouteController::class, 'search'])->name('pretrazi');
//
Route::get('info/{page}', [CatalogRouteController::class, 'page'])->name('catalog.route.page');
Route::get('blog/{blog?}', [CatalogRouteController::class, 'blog'])->name('catalog.route.blog');
//
Route::get('cache/image', [HomeController::class, 'imageCache']);
Route::get('cache/thumb', [HomeController::class, 'thumbCache']);
/**
 * Sitemap routes
 */
Route::redirect('/sitemap.xml', '/sitemap');
Route::get('sitemap/{sitemap?}', [HomeController::class, 'sitemapXML'])->name('sitemap');
Route::get('image-sitemap', [HomeController::class, 'sitemapImageXML'])->name('sitemap');
/**
 * Forgot password & login routes.
 */
Route::get('forgot-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forgot-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
/*
 * Groups, Categories and Products routes resolver.
 * https://www.antikvarijat-biblos.hr/kategorija-proizvoda/knjige/
 */
Route::get('aukcije/{group?}/{auction?}', [CatalogRouteController::class, 'resolve'])->name('catalog.route');
