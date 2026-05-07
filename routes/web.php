<?php

use App\Http\Controllers\FrontendController;
use App\Mail\InvoiceMail;
use App\Products;
use App\WebsiteLock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
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

Route::get('/test-invoice', function () {
	$order = \App\Orders::latest()->first();
	$user = $order->Users;

	$html = view('invoice_template', compact('order', 'user'))->render();

	$to = 'parisnta91@gmail.com';
	$subject = "Invoice - Order #{$order->invoice_no}";
	$headers  = "MIME-Version: 1.0\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8\r\n";
	$headers .= "From: Paris La Belle <jgrrylvmgyxm>" . "\r\n";

	if (mail($to, $subject, $html, $headers)) {
		return "✅ Mail sent successfully.";
	} else {
		return "❌ Failed to send mail.";
	}
});


/*Clear Cache*/
Route::get('/clear_cache', function () {
	$exitCode = Artisan::call('cache:clear');
});
/*Clear Cache*/

/*Clear Route*/
Route::get('/clear_route', function () {
	$exitCode = Artisan::call('route:clear');
});
/*Clear Route*/

/*Clear Config*/
Route::get('/clear_config', function () {
	$exitCode = Artisan::call('config:clear');
});
/*Clear Config*/

Route::post('/verify-passcode', function (Request $request) {
	$lock = WebsiteLock::first();

	if ($lock && $request->passcode === $lock->passcode) {
		Session::put('website_unlocked', true);
		return response()->json(['status' => 'success']);
	}

	return response()->json(['status' => 'error']);
})->name('verify-passcode');

/*Authentication Route Start*/
Route::get('/admin', 'UsersController@Login')->name('admin');
Route::get('/merchant', 'UsersController@Login')->name('merchant');
Route::post('/admin', 'UsersController@CheckLogin')->name('check_login');
Route::post('/check_signin', 'UsersController@CheckSignInEmail')->name('check_signin');
Route::post('/check_signin_mob', 'UsersController@CheckSignInMobile')->name('check_signin_mob');
Route::post('/login_otp', 'UsersController@LoginOTP')->name('login_otp');
Route::get('/logout', 'UsersController@Logout')->name('logout');
Route::get('/forgot', 'UsersController@Forgot')->name('forgot');
Route::post('/forgot', 'UsersController@CheckForgot')->name('check_forgot');
Route::post('/admin/forgot', 'UsersController@admin_CheckForgot')->name('admin.check_forgot');
Route::get('/reset', 'UsersController@Reset')->name('reset');
Route::post('/reset_password', 'UsersController@ResetPassword')->name('reset_password');
Route::get('/activation/{code}', 'FUIController@Activation')->name('activation');
Route::post('/reactivate', 'FUIController@reactivateFromModal')->name('reactivate.account');

Route::get('/resend_url', 'FUIController@ResendUrl')->name('resend_url');
Route::post('/resend_url', 'FUIController@ResendActivateUrl')->name('resend_activate_url');
Route::get('/chk_act_question', 'FUIController@ChkActQuestion')->name('chk_act_question');
Route::post('/chk_act_answer', 'FUIController@ChkActAnswer')->name('chk_act_answer');
Route::get('/chk_repwd_question', 'UsersController@ChkRepwdQuestion')->name('chk_repwd_question');
Route::post('/chk_repwd_answer', 'UsersController@ChkRepwdAnswer')->name('chk_repwd_answer');
Route::get('/verify/{on}/{id}', 'FUIController@Verify')->name('verify');
Route::post('/verify', 'FUIController@CheckVerify')->name('checkverify');

Route::get('/edit_profile', 'UsersController@EditProfile')->name('edit_profile');
Route::post('/edit_profile', 'UsersController@UpdateProfile')->name('update_profile');

Route::post('/address-store', 'UsersController@address_store')->name('address.store');
Route::get('/address/{address}/delete', 'UsersController@address_delete')->name('address.delete');
Route::get('/address/{id}', 'UsersController@address_edit')->name('address.edit');
Route::post('/address/make-default/{id}', 'UsersController@makeDefault')->name('address.make_default');


/*Authentication Route End*/

/* Front End Routes Start */
Route::get('/', 'FUIController@Home')->name('home');
Route::get('/seller_signup_old', 'FUIController@SellerSignupOLD')->name('seller_signup_old');
Route::get('/seller_signup', 'FUIController@SellerSignup')->name('seller_signup');
Route::post('/seller_register', 'FUIController@SellerRegister')->name('seller_register');
Route::get('/signin/otp', 'FUIController@SignInOtp')->name('signin.otp');
Route::post('/signin/send-otp', 'FUIController@sendLoginOtp')->name('send_login_otp');

Route::get('/signin', 'FUIController@SignIn')->name('signin');
Route::post('/email_signin_check', 'FUIController@EmailSignInCheck')->name('email_signin_check');
Route::post('/mobile_signin_check', 'FUIController@MobileSignInCheck')->name('mobile_signin_check');
Route::get('/redirect/{service}', 'SocialAuthController@redirect')->name('redirect');
Route::get('/callback/{service}', 'SocialAuthController@callback')->name('callback');
Route::get('/signup', 'FUIController@SignUp')->name('signup');
Route::post('/email_register', 'FUIController@EmailRegister')->name('email_register');
Route::post('/send-signup-email', 'FUIController@sendSignUpEmail')->name('send.signup.email');
Route::post('/mob_register', 'FUIController@MobileRegister')->name('mob_register');
Route::get('/customer_forgot', 'FUIController@CustomerForgot')->name('customer_forgot');
Route::post('/check_customer_forgot', 'FUIController@CheckCustomerForgot')->name('check_customer_forgot');
Route::get('/customer_reset', 'FUIController@CustomerReset')->name('customer_reset');
Route::post('/customer_reset_password', 'FUIController@CustomerResetPassword')->name('customer_reset_password');
// Route::post('/google_signin', 'FUIController@GoogleSignin')->name('google_signin');

Route::get('/my_account', 'FUIController@MyAccount')->name('my_account');
Route::get('/my_account/view_order/{id}', 'FUIController@ViewOrder')->name('my_view_orders');
Route::get('/my_account/track_order/{id}', 'FUIController@TrackOrder')->name('my_track_orders');
Route::get('/my_account/live_track_order/{id}', 'FUIController@LiveTrackOrder')->name('live_track_order');
Route::get('/my_account/review_order/{id}', 'FUIController@ReviewOrder')->name('my_review_orders');

Route::post('/apply-coupon', 'FUIController@apply_coupon')->name('apply.coupon');
Route::get('/remove-coupon', 'FUIController@remove_coupon')->name('remove.coupon');
Route::post('/get-shipping-charge', 'FUIController@getShippingCharge')->name('get_shipping_charge');





Route::get('/my_account/my_view_return_order/{id}', 'FUIController@MyViewReturnOrder')->name('my_view_return_order');
Route::post('/customer_cancel_order', 'FUIController@CustomerCancelOrder')->name('customer_cancel_order');
Route::post('/send-cancel-email', 'FUIController@sendCancelEmail')->name('send.order_cancel.email');
Route::get('/customer_return_order/{id}', 'FUIController@CustomerReturnOrder')->name('customer_return_order');
Route::post('/customer_return_order/', 'FUIController@SaveReturnOrder')->name('save_return_order');
Route::post('/send_feedback', 'FUIController@SendFeedBack')->name('send_feedback');
Route::post('/submit_review', 'FUIController@SubmitReview')->name('submit_review');
Route::get('/get-review', 'FUIController@getReview')->name('get_review');

Route::get('/category/{name}/{id?}', 'FUIController@cateProducts')->name('category.products');
Route::get('/compare-product/{id}', 'FUIController@compareProduct')->name('compare.product');


Route::post('/notification-preferences', 'FUIController@notification_update')->name('notification.preferences.update');

Route::post('/account/deactivate', 'FUIController@deactivate')->name('account.deactivate');


Route::get('/main_search/', 'FUIController@MainSearch')->name('main_search');
Route::get('/all_products/', 'FUIController@AllProducts')->name('all_products');
Route::get('/cat_lists/', 'FUIController@CatLists')->name('cat_lists');
Route::get('/sub_cat_lists/{main_cat}', 'FUIController@SubCatLists')->name('sub_cat_lists');
Route::get('/sub_sub_cat_lists/{sub_cat}', 'FUIController@SubSubCatLists')->name('sub_sub_cat_lists');
Route::get('/all_cat_products/{main_cat}', 'FUIController@AllCatProducts')->name('all_cat_products');
Route::get('/all_filter_products', 'FUIController@AllFilterProducts')->name('all_filter_products');
Route::get('/value_filter_products/{id}', 'FUIController@ValueFilterProducts')->name('value_filter_products');
Route::get('/sort_filter_products', 'FUIController@SortFilterProducts')->name('sort_filter_products');
Route::get('/offer_products/', 'FUIController@OfferProducts')->name('offer_products');
Route::get('/offer_products/{id}', 'FUIController@OfferProductsDetails')->name('offer_products_dets');
Route::get('/sub_category/{main_cat}', 'FUIController@SubCategory')->name('sub_category');
Route::get('/sub_sub_category/{sub_cat}', 'FUIController@SubSubCategory')->name('sub_sub_category');
Route::get('/sub_sub_category/products/{sub_sub_cat}', 'FUIController@SubSubCategoryProducts')->name('sub_sub_category_products');
Route::get('/category/products/{main_cat}', 'FUIController@CategoryProducts')->name('category_products');
Route::get('/brands/products/{id}', 'FUIController@BrandsProducts')->name('brands_products');
Route::get('/view_products/{id}', 'FUIController@ViewProducts')->name('view_products');
Route::get('/tag_products/{id}', 'FUIController@TagProducts')->name('tag_products');
Route::post('/attributes_image', 'FUIController@AttributesImage')->name('attributes_image');
Route::get('/pages/{name}', 'FUIController@Pages')->name('pages');
Route::get('/terms_conditions', 'FUIController@Terms')->name('terms_conditions');
Route::get('/about', 'FUIController@About')->name('about');
Route::get('/career', 'FUIController@CareerPage')->name('career');
Route::post('/career_form', 'FUIController@CareerForm')->name('career_form');
Route::get('/contact', 'FUIController@Contact')->name('contact');
Route::post('/contact', 'FUIController@StoreContact')->name('store_contact');
Route::post('/send-contact-email', 'FUIController@sendContactEmail')->name('send.contact.email');
Route::get('/how_to_find_us', 'FUIController@HowToFindUs')->name('how_to_find_us');
Route::get('/privacy', 'FUIController@Privacy')->name('privacy');
Route::get('/disclaimer', 'FUIController@Disclaimer')->name('disclaimer');
Route::post('/news_letters', 'FUIController@NewsLetters')->name('news_letters');
Route::post('/send-news_letters-email', 'FUIController@sendNewsLettersEmail')->name('send.news_letters.email');
Route::get('/unsubcribe/{id}', 'FUIController@UnSubscribeNewsLetters')->name('unsubcribe');
Route::post('/add_to_cart', 'FUIController@AddToCart')->name('add_to_cart');
Route::post('/offer_add_to_cart', 'FUIController@OfferAddToCart')->name('offer_add_to_cart');
Route::post('/delete_cart', 'FUIController@DeleteCart')->name('delete_cart');
Route::get('/cart', 'FUIController@Cart')->name('cart');
Route::post('/cart', 'FUIController@CartSave')->name('cart_save');
Route::post('/cart_qty_update', 'FUIController@CartQtyUpdate')->name('cart_qty_update');
Route::post('/data_billing', 'FUIController@DataBilling')->name('data_billing');
Route::post('/check_onhand_qty', 'FUIController@CheckOnHandQty')->name('check_onhand_qty');
Route::get('/wishlist', 'FUIController@WishList')->name('wishlist');
Route::post('/wishlist', 'FUIController@WishListSave')->name('wishlist_save');
Route::post('/delete_wishlist', 'FUIController@DeleteWishList')->name('delete_wishlist');
Route::get('/checkout', 'FUIController@Checkout')->name('checkout');
Route::post('/check_cut_off', 'FUIController@CheckCutOffs')->name('check_cut_off');
Route::post('/checkout', 'FUIController@CheckoutTrans')->name('checkout_trans');
Route::post('/checkout_verif', 'FUIController@CheckoutVerif')->name('checkout_verif');
Route::post('/payment_start', 'FUIController@PaymentStart')->name('payment_start');
Route::post('/payment_request', 'FUIController@PaymentRequest')->name('payment_request');
Route::post('/payment_response', 'FUIController@PaymentResponse')->name('payment_response');
Route::post('/update_qty', 'FUIController@UpdateQty')->name('update_qty');
Route::post('/pincode_check', 'FUIController@PincodeCheck')->name('pincode_check');
Route::post('/brand_auto_complete', 'FUIController@BrandAutoComplete')->name('brand_auto_complete');
Route::post('/select_state', 'MerchantsController@SelectState')->name('select_state');
Route::post('/select_city', 'MerchantsController@SelectCity')->name('select_city');
Route::post('/select_att_vals', 'ProductsController@SelectAttVals')->name('select_att_vals');
Route::post('/cat_select_att_vals', 'CategoryManagementSettingsController@SelectAttVals')->name('cat_select_att_vals');

Route::get('products', [FrontendController::class, 'products'])->name('products');
Route::get('services', [FrontendController::class, 'services'])->name('services');
Route::get('about-us', [FrontendController::class, 'aboutUs'])->name('about_us');
Route::get('contact-us', [FrontendController::class, 'contactUs'])->name('contact_us');
Route::post('contact-us', [FrontendController::class, 'storeContact'])->name('contact_us.store');




Route::match(['get', 'post'], '/phonepe/callback', 'FUIController@phonepeCallback')->name('phonepe.callback');

Route::post('/checkout/easebuzz/callback', 'FUIController@easebuzzCallback')->name('easebuzz.callback');



Route::get('/made-to-order', 'FUIController@made_to_order')->name('made_to_order');
Route::post('/send-made-to-order-email', 'FUIController@sendMadeOrderEmail')->name('send.made_order.email');
Route::post('/send-checkout-email', 'FUIController@sendCheckoutEmail')->name('send.checkout.email');

Route::post('/customise_products', 'FUIController@customise_store')->name('customise_store');
Route::get('/get-address', 'FUIController@getAddress')->name('getAddress');

Route::get('/collections', 'FUIController@collections')->name('collections');
Route::get('/ready-to-ship', 'FUIController@ready_to_ship')->name('ready_to_ship');
Route::get('/featured-product', 'FUIController@featured_product')->name('featured_product');

Route::post('/buy-now', 'FUIController@buyNow')->name('cart.buyNow');


Route::get('/sell_on_folkgems', 'FUIController@SellOnFolkgems')->name('sell_on_folkgems');
Route::get('/faqs', 'FUIController@FAQs')->name('faqs');
Route::post('/add_multiple_to_cart',  'FUIController@addMultipleToCart')->name('add_multiple_to_cart');
Route::post('/delete_multiple_from_wishlist',  'FUIController@deleteMultipleFromWishlist')->name('delete_multiple_from_wishlist');


/* Front End Routes End */

Route::group(['middleware' => 'check_login'], function () {
	/* Dashboard Routes Start */
	Route::get('/dashboard', 'DashboardController@Dashboard')->name('dashboard');
	/* Dashboard Routes End */

	/*User Route Start*/
	Route::get('/manage_user', 'UsersController@index')->name('manage_user');
	Route::get('/add_user', 'UsersController@create')->name('add_user');
	Route::post('/select_citys', 'UsersController@SelectCity')->name('select_citys');
	Route::post('/add_user', 'UsersController@store')->name('store_user');
	Route::get('/edit_user/{id}', 'UsersController@edit')->name('edit_user');
	Route::post('/edit_user', 'UsersController@update')->name('update_user');
	Route::get('/view_user/{id}', 'UsersController@view')->name('view_user');
	Route::post('/delete_user', 'UsersController@delete')->name('delete_user');
	Route::post('/delete_user_all', 'UsersController@DeleteAll')->name('delete_user_all');
	Route::get('/status_user/{id}', 'UsersController@StatusUser')->name('status_user');
	Route::get('/approve_user/{id}', 'UsersController@ApprovedUser')->name('approve_user');
	Route::post('/user_block', 'UsersController@UserBlock')->name('user_block');
	Route::post('/user_unblock', 'UsersController@UserUnblock')->name('user_unblock');
	Route::get('/my_profile', 'UsersController@MyProfile')->name('my_profile');
	/*User Route End*/
	Route::get('/change-password', 'UsersController@changePassword')->name('change_password');

	Route::get('/manage_admin_staff', 'UsersController@admin_staff')->name('manage_admin_staff');

	/*Feed Back Route Start*/
	Route::get('/feedbacks', 'FeedBackController@index')->name('feedbacks');
	Route::get('/view_feedbacks/{id}', 'FeedBackController@view')->name('view_feedbacks');
	Route::post('/delete_feedbacks', 'FeedBackController@delete')->name('delete_feedbacks');
	Route::post('/delete_feedbacks_all', 'FeedBackController@DeleteAll')->name('delete_feedbacks_all');
	Route::get('/status_feedbacks/{id}', 'FeedBackController@StatusFeedbacks')->name('status_feedbacks');
	Route::post('/feedbacks_block', 'FeedBackController@FeedbacksBlock')->name('feedbacks_block');
	Route::post('/feedbacks_unblock', 'FeedBackController@FeedbacksUnblock')->name('feedbacks_unblock');
	/*Feed Back Route End*/

	/*Modules Route Start*/
	Route::get('/manage_modules', 'ModulesController@index')->name('manage_modules');
	Route::get('/add_modules', 'ModulesController@create')->name('add_modules');
	Route::post('/add_modules', 'ModulesController@store')->name('store_modules');
	Route::get('/edit_modules/{id}', 'ModulesController@edit')->name('edit_modules');
	Route::post('/edit_modules', 'ModulesController@update')->name('update_modules');
	Route::post('/delete_modules', 'ModulesController@delete')->name('delete_modules');
	Route::post('/delete_modules_all', 'ModulesController@DeleteAll')->name('delete_modules_all');
	/*Modules Route End*/

	/* Coupon Route start */
	Route::get('/coupons', 'CouponController@index')->name('manage_coupons');
	Route::get('/add_coupons', 'CouponController@create')->name('add_coupons');
	Route::post('/add_coupons', 'CouponController@store')->name('store_coupons');
	Route::get('/edit_coupons/{id}', 'CouponController@edit')->name('edit_coupons');
	Route::post('/edit_coupons', 'CouponController@update')->name('update_coupons');
	Route::post('/delete_coupons', 'CouponController@delete')->name('delete_coupons');

	Route::get('/redeem_list/{id}', 'CouponController@redeem_list')->name('redeem_list');
	Route::get('/view_coupons', 'CouponController@viewCouponUsers')->name('view_coupons');
	Route::get('/status_coupon/{id}', 'CouponController@StatusCoupon')->name('status_coupon');
	Route::get('/coupons/share/{id}', 'CouponController@showShareForm')->name('share_coupon_form');
	Route::post('/coupons/send', 'CouponController@sendCouponToUsers')->name('send_coupon_to_users');


	/* Coupon Route end */

	/*Roles Route Start*/
	Route::get('/manage_role', 'RolesController@index')->name('manage_role');
	Route::get('/add_role', 'RolesController@create')->name('add_role');
	Route::post('/add_role', 'RolesController@store')->name('store_role');
	Route::get('/edit_role/{id}', 'RolesController@edit')->name('edit_role');
	Route::post('/edit_role', 'RolesController@update')->name('update_role');
	Route::post('/delete_role', 'RolesController@delete')->name('delete_role');
	Route::post('/delete_role_all', 'RolesController@DeleteAll')->name('delete_role_all');
	Route::get('/status_role/{id}', 'RolesController@Statusrole')->name('status_role');
	Route::post('/role_block', 'RolesController@roleBlock')->name('role_block');
	Route::post('/role_unblock', 'RolesController@roleUnblock')->name('role_unblock');

	Route::get('/user_previl', 'RolesController@UserPrivileges')->name('user_previl');
	Route::post('/user_previl', 'RolesController@SavePrivileges')->name('save_user_previl');
	Route::post('/select_user_previl', 'RolesController@SelectPrivileges')->name('select_user_previl');
	/*Roles Route End*/

	/*Account Setting Route Start*/
	Route::get('/manage_credits', 'CreditsManagementController@index')->name('manage_credits');
	Route::get('/add_credits/{id}', 'CreditsManagementController@create')->name('add_credits');
	Route::post('/add_credits', 'CreditsManagementController@store')->name('store_credits');

	/* Admin Commision Routes Start */
	Route::get('/manage_admin_comis', 'AdminCommisionController@index')->name('manage_admin_comis');
	Route::get('/orderby_admin_comis', 'AdminCommisionController@OrderByAdminCom')->name('orderby_admin_comis');
	Route::post('/status_comis', 'AdminCommisionController@StatusComis')->name('status_comis');
	Route::post('/remark_comis', 'AdminCommisionController@RemarkComis')->name('remark_comis');
	Route::get('/search_comis', 'AdminCommisionController@SearchComis')->name('search_comis');
	Route::post('/export_com_csv', 'AdminCommisionController@ExportComCSV')->name('export_com_csv');
	/* Admin Commision Routes End */

	/* Cashout Routes Start */
	Route::get('/manage_cashout', 'CashoutController@index')->name('manage_cashout');
	Route::get('/add_cashout', 'CashoutController@create')->name('add_cashout');
	Route::post('/add_cashout', 'CashoutController@store')->name('store_cashout');
	Route::get('/view_cashout/{id}', 'CashoutController@view')->name('view_cashout');
	Route::get('/make_pay/{id}', 'CashoutController@MakePay')->name('make_pay');
	Route::post('/process_pay', 'CashoutController@ProcessPay')->name('process_pay');
	Route::post('/export_cho_csv', 'CashoutController@ExportChoCSV')->name('export_cho_csv');
	Route::post('/search_cashout', 'CashoutController@SearchCashout')->name('search_cashout');
	/* Cashout Routes End */

	/* Admin Cashout Routes Start */
	Route::get('/manage_admin_cashout', 'AdminCashoutsController@index')->name('manage_admin_cashout');
	Route::get('/add_admin_cashout', 'AdminCashoutsController@create')->name('add_admin_cashout');
	Route::post('/add_admin_cashout', 'AdminCashoutsController@store')->name('store_admin_cashout');
	Route::get('/view_admin_cashout/{id}', 'AdminCashoutsController@view')->name('view_admin_cashout');
	Route::post('/export_admin_cashout_csv', 'AdminCashoutsController@ExportACCSV')->name('export_admin_cashout_csv');
	Route::post('/search_admin_cashout', 'AdminCashoutsController@SearchAdminCashout')->name('search_admin_cashout');
	Route::post('/select_vendor', 'AdminCashoutsController@SelectVendor')->name('select_vendor');
	Route::post('/select_credit_note', 'AdminCashoutsController@SelectCreditNote')->name('select_credit_note');
	Route::get('/remark_admin_cashout/{id}', 'AdminCashoutsController@remark')->name('remark_admin_cashout');
	Route::post('/remark_admin_cashout', 'AdminCashoutsController@storeremark')->name('store_remark_admin_cashout');
	/* Admin Cashout Routes End */
	/*Account Setting Route End*/

	/* Settings Routes Start */
	/*General Setting Route Start*/
	Route::get('/general_setting', 'GeneralSettingsController@create')->name('create_general_setting');
	Route::post('/general_setting', 'GeneralSettingsController@store')->name('store_general_setting');
	/*General Setting Route End*/

	Route::get('/shipping_setting', 'GeneralSettingsController@create_shipping')->name('create_shipping_setting');
	Route::post('/shipping_setting', 'GeneralSettingsController@store_shipping')->name('store_shipping_setting');


	Route::get('/website_lock_setting', 'GeneralSettingsController@create_lock')->name('website-lock.create');
	Route::post('/website_lock_setting', 'GeneralSettingsController@updateWebsiteLock')->name('website-lock.update');


	/*Email Setting Route Start*/
	Route::get('/email_setting', 'EmailSettingsController@create')->name('create_email_setting');
	Route::post('/email_setting', 'EmailSettingsController@store')->name('store_email_setting');
	/*Email Setting Route End*/

	/*Widget Setting Route Start*/
	Route::get('/widget_setting', 'FooWidgetController@create')->name('create_widget_setting');
	Route::post('/widget_setting', 'FooWidgetController@store')->name('store_widget_setting');
	/*Widget Setting Route End*/

	Route::get('/manage_home_services', 'HomeServicesController@index')->name('manage_home_services');
	Route::post('/manage_home_services', 'HomeServicesController@store')->name('store_home_services');
	Route::post('/delete_home_service', 'HomeServicesController@delete')->name('delete_home_service');

	/*Header Setting Route Start*/
	Route::get('/header_setting', 'HeaderMenusController@create')->name('header_setting');
	Route::post('/header_setting', 'HeaderMenusController@store')->name('store_header_setting');
	/*Header Setting Route End*/

	/*Footer Setting Route Start*/
	Route::get('/footer_setting', 'FooterSettingsController@create')->name('footer_setting');
	Route::post('/footer_setting', 'FooterSettingsController@store')->name('store_footer_setting');
	/*Footer Setting Route End*/

	/*Artist Setting Route Start*/
	Route::get('/artist_setting', 'OurArtistsController@create')->name('artist_setting');
	Route::post('/artist_setting', 'OurArtistsController@store')->name('store_artist_setting');
	/*Artist Setting Route End*/

	/*Testimonial Setting Route Start*/
	Route::get('/testimonial_setting', 'FooterSettingsController@create_testimonial')->name('testimonial_setting');
	Route::post('/testimonial_setting', 'FooterSettingsController@store_testimonial')->name('store_testimonial_setting');
	Route::post('/delete-testimonial', 'FooterSettingsController@delete_testimonial')->name('delete_testimonial');

	// 	Made to order Setting

	Route::get('/made_to_order_setting', 'FooterSettingsController@create_madeToOrder')->name('madeToOrder_setting');
	Route::post('/made_to_order_setting', 'FooterSettingsController@store_madeToOrder')->name('store_madeToOrderl_setting');

	/*Testimonial Setting Route End*/

	/*Sell On Folkgems Page Setting Route Start*/
	Route::get('/sofp_setting', 'SellOnFolkgemsPagesController@create')->name('sofp_setting');
	Route::post('/sofp_setting', 'SellOnFolkgemsPagesController@store')->name('store_sofp_setting');
	/*Sell On Folkgems Page Setting Route End*/

	/*FAQ Page Setting Route Start*/
	Route::get('/faq_page_setting', 'FAQPagesController@create')->name('faq_page_setting');
	Route::post('/faq_page_setting', 'FAQPagesController@store')->name('store_faq_page_setting');
	/*FAQ Page Setting Route End*/

	/*Contact Us Page Setting Route Start*/
	Route::get('/contact_page_setting', 'ContactUsPagesController@create')->name('contact_page_setting');
	Route::post('/contact_page_setting', 'ContactUsPagesController@store')->name('store_contact_page_setting');
	/*Contact Us Page Setting Route End*/

	/*Social Media Setting Route Start*/
	Route::get('/social_media_setting', 'SocialMediaSettingsController@create')->name('create_social_media_setting');
	Route::post('/social_media_setting', 'SocialMediaSettingsController@store')->name('store_social_media_setting');
	/*Social Media Setting Route End*/

	/*Manage Country Setting Route Start*/
	Route::get('/manage_country', 'CountriesManagementController@index')->name('index_manage_country');
	Route::get('/add_country', 'CountriesManagementController@create')->name('create_add_country');
	Route::post('/add_country', 'CountriesManagementController@store')->name('store_add_country');
	Route::get('/edit_country/{id}', 'CountriesManagementController@edit')->name('edit_edit_country');
	Route::post('/edit_country', 'CountriesManagementController@update')->name('update_edit_country');
	Route::get('/status_country_submit/{id}', 'CountriesManagementController@status_country')->name('status_country_submit');
	Route::post('/country_details', 'CountriesManagementController@CountryDetails')->name('country_details');
	Route::post('/country_block', 'CountriesManagementController@CountryBlock')->name('country_block');
	Route::post('/country_unblock', 'CountriesManagementController@CountryUnblock')->name('country_unblock');
	/*Manage Country Setting Route End*/

	/*Manage New Country Setting Route Start*/
	Route::get('/manage_all_country', 'CountriesManagementController@All')->name('index_manage_all_country');
	Route::get('/new_country', 'CountriesManagementController@NewCreate')->name('create_new_country');
	Route::post('/new_country', 'CountriesManagementController@NewStore')->name('store_new_country');
	Route::get('/edit_all_country/{id}', 'CountriesManagementController@NewEdit')->name('edit_edit_all_country');
	Route::post('/edit_all_country', 'CountriesManagementController@NewUpdate')->name('update_edit_all_country');
	Route::post('/delete_all_country', 'CountriesManagementController@NewDelete')->name('delete_all_country');
	Route::post('/delete_all_country_all', 'CountriesManagementController@NewDeleteAll')->name('delete_all_country_all');
	/*Manage New Country Setting Route End*/

	/*Payment Setting Route Start*/
	Route::get('/payment_setting', 'PaymentSettingsController@create')->name('create_payment_setting');
	Route::post('/payment_setting', 'PaymentSettingsController@store')->name('store_payment_setting');
	Route::post('/pcountry_details', 'PaymentSettingsController@CountryDetails')->name('pcountry_details');
	/*Payment Setting Route End*/

	/*Logo Setting Route Start*/
	Route::get('/logo_setting', 'LogoSettingsController@create')->name('create_logo_setting');
	Route::post('/logo_setting', 'LogoSettingsController@store')->name('store_logo_setting');
	/*Logo Setting Route End*/

	/*Fav Icon Setting Route Start*/
	Route::get('/favicon_setting', 'FaviconSettingsController@create')->name('create_favicon_setting');
	Route::post('/favicon_setting', 'FaviconSettingsController@store')->name('store_favicon_setting');
	/*Fav Icon Setting Route End*/

	/*No Image Setting Route Start*/
	Route::get('/noimage_setting', 'NoimageSettingsController@create')->name('create_noimage_setting');
	Route::post('/noimage_setting', 'NoimageSettingsController@store')->name('store_noimage_setting');
	Route::post('/noimage/delete', 'NoimageSettingsController@destroy')->name('delete_noimage');

	/*No Image Setting Route End*/

	/*FAQ Setting Route Start*/
	Route::get('/manage_faq', 'FAQSController@index')->name('manage_faq');
	Route::get('/add_faq', 'FAQSController@create')->name('add_faq');
	Route::post('/add_faq', 'FAQSController@store')->name('store_faq');
	Route::get('/edit_faq/{id}', 'FAQSController@edit')->name('edit_faq');
	Route::post('/edit_faq', 'FAQSController@update')->name('update_faq');
	Route::post('/delete_faq', 'FAQSController@delete')->name('delete_faq');
	Route::post('/delete_faq_all', 'FAQSController@DeleteAll')->name('delete_faq_all');
	Route::get('/status_faq/{id}', 'FAQSController@StatusFAQ')->name('status_faq');
	Route::post('/faq_block', 'FAQSController@FAQBlock')->name('faq_block');
	Route::post('/faq_unblock', 'FAQSController@FAQUnblock')->name('faq_unblock');
	/*FAQ Setting Route End*/

	/*Career Jobs Route Start*/
	Route::get('/manage_carr_jobs', 'CareerJobsController@index')->name('manage_carr_jobs');
	Route::get('/add_carr_jobs', 'CareerJobsController@create')->name('add_carr_jobs');
	Route::post('/add_carr_jobs', 'CareerJobsController@store')->name('store_carr_jobs');
	Route::get('/edit_carr_jobs/{id}', 'CareerJobsController@edit')->name('edit_carr_jobs');
	Route::post('/edit_carr_jobs', 'CareerJobsController@update')->name('update_carr_jobs');
	Route::post('/delete_carr_jobs', 'CareerJobsController@delete')->name('delete_carr_jobs');
	Route::post('/delete_carr_jobs_all', 'CareerJobsController@DeleteAll')->name('delete_carr_jobs_all');
	Route::get('/status_carr_jobs/{id}', 'CareerJobsController@StatusCJ')->name('status_carr_jobs');
	Route::post('/carr_jobs_block', 'CareerJobsController@CJBlock')->name('carr_jobs_block');
	Route::post('/carr_jobs_unblock', 'CareerJobsController@CJUnblock')->name('carr_jobs_unblock');
	/*Career Jobs Route End*/

	/*Career Jobs Route Start*/
	Route::get('/manage_carr_form', 'CareerFormController@index')->name('manage_carr_form');
	Route::get('/view_carr_form/{id}', 'CareerFormController@view')->name('view_carr_form');
	Route::post('/delete_carr_form', 'CareerFormController@delete')->name('delete_carr_form');
	Route::post('/delete_carr_form_all', 'CareerFormController@DeleteAll')->name('delete_carr_form_all');
	Route::get('/status_carr_form/{id}', 'CareerFormController@StatusCF')->name('status_carr_form');
	Route::post('/carr_form_block', 'CareerFormController@CFBlock')->name('carr_form_block');
	Route::post('/carr_form_unblock', 'CareerFormController@CFUnblock')->name('carr_form_unblock');
	/*Career Jobs Route End*/

	/*Banner Setting Route Start*/
	Route::get('/manage_banner_image', 'BannerImageSettingsController@index')->name('manage_banner_image');
	Route::get('/add_banner_image', 'BannerImageSettingsController@create')->name('add_banner_image');
	Route::post('/add_banner_image', 'BannerImageSettingsController@store')->name('store_banner_image');
	Route::get('/edit_banner_image/{id}', 'BannerImageSettingsController@edit')->name('edit_banner_image');
	Route::post('/edit_banner_image', 'BannerImageSettingsController@update')->name('update_banner_image');
	Route::post('/delete_banner_image', 'BannerImageSettingsController@delete')->name('delete_banner_image');
	Route::post('/delete_banner_image_all', 'BannerImageSettingsController@DeleteAll')->name('delete_banner_image_all');
	Route::get('/status_banner_image/{id}', 'BannerImageSettingsController@StatusBannerImage')->name('status_banner_image');
	Route::post('/banner_image_block', 'BannerImageSettingsController@BannerImageBlock')->name('banner_image_block');
	Route::post('/banner_image_unblock', 'BannerImageSettingsController@BannerImageUnblock')->name('banner_image_unblock');
	/*Banner Setting Route End*/

	/*Category Advertisement Settings Route Start*/
	Route::get('/manage_advertisement', 'CategoryAdvertisementSettingsController@index')->name('manage_advertisement');
	Route::get('/add_advertisement', 'CategoryAdvertisementSettingsController@create')->name('add_advertisement');
	Route::post('/add_advertisement', 'CategoryAdvertisementSettingsController@store')->name('store_advertisement');
	Route::get('/edit_advertisement/{id}', 'CategoryAdvertisementSettingsController@edit')->name('edit_advertisement');
	Route::post('/edit_advertisement', 'CategoryAdvertisementSettingsController@update')->name('update_advertisement');
	Route::post('/delete_advertisement', 'CategoryAdvertisementSettingsController@delete')->name('delete_advertisement');
	Route::post('/delete_advertisement_all', 'CategoryAdvertisementSettingsController@DeleteAll')->name('delete_advertisement_all');
	Route::get('/status_advertisement/{id}', 'CategoryAdvertisementSettingsController@StatusAdvertisement')->name('status_advertisement');
	Route::post('/advertisement_block', 'CategoryAdvertisementSettingsController@AdvertisementBlock')->name('advertisement_block');
	Route::post('/advertisement_unblock', 'CategoryAdvertisementSettingsController@AdvertisementUnblock')->name('advertisement_unblock');
	/*Category Advertisement Settings Route End*/

	/*Category Banner Settings Route Start*/
	Route::get('/manage_category_banner', 'CategoryBannerSettingsController@index')->name('manage_category_banner');
	Route::get('/add_category_banner', 'CategoryBannerSettingsController@create')->name('add_category_banner');
	Route::post('/add_category_banner', 'CategoryBannerSettingsController@store')->name('store_category_banner');
	Route::get('/edit_category_banner/{id}', 'CategoryBannerSettingsController@edit')->name('edit_category_banner');
	Route::post('/edit_category_banner', 'CategoryBannerSettingsController@update')->name('update_category_banner');
	Route::post('/delete_category_banner', 'CategoryBannerSettingsController@delete')->name('delete_category_banner');
	Route::post('/delete_category_banner_all', 'CategoryBannerSettingsController@DeleteAll')->name('delete_category_banner_all');
	Route::get('/status_category_banner/{id}', 'CategoryBannerSettingsController@StatusCategoryBanner')->name('status_category_banner');
	Route::post('/category_banner_block', 'CategoryBannerSettingsController@CategoryBannerBlock')->name('category_banner_block');
	Route::post('/category_banner_unblock', 'CategoryBannerSettingsController@CategoryBannerUnblock')->name('category_banner_unblock');
	/*Category Banner Settings Route End*/

	/*Colour Settings Route Start*/
	Route::get('/manage_color', 'ColorSettingsController@index')->name('manage_color');
	Route::get('/add_color', 'ColorSettingsController@create')->name('add_color');
	Route::post('/add_color', 'ColorSettingsController@store')->name('store_color');
	Route::get('/edit_color/{id}', 'ColorSettingsController@edit')->name('edit_color');
	Route::post('/edit_color', 'ColorSettingsController@update')->name('update_color');
	Route::post('/delete_color', 'ColorSettingsController@delete')->name('delete_color');
	Route::post('/delete_color_all', 'ColorSettingsController@DeleteAll')->name('delete_color_all');
	Route::get('/status_color/{id}', 'ColorSettingsController@StatusColor')->name('status_color');
	Route::post('/color_block', 'ColorSettingsController@ColorBlock')->name('color_block');
	Route::post('/color_unblock', 'ColorSettingsController@ColorUnblock')->name('color_unblock');
	/*Colour Settings Route End*/

	/*Size Settings Route Start*/
	Route::get('/manage_size', 'SizeSettingsController@index')->name('manage_size');
	Route::get('/add_size', 'SizeSettingsController@create')->name('add_size');
	Route::post('/add_size', 'SizeSettingsController@store')->name('store_size');
	Route::get('/edit_size/{id}', 'SizeSettingsController@edit')->name('edit_size');
	Route::post('/edit_size', 'SizeSettingsController@update')->name('update_size');
	Route::post('/delete_size', 'SizeSettingsController@delete')->name('delete_size');
	Route::post('/delete_size_all', 'SizeSettingsController@DeleteAll')->name('delete_size_all');
	Route::get('/status_size/{id}', 'SizeSettingsController@StatusSize')->name('status_size');
	Route::post('/size_block', 'SizeSettingsController@SizeBlock')->name('size_block');
	Route::post('/size_unblock', 'SizeSettingsController@SizeUnblock')->name('size_unblock');
	/*Size Settings Route End*/

	/*Capacity Settings Route Start*/
	Route::get('/manage_capacity', 'CapacitySettingsController@index')->name('manage_capacity');
	Route::get('/add_capacity', 'CapacitySettingsController@create')->name('add_capacity');
	Route::post('/add_capacity', 'CapacitySettingsController@store')->name('store_capacity');
	Route::get('/edit_capacity/{id}', 'CapacitySettingsController@edit')->name('edit_capacity');
	Route::post('/edit_capacity', 'CapacitySettingsController@update')->name('update_capacity');
	Route::post('/delete_capacity', 'CapacitySettingsController@delete')->name('delete_capacity');
	Route::post('/delete_capacity_all', 'CapacitySettingsController@DeleteAll')->name('delete_capacity_all');
	Route::get('/status_capacity/{id}', 'CapacitySettingsController@StatusCapacity')->name('status_capacity');
	Route::post('/capacity_block', 'CapacitySettingsController@CapacityBlock')->name('capacity_block');
	Route::post('/capacity_unblock', 'CapacitySettingsController@CapacityUnblock')->name('capacity_unblock');
	/*Capacity Settings Route End*/

	/*Attributes Fields Settings Route Start*/
	Route::get('/manage_att_fields', 'AttributesFieldsController@index')->name('manage_att_fields');
	Route::get('/add_att_fields', 'AttributesFieldsController@create')->name('add_att_fields');
	Route::post('/add_att_fields', 'AttributesFieldsController@store')->name('store_att_fields');
	Route::get('/edit_att_fields/{id}', 'AttributesFieldsController@edit')->name('edit_att_fields');
	Route::post('/edit_att_fields', 'AttributesFieldsController@update')->name('update_att_fields');
	Route::post('/delete_att_fields', 'AttributesFieldsController@delete')->name('delete_att_fields');
	Route::post('/delete_att_fields_all', 'AttributesFieldsController@DeleteAll')->name('delete_att_fields_all');
	Route::get('/status_att_fields/{id}', 'AttributesFieldsController@StatusAttFields')->name('status_att_fields');
	Route::post('/att_fields_block', 'AttributesFieldsController@AttFieldsBlock')->name('att_fields_block');
	Route::post('/att_fields_unblock', 'AttributesFieldsController@AttFieldsUnblock')->name('att_fields_unblock');
	/*Attributes Fields Settings Route End*/

	/*Attributes Settings Route Start*/
	Route::get('/manage_attributes', 'AttributesSettingsController@index')->name('manage_attributes');
	Route::get('/add_attributes', 'AttributesSettingsController@create')->name('add_attributes');
	Route::post('/add_attributes', 'AttributesSettingsController@store')->name('store_attributes');
	Route::get('/edit_attributes/{id}', 'AttributesSettingsController@edit')->name('edit_attributes');
	Route::post('/edit_attributes', 'AttributesSettingsController@update')->name('update_attributes');
	Route::post('/delete_attributes', 'AttributesSettingsController@delete')->name('delete_attributes');
	Route::post('/delete_attributes_all', 'AttributesSettingsController@DeleteAll')->name('delete_attributes_all');
	Route::get('/status_attributes/{id}', 'AttributesSettingsController@StatusAttributes')->name('status_attributes');
	Route::post('/attributes_block', 'AttributesSettingsController@AttributesBlock')->name('attributes_block');
	Route::post('/attributes_unblock', 'AttributesSettingsController@AttributesUnblock')->name('attributes_unblock');
	/*Attributes Settings Route End*/

	/*City Settings Route Start*/
	Route::get('/manage_city', 'CityManagementController@index')->name('manage_city');
	Route::get('/add_city', 'CityManagementController@create')->name('add_city');
	Route::post('/add_city', 'CityManagementController@store')->name('store_city');
	Route::get('/edit_city/{id}', 'CityManagementController@edit')->name('edit_city');
	Route::post('/edit_city', 'CityManagementController@update')->name('update_city');
	Route::post('/delete_city', 'CityManagementController@delete')->name('delete_city');
	Route::post('/delete_city_all', 'CityManagementController@DeleteAll')->name('delete_city_all');
	Route::get('/status_city/{id}', 'CityManagementController@StatusCity')->name('status_city');
	Route::post('/city_block', 'CityManagementController@CityBlock')->name('city_block');
	Route::post('/city_unblock', 'CityManagementController@CityUnblock')->name('city_unblock');
	Route::post('/city_default', 'CityManagementController@CityDefault')->name('city_default');
	Route::post('/state_details', 'CityManagementController@StateDetails')->name('state_details');
	/*City Settings Route End*/

	/*State Settings Route Start*/
	Route::get('/manage_state', 'StateManagementsController@index')->name('manage_state');
	Route::get('/add_state', 'StateManagementsController@create')->name('add_state');
	Route::post('/add_state', 'StateManagementsController@store')->name('store_state');
	Route::get('/edit_state/{id}', 'StateManagementsController@edit')->name('edit_state');
	Route::post('/edit_state', 'StateManagementsController@update')->name('update_state');
	Route::post('/delete_state', 'StateManagementsController@delete')->name('delete_state');
	Route::post('/delete_state_all', 'StateManagementsController@DeleteAll')->name('delete_state_all');
	Route::get('/status_state/{id}', 'StateManagementsController@StatusState')->name('status_state');
	Route::post('/state_block', 'StateManagementsController@StateBlock')->name('state_block');
	Route::post('/state_unblock', 'StateManagementsController@StateUnblock')->name('state_unblock');
	Route::post('/state_default', 'StateManagementsController@StateDefault')->name('state_default');
	/*State Settings Route End*/

	/*Category Management Settings Route Start*/
	Route::get('/manage_category', 'CategoryManagementSettingsController@index')->name('manage_category');
	Route::get('/add_category', 'CategoryManagementSettingsController@create')->name('add_category');
	Route::post('/add_category', 'CategoryManagementSettingsController@store')->name('store_category');
	Route::get('/edit_category/{id}', 'CategoryManagementSettingsController@edit')->name('edit_category');
	Route::post('/edit_category', 'CategoryManagementSettingsController@update')->name('update_category');
	Route::get('/status_category/{id}', 'CategoryManagementSettingsController@StatusMainCategory')->name('status_category');
	Route::post('/category_block', 'CategoryManagementSettingsController@MainCategoryBlock')->name('category_block');
	Route::post('/category_unblock', 'CategoryManagementSettingsController@MainCategoryUnblock')->name('category_unblock');
	Route::post('/home_view', 'CategoryManagementSettingsController@HomeView')->name('home_view');

	Route::post('/delete_category_image', 'CategoryManagementSettingsController@delete')->name('delete_category_image');
	/*Category Management Settings Route End*/

	/*Sub Category Management Settings Route Start*/
	Route::get('/manage_sub_category/{id}', 'SubCategoryManagementSettingsController@index')->name('manage_sub_category');
	Route::get('/add_sub_category/{id}', 'SubCategoryManagementSettingsController@create')->name('add_sub_category');
	Route::post('/add_sub_category', 'SubCategoryManagementSettingsController@store')->name('store_sub_category');
	Route::get('/edit_sub_category/{id}', 'SubCategoryManagementSettingsController@edit')->name('edit_sub_category');
	Route::post('/edit_sub_category', 'SubCategoryManagementSettingsController@update')->name('update_sub_category');
	Route::get('/status_sub_category/{id}', 'SubCategoryManagementSettingsController@StatusMainCategory')->name('status_sub_category');
	Route::post('/sub_category_block', 'SubCategoryManagementSettingsController@MainCategoryBlock')->name('sub_category_block');
	Route::post('/sub_category_unblock', 'SubCategoryManagementSettingsController@MainCategoryUnblock')->name('sub_category_unblock');

	Route::post('/delete_sub_category_image', 'SubCategoryManagementSettingsController@delete')->name('delete_sub_category_image');
	/*Sub Category Management Settings Route End*/

	/*Sub Sub Category Management Settings Route Start*/
	Route::get('/manage_sub_sub_category/{id}', 'SubSubCategoryManagementSettingsController@index')->name('manage_sub_sub_category');
	Route::get('/add_sub_sub_category/{id}', 'SubSubCategoryManagementSettingsController@create')->name('add_sub_sub_category');
	Route::post('/add_sub_sub_category', 'SubSubCategoryManagementSettingsController@store')->name('store_sub_sub_category');
	Route::get('/edit_sub_sub_category/{id}', 'SubSubCategoryManagementSettingsController@edit')->name('edit_sub_sub_category');
	Route::post('/edit_sub_sub_category', 'SubSubCategoryManagementSettingsController@update')->name('update_sub_sub_category');
	Route::post('/delete_sub_sub_category', 'SubSubCategoryManagementSettingsController@delete')->name('delete_sub_sub_category');
	Route::post('/delete_sub_sub_category_all', 'SubSubCategoryManagementSettingsController@DeleteAll')->name('delete_sub_sub_category_all');
	Route::get('/status_sub_sub_category/{id}', 'SubSubCategoryManagementSettingsController@StatusMainCategory')->name('status_sub_sub_category');
	Route::post('/sub_sub_category_block', 'SubSubCategoryManagementSettingsController@MainCategoryBlock')->name('sub_sub_category_block');
	Route::post('/sub_sub_category_unblock', 'SubSubCategoryManagementSettingsController@MainCategoryUnblock')->name('sub_sub_category_unblock');
	/*Sub Sub Category Management Settings Route End*/

	/*CMS PAGE Settings Route Start*/
	Route::get('/manage_cms_page', 'CMSPageManagementController@index')->name('manage_cms_page');
	Route::get('/add_cms_page', 'CMSPageManagementController@create')->name('add_cms_page');
	Route::post('/add_cms_page', 'CMSPageManagementController@store')->name('store_cms_page');
	Route::get('/edit_cms_page/{id}', 'CMSPageManagementController@edit')->name('edit_cms_page');
	Route::post('/edit_cms_page', 'CMSPageManagementController@update')->name('update_cms_page');
	Route::post('/delete_cms_page', 'CMSPageManagementController@delete')->name('delete_cms_page');
	Route::post('/delete_cms_page_all', 'CMSPageManagementController@DeleteAll')->name('delete_cms_page_all');
	Route::get('/status_cms_page/{id}', 'CMSPageManagementController@StatusCMSPage')->name('status_cms_page');
	Route::post('/cms_page_block', 'CMSPageManagementController@CMSPageBlock')->name('cms_page_block');
	Route::post('/cms_page_unblock', 'CMSPageManagementController@CMSPageUnblock')->name('cms_page_unblock');
	/*CMS PAGE Settings Route End*/

	/*About Us CMS PAGE Settings Route Start*/
	Route::get('/manage_about_page', 'AboutUsCMSSettingsController@index')->name('manage_about_page');
	Route::get('/add_about_page', 'AboutUsCMSSettingsController@create')->name('add_about_page');
	Route::post('/add_about_page', 'AboutUsCMSSettingsController@store')->name('store_about_page');
	/*About Us CMS PAGE Settings Route End*/

	/*About Us CMS PAGE Settings Route Start*/
	Route::get('/manage_career', 'CareerController@index')->name('manage_career');
	Route::get('/add_career', 'CareerController@create')->name('add_career');
	Route::post('/add_career', 'CareerController@store')->name('store_career');
	/*About Us CMS PAGE Settings Route End*/

	/*Disclaimers CMS PAGE Settings Route Start*/
	Route::get('/add_disclaimers', 'DisclaimersController@create')->name('add_disclaimers');
	Route::post('/add_disclaimers', 'DisclaimersController@store')->name('store_disclaimers');
	/*Disclaimers CMS PAGE Settings Route End*/

	/*Terms CMS PAGE Settings Route Start*/
	Route::get('/manage_terms', 'TermsCMSSettingsController@index')->name('manage_terms');
	Route::get('/terms', 'TermsCMSSettingsController@create')->name('terms');
	Route::post('/terms', 'TermsCMSSettingsController@store')->name('store_terms');
	/*Terms CMS PAGE Settings Route End*/

	/*Tax Management Route Start*/
	Route::get('/manage_tax', 'TaxManagementController@index')->name('manage_tax');
	Route::get('/add_tax', 'TaxManagementController@create')->name('add_tax');
	Route::post('/add_tax', 'TaxManagementController@store')->name('store_tax');
	Route::get('/edit_tax/{id}', 'TaxManagementController@edit')->name('edit_tax');
	Route::post('/edit_tax', 'TaxManagementController@update')->name('update_tax');
	Route::post('/delete_tax', 'TaxManagementController@delete')->name('delete_tax');
	Route::post('/delete_tax_all', 'TaxManagementController@DeleteAll')->name('delete_tax_all');
	Route::get('/status_tax/{id}', 'TaxManagementController@StatusTax')->name('status_tax');
	Route::post('/tax_block', 'TaxManagementController@TaxBlock')->name('tax_block');
	Route::post('/tax_unblock', 'TaxManagementController@TaxUnblock')->name('tax_unblock');
	/*Tax Management Route End*/

	/*Tax Cut OFF Management Route Start*/
	Route::get('/manage_cutoff', 'TaxCutoffController@index')->name('manage_cutoff');
	Route::get('/add_cutoff', 'TaxCutoffController@create')->name('add_cutoff');
	Route::post('/add_cutoff', 'TaxCutoffController@store')->name('store_cutoff');
	Route::get('/edit_cutoff/{id}', 'TaxCutoffController@edit')->name('edit_cutoff');
	Route::post('/edit_cutoff', 'TaxCutoffController@update')->name('update_cutoff');
	Route::post('/delete_cutoff', 'TaxCutoffController@delete')->name('delete_cutoff');
	Route::post('/delete_cutoff_all', 'TaxCutoffController@DeleteAll')->name('delete_cutoff_all');
	Route::get('/status_cutoff/{id}', 'TaxCutoffController@StatusCutoff')->name('status_cutoff');
	Route::post('/cutoff_block', 'TaxCutoffController@CutoffBlock')->name('cutoff_block');
	Route::post('/cutoff_unblock', 'TaxCutoffController@CutoffUnblock')->name('cutoff_unblock');
	/*Tax Cut OFF Management Route End*/

	/*COD Management Route Start*/
	Route::get('/manage-payment-settings', 'CodController@index')->name('manage_cod');
	Route::get('/add_cod', 'CodController@create')->name('add_cod');
	Route::post('/add_cod', 'CodController@store')->name('store_cod');
	Route::get('/edit_cod/{id}', 'CodController@edit')->name('edit_cod');
	Route::post('/edit_cod', 'CodController@update')->name('update_cod');
	Route::post('/delete_cod', 'CodController@delete')->name('delete_cod');
	Route::post('/delete_cod_all', 'CodController@DeleteAll')->name('delete_cod_all');
	Route::get('/status_cod/{id}', 'CodController@Statuscod')->name('status_cod');
	Route::post('/cod_block', 'CodController@codBlock')->name('cod_block');
	Route::post('/cod_unblock', 'CodController@codUnblock')->name('cod_unblock');
	/*COD Management Route End*/

	/*Login Security Route Start*/
	Route::get('/manage_secure', 'LoginSecurityController@index')->name('manage_secure');
	Route::get('/add_secure', 'LoginSecurityController@create')->name('add_secure');
	Route::post('/add_secure', 'LoginSecurityController@store')->name('store_secure');
	Route::get('/edit_secure/{id}', 'LoginSecurityController@edit')->name('edit_secure');
	Route::post('/edit_secure', 'LoginSecurityController@update')->name('update_secure');
	Route::post('/delete_secure', 'LoginSecurityController@delete')->name('delete_secure');
	Route::post('/delete_secure_all', 'LoginSecurityController@DeleteAll')->name('delete_secure_all');
	Route::get('/status_secure/{id}', 'LoginSecurityController@StatusSecure')->name('status_secure');
	Route::post('/secure_block', 'LoginSecurityController@SecureBlock')->name('secure_block');
	Route::post('/secure_unblock', 'LoginSecurityController@SecureUnblock')->name('secure_unblock');
	/*Login Security Route End*/

	/* Settings Routes End */

	/* Merchants Routes Start */
	Route::get('/merchant_dashboard', 'MerchantsController@dashboard')->name('merchant_dashboard');
	Route::get('/manage_merchant', 'MerchantsController@index')->name('manage_merchant');
	Route::get('/add_merchant', 'MerchantsController@create')->name('add_merchant');
	Route::post('/add_merchant', 'MerchantsController@store')->name('store_merchant');
	Route::get('/view_merchant/{id}', 'MerchantsController@view')->name('view_merchant');
	Route::get('/edit_merchant/{id}', 'MerchantsController@edit')->name('edit_merchant');
	Route::post('/edit_merchant', 'MerchantsController@update')->name('update_merchant');
	Route::get('/status_merchant/{id}', 'MerchantsController@StatusMerchant')->name('status_merchant');
	Route::get('/approve_merchant/{id}', 'MerchantsController@ApproveMerchant')->name('approve_merchant');
	Route::post('/merchant_block', 'MerchantsController@MerchantBlock')->name('merchant_block');
	Route::post('/merchant_unblock', 'MerchantsController@MerchantUnblock')->name('merchant_unblock');
	/* Merchants Routes End */

	/* Stores Routes Start */
	Route::get('/manage_store/{id}', 'StoreController@index')->name('manage_store');
	Route::get('/add_store/{id}', 'StoreController@create')->name('add_store');
	Route::post('/add_store', 'StoreController@store')->name('store_store');
	Route::get('/edit_store/{id}', 'StoreController@edit')->name('edit_store');
	Route::post('/edit_store', 'StoreController@update')->name('update_store');
	Route::get('/status_store/{id}', 'StoreController@StatusStore')->name('status_store');
	Route::post('/store_block', 'StoreController@StoreBlock')->name('store_block');
	Route::post('/store_unblock', 'StoreController@StoreUnblock')->name('store_unblock');
	/* Stores Routes End */

	/*Tag Route Start*/
	Route::get('/manage_tag', 'TagsController@index')->name('manage_tag');
	Route::get('/add_tag', 'TagsController@create')->name('add_tag');
	Route::post('/add_tag', 'TagsController@store')->name('store_tag');
	Route::get('/edit_tag/{id}', 'TagsController@edit')->name('edit_tag');
	Route::post('/edit_tag', 'TagsController@update')->name('update_tag');
	Route::post('/delete_tag', 'TagsController@delete')->name('delete_tag');
	Route::post('/delete_tag_all', 'TagsController@DeleteAll')->name('delete_tag_all');
	Route::get('/status_tag/{id}', 'TagsController@StatusTag')->name('status_tag');
	Route::post('/tag_block', 'TagsController@TagBlock')->name('tag_block');
	Route::post('/tag_unblock', 'TagsController@TagUnblock')->name('tag_unblock');
	/*Tag Route End*/

	/*Measurement Route Start*/
	Route::get('/manage_measurement', 'MeasurementUnitsController@index')->name('manage_measurement');
	Route::get('/add_measurement', 'MeasurementUnitsController@create')->name('add_measurement');
	Route::post('/add_measurement', 'MeasurementUnitsController@store')->name('store_measurement');
	Route::get('/edit_measurement/{id}', 'MeasurementUnitsController@edit')->name('edit_measurement');
	Route::post('/edit_measurement', 'MeasurementUnitsController@update')->name('update_measurement');
	Route::post('/delete_measurement', 'MeasurementUnitsController@delete')->name('delete_measurement');
	Route::post('/delete_measurement_all', 'MeasurementUnitsController@DeleteAll')->name('delete_measurement_all');
	Route::get('/status_measurement/{id}', 'MeasurementUnitsController@StatusMeasurement')->name('status_measurement');
	Route::post('/measurement_block', 'MeasurementUnitsController@MeasurementBlock')->name('measurement_block');
	Route::post('/measurement_unblock', 'MeasurementUnitsController@MeasurementUnblock')->name('measurement_unblock');
	/*Measurement Route End*/

	/*Products Route Start*/
	Route::get('/manage_product', 'ProductsController@index')->name('manage_product');
	Route::get('/add_product', 'ProductsController@create')->name('add_product');
	Route::post('/select_sub_cat', 'ProductsController@SelectSubCat')->name('select_sub_cat');
	Route::post('/select_sub_sub_cat', 'ProductsController@SelectSubSubCat')->name('select_sub_sub_cat');
	Route::post('/add_product', 'ProductsController@store')->name('store_product');
	Route::get('/view_product/{id}', 'ProductsController@view')->name('view_product');
	Route::get('/edit_product/{id}', 'ProductsController@edit')->name('edit_product');
	Route::post('/edit_product', 'ProductsController@update')->name('update_product');
	Route::post('/delete_product', 'ProductsController@delete')->name('delete_product');
	Route::post('/delete_product_all', 'ProductsController@DeleteAll')->name('delete_product_all');
	Route::get('/status_product/{id}', 'ProductsController@StatusProduct')->name('status_product');
	Route::post('/product_block', 'ProductsController@ProductBlock')->name('product_block');
	Route::post('/product_unblock', 'ProductsController@ProductUnblock')->name('product_unblock');
	Route::post('/export_csv', 'ProductsController@ExportCSV')->name('export_csv');
	Route::post('/sold_product', 'ProductsController@SoldProduct')->name('sold_product');
	Route::post('/get_tax', 'ProductsController@GetTax')->name('get_tax');
	Route::get('/search_products', 'ProductsController@SearchProducts')->name('search_products');
	Route::get('/products/bulk-upload', 'ProductsController@showBulkUploadForm')->name('product.bulk_upload');
	Route::post('/products/bulk-upload', 'ProductsController@handleBulkUpload')->name('product.bulk_upload.save');
	// web.php
	Route::get('/download-product-template', 'ProductsController@downloadTemplate')->name('products.download-template');


	// Route::post('/select_att_vals', 'ProductsController@SelectAttVals')->name('select_att_vals');
	/*Products Route End*/

	/*Offers Route Start*/
	Route::get('/manage_offer', 'OffersController@index')->name('manage_offer');
	Route::get('/add_offer', 'OffersController@create')->name('add_offer');
	Route::post('/check_stock', 'OffersController@CheckStock')->name('check_stock');
	Route::post('/select_atts', 'OffersController@SelectAtts')->name('select_atts');
	Route::post('/add_offer', 'OffersController@store')->name('store_offer');
	Route::get('/view_offer/{id}', 'OffersController@view')->name('view_offer');
	Route::get('/edit_offer/{id}', 'OffersController@edit')->name('edit_offer');
	Route::post('/edit_offer', 'OffersController@update')->name('update_offer');
	Route::post('/delete_offer', 'OffersController@delete')->name('delete_offer');
	Route::post('/delete_offer_all', 'OffersController@DeleteAll')->name('delete_offer_all');
	Route::get('/status_offer/{id}', 'OffersController@StatusOffer')->name('status_offer');
	Route::post('/offer_block', 'OffersController@OfferBlock')->name('offer_block');
	Route::post('/offer_unblock', 'OffersController@OfferUnblock')->name('offer_unblock');
	/*Offers Route End*/

	/*Offers Stock Trans Settings Route Start*/
	Route::get('/manage_offer_stock', 'OffersController@OfferStock')->name('manage_offer_stock');
	Route::post('/export_offer_stock_csv', 'OffersController@ExportOfferStockCSV')->name('export_offer_stock_csv');

	Route::get('/manage_offer_trans', 'OffersController@OfferTrans')->name('manage_offer_trans');
	Route::post('/export_offer_trans_csv', 'OffersController@ExportOfferTransCSV')->name('export_offer_trans_csv');
	/*Offers Stock Trans Settings Route End*/

	/*Review Route Start*/
	Route::get('/manage_review', 'ReviewController@index')->name('manage_review');
	Route::post('/delete_review', 'ReviewController@delete')->name('delete_review');
	Route::post('/delete_review_all', 'ReviewController@DeleteAll')->name('delete_review_all');
	Route::get('/status_review/{id}', 'ReviewController@StatusReview')->name('status_review');
	Route::post('/review_block', 'ReviewController@ReviewBlock')->name('review_block');
	Route::post('/review_unblock', 'ReviewController@ReviewUnblock')->name('review_unblock');
	/*Review Route End*/

	/*Stock Settings Route Start*/
	Route::get('/manage_stock', 'StockManagementController@index')->name('manage_stock');
	Route::get('/manage_stock/{filter}', 'StockManagementController@Filter')->name('filter_manage_stock');
	Route::get('/manage_substock/{id}', 'StockManagementController@SubStock')->name('manage_substock');
	Route::get('/add_stock', 'StockManagementController@create')->name('add_stock');
	Route::post('/add_stock', 'StockManagementController@store')->name('store_stock');
	Route::get('/damage_stock', 'StockManagementController@Damagecreate')->name('damage_stock');
	Route::post('/damage_stock', 'StockManagementController@Damagestore')->name('store_damage_stock');
	Route::post('/select_qty', 'StockManagementController@SelectQty')->name('select_qty');
	Route::get('/edit_stock/{id}', 'StockManagementController@edit')->name('edit_stock');
	Route::post('/edit_stock', 'StockManagementController@update')->name('update_stock');
	Route::post('/delete_stock', 'StockManagementController@delete')->name('delete_stock');
	Route::post('/delete_stock_all', 'StockManagementController@DeleteAll')->name('delete_stock_all');
	Route::get('/status_stock/{id}', 'StockManagementController@StatusStock')->name('status_stock');
	Route::post('/stock_block', 'StockManagementController@StockBlock')->name('stock_block');
	Route::post('/stock_unblock', 'StockManagementController@StockUnblock')->name('stock_unblock');
	Route::post('/export_stock_csv', 'StockManagementController@ExportStockCSV')->name('export_stock_csv');
	Route::get('/search_inv_stock', 'StockManagementController@SearchInvStock')->name('search_inv_stock');
	/*Stock Settings Route End*/

	/*Stock Trans Settings Route Start*/
	Route::get('/manage_stock_trans', 'StockTransactionsController@index')->name('manage_stock_trans');
	Route::post('/export_sck_trans_csv', 'StockTransactionsController@ExportStockCSV')->name('export_sck_trans_csv');
	/*Stock Trans Settings Route End*/

	/*Brands Route Start*/
	Route::get('/manage_brands', 'BrandsController@index')->name('manage_brands');
	Route::get('/add_brands', 'BrandsController@create')->name('add_brands');
	Route::post('/city_details', 'BrandsController@CityDetails')->name('city_details');
	Route::post('/add_brands', 'BrandsController@store')->name('store_brands');
	Route::get('/edit_brands/{id}', 'BrandsController@edit')->name('edit_brands');
	Route::post('/edit_brands', 'BrandsController@update')->name('update_brands');
	Route::post('/delete_brands', 'BrandsController@delete')->name('delete_brands');
	Route::post('/delete_brands_all', 'BrandsController@DeleteAll')->name('delete_brands_all');
	Route::get('/status_brands/{id}', 'BrandsController@StatusBrands')->name('status_brands');
	Route::post('/brands_block', 'BrandsController@BrandsBlock')->name('brands_block');
	Route::post('/brands_unblock', 'BrandsController@BrandsUnblock')->name('brands_unblock');
	/*Brands Route End*/

	/*Messages Route Start*/
	/*Enquery Route Start*/
	Route::get('/manage_enquiries', 'EnqueriesController@index')->name('manage_enquiries');
	Route::post('/delete_enquiries', 'EnqueriesController@delete')->name('delete_enquiries');
	Route::post('/delete_enquiries_all', 'EnqueriesController@DeleteAll')->name('delete_enquiries_all');
	Route::get('/status_enquiries/{id}', 'EnqueriesController@StatusEnquiries')->name('status_enquiries');
	Route::get('/view_enquiries/{id}', 'EnqueriesController@ViewEnquiries')->name('view_enquiries');
	Route::post('/enquiries_block', 'EnqueriesController@EnquiriesBlock')->name('enquiries_block');
	Route::post('/enquiries_unblock', 'EnqueriesController@EnquiriesUnblock')->name('enquiries_unblock');

	Route::get('/search_enquiry', 'EnqueriesController@SearchEnquiry')->name('search_enquiry');
	/*Enquery Route End*/

	/*News Letter Route Start*/
	Route::get('/manage_news_letters', 'NewsLetterController@index')->name('manage_news_letters');
	Route::post('/delete_news_letters', 'NewsLetterController@delete')->name('delete_news_letters');
	Route::post('/delete_news_letters_all', 'NewsLetterController@DeleteAll')->name('delete_news_letters_all');
	Route::get('/status_news_letters/{id}', 'NewsLetterController@StatusNewsLetters')->name('status_news_letters');
	Route::post('/news_letters_block', 'NewsLetterController@NewsLettersBlock')->name('news_letters_block');
	Route::post('/news_letters_unblock', 'NewsLetterController@NewsLettersUnblock')->name('news_letters_unblock');
	Route::get('/send_news_letters', 'NewsLetterController@SendNewsLetters')->name('send_news_letters');
	Route::post('/send_news_letters', 'NewsLetterController@MailedNewsLetters')->name('mailed_news_letters');

	Route::post('/send/news-letters-email', 'NewsLetterController@sendLettersEmail')->name('send.newsletters.email');
	/*News Letter Route End*/
	/*Messages Route End*/

	/*Transaction Route Start*/
	/*Orders Route Start*/

	Route::get('/custom_orders', 'OrdersController@CustomOrders')->name('custom_orders');
	Route::post('/custom_orders/profit', 'OrdersController@addOrderProfit')->name('orders.update.custom_order.profit');

	Route::get('/view_customise_orders/{id}', 'OrdersController@viewCustomise')->name('view_customise_orders');
	Route::get('/edit_customise_orders/{id}', 'OrdersController@editCustomise')->name('edit_customise_orders');
	Route::post('/edit_customise_orders', 'OrdersController@updateCustomise')->name('update_customise_orders');
	Route::post('/paymentstatus_customise_orders', 'OrdersController@PaymentStatusOrdersCustomise')->name('paymentstatus_customise_orders');
	Route::post('/delete_customise_orders', 'OrdersController@deleteCustomise')->name('delete_customise_orders');
	Route::post('/delete_all_customise_orders', 'OrdersController@deleteCustomiseAll')->name('delete_all_customise_orders');
	Route::post('/status_customise_orders', 'OrdersController@StatusCustomiseOrders')->name('status_customise_orders');
	Route::get('/all_orders', 'OrdersController@AllOrders')->name('all_orders');

	Route::get('/all_deleted_orders', 'OrdersController@AllDeletedOrders')->name('all_deleted_orders');


	Route::post('/orders/update-tracking', 'OrdersController@updateTracking')->name('orders.update.tracking');
	Route::post('/orders/additional-discount', 'OrdersController@addDiscount')->name('orders.update.additional.discount');


	Route::get('/replace_all_orders', 'OrdersController@ReplaceOrders')->name('replace_all_orders');
	Route::get('/cancel_all_orders', 'OrdersController@CancelAllOrders')->name('cancel_all_orders');
	Route::get('/cancel_req_orders', 'OrdersController@CancelReqOrders')->name('cancel_req_orders');

	Route::post('/send-cancel_req-email', 'OrdersController@sendCancelReqEmail')->name('send.cancel-request.email');
	Route::post('/send-cancel_reject-email', 'OrdersController@sendCancelRejectEmail')->name('send.cancel-reject.email');

	Route::get('/cancel_req_accept/{id}', 'OrdersController@CancelReqAccept')->name('cancel_req_accept');
	Route::post('/cancel_req_status/', 'OrdersController@CancelReqStatus')->name('cancel_req_status');
	Route::post('/approve-cancel-orders', 'OrdersController@approveCancelOrders')->name('approve.cancel.orders');
	Route::post('/reject-cancel-orders', 'OrdersController@rejectCancelOrders')->name('reject.cancel.orders');

	Route::get('/new_orders/', 'OrdersController@NewOrders')->name('new_orders');
	Route::get('/create_credit_notes/', 'OrdersController@CreateCreditNotes')->name('create_credit_notes');
	Route::post('/new_orders/', 'OrdersController@SaveNewOrders')->name('save_new_orders');
	Route::post('/get_grv/', 'OrdersController@GetGRV')->name('get_grv');
	Route::post('/get_ex_grv/', 'OrdersController@GetEXGRV')->name('get_ex_grv');
	Route::post('/get_cn_grv/', 'OrdersController@GetCNGRV')->name('get_cn_grv');
	Route::get('/edit_orders/{id}', 'OrdersController@edit')->name('edit_orders');
	Route::post('/edit_orders', 'OrdersController@update')->name('update_orders');
	Route::get('/delivery_orders/{id}', 'OrdersController@EditDelivery')->name('delivery_orders');
	Route::post('/delivery_orders', 'OrdersController@UpdateDelivery')->name('update_delivery_orders');
	Route::get('/view_orders/{id}', 'OrdersController@view')->name('view_orders');
	Route::post('/status_orders', 'OrdersController@StatusOrders')->name('status_orders');
	Route::post('/paymentstatus_orders', 'OrdersController@PaymentStatusOrders')->name('paymentstatus_orders');
	Route::post('/delete_orders', 'OrdersController@delete')->name('delete_orders');
	Route::post('/delete_all_orders', 'OrdersController@DeleteAll')->name('delete_all_orders');
	Route::post('/check_tax', 'OrdersController@CheckTax')->name('check_tax');
	Route::post('/delete_odr_det', 'OrdersController@DeleteOrderDetails')->name('delete_odr_det');
	Route::post('/srh_products', 'OrdersController@SearchProducts')->name('srh_products');
	Route::post('/apply_products', 'OrdersController@ApplyProducts')->name('apply_products');
	Route::post('/export_csv_order', 'OrdersController@ExportCSV')->name('export_csv_order');

	Route::post('/export_csv_custom_order', 'OrdersController@ExportCSVCustom')->name('export_csv_custom_order');
	Route::get('/search_order', 'OrdersController@SearchOrder')->name('search_order');
	Route::post('/refundstatus_orders', 'OrdersController@RefundStatusOrders')->name('refundstatus_orders');

	Route::get('/manage_credit_notes', 'OrdersController@AllCreditNotes')->name('manage_credit_notes');
	Route::get('/view_credit_notes/{id}', 'OrdersController@ViewCreditNotes')->name('view_credit_notes');
	Route::post('/status_credit_notes', 'OrdersController@StatusCreditNotes')->name('status_credit_notes');
	Route::get('/transaction_summary', 'OrdersController@TransactionSummary')->name('transaction_summary');
	Route::get('/filter_transaction_summary', 'OrdersController@FilterTransactionSummary')->name('filter_transaction_summary');
	/*Orders Route End*/

	/*Return Orders Route Start*/
	Route::get('/return_all_orders', 'ReturnOrderController@ReturnAllOrders')->name('return_all_orders');
	Route::get('/view_return_orders/{id}', 'ReturnOrderController@view')->name('view_return_orders');
	Route::post('/return_sts_orders/', 'ReturnOrderController@ReturnStsOrders')->name('return_sts_orders');
	Route::get('/get_reject_return_orders/{id}', 'ReturnOrderController@GetReturnOrdersStatus')->name('get_reject_return_orders');
	Route::post('/reject_return_orders/', 'ReturnOrderController@ReturnOrdersStatus')->name('reject_return_orders');
	Route::post('/delete_ret_detz/', 'ReturnOrderController@ReturnOrdersDelete')->name('delete_ret_detz');
	Route::post('/export_return_order', 'ReturnOrderController@ExportCSV')->name('export_return_order');
	/*Return Orders Route End*/

	/*GRV Return Orders Route Start*/
	Route::get('/grv_orders', 'GrvOrdersController@GRVOrders')->name('grv_orders');
	Route::get('/create_grv_orders/{id}', 'GrvOrdersController@CreateGRVOrders')->name('create_grv_orders');
	Route::post('/create_grv_orders', 'GrvOrdersController@StoreGRVOrders')->name('store_grv_orders');
	Route::get('/view_grv_orders/{id}', 'GrvOrdersController@view')->name('view_grv_orders');
	Route::post('/grv_sts_orders/', 'GrvOrdersController@GRVStsOrders')->name('grv_sts_orders');
	Route::get('/edit_grv_orders/{id}', 'GrvOrdersController@edit')->name('edit_grv_orders');
	Route::post('/edit_grv_orders', 'GrvOrdersController@update')->name('update_grv_orders');
	Route::post('/export_grv_order', 'GrvOrdersController@ExportCSV')->name('export_grv_order');
	/*GRV Return Orders Route End*/

	/*Courier Route Start*/
	Route::get('/courier_track', 'CourierTrackController@AllOrders')->name('courier_track');
	Route::get('/view_courier_track/{id}', 'CourierTrackController@view')->name('view_courier_track');
	Route::post('/export_co_csv_order', 'CourierTrackController@ExportCourierCSV')->name('export_co_csv_order');
	Route::get('/search_cou_order', 'CourierTrackController@SearchCouOrder')->name('search_cou_order');
	/*Courier Route End*/

	/*Shipment Orders Route Start*/
	Route::get('/shipment_order', 'ShipmentController@AllShipment')->name('shipment_order');
	Route::get('/add_shipment_order', 'ShipmentController@create')->name('add_shipment_order');
	Route::post('/add_shipment_order', 'ShipmentController@store')->name('store_shipment_order');
	Route::get('/add_bulk_shipment_order', 'ShipmentController@BulkCreate')->name('add_bulk_shipment_order');
	Route::post('/add_bulk_shipment_order', 'ShipmentController@BulkStore')->name('store_bulk_shipment_order');
	Route::get('/view_shipment_order/{id}', 'ShipmentController@view')->name('view_shipment_order');
	Route::get('/edit_shipment_order/{id}', 'ShipmentController@edit')->name('edit_shipment_order');
	Route::post('/edit_shipment_order', 'ShipmentController@update')->name('update_shipment_order');
	Route::post('/delete_shipment_order', 'ShipmentController@delete')->name('delete_shipment_order');
	Route::post('/delete_all_shipment_order', 'ShipmentController@DeleteAll')->name('delete_all_shipment_order');
	Route::get('/search_shipment', 'ShipmentController@SearchShipment')->name('search_shipment');
	Route::post('/export_shipment_order', 'ShipmentController@ExportShipmentCSV')->name('export_shipment_order');
	/*Shipment Orders Route End*/

	/*Transaction Route Start*/
	Route::get('/all_transaction', 'OrdersTransactionsController@AllTransaction')->name('all_transaction');
	Route::get('/view_transaction/{id}', 'OrdersTransactionsController@view')->name('view_transaction');
	Route::post('/export_csv_trans', 'OrdersTransactionsController@ExportTransCSV')->name('export_csv_trans');
	Route::post('/delete_trans', 'OrdersTransactionsController@delete')->name('delete_trans');
	Route::post('/delete_all_trans', 'OrdersTransactionsController@DeleteAll')->name('delete_all_trans');
	Route::get('/search_trans', 'OrdersTransactionsController@SearchTrans')->name('search_trans');
	/*Transaction Route End*/

	/*Transaction Route End*/


	/*Merchant User Route Start*/
	/* Dashboard Routes Start */
	Route::get('/merchants_dashboard', 'DashboardController@MerchantsDashboard')->name('merchants_dashboard');
	/* Dashboard Routes End */

	/* Settings Routes Start */
	/*Account Setting Route Start*/
	Route::get('/account_setting', 'AccountSettingsController@create')->name('create_account_setting');
	Route::post('/account_setting', 'AccountSettingsController@store')->name('store_account_setting');
	/*Account Setting Route End*/
	/* Settings Routes End */

	/*Bank Details Route Start*/
	Route::get('/bank_details', 'BankDetailsController@index')->name('bank_details');
	Route::get('/add_bank_details', 'BankDetailsController@create')->name('add_bank_details');
	Route::post('/add_bank_details', 'BankDetailsController@store')->name('store_bank_details');
	Route::get('/view_bank_details/{id}', 'BankDetailsController@view')->name('view_bank_details');
	Route::get('/edit_bank_details/{id}', 'BankDetailsController@edit')->name('edit_bank_details');
	Route::post('/edit_bank_details', 'BankDetailsController@update')->name('update_bank_details');
	Route::post('/delete_bank_details', 'BankDetailsController@delete')->name('delete_bank_details');
	Route::post('/delete_all_bank_details', 'BankDetailsController@DeleteAll')->name('delete_all_bank_details');
	Route::post('/bank_default', 'BankDetailsController@BankDefault')->name('bank_default');
	/*Bank Details Route End*/

	/*Merchant User Route End*/
});
