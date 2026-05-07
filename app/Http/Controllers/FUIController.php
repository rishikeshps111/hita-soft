<?php

namespace App\Http\Controllers;

use App\CentralLogics\PhonePe;
use Illuminate\Http\Request;
use App\User;
use App\loginSecurity;
use App\MerchantsDocuments;
use App\ShippingAddress;
use App\ShippingSetting;
use App\Coupon;
use App\CouponUsage;
use App\Store;
use App\CityManagement;
use App\StateManagements;
use App\CountriesManagement;
use App\EmailSettings;
use App\ContactUsPage;
use App\GeneralSettings;
use App\PaymentMethod;
use App\Widget;
use App\BannerImageSettings;
use App\CategoryAdvertisementSettings;
use App\CategoryManagementSettings;
use App\SubCategoryManagementSettings;
use App\SubSubCategoryManagementSettings;
use App\Products;
use App\ProductsAttributes;
use App\StockManagement;
use App\AttributesSettings;
use App\AttributesFields;
use App\ProductsImages;
use App\MeasurementUnits;
use App\Tags;
use App\Address;
use App\CMSPageManagement;
use App\TermsCMSSettings;
use App\AboutUsCMSSettings;
use App\AboutAwards;
use App\Disclaimers;
use App\Contacts;
use App\Career;
use App\CareerJobs;
use App\CareerForm;
use App\NewsLetter;
use App\SizeSettings;
use App\ColorSettings;
use App\Brands;
use App\Carts;
use App\TaxCutoff;
use App\Cod;
use App\WishList;
use App\OurArtist;
use App\PaymentSettings;
use App\Orders;
use App\OrderDetails;
use App\OrdersTransactions;
use App\DemoOrders;
use App\DemoOrderDetails;
use App\DemoOrdersTransactions;
use App\StockTransactions;
use App\Shipment;
use App\AdminCommision;
use App\Review;
use App\FeedBack;
use App\ShypliteAuth;
use App\ReturnOrder;
use App\ReturnOrderDetails;
use App\Offers;
use App\OffersSub;
use App\OfferTransaction;
use App\SellOnFolkgemsPage;
use App\FAQPage;
use App\FAQS;
use App\CommonModel;
use App\TestimonialSetting;
use App\CustomiseProduct;
use App\HomeService;

use Pdf;
use Collective\Html\HtmlFacade;
use Illuminate\Support\Facades\Validator;
use Crypt;
use Response;
use Input;
use DB;
use View;
use Session;
use Redirect;
use URL;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail;
use App\Mail\RegisterSuccessMail;


class FUIController extends Controller
{
    protected $respose;
    protected $common;

    public function __construct(Response $response)
    {
        $this->response = $response;
        $this->common = new CommonModel();
    }

    public function array_flatten($array)
    {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function Home()
    {
        $merchant = User::WhereIn('user_type', [2, 3])->Where('is_block', 1)->get();
        $banner_images = BannerImageSettings::Where('is_block', 1)->get();
        $main_cat = CategoryManagementSettings::Where('is_block', 1)->Where('is_top_cat', 1)->OrderBy('priority', 'ASC')->take(15)->get();
        $main_cat_ids = $main_cat->pluck('id')->toArray();
        $sub_cat = SubCategoryManagementSettings::whereIn('main_cat_name', $main_cat_ids)
            ->where('is_block', 1)
            ->get();
        $brand = Brands::Where('is_block', 1)->OrderBy('id', 'desc')->take(12)->get();
        $first_cat = CategoryManagementSettings::Where('is_block', 1)->Where('is_home', 1)->first();
        $second_cat = CategoryManagementSettings::Where('is_block', 1)->Where('is_home', 2)->first();
        $third_cat = CategoryManagementSettings::Where('is_block', 1)->Where('is_home', 3)->first();
        $widget = Widget::first();
        $artist = OurArtist::first();

        $first_products = array();
        if ($first_cat) {
            $first_products = Products::Where('is_block', 1)->Where('main_cat_name', $first_cat->id)->get();
        }

        $second_products = array();
        if ($second_cat) {
            $second_products = Products::Where('is_block', 1)->Where('main_cat_name', $second_cat->id)->get();
        }

        $third_products = array();
        if ($third_cat) {
            $third_products = Products::Where('is_block', 1)->Where('main_cat_name', $third_cat->id)->get();
        }

        $top_products = Products::Where('is_block', 1)->Where('toprated_flag', 1)->get();
        $featured_products = Products::Where('is_block', 1)->Where('featuredproduct_flag', 1)->OrderBy('id', 'desc')->take(15)->get();
        $best_seller = Products::Where('is_block', 1)->Where('best_seller_flag', 1)->OrderBy('id', 'desc')->take(10)->get();
        $latest_products = Products::Where('is_block', 1)->OrderBy('id', 'desc')->take(8)->get();
        $new_arrival = Products::Where('is_block', 1)->Where('new_arrival', 1)->OrderBy('id', 'desc')->take(15)->get();

        $offer_products = Offers::Where('is_block', 1)->where(function ($q) {
            $q->where('offer_end', '>=', date("Y-m-d H:i:s"))
                ->orWhereNull('offer_end');
        })->OrderBy('id', 'desc')->paginate(10);

        $about = AboutUsCMSSettings::first();
        if ($about) {
            $aaws = AboutAwards::Where('about_id', $about->id)->get();
        } else {
            Session::flash('message', 'Page Not Found');
        }
        $testimonial = TestimonialSetting::get();
        $home_services = HomeService::where('is_block', 1)->orderBy('priority', 'ASC')->orderBy('id', 'ASC')->get();

        return View::make("front_end.index")->with(array('banner_images' => $banner_images, 'main_cat' => $main_cat, 'sub_cat' => $sub_cat, 'brand' => $brand, 'first_cat' => $first_cat, 'second_cat' => $second_cat, 'third_cat' => $third_cat, 'first_products' => $first_products, 'second_products' => $second_products, 'third_products' => $third_products, 'top_products' => $top_products, 'featured_products' => $featured_products, 'best_seller' => $best_seller, 'latest_products' => $latest_products, 'new_arrival' => $new_arrival, 'widget' => $widget, 'artist' => $artist, 'offer_products' => $offer_products, 'about' => $about, 'aaws' => $aaws, 'testimonial' => $testimonial, 'home_services' => $home_services));
    }

    public function MainSearch(Request $request)
    {
        $data = $request->all();
        $keyword = $data['main_srh'];
        $all_products = array();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

        if ($keyword) {
            $exp = explode(' ', $keyword);

            $all_products = Products::Where('is_block', 1)->where(function ($q) use ($exp) {
                foreach ($exp as $ekey => $evalue) {
                    $q->orWhere('product_title', 'LIKE', '%' . $evalue . '%');
                }
            })->orderByRaw('CASE WHEN onhand_qty = 0 THEN 1 ELSE 0 END')->OrderBy('id', 'desc')->paginate(32);


            if (sizeof($all_products) == 0) {
                $catsz = CategoryManagementSettings::Where('is_block', 1)->select('id')->distinct()->where(function ($q) use ($exp) {
                    foreach ($exp as $ekey => $evalue) {
                        $q->orWhere('main_cat_name', 'LIKE', '%' . $evalue . '%');
                    }
                })->OrderBy('id', 'desc')->get();

                // print_r($catsz);die();

                if (sizeof($catsz) != 0) {
                    $all_products = Products::Where('is_block', 1)->WhereIn('main_cat_name', $catsz)->OrderBy('id', 'desc')->paginate(32);
                }
            }

            // print_r($all_products);die();
        }


        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();


        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }

            return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'stars' => $stars));
        } else {
            Session::flash('message', 'Sorry No Products For This Keyword!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('home');
        }
    }

    public function AllProducts(Request $request)
    {
        $data = $request->all();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $brands = Brands::Where('is_block', 1)->get();
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        // $all_products = Products::Where('is_block',1)->OrderBy('id', 'desc')->paginate(32);
        // $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block',1)->OrderBy('id', 'desc')->take(32)->get();
        // $widget = Widget::first();

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
                $category[$key]->{'sub'} = SubCategoryManagementSettings::Where('main_cat_name', $value->id)->Where('is_block', 1)->get();
            }
        }

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

        $all_products = Products::Where('is_block', 1);
        //$all_products = Products::query()->where('is_block', 1)->orderBy('created_at', 'desc');

        $filter['main_cat'] = '';

        if (isset($data['main_cat']) && $data['main_cat']) {
            $filter['main_cat'] = $data['main_cat'];
            $main_cat = $data['main_cat'];

            // Get all subcategories under the selected main category
            $subcategories = SubCategoryManagementSettings::where('main_cat_name', $main_cat)
                ->where('is_block', 1)
                ->pluck('sub_cat_id')
                ->toArray();

            // Include main category and its subcategories in the product filter
            $all_products->where(function ($query) use ($main_cat, $subcategories) {
                $query->where('main_cat_name', $main_cat)
                    ->orWhereIn('sub_cat_name', $subcategories);
            });
        }

        if (isset($data['main_cat']) && $data['main_cat']) {
            $filter['main_cat'] = $data['main_cat'];
            $main_cat = $data['main_cat'];
            $all_products->Where('main_cat_name', $main_cat);
        }

        if (isset($data['sub_cat']) && $data['sub_cat']) {
            $filter['sub_cat'] = $data['sub_cat'];
            $sub_cat = $data['sub_cat'];
            $all_products->Where('sub_cat_name', $sub_cat);
        }

        if (isset($data['sub_sub_cat']) && $data['sub_sub_cat']) {
            $filter['sub_sub_cat'] = $data['sub_sub_cat'];
            $sub_sub_cat = $data['sub_sub_cat'];
            $all_products->Where('sub_sub_cat_name', $sub_sub_cat);
        }

        // print_r($data['brand']);die();
        $brsz = [];
        if (isset($data['brand']) && sizeof($data['brand']) != 0) {
            foreach ($data['brand'] as $bkey => $bvalue) {
                array_push($brsz, $bvalue);
            }

            if (sizeof($brsz) != 0) {
                $all_products->WhereIn('brand', $brsz);
            }
        }

        $r_p_ids = [];
        if (isset($data['review']) && sizeof($data['review']) != 0) {
            foreach ($data['review'] as $rtkey => $rtvalue) {
                $rev = Review::Where('is_block', 1)->Where('rating', $rtvalue)->get();
                if (sizeof($rev) != 0) {
                    foreach ($rev as $revkey => $revvalue) {
                        array_push($r_p_ids, $revvalue->product_id);
                    }
                }
            }

            if (sizeof($r_p_ids) != 0) {
                $all_products->whereIn('id', $r_p_ids);
            }
        }

        // print_r($data);die();
        $min_pce = "";
        $max_pce = "";
        if (isset($data['min_pce'])) {
            $min_pce  = $data['min_pce'];
        }

        if (isset($data['max_pce'])) {
            $max_pce  = $data['max_pce'];
        }

        if (($min_pce) && ($max_pce)) {
            $all_products->WhereBetween('discounted_price', [$min_pce, $max_pce]);
        } elseif (($min_pce)) {
            $all_products->Where('discounted_price', '>=', $min_pce);
        } elseif (($max_pce)) {
            $all_products->Where('discounted_price', '<=', $max_pce);
        }
        if (!empty($data['main_cat_filter']) && $data['main_cat_filter'] != '8') {
            $all_products->where('main_cat_name', $data['main_cat_filter']); // Use your actual column name
        }

        if (isset($data['sort_fitler']) && $data['sort_fitler'] == "latest") {
            $all_products->OrderBy('id', 'desc');
        } else if (isset($data['sort_fitler']) && $data['sort_fitler'] == "popular") {
            $all_products->OrderBy('id', 'desc');
        } else if (isset($data['sort_fitler']) && $data['sort_fitler'] == "l_h") {
            $all_products->OrderBy('discounted_price', 'asc');
        } else if (isset($data['sort_fitler']) && $data['sort_fitler'] == "h_l") {
            $all_products->OrderBy('discounted_price', 'desc');
        } else {
            $all_products->OrderBy('created_at', 'desc');
        }

        $all_products = $all_products->GroupBy('id')->get();

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }
        }

        return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'attributes' => $attributes, 'brands' => $brands, 'filter' => $filter, 'stars' => $stars, 'data' => $data));

        // return View::make("front_end.all_products")->with(array('all_products'=>$all_products, 'category'=>$category, 'featured_products'=>$featured_products, 'attributes'=>$attributes, 'widget'=>$widget, 'filter'=>$filter));
    }

    public function CatLists(Request $request)
    {
        $category = CategoryManagementSettings::Where('is_block', 1);

        $data = $request->all();

        if (isset($data['cat_srh']) && $data['cat_srh']) {
            $keyword = $data['cat_srh'];
            $exp = explode(' ', $keyword);

            $category = CategoryManagementSettings::Where('is_block', 1)->where(function ($q) use ($exp) {
                foreach ($exp as $ekey => $evalue) {
                    $q->orWhere('main_cat_name', 'LIKE', '%' . $evalue . '%');
                }
            });
        }

        if (isset($data['filter']) && $data['filter'] == "latest") {
            $category = $category->OrderBy('id', 'desc')->get();
        } else {
            $category = $category->OrderBy('id', 'desc')->get();
            // $category = $category->get(); 
        }

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
                $category[$key]->{'cat_prods'} = $a_c_products;
            }

            return view("front_end.cat_lists")->with(array('category' => $category));
        } else {
            Session::flash('message', 'Data Not Found!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
    }

    public function SubCatLists(Request $request, $main_cat)
    {
        $category = SubCategoryManagementSettings::Where('main_cat_name', $main_cat)->Where('is_block', 1);

        $data = $request->all();

        if (isset($data['cat_srh']) && $data['cat_srh']) {
            $keyword = $data['cat_srh'];
            $exp = explode(' ', $keyword);

            $category = SubCategoryManagementSettings::Where('is_block', 1)->where(function ($q) use ($exp) {
                foreach ($exp as $ekey => $evalue) {
                    $q->orWhere('sub_cat_name', 'LIKE', '%' . $evalue . '%');
                }
            });
        }

        if (isset($data['filter']) && $data['filter'] == "latest") {
            $category = $category->OrderBy('sub_cat_id', 'desc')->get();
        } else {
            $category = $category->OrderBy('sub_cat_id', 'desc')->get();
            // $category = $category->get(); 
        }

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('sub_cat_name', $value->sub_cat_id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
                $category[$key]->{'cat_prods'} = $a_c_products;
            }

            return View::make("front_end.sub_cat_lists")->with(array('category' => $category, 'main_cat' => $main_cat));
        } else {
            Session::flash('message', 'Data Not Found!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
    }

    public function SubSubCatLists(Request $request, $sub_cat)
    {
        $category = SubSubCategoryManagementSettings::Where('sub_cat_name', $sub_cat)->Where('is_block', 1);

        $data = $request->all();

        if (isset($data['cat_srh']) && $data['cat_srh']) {
            $keyword = $data['cat_srh'];
            $exp = explode(' ', $keyword);

            $category = SubSubCategoryManagementSettings::Where('is_block', 1)->where(function ($q) use ($exp) {
                foreach ($exp as $ekey => $evalue) {
                    $q->orWhere('sub_sub_cat_name', 'LIKE', '%' . $evalue . '%');
                }
            });
        }

        if (isset($data['filter']) && $data['filter'] == "latest") {
            $category = $category->OrderBy('sub_sub_cat_id', 'desc')->get();
        } else {
            $category = $category->OrderBy('sub_sub_cat_id', 'desc')->get();
            // $category = $category->get(); 
        }

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('sub_sub_cat_name', $value->sub_sub_cat_id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
                $category[$key]->{'cat_prods'} = $a_c_products;
            }

            return View::make("front_end.sub_sub_cat_lists")->with(array('category' => $category, 'sub_cat' => $sub_cat));
        } else {
            Session::flash('message', 'Data Not Found!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::back();
        }
    }

    public function AllCatProducts($main_cat)
    {
        $all_products = Products::Where('main_cat_name', $main_cat)->Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());


        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }
        }
        return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'stars' => $stars));
    }

    public function AllFilterProducts(Request $request)
    {
        $data = $request->all();
        $p_id = [];
        $p_amount1 = "";
        $p_amount2 = "";
        $fil_cats  = "";
        $fil_ss_cats  = "";
        $fil_brnd  = "";
        $fil_atts  = "";
        $sort_by   = "";
        // print_r($data);die();

        if (isset($data['p_amount1'])) {
            $p_amount1  = $data['p_amount1'];
        }

        if (isset($data['p_amount2'])) {
            $p_amount2  = $data['p_amount2'];
        }

        if (isset($data['fil_cats'])) {
            $fil_cats  = $data['fil_cats'];
        }

        if (isset($data['fil_ss_cats'])) {
            $fil_ss_cats  = $data['fil_ss_cats'];
        }

        if (isset($data['fil_brnd'])) {
            $fil_brnd  = $data['fil_brnd'];
        }

        if (isset($data['fil_atts'])) {
            $fil_atts  = $data['fil_atts'];
        }

        if (isset($data['fil_sort'])) {
            $sort_by  = $data['fil_sort'];
        }

        // $all_products = array();
        $all_products = Products::Where('is_block', 1);
        if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_ss_cats)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_brnd)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_cats) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($fil_cats) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_ss_cats)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_brnd)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('is_block', 1);
                }
            } else {
                $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_cats) && ($fil_ss_cats)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_cats) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_cats) && ($fil_ss_cats)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_cats) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($fil_cats) && ($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($fil_cats) && ($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($fil_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1) && ($p_amount2)) {
            $all_products = Products::WhereBetween('discounted_price', [$p_amount1, $p_amount2])->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_cats)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_ss_cats)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('is_block', 1);
            }
        } else if (($p_amount2) && ($fil_cats)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_ss_cats)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_brnd)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount2) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('is_block', 1);
            }
        } else if (($fil_cats) && ($fil_ss_cats)) {
            $all_products = Products::Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($fil_cats) && ($fil_brnd)) {
            $all_products = Products::Where('main_cat_name', $fil_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($fil_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('main_cat_name', $fil_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('main_cat_name', $fil_cats)->Where('is_block', 1);
            }
        } else if (($fil_ss_cats) && ($fil_brnd)) {
            $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($p_amount1) && ($p_amount2) && ($fil_cats) && ($fil_ss_cats) && ($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('main_cat_name', $fil_cats)->Where('sub_sub_cat_name', $fil_ss_cats)->Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($fil_ss_cats) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
            }
        } else if (($fil_brnd) && ($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::Where('brand', $fil_brnd)->WhereIn('id', $p_id)->Where('is_block', 1);
                } else {
                    $all_products = Products::Where('brand', $fil_brnd)->Where('is_block', 1);
                }
            } else {
                $all_products = Products::Where('brand', $fil_brnd)->Where('is_block', 1);
            }
        } else if (($p_amount1)) {
            $all_products = Products::Where('discounted_price', '>=', $p_amount1)->Where('is_block', 1);
        } else if (($p_amount2)) {
            $all_products = Products::Where('discounted_price', '<=', $p_amount2)->Where('is_block', 1);
        } else if (($fil_cats)) {
            $all_products = Products::Where('main_cat_name', $fil_cats)->Where('is_block', 1);
        } else if (($fil_ss_cats)) {
            $all_products = Products::Where('sub_sub_cat_name', $fil_ss_cats)->Where('is_block', 1);
        } else if (($fil_brnd)) {
            $all_products = Products::Where('brand', $fil_brnd)->Where('is_block', 1);
        } else if (($fil_atts)) {
            $att = ProductsAttributes::where('attribute_values', $fil_atts)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                if (count($p_id) != 0) {
                    $all_products = Products::WhereIn('id', $p_id)->Where('is_block', 1);
                }
            }
        } else {
            // Session::flash('message', 'No More Products by your Searched Items!'); 
            // Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('all_products');
        }

        // print_r($sort_by);die();

        if (isset($sort_by) && !empty($sort_by)) {
            if ($sort_by == "manual") {
                $all_products = $all_products->Where('featuredproduct_flag', 1);
            } elseif ($sort_by == "best-selling") {
                $all_products = $all_products->Where('best_seller_flag', 1);
            } elseif ($sort_by == "title-ascending") {
                $all_products = $all_products->OrderBy('product_title', 'asc');
            } elseif ($sort_by == "title-descending") {
                $all_products = $all_products->OrderBy('product_title', 'desc');
            } elseif ($sort_by == "price-ascending") {
                $all_products = $all_products->OrderBy('discounted_price', 'asc');
            } elseif ($sort_by == "price-descending") {
                $all_products = $all_products->OrderBy('discounted_price', 'desc');
            } elseif ($sort_by == "created-ascending") {
                $all_products = $all_products->OrderBy('created_at', 'asc');
            } elseif ($sort_by == "star-ascending") {
                $prods = Products::Where('is_block', 1)->OrderBy('id', 'desc')->get();
                if (($prods) && (count($prods) != 0)) {
                    foreach ($prods as $pkeyzz => $pvaluezz) {
                        $reviews = Review::Where('product_id', $pvaluezz->id)->Where('is_block', 1)->get();
                        $p_avgs = 0;
                        if (count($reviews) != 0) {
                            $p_sum = $reviews->sum('rating');
                            $cntz = count($reviews);
                            if ($p_sum != 0) {
                                $p_avgs = $p_sum / $cntz;
                            } else {
                                $p_avgs = 0;
                            }
                        }
                        $prods[$pkeyzz]->{'review'} = $p_avgs;
                    }
                }
                $p_ids = array();
                foreach ($prods as $pkey => $pvalue) {
                    if (isset($pvalue->review) && $pvalue->review != 0) {
                        $p_ids[] = $pvalue->id;
                    }
                }

                $all_products = $all_products->WhereIn('id', $p_ids);
            }
        } else {
            Session::flash('message', 'No More Products by your Searched Items!');
            Session::flash('alert-class', 'alert-danger');
            $all_products = $all_products->OrderBy('id', 'desc');
        }

        $all_products = $all_products->paginate(32);
        // print_r($all_products);die();

        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());


        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }
        }

        if (count($all_products) != 0) {
            return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'filter_cats' => $fil_cats, 'filter_ss_cats' => $fil_ss_cats, 'filter_brnd' => $fil_brnd, 'filter_atts' => $fil_atts, 'filter_amount1' => $p_amount1, 'filter_amount2' => $p_amount2, 'filter_sort' => $sort_by, 'stars' => $stars));
        } else {
            Session::flash('message', 'No More Products by your Searched Items!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('all_products');
        }
    }

    public function ValueFilterProducts($id)
    {
        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

        if ($id != 0) {
            $att = ProductsAttributes::where('attribute_values', $id)->get();
            if (isset($att) && count($att) != 0) {
                foreach ($att as $keyz => $valuez) {
                    $p_id[] = $valuez->product_id;
                }

                $all_products = "";
                if (count($p_id) != 0) {
                    $all_products = Products::WhereIn('id', $p_id)->Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
                }

                $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
                $attributes = AttributesSettings::Where('is_block', 1)->get();
                $widget = Widget::first();

                if (($category) && (count($category) != 0)) {
                    foreach ($category as $key => $value) {
                        $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                        $category[$key]->{'cat_count'} = count($a_c_products);
                    }
                }

                if (($all_products) && (count($all_products) != 0)) {
                    $max = Products::max('discounted_price');
                    $all_products->{'max_price'} = $max;
                    foreach ($all_products as $keyzz => $valuezz) {
                        $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                        $average = 0;
                        if (count($review) != 0) {
                            $sum = $review->sum('rating');
                            $count = count($review);
                            if ($sum != 0) {
                                $average = $sum / $count;
                            } else {
                                $average = 0;
                            }
                        }
                        $all_products[$keyzz]->{'review'} = $average;
                    }
                }

                return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'stars' => $stars));
            } else {
                Session::flash('message', 'No More Product for Your Search!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('all_products');
            }
        } else {
            Session::flash('message', 'No More Product for Your Search!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('all_products');
        }
    }

    public function SortFilterProducts()
    {
        $data = $request->all();
        $all_products = "";
        // print_r($data);die();

        if (isset($data['SortBy']) && !empty($data['SortBy'])) {
            if ($data['SortBy'] == "manual") {
                $all_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
            } elseif ($data['SortBy'] == "best-selling") {
                /*not develope*/
                $all_products = Products::Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
            } elseif ($data['SortBy'] == "title-ascending") {
                $all_products = Products::Where('is_block', 1)->OrderBy('product_title', 'asc')->paginate(32);
            } elseif ($data['SortBy'] == "title-descending") {
                $all_products = Products::Where('is_block', 1)->OrderBy('product_title', 'desc')->paginate(32);
            } elseif ($data['SortBy'] == "price-ascending") {
                $all_products = Products::Where('is_block', 1)->OrderBy('discounted_price', 'asc')->paginate(32);
            } elseif ($data['SortBy'] == "price-descending") {
                $all_products = Products::Where('is_block', 1)->OrderBy('discounted_price', 'desc')->paginate(32);
            } elseif ($data['SortBy'] == "created-ascending") {
                $all_products = Products::Where('is_block', 1)->OrderBy('created_at', 'asc')->paginate(32);
            } elseif ($data['SortBy'] == "star-ascending") {
                $prods = Products::Where('is_block', 1)->OrderBy('id', 'desc')->get();
                if (($prods) && (count($prods) != 0)) {
                    foreach ($prods as $pkeyzz => $pvaluezz) {
                        $reviews = Review::Where('product_id', $pvaluezz->id)->Where('is_block', 1)->get();
                        $p_avgs = 0;
                        if (count($reviews) != 0) {
                            $p_sum = $reviews->sum('rating');
                            $cntz = count($reviews);
                            if ($p_sum != 0) {
                                $p_avgs = $p_sum / $cntz;
                            } else {
                                $p_avgs = 0;
                            }
                        }
                        $prods[$pkeyzz]->{'review'} = $p_avgs;
                    }
                }
                $p_ids = array();
                foreach ($prods as $pkey => $pvalue) {
                    if (isset($pvalue->review) && $pvalue->review != 0) {
                        $p_ids[] = $pvalue->id;
                    }
                }
                $all_products = Products::WhereIn('id', $p_ids)->Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
            } else {
                $all_products = Products::Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
            }

            $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
            $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
            $attributes = AttributesSettings::Where('is_block', 1)->get();
            $widget = Widget::first();

            $stars = array();
            $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
            $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
            $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
            $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
            $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

            if (($category) && (count($category) != 0)) {
                foreach ($category as $key => $value) {
                    $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                    $category[$key]->{'cat_count'} = count($a_c_products);
                }
            }

            if (($all_products) && (count($all_products) != 0)) {
                $max = Products::max('discounted_price');
                $all_products->{'max_price'} = $max;
                foreach ($all_products as $keyzz => $valuezz) {
                    $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                    $average = 0;
                    if (count($review) != 0) {
                        $sum = $review->sum('rating');
                        $count = count($review);
                        if ($sum != 0) {
                            $average = $sum / $count;
                        } else {
                            $average = 0;
                        }
                    }
                    $all_products[$keyzz]->{'review'} = $average;
                }
            }
            return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'stars' => $stars));
        } else {
            Session::flash('message', 'No More Product for Your Search!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('all_products');
        }
    }

    public function OfferProducts()
    {
        $offer_products = Offers::Where('is_block', 1)->where(function ($q) {
            $q->where('offer_end', '>=', date("Y-m-d H:i:s"))
                ->orWhereNull('offer_end');
        })->OrderBy('id', 'desc')->paginate(12);

        if (sizeof($offer_products) != 0) {
            return View::make("front_end.offer_products")->with(array('offer_products' => $offer_products));
        } else {
            Session::flash('message', 'Offers Not Available!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('home');
        }
    }

    public function OfferProductsDetails($id)
    {
        $offer_products = Offers::Where('is_block', 1)->Where('id', $id)->first();
        if ($offer_products) {
            $main_prods = [];
            $offer_prods = [];
            $offers = OffersSub::Where('offer', $offer_products->id)->get();
            if (sizeof($offers) != 0) {
                foreach ($offers as $key => $value) {
                    if ($value->type == 1) {
                        array_push($main_prods, $value->id);
                    } else if ($value->type == 2) {
                        array_push($offer_prods, $value->id);
                    }
                }

                if (sizeof($main_prods) != 0) {
                    $main_products = OffersSub::WhereIn('id', $main_prods)->get();
                    if ($offer_products->offer_type == 1) {
                        if (sizeof($offer_prods) != 0) {
                            $offer_pds = OffersSub::WhereIn('id', $offer_prods)->get();
                            return View::make("front_end.offer_products_dets")->with(array('offer_products' => $offer_products, 'main_products' => $main_products, 'offer_pds' => $offer_pds));
                        } else {
                            Session::flash('message', 'Offers Not Available!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('offer_products');
                        }
                    } else {
                        $offer_pds = array();
                        return View::make("front_end.offer_products_dets")->with(array('offer_products' => $offer_products, 'main_products' => $main_products, 'offer_pds' => $offer_pds));
                    }
                } else {
                    Session::flash('message', 'Offers Not Available!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('offer_products');
                }
            } else {
                Session::flash('message', 'This Offers is closed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('offer_products');
            }
        } else {
            Session::flash('message', 'Offers Not Available!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('offer_products');
        }
    }

    /*public function SubCategory ($main_cat) {
        $sub_cat = SubCategoryManagementSettings::Where('main_cat_name', $main_cat)->Where('is_block',1)->paginate(12);

        return View::make("front_end.sub_category")->with(array('sub_cat'=>$sub_cat));
    }*/

    public function SubCategory($main_cat)
    {
        $sub_cat = SubCategoryManagementSettings::Where('main_cat_name', $main_cat)->Where('is_block', 1)->paginate(32);
        $all_products = Products::Where('main_cat_name', $main_cat)->Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();


        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }
        }
        return View::make("front_end.sub_category")->with(array('sub_cat' => $sub_cat, 'all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget));
    }

    public function SubSubCategory($sub_cat)
    {
        $sub_sub_cat = SubSubCategoryManagementSettings::Where('sub_cat_name', $sub_cat)->Where('is_block', 1)->paginate(32);
        $all_products = Products::Where('is_block', 1)->OrderBy('id', 'desc')->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(32)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();


        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }
        }
        return View::make("front_end.sub_sub_category")->with(array('sub_sub_cat' => $sub_sub_cat, 'all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget));
    }

    public function cateProducts($name, $id = null)
    {
        $categoryName = str_replace('-', ' ', $name);

        $category = CategoryManagementSettings::whereRaw("LOWER(main_cat_name) = ?", [$categoryName])->first();
        // dd($category);

        $sortFilter = request()->get('sort_fitler');
        $subCatFilter = request()->get('sub_cat_filter');
        $minPrice = request()->get('min_price');
        $maxPrice = request()->get('max_price');
        $subCategoryIds = SubCategoryManagementSettings::where('main_cat_name', $category->id)
            ->where('is_block', 1)
            ->pluck('sub_cat_id')
            ->toArray();

        $products = Products::Where('is_block', 1);
        if ($id) {
            $products->where('sub_cat_name', $id);
        } else {
            $products->where(function ($query) use ($category, $subCategoryIds) {
                $query->where('main_cat_name', $category->id)
                    ->orWhereIn('sub_cat_name', $subCategoryIds);
            });
        }



        if ($subCatFilter) {
            $products->where('sub_cat_name', $subCatFilter);
        }

        if (!empty($minPrice)) {
            $products->where('original_price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $products->where('original_price', '<=', $maxPrice);
        }

        if ($sortFilter == "latest" || $sortFilter == "popular") {
            $products->orderBy('id', 'desc');
        } elseif ($sortFilter == "l_h") {
            $products->orderBy('discounted_price', 'asc');
        } elseif ($sortFilter == "h_l") {
            $products->orderBy('discounted_price', 'desc');
        } else {
            $products->orderBy('created_at', 'desc');
        }

        $products = $products->get();
        // dd($products);
        // dd($products);
        return view('front_end.cate_products', compact('products', 'category'));
    }

    public function CategoryProducts($main_cat)
    {
        $filter_cats = $main_cat;
        // $products = Products::Where('main_cat_name', $main_cat)->Where('is_block',1)->paginate(12);

        // return View::make("front_end.category_products")->with(array('products'=>$products));

        $all_products = Products::Where('main_cat_name', $main_cat)->Where('is_block', 1)->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(12)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());


        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }

            return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'filter_cats' => $filter_cats, 'stars' => $stars));
        } else {
            Session::flash('message', 'Category Products Not Available!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('all_products');
        }
    }

    public function SubSubCategoryProducts($sub_sub_cat)
    {
        $filter_ss_cats = $sub_sub_cat;
        // $products = Products::Where('sub_sub_cat_name', $sub_sub_cat)->Where('is_block',1)->paginate(12);

        // return View::make("front_end.sub_sub_category_products")->with(array('products'=>$products));

        $all_products = Products::Where('sub_sub_cat_name', $sub_sub_cat)->Where('is_block', 1)->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(12)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }

            return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'filter_ss_cats' => $filter_ss_cats, 'stars' => $stars));
        } else {
            Session::flash('message', 'Sub Sub Category Products Not Available!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('all_products');
        }
    }

    public function BrandsProducts($id)
    {
        $fil_brnd = $id;
        // $products = Products::Where('brand', $id)->Where('is_block',1)->paginate(12);

        // return View::make("front_end.brands_products")->with(array('products'=>$products));

        $all_products = Products::Where('brand', $id)->Where('is_block', 1)->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(12)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }

            return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'filter_brnd' => $fil_brnd, 'stars' => $stars));
        } else {
            Session::flash('message', 'Brand Products Not Available!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('all_products');
        }
    }

    public function ViewProducts($id)
    {
        $users = session()->get('user');
        $user = null;
        if ($users && $users->user_type == 4) {
            $user = User::Where('id', $users->id)->first();
        }
        $products = Products::with('Attributes')->Where('id', $id)->Where('is_block', 1)->first();
        // dd($products->Attributes); 
        if ($products) {
            $related = Products::where('id', '!=', $id)->where('is_block', 1)->inRandomOrder()->take(3)->get();
            foreach ($related as $item) {
                $item->att = ProductsAttributes::where('product_id', $item->id)
                    ->where('is_block', 1)
                    ->get();
            }
        } else {
            $related = array();
        }
        $review = Review::Where('is_block', 1)->Where('product_id', $id)->orderByDesc('rating')
            ->paginate(10);
        $stars = array();

        $average = 0;
        if (count($review) != 0) {
            $sum = $review->sum('rating');
            $count = count($review);
            if ($sum != 0) {
                $average = $sum / $count;
            } else {
                $average = 0;
            }

            $stars['review5'] = count(Review::Where('is_block', 1)->Where('product_id', $id)->Where('rating', 5)->get());
            $stars['review4'] = count(Review::Where('is_block', 1)->Where('product_id', $id)->Where('rating', 4)->get());
            $stars['review3'] = count(Review::Where('is_block', 1)->Where('product_id', $id)->Where('rating', 3)->get());
            $stars['review2'] = count(Review::Where('is_block', 1)->Where('product_id', $id)->Where('rating', 2)->get());
            $stars['review1'] = count(Review::Where('is_block', 1)->Where('product_id', $id)->Where('rating', 1)->get());
        } else {
            $average = 0;
        }

        $att_id = [];
        $att_vals_id = [];
        if ($products) {
            $products['images'] = ProductsImages::where('product_id', $products->id)->Where('is_block', 1)->get();
            $products['att'] = ProductsAttributes::where('product_id', $products->id)->Where('is_block', 1)->whereNotNull('colors')->get();
            $p_atts = ProductsAttributes::where('product_id', $products->id)->Where('is_block', 1)->groupBy('attribute_name')->get();
            $p_atts_vals = ProductsAttributes::where('product_id', $products->id)->Where('is_block', 1)->get();
            if (sizeof($p_atts) != 0) {
                foreach ($p_atts as $key => $value) {
                    array_push($att_id, $value->attribute_name);
                }
            }

            if (sizeof($p_atts_vals) != 0) {
                foreach ($p_atts_vals as $key => $value) {
                    array_push($att_vals_id, $value->attribute_values);
                }
            }

            if (sizeof($att_id) != 0) {
                $products['att_fields'] = AttributesFields::WhereIn('id', $att_id)->get();
            }

            if (sizeof($att_vals_id) != 0) {
                $products['att_values'] = AttributesSettings::WhereIn('id', $att_vals_id)->get();
            }
            $footer_social_links = DB::table('footer_social_links')->get();

            // dd($colors);
            // print_r($products['att_fields']);
            // print_r($products['att_values']);die();
            // print_r($att_id);die();
            // print_r($p_atts);die();
        } else {
            Session::flash('message', 'Apologies, Item not available for now');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('home');
        }

        return View::make("front_end.view_products")->with(array('p_atts_vals' => $p_atts_vals, 'p_atts' => $p_atts, 'products' => $products, 'footer_social_links' => $footer_social_links, 'related' => $related, 'review' => $review, 'stars' => $stars, 'average' => $average, 'user' => $user));
    }

    public function TagProducts($id)
    {
        $tg = Tags::Where('id', $id)->Where('is_block', 1)->first();
        $ids = array();
        if ($tg) {
            $prod = Products::Where('is_block', 1)->get();
            if (($prod) && (count($prod) != 0)) {
                foreach ($prod as $key => $value) {
                    $tags = json_decode($value->tags);
                    if ($tags && count($tags) != 0) {
                        foreach ($tags as $keys => $values) {
                            if (($tg->id == $values)) {
                                $ids[] = $value->id;
                            }
                        }
                    }
                }
            }
        }

        // $products = Products::WhereIn('id', $ids)->Where('is_block',1)->paginate(12);

        // return View::make("front_end.tag_products")->with(array('products'=>$products));

        $all_products = Products::WhereIn('id', $ids)->Where('is_block', 1)->paginate(32);
        $category = CategoryManagementSettings::Where('is_block', 1)->OrderBy('id', 'desc')->get();
        $featured_products = Products::Where('featuredproduct_flag', 1)->Where('is_block', 1)->OrderBy('id', 'desc')->take(12)->get();
        $attributes = AttributesSettings::Where('is_block', 1)->get();
        $widget = Widget::first();

        $stars = array();
        $stars['review5'] = count(Review::Where('is_block', 1)->Where('rating', 5)->GroupBy('product_id')->get());
        $stars['review4'] = count(Review::Where('is_block', 1)->Where('rating', 4)->GroupBy('product_id')->get());
        $stars['review3'] = count(Review::Where('is_block', 1)->Where('rating', 3)->GroupBy('product_id')->get());
        $stars['review2'] = count(Review::Where('is_block', 1)->Where('rating', 2)->GroupBy('product_id')->get());
        $stars['review1'] = count(Review::Where('is_block', 1)->Where('rating', 1)->GroupBy('product_id')->get());

        if (($category) && (count($category) != 0)) {
            foreach ($category as $key => $value) {
                $a_c_products = Products::Where('main_cat_name', $value->id)->Where('is_block', 1)->OrderBy('id', 'desc')->get();
                $category[$key]->{'cat_count'} = count($a_c_products);
            }
        }

        if (($all_products) && (count($all_products) != 0)) {
            $max = Products::max('discounted_price');
            $all_products->{'max_price'} = $max;
            foreach ($all_products as $keyzz => $valuezz) {
                $review = Review::Where('product_id', $valuezz->id)->Where('is_block', 1)->get();
                $average = 0;
                if (count($review) != 0) {
                    $sum = $review->sum('rating');
                    $count = count($review);
                    if ($sum != 0) {
                        $average = $sum / $count;
                    } else {
                        $average = 0;
                    }
                }
                $all_products[$keyzz]->{'review'} = $average;
            }
        }
        return View::make("front_end.all_products")->with(array('all_products' => $all_products, 'category' => $category, 'featured_products' => $featured_products, 'attributes' => $attributes, 'widget' => $widget, 'stars' => $stars));
    }

    public function AttributesImage(Request $request)
    {
        $id = 0;
        $product_id = 0;
        $image = 0;
        $price = 0;
        $data = array();
        if ($request->ajax() && isset($request->id) && isset($request->product_id)) {
            $id = $request->id;
            $product_id = $request->product_id;
            if ($id != 0 && $product_id != 0) {
                $att = ProductsAttributes::where('attribute_values', $id)->where('product_id', $product_id)->first();
                if ($att) {
                    $image = asset('/images/attributes/' . $att->image);
                    $price = $att->att_price;
                    $data = array('image' => $image, 'price' => $price);
                }
            }
        }
        echo json_encode($data);
    }

    public function Pages($name)
    {
        $cms = CMSPageManagement::where('page_name', $name)->first();
        if ($cms) {
            return View::make("front_end.pages")->with(array('cms' => $cms));
        } else {
            Session::flash('message', 'Page Not Found');
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('home');
            return Redirect::back();
        }
    }

    public function Terms()
    {
        $terms = TermsCMSSettings::first();
        return View::make("front_end.terms_conditions")->with(array('terms' => $terms));
    }

    public function About()
    {
        $about = AboutUsCMSSettings::first();
        if ($about) {
            $aaws = AboutAwards::Where('about_id', $about->id)->get();
            return View::make("front_end.about")->with(array('about' => $about, 'aaws' => $aaws));
        } else {
            Session::flash('message', 'Page Not Found');
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('home');
            return Redirect::back();
        }
    }

    public function CareerPage()
    {
        $career = Career::first();
        if ($career) {
            $jobs = CareerJobs::Where('is_active', 1)->get();
            return View::make("front_end.career")->with(array('career' => $career, 'jobs' => $jobs));
        } else {
            Session::flash('message', 'Page Not Found');
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('home');
            return Redirect::back();
        }
    }

    public function CareerForm(Request $request)
    {
        $data = $request->all();
        $page = "Settings";
        $rules = array(
            'first_name' => 'required|alpha',
            'last_name'  => 'required|alpha',
            'email'      => 'required|email',
            'mobile'     => 'required|min:10|max:13|regex:/^[0-9+]+$/',
            'resume'     => 'required|mimes:pdf,docx|max:2048',
            'job'        => 'nullable|exists:career_jobs,id',
            'message'    => 'required',
        );

        $messages = [
            'resume.required' => 'The Resume field is required.',
            'resume.mimes' => 'The Resume must be a file of type: pdf, docx.',
            'mobile.regex' => 'The mobile format is invalid. Eg(+919874563210)',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('/career/')->withErrors($validator);
        } else {
            $career = new CareerForm();

            if ($career) {
                $career->first_name     = $data['first_name'];
                $career->last_name      = $data['last_name'];
                $career->email          = $data['email'];
                $career->mobile         = $data['mobile'];

                if (isset($data['job']) && $data['job']) {
                    $career->job            = $data['job'];
                }

                $career->message        = $data['message'];

                $resume_files = $request->file('resume');
                if (isset($resume_files)) {
                    $file_name = $resume_files->getClientOriginalName();
                    $date = date('M-Y');
                    $file_path = 'images/career_resume/' . $date;
                    $resume_files->move($file_path, $file_name);
                    $career->resume = $file_path . '/' . $file_name;
                } else {
                    $career->resume = NULL;
                }

                if ($career->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "info@folkgems.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Folkgems";
                    }

                    $name = $career->first_name . ' ' . $career->last_name;
                    $email = $career->email;
                    $ph = $career->mobile;

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: jgrrylvmgyxm" . "\r\n";
                    $to = $email;
                    $subject = "Career Form";

                    $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 300px; margin: 0 auto;display: block;"></div>
                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                            <h2 style="color: #ff5c00;margin-top: 0px;">Career Form Details</h2>
                            <p>"Thank You For Resume Submitted with us".</p>
                                <p>Our Admin Team Will Evaluate and Reply Soon.</p>
                                <p>Any Queries Please email at <a href="mailto:info@folkgems.com" target="_blank" style="color: black;text-decoration: none;">info@folkgems.com</a>.</p>
                            <p></p>
                            <p>Thank You.</p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p>Thanks & Regards,</p>
                            <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                        </div>
                    </div>';

                    $msg = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 300px; margin: 0 auto;display: block;"></div>
                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                            <h2 style="color: #ff5c00;margin-top: 0px;">Career Form Details</h2>
                            <table align="center" style=" text-align: center;">
                                <tr>
                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Name</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $name . '</td>
                                </tr>
                                <tr>
                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">E-Mail</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : <a href="mailto:' . $email . '" target="_blank" style="color: #333;text-decoration: none;">' . $email . '</a></td>
                                </tr>
                                <tr>
                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Phone No</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $ph . '</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center;text-transform: uppercase;color: #333;padding-bottom: 12px;font-weight:bold;width: 120px;">Message</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . nl2br($career->message) . '</td>
                                </tr>
                            </table>
                            
                            <p>New Career Form Details. Verify and Reply this Recruiter</p>
                            <p></p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p>Thanks & Regards,</p>
                            <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                        </div>
                    </div>';
                    // die();
                    // if(1 == 1) {
                    if (mail($to, $subject, $txt, $headers) && mail($admin_email, $subject, $msg, $headers)) {
                        Session::flash('message', 'Applied Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('career');
                    } else {
                        Session::flash('message', 'Applied Successfully!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('career');
                    }
                } else {
                    Session::flash('message', 'Failed to apply!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('career');
                }
            } else {
                Session::flash('message', 'Not possible to apply!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('career');
            }
        }
    }

    public function SellOnFolkgems()
    {
        $sell = SellOnFolkgemsPage::first();
        $faq = FAQS::Where('is_block', 1)->Where('faq_cat', 2)->get();
        if ($sell) {
            return View::make("front_end.sell_on_folkgems")->with(array('sell' => $sell, 'faq' => $faq));
        } else {
            Session::flash('message', 'Page Not Found');
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('home');
            return Redirect::back();
        }
    }

    public function FAQs()
    {
        $fpage = FAQPage::first();
        $faq = FAQS::Where('is_block', 1)->get();
        // dd($faq);
        if ($fpage) {
            return View::make("front_end.faqs")->with(array('fpage' => $fpage, 'faq' => $faq));
        } else {
            Session::flash('message', 'Page Not Found');
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('home');
            return Redirect::back();
        }
    }

    public function SellerSignupOLD()
    {
        return View::make("front_end.seller_signup_old");
    }

    public function SellerSignup()
    {
        return View::make("front_end.seller_signup");
    }

    public function SellerRegister(Request $request)
    {
        $rules = array(
            'first_name'              => 'required',
            'last_name'               => 'nullable',
            'email'                   => 'required|email|unique:users,email',
            'phone'                   => 'required|numeric|unique:users,phone',
            'password'                => 'required|min:5',
            'c_password'              => 'required|min:5|same:password',
            'bussiness_name'          => 'required',
            'question'                => 'required',
            'answer'                  => 'required',
            'country'                 => 'required',
            'state'                   => 'required',
            'address1'                => 'required',
            'address2'                => 'nullable',
            'pincode'                 => 'nullable|numeric|integer',
            'profile_img'             => 'nullable',
            'is_approved'             => 'nullable',
            'is_block'                => 'nullable',
            'user_type'               => 'nullable',
            'login_type'              => 'nullable',
        );

        $messages = [
            'bussiness_name.required' => 'The company name field is required.',
            'address1.required' => 'The address field is required.',
            'address2.required' => 'The location field is required.',
            'c_password.required' => 'The confirm password field is required.',
            'c_password.min' => 'The confirm password must be at least 5 characters.',
            'c_password.same' => 'The confirm password and password must match.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return Redirect::back()->withInput()->withErrors($validator);
            return View::make('front_end.seller_signup')->withErrors($validator);
        } else {
            $data = $request->all();
            $merchant = new User();

            if ($merchant) {
                $img_files111 = $request->file('profile_img');
                if (isset($img_files111)) {
                    $file_name = $img_files111->getClientOriginalName();
                    $date = date('M-Y');
                    // $file_path = '../public/images/profile_img/'.$date;
                    $file_path = 'images/profile_img/' . $date;
                    $img_files111->move($file_path, $file_name);
                    $merchant->profile_img = $file_path . '/' . $file_name;
                } else {
                    $merchant->profile_img = NULL;
                }

                $merchant->first_name                = $data['first_name'];
                $merchant->last_name                 = $data['last_name'];
                $merchant->email                     = $data['email'];
                $merchant->phone                     = $data['phone'];
                $merchant->password                  = md5($data['password']);
                $merchant->password_salt             = Crypt::encryptString($data['c_password']);
                $merchant->bussiness_name            = $data['bussiness_name'];
                $merchant->question                  = $data['question'];
                $merchant->answer                    = $data['answer'];
                $merchant->country                   = $data['country'];
                $merchant->state                     = $data['state'];
                $merchant->address1                  = $data['address1'];
                $merchant->address2                  = $data['address2'];
                $merchant->pincode                   = $data['pincode'];

                $merchant->commission                = 0;
                $merchant->return_commission         = 0;
                $merchant->payment_account_details   = NULL;
                $merchant->user_type                 = 3;
                $merchant->is_approved               = 0;
                $merchant->is_block                  = 0;
                $merchant->login_type                = 1;

                $pass = $data['password'];
                if ($merchant->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "info@folkgems.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Folkgems";
                    }

                    $name = $merchant->first_name . ' ' . $merchant->last_name;
                    $email = $merchant->email;
                    $ph = $merchant->phone;

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: jgrrylvmgyxm" . "\r\n";
                    $to = $email;
                    $subject = "Merchants Registration";

                    $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></div>
                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                            <h2 style="color: #ff5c00;margin-top: 0px;">Register Process Success</h2>
                            <p>"Thank You For Your Registering with us".</p>
                                <p>Our Admin Team Will Evaluate and Approve Soon.</p>
                                <p>Any Queries Please email at <a href="mailto:info@folkgems.com" target="_blank" style="color: black;text-decoration: none;">info@folkgems.com</a>.</p>
                            <p></p>
                            <p>Thank You.</p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p>Thanks & Regards,</p>
                            <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                        </div>
                    </div>';

                    $msg = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 300px; margin: 0 auto;display: block;"></div>
                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                            <h2 style="color: #ff5c00;margin-top: 0px;">Merchants Details</h2>
                            <table align="center" style=" text-align: center;">
                                <tr>
                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Name</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $name . '</td>
                                </tr>
                                <tr>
                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">E-Mail</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : <a href="mailto:' . $email . '" target="_blank" style="color: #333;text-decoration: none;">' . $email . '</a></td>
                                </tr>
                                <tr>
                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Phone No</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $ph . '</td>
                                </tr>
                                <tr>
                                    <th style="text-align: center;text-transform: uppercase;color: #333;padding-bottom: 12px;font-weight:bold;width: 120px;">Password</th>
                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $pass . '</td>
                                </tr>
                            </table>
                            
                            <p>New Merchant Details. Verify and Approve this Merchant</p>
                            <p></p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p>Thanks & Regards,</p>
                            <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                        </div>
                    </div>';

                    if (mail($to, $subject, $txt, $headers) && mail($admin_email, $subject, $msg, $headers)) {
                        Session::flash('message', 'Thanks, we received your Vendor registration request, we will review the details and get back to you soon!');
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('home');
                    } else {
                        Session::flash('message', 'Thanks, we received your Vendor registration request, we will review the details and get back to you soon!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('home');
                    }
                } else {
                    Session::flash('message', 'Register Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('seller_signup');
                }
            } else {
                Session::flash('message', 'Register Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('seller_signup');
            }
        }
    }

    public function SignInOtp()
    {
        $l_usr = session()->get('user');
        if (isset($_COOKIE["user"]) && !empty($_COOKIE["user"])) {
            $cook = $_COOKIE["user"];
            $cook = json_decode($cook);
            $user = User::Where('id', $cook->id)->first();

            if ($user) {
                if (($user->user_type == 4)) {
                    if ($user->verification == 1) {
                        if ($user->is_block == 1) {
                            session()->forget('user');
                            Session::flash('message', 'Login Successfully!');
                            Session::flash('alert-class', 'alert-success');
                            Session::put('user', $user);

                            $users = session()->get('user');
                            $ses_carts = session()->get('cart');
                            $cartData = array();

                            if (isset($ses_carts)) {
                                Carts::Where('user_id', $users->id)->delete();
                                foreach ($ses_carts as $key => $value) {
                                    $carts = new Carts();
                                    if ($carts) {
                                        $carts->product_id  = $value['product_id'];
                                        $carts->user_id     = $users->id;
                                        $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                        $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                        $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                        $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                        $carts->tax_amount   = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                        $carts->total_price   = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                        $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                        $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                        $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                        $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                        $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                        $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                        $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                        $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                        $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                        $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                        $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                        $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                        $carts->is_block    = 1;

                                        $carts->save();
                                    }
                                }
                            }

                            return redirect()->route('home');
                        } else {
                            session()->forget('user');
                            if (isset($_COOKIE["user"])) {
                                setcookie("user", "");
                            }
                            Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('signin');
                        }
                    } else {
                        session()->forget('user');
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    session()->forget('user');
                    if (isset($_COOKIE["user"])) {
                        setcookie("user", "");
                    }
                    Session::flash('message', 'Login failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('message', 'Login Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else if ($l_usr) {
            if (($l_usr->user_type == 4)) {
                if ($l_usr->verification == 1) {
                    if ($l_usr->is_block == 1) {
                        session()->forget('user');
                        Session::flash('message', 'Login Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $l_usr);

                        $users = session()->get('user');
                        $ses_carts = session()->get('cart');
                        $cartData = array();

                        if (isset($ses_carts)) {
                            Carts::Where('user_id', $users->id)->delete();
                            foreach ($ses_carts as $key => $value) {
                                $carts = new Carts();
                                if ($carts) {
                                    $carts->product_id  = $value['product_id'];
                                    $carts->user_id     = $users->id;
                                    $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                    $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                    $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                    $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                    $carts->tax_amount   = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                    $carts->total_price   = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                    $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                    $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                    $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                    $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                    $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                    $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                    $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                    $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                    $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                    $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                    $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                    $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                    $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                    $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                    $carts->is_block    = 1;

                                    $carts->save();
                                }
                            }
                        }

                        return redirect()->route('home');
                    } else {
                        session()->forget('user');
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    session()->forget('user');
                    if (isset($_COOKIE["user"])) {
                        setcookie("user", "");
                    }
                    Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                session()->forget('user');
                if (isset($_COOKIE["user"])) {
                    setcookie("user", "");
                }
                Session::flash('message', 'Login failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            return View::make("front_end.signinOtp");
        }
    }

    public function sendLoginOtp(Request $request)
    {
        $request->validate(['phone' => 'required|digits:10']);

        // Check if phone exists
        $user = User::where('phone', $request->phone)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'This phone number is not registered.'
            ]);
        }

        $otp = rand(100000, 999999);
        session(['otp' => $otp, 'otp_phone' => $request->phone]);

        // $brand = "RANGBYBHAVANA"; 
        // $validity = 5; 
        // $mobile= $request->phone;
        // $user->login_otp = $otp;
        // $user->otp_expires_at = now()->addMinutes($validity);
        // $user->save();

        // $message = "Your OTP for logging in to $brand is $otp. Please enter this code to complete your login. This OTP is valid for the next $validity minutes. RANG BY BHAVANA";

        //     $apiKey = "HbIkrciaNUyvecWAgU7PXA";
        //     $senderId = "RANGBB";
        //     $route = "5";
        //     $templateId = "1007288026391843126";

        //     $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
        //          . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
        //          . "&number=$mobile&text=" . urlencode($message)
        //          . "&route=$route&DLTTemplateId=$templateId";

        //     $ch = curl_init();
        //     curl_setopt($ch, CURLOPT_URL, $url);
        //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //     $smsResponse = curl_exec($ch);
        //     $smsError = curl_error($ch);
        //     curl_close($ch);


        // dd($smsResponse);
        if ($smsError) {
            return response()->json([
                'success' => false,
                'message' => 'OTP generation failed. SMS Error: ' . $smsError
            ]);
        }

        // sendSms($request->phone, $message, 'RANGBB', '1', '1007288026391843126');

        return response()->json(['success' => true]);
    }


    public function SignIn()
    {
        $l_usr = session()->get('user');
        if (isset($_COOKIE["user"]) && !empty($_COOKIE["user"])) {
            $cook = $_COOKIE["user"];
            $cook = json_decode($cook);
            $user = User::Where('id', $cook->id)->first();

            if ($user) {
                if (($user->user_type == 4)) {
                    if ($user->verification == 1) {
                        if ($user->is_block == 1) {
                            session()->forget('user');
                            Session::flash('message', 'Login Successfully!');
                            Session::flash('alert-class', 'alert-success');
                            Session::put('user', $user);

                            $users = session()->get('user');
                            $ses_carts = session()->get('cart');
                            $cartData = array();

                            if (isset($ses_carts)) {
                                Carts::Where('user_id', $users->id)->delete();
                                foreach ($ses_carts as $key => $value) {
                                    $carts = new Carts();
                                    if ($carts) {
                                        $carts->product_id  = $value['product_id'];
                                        $carts->user_id     = $users->id;
                                        $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                        $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                        $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                        $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                        $carts->tax_amount   = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                        $carts->total_price   = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                        $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                        $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                        $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                        $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                        $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                        $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                        $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                        $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                        $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                        $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                        $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                        $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                        $carts->is_block    = 1;

                                        $carts->save();
                                    }
                                }
                            }

                            return redirect()->route('home');
                        } else {
                            session()->forget('user');
                            if (isset($_COOKIE["user"])) {
                                setcookie("user", "");
                            }
                            Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('signin');
                        }
                    } else {
                        session()->forget('user');
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    session()->forget('user');
                    if (isset($_COOKIE["user"])) {
                        setcookie("user", "");
                    }
                    Session::flash('message', 'Login failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('message', 'Login Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else if ($l_usr) {
            if (($l_usr->user_type == 4)) {
                if ($l_usr->verification == 1) {
                    if ($l_usr->is_block == 1) {
                        session()->forget('user');
                        Session::flash('message', 'Login Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $l_usr);

                        $users = session()->get('user');
                        $ses_carts = session()->get('cart');
                        $cartData = array();

                        if (isset($ses_carts)) {
                            Carts::Where('user_id', $users->id)->delete();
                            foreach ($ses_carts as $key => $value) {
                                $carts = new Carts();
                                if ($carts) {
                                    $carts->product_id  = $value['product_id'];
                                    $carts->user_id     = $users->id;
                                    $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                    $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                    $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                    $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                    $carts->tax_amount   = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                    $carts->total_price   = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                    $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                    $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                    $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                    $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                    $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                    $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                    $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                    $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                    $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                    $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                    $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                    $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                    $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                    $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                    $carts->is_block    = 1;

                                    $carts->save();
                                }
                            }
                        }

                        return redirect()->route('home');
                    } else {
                        session()->forget('user');
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    session()->forget('user');
                    if (isset($_COOKIE["user"])) {
                        setcookie("user", "");
                    }
                    Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                session()->forget('user');
                if (isset($_COOKIE["user"])) {
                    setcookie("user", "");
                }
                Session::flash('message', 'Login failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            return View::make("front_end.signin");
        }
    }

    public function EmailSignInCheck(Request $request)
    {
        $data = $request->all();
        $rules = array(
            // 'email'                   => 'required',
            'email'                   => 'required',
            'password'                => 'required',
            // 'g-recaptcha-response'      => 'required',
            'clogin_type'             => 'nullable',
        );

        $messages = [
            'email.required'    => 'The email or phone number field is required.',
            'password.required' => 'The password field is required.',
            // 'g-recaptcha-response.required'=>'The capcha field is required.',
            'email.exists' => 'Registration not found, please sign up to login.'
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return view('front_end.signin')->withErrors($validator)->with(array('clogin_type' => 0));
        } else {

            $loginInput = $data['email'];

            if (filter_var($loginInput, FILTER_VALIDATE_EMAIL)) {
                $validator = Validator::make($data, [
                    'email' => 'email:rfc,dns|exists:users,email',
                ], [
                    'email.email'  => 'Please enter a valid email address.',
                    'email.exists' => 'Email not registered, please sign up first.',
                ]);

                if ($validator->fails()) {
                    return view('front_end.signin')->withErrors($validator)->with(['clogin_type' => 0]);
                }

                $user = User::where('email', $loginInput)->where('is_block', 1)->first();
            } else {
                $user = User::where('phone', $loginInput)->where('is_block', 1)->first();

                if (!$user) {
                    return view('front_end.signin')->withErrors([
                        'email' => 'Phone number not registered, please sign up first.'
                    ])->with(['clogin_type' => 0]);
                }
            }

            // $user = User::where('email', $data['email'])->where('is_block', 1)->first();

            if ($user) {
                $pass = md5($data['password']);
                if ($user->password == $pass) {
                    if (($user->user_type == 4)) {
                        if ($user->verification == 1) {
                            session()->forget('user');
                            Session::flash('message', 'Login Successful!');
                            Session::flash('alert-class', 'alert-success');
                            Session::put('user', $user);
                            $user->{'pass'} = $data['password'];
                            $ck = json_encode($user);
                            if (isset($data["remember"]) && !empty($data["remember"])) {
                                // setcookie("user",$ck, time() + (60 * 60 * 5), "/");
                                setcookie("user", $ck, time() + (60 * 60 * 5));
                            } else {
                                if (isset($_COOKIE["user"])) {
                                    setcookie("user", "");
                                }
                            }

                            $users = session()->get('user');
                            $ses_carts = session()->get('cart');
                            $cartData = array();

                            if (isset($ses_carts) != 0) {
                                Carts::Where('user_id', $users->id)->delete();
                                foreach ($ses_carts as $key => $value) {
                                    $carts = new Carts();
                                    if ($carts) {
                                        $carts->product_id  = $value['product_id'];
                                        $carts->user_id     = $users->id;
                                        $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                        $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                        $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                        $carts->discounted_price       = (isset($value['discounted_price'])) ? $value['discounted_price'] : 0;
                                        $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                        $carts->tax_amount       = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                        $carts->total_price       = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                        $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                        $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                        $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                        $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                        $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                        $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                        $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                        $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                        $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                        $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                        $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                        $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                        $carts->is_block    = 1;

                                        $carts->save();
                                    }
                                }
                            }

                            if (session()->has('cart') && !empty(session('cart'))) {
                                return redirect()->route('cart');
                            } else {
                                return redirect()->route('home');
                            }
                        } else {
                            session()->forget('user');
                            if (isset($_COOKIE["user"])) {
                                setcookie("user", "");
                            }

                            Session::put('reactivate_user_id', $user->id);
                            Session::flash('show_reactivation_modal', true);

                            Session::flash('message', 'Your account was deactivated, kindly reactivate by clicking below.');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('signin');
                        }
                    } else {
                        Session::flash('message', 'Wrong User Name And Password!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    Session::flash('message', 'Entered Password Seems Incorrect, Kindly Try Again !');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('msg_prefix', 'Account has been disabled. Please ');
                Session::flash('msg_link', '<a href="' . route('contact') . '">Contact</a>');
                Session::flash('msg_suffix', ' RANG for reactivation.');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        }
    }

    public function MobileSignInCheck(Request $request)
    {

        $data = $request->all();

        $rules = array(
            'mobile'                  => 'nullable',
            'otp'                     => 'required|exists:users,login_otp',
            // 'g-recaptcha-response'      => 'required',
        );

        $messages = [
            'mobile.nullable' => '',
            // 'g-recaptcha-response.required'=>'The capcha field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return View::make('front_end.signin')->withErrors($validator)->with(array('clogin_type' => 1));
        } else {
            $user = User::where('login_otp', $data['otp'])->where('otp_expires_at', '>=', now())->where('is_block', 1)->where('is_approved', 1)->first();

            if ($user) {
                if (($user->user_type == 4)) {
                    if ($user->verification == 1) {
                        session()->forget('user');
                        Session::flash('message', 'Login Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $user);
                        $ck = json_encode($user);
                        if (isset($data["mob_rem"]) && !empty($data["mob_rem"])) {
                            // setcookie("user",$ck, time() + (60 * 60 * 5), "/");
                            setcookie("user", $ck, time() + (60 * 60 * 5));
                        } else {
                            if (isset($_COOKIE["user"])) {
                                setcookie("user", "");
                            }
                        }

                        $users = session()->get('user');
                        $ses_carts = session()->get('cart');
                        $cartData = array();

                        if (isset($ses_carts) != 0) {
                            Carts::Where('user_id', $users->id)->delete();
                            foreach ($ses_carts as $key => $value) {
                                $carts = new Carts();
                                if ($carts) {
                                    $carts->product_id  = $value['product_id'];
                                    $carts->user_id     = $users->id;
                                    $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                    $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                    $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                    $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                    $carts->tax_amount       = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                    $carts->total_price       = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                    $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                    $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                    $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                    $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                    $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                    $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                    $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                    $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                    $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                    $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                    $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                    $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                    $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                    $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                    $carts->is_block    = 1;

                                    $carts->save();
                                }
                            }
                        }

                        $user->signin_verify = NULL;
                        $user->mobile_verify = 1;
                        $user->login_otp = null;
                        $user->otp_expires_at = null;
                        $user->save();

                        return redirect()->route('home');
                    } else {
                        session()->forget('user');
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    Session::flash('message', 'Wrong User Name And Password!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('message', 'Login Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        }
    }

    public function CustomerForgot()
    {
        return View::make('front_end.customer_forgot');
    }

    public function CheckCustomerForgot(Request $request)
    {
        $data = $request->all();

        $rules = array(
            'email_mob'       => 'required',
        );


        $messages = [
            'email_mob.required' => 'The Email or Mobile Number field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return View::make('user.forgot')->withErrors($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $user = false;
            $mob_user = false;
            // print_r($data);die();
            $user = User::where('email', $data['email_mob'])->where('is_block', 1)->first();
            // $mob_user = User::where('phone', $data['email_mob'])->where('is_block', 1)->first();

            if ($user) {
                $user->remember_token = $this->common->gj_random(6);
                if ($user->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "info@folkgems.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Folkgems";
                    }

                    $name = $user->full_name ?? '';
                    $email = $user->email;
                    $reset_pw = $user->remember_token;

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "From: Rukmini Fashions <noreply@rukminifashions.com>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    $to = $email;
                    $subject = "Rukmini Fashions :Reset Password";

                    $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                            <div style="margin: margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                            <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                <h2 style="color: #B73182;margin-top: 0px;">Reset Password Code</h2>
                                <p style="font-size:13px;font-weight:600;">Dear ' . $name . ',</p>
                                <p style="font-size:13px;font-weight:600;"> We received a request to reset the password for your Rukmini Fashions account. </p>
                                <p style="font-size:13px;font-weight:600;"> To proceed with the password reset, please use the below mentioned Reset code : [' . $reset_pw . '].  </p>
                                <p style="font-size:13px;font-weight:600;"> Please do not share this reset code with anyone. Verifying your email address will help us ensure the security of your account and protect your personal information.</p>
                               
                                <p style="font-size:13px;font-weight:600;">If you have any questions or concern.s, please do not hesitate to reach out to our <a href="' . route('contact') . '">customer support team</a>.</p>
                                <p></p>
                                <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                 <div style="padding: 20px 0; text-align: center;">
                                    <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                    </a>
                                    <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                    </a>
                                    <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                    </a>
                                </div>
                            </div>
                        </div>';

                    if (mail($to, $subject, $txt, $headers, "-f noreply@rukminifashions.com")) {
                        Session::flash('message', 'Email Sent Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('customer_reset');
                    } else {
                        Session::flash('message', 'Email Sent Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('customer_forgot');
                    }

                    session()->forget('forgot_email_mob');
                    Session::put('forgot_email_mob', $data['email_mob']);
                }
            }
            // elseif ($mob_user) {
            //     return Redirect::back();
            //     $otp = mt_rand(100000, 999999);
            //     $mob_user->remember_token = $otp;
            //     if($mob_user->save()) {
            //         $text = "Please Use this ".$otp." reference code to reset the password,Paris La Bele.";
            //         $text = urlencode($text);

            //         $curl = curl_init();

            //         // Send the POST request with cURL
            //         curl_setopt_array($curl, array(
            //         CURLOPT_RETURNTRANSFER => 1,
            //         CURLOPT_URL => "http://smschub.com/api/sms/format/json",
            //         CURLOPT_POST => 1,
            //         CURLOPT_CUSTOMREQUEST => 'POST',
            //         CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
            //         CURLOPT_POSTFIELDS => array(
            //             'mobile' => $mob_user->phone,
            //             'route' => 'TL',
            //             'text' => $text,
            //             'sender' => 'GJICAM')));

            //         // Send the request & save response to $response
            //         $response = curl_exec($curl);

            //         // Close request to clear up some resources
            //         curl_close($curl);
            //         $response = json_decode($response);
            //         // Print response

            //         if(isset($response->data->status) && $response->data->status == "success") {
            //             Session::flash('message', 'OTP Message Send Successfully!'); 
            //             Session::flash('alert-class', 'alert-success');
            //             return redirect()->route('reset');
            //         } else {
            //             Session::flash('message', 'OTP Message Send Failed!'); 
            //             Session::flash('alert-class', 'alert-danger');
            //             return redirect()->route('forgot');
            //         }
            //     }
            // } 
            // else{
            //     Session::flash('message', 'It\'s not valid Email or Phone Number!'); 
            //     Session::flash('alert-class', 'alert-danger');
            //     return redirect()->route('home');
            // }
        }
    }

    public function CustomerReset()
    {
        return View::make('front_end.customer_reset');
    }

    public function CustomerResetPassword(Request $request)
    {
        $rules = array(
            'remember_token'          => 'required|exists:users,remember_token',
            'password'                => 'required|min:5',
            // 'password_salt'           => 'required|min:5|same:password',
        );

        $messages = [
            'remember_token.required' => 'The reset code field is required.',
            'remember_token.exists'   => 'Wrong reset code.',
            'password_salt.required' => 'The confirm password field is required.',
            'password_salt.min'      => 'The confirm password must be at least 5 characters.',
            'password_salt.same'     => 'The confirm password and password must match.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return View::make('user.customer_reset')->withErrors($validator);
            return Redirect::back()->withInput()->withErrors($validator);
        } else {
            $data = $request->all();

            $user = User::where('remember_token', $data['remember_token'])->where('is_block', 1)->first();

            if ($user) {
                $user->password                  = md5($data['password']);
                $user->password_salt             = Crypt::encryptString($data['password']);
                $user->remember_token            = NULL;


                $pass = $data['password'];
                if ($user->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "palackalpaperbags@gmail.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Parislabelle";
                    }

                    $name = $user->full_name ?? '';
                    $email = $user->email;
                    $password = $pass;

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: Rukmini Fashions <admin@rukminifashions.com>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    $to = $email;
                    $subject = "Password Changed Successfully.";
                    $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                            <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>

                            <div /style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                <h2 style="color: #B73182;margin-top: 0px;">Password Changed Successfully</h2>
                                <p style="font-size:15px;font-weight:600;">Dear ' . $name . ', </p>
                                <p style="font-size:15px;font-weight:600;">Your password for Rukmini Fashions account has been successfully changed! </p>
                                <p style="font-size:15px;font-weight:600;">Kindly login with your Email to explore Rukmini Fashions. </p>
                               
                                 <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p style="font-size:15px;font-weight:600;">Best Regards,</p>
                                <p style="font-size:15px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                <div style="padding: 20px 0; text-align: center;">
                                    <a href="https://www.instagram.com/parislabellenta" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                    </a>
                                    <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                    </a>
                                    <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                    </a>
                                </div>
                            </div>
                        </div>';


                    if (mail($to, $subject, $txt, $headers)) {
                        Session::flash('message', 'Password Changed and Mail Sent Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        session()->forget('user');
                        return redirect()->route('signin');
                    } else {
                        Session::flash('message', 'Password Changed Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        session()->forget('user');
                        return redirect()->route('signin');
                    }
                } else {
                    Session::flash('message', 'Password Changed Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('customer_forgot');
                }
            } else {
                Session::flash('message', 'You\'re Reset Code Is Not Valid!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('customer_reset');
            }
        }
    }


    public function reactivateFromModal(Request $request)
    {
        $user = User::where('id', $request->user_id)->where('is_block', 1)->first();

        if ($user) {
            if ($user->verification != 1) {
                $user->verification = 1;
                $user->is_active = 1;
                $user->email_verify = 1;
                if ($user->save()) {
                    Session::put('user', $user);
                    Session::flash('message', 'Your Account Activated Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('home');
                } else {
                    Session::flash('message', 'Account Activation Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('message', 'Your Account is Already Activated!');
                Session::flash('alert-class', 'alert-info');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'Invalid User or Account Already Active!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function deactivate(Request $request)
    {
        $users = session()->get('user');
        if ($users) {
            $lusr = User::Where('id', $users->id)->first();

            $request->validate([
                'password' => 'required|string',
                'reason' => 'required|integer',
            ]);

            $md5Password = md5($request->password);
            if ($md5Password === $lusr->password) {
                // $user = $users;
                $lusr->is_active = 0;
                $lusr->verification = 0;
                $lusr->deactivation_reason = $request->reason;
                if ($request->reason == 4) {
                    $lusr->custom_reason = $request->custom_reason;
                } else {
                    $lusr->custom_reason = null;
                }
                $lusr->save();

                session()->forget('user');
                session()->forget('cart');

                Session::flash('message', 'Your account has been deactivated.');
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('home');
            } else {
                //  Session::flash('message', 'Your account has been deactivated.'); 
                // Session::flash('alert-class', 'alert-success');
                return back()->withErrors(['password' => 'The provided password is incorrect.']);
            }
        }
    }

    public function ready_to_ship(Request $request)
    {
        $data = $request->all();
        $sortFilter = $request->get('sort_filter');
        $mainCategory = $request->get('main_cat');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        $category = CategoryManagementSettings::where('is_block', 1)->orderBy('id', 'desc')->get();

        foreach ($category as $key => $value) {
            $catProducts = Products::where('main_cat_name', $value->id)
                ->where('is_block', 1)
                ->get();

            $category[$key]->cat_count = $catProducts->count();
            $category[$key]->sub = SubCategoryManagementSettings::where('main_cat_name', $value->id)
                ->where('is_block', 1)
                ->get();
        }

        // Start building product query
        $products = Products::where('is_block', 1);

        if (!empty($data['main_cat'])) {
            $products->whereIn('main_cat_name', $data['main_cat']);
        }

        if (!empty($minPrice)) {
            $products->where('original_price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $products->where('original_price', '<=', $maxPrice);
        }

        $products->orderByRaw('CASE WHEN onhand_qty = 0 THEN 1 ELSE 0 END');

        if (!empty($data['sort_filter'])) {
            switch ($data['sort_filter']) {
                case 'l_h':
                    $products->orderBy('original_price', 'asc');
                    break;
                case 'h_l':
                    $products->orderBy('original_price', 'desc');
                    break;
                case 'latest':
                case 'popular':
                    $products->orderBy('id', 'desc');
                    break;
                default:
                    $products->orderBy('created_at', 'desc');
                    break;
            }
        }

        $products = $products->get();

        return view('front_end.ready_to_ship', [
            'products' => $products,
            'category' => $category
        ]);
    }

    public function featured_product(Request $request)
    {
        $data = $request->all();
        $sortFilter = $request->get('sort_filter');
        $mainCategory = $request->get('main_cat');

        $category = CategoryManagementSettings::where('is_block', 1)->orderBy('id', 'desc')->get();

        foreach ($category as $key => $value) {
            $catProducts = Products::where('main_cat_name', $value->id)
                ->where('is_block', 1)
                ->get();

            $category[$key]->cat_count = $catProducts->count();
            $category[$key]->sub = SubCategoryManagementSettings::where('main_cat_name', $value->id)
                ->where('is_block', 1)
                ->get();
        }

        // Start building product query
        $products = Products::where('is_block', 1)->where('featuredproduct_flag', 1);
        if (!empty($data['main_cat'])) {
            $products->where('main_cat_name', $data['main_cat']);
        }

        if (!empty($data['sort_filter'])) {
            switch ($data['sort_filter']) {
                case 'l_h':
                    $products->orderBy('original_price', 'asc');
                    break;
                case 'h_l':
                    $products->orderBy('original_price', 'desc');
                    break;
                case 'latest':
                case 'popular':
                    $products->orderBy('id', 'desc');
                    break;
                default:
                    $products->orderBy('created_at', 'desc');
                    break;
            }
        }

        $products = $products->get();

        return view('front_end.featured_product', [
            'products' => $products,
            'category' => $category
        ]);
    }

    public function collections()
    {

        $hcat1 = CategoryManagementSettings::Where('is_block', 1)->Where('is_top_cat', 1)->OrderBy('priority', 'ASC')->take(15)->get();
        return view('front_end.collections', compact('hcat1'));
    }


    public function Cart()
    {
        $users = session()->get('user');
        $ses_carts = session()->get('cart');
        $ses_carts = json_decode(json_encode($ses_carts), FALSE);
        // print_r($ses_carts);die();
        $carts = "";
        if ($users) {
            if ($users->user_type == 4) {
                $carts = Carts::Where('user_id', $users->id)->get();
                $shipping = ShippingSetting::first();
                return View::make("front_end.cart")->with(array('carts' => $carts, 'shipping' => $shipping));
            } else {
                Session::flash('message', 'Kindly Sign In to continue using Rukmini Fashions');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else if (isset($ses_carts)) {
            foreach ($ses_carts as $key => $value) {
                if (isset($value->att_name) && $value->att_name != 0 && isset($value->att_value) && $value->att_value != 0) {
                    $att_name = AttributesFields::Where('id', $value->att_name)->first();
                    $att_value = AttributesSettings::Where('id', $value->att_value)->first();

                    if ($att_name) {
                        $value->{'att_n'} = $att_name->att_name;
                    } else {
                        $value->{'att_n'} = NULL;
                    }

                    if ($att_value) {
                        $value->{'att_v'} = $att_value->att_value;
                    } else {
                        $value->{'att_v'} = NULL;
                    }
                }
            }
            $shipping = ShippingSetting::first();
            return View::make("front_end.cart")->with(array('ses_carts' => $ses_carts, 'shipping' => $shipping));
        } else {
            Session::flash('message', 'Kindly Sign-In / Sign-Up to continue using Rukmini Fashions');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function SignUp()
    {
        $secure = loginSecurity::all();
        return View::make("front_end.signup")->with(array('secure' => $secure));
    }

    public function EmailRegister(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'full_name'   => 'required',
            // 'last_name' =>'required',
            'email'                   => 'required|email:rfc,dns|unique:users,email',
            'phone'                   => 'required|numeric|unique:users,phone',
            'password'                => 'required|min:5',
            'password_salt'           => 'nullable',
            'remember_token'          => 'nullable',
            'verification'            => 'nullable',
            'is_approved'             => 'nullable',
            'is_block'                => 'nullable',
            'user_type'               => 'nullable',
            'login_type'              => 'nullable',
            'clogin_type'             => 'nullable',
            'g-recaptcha-response'    => 'required',
        );

        $messages = [
            'password.required' => 'The password field is required.',
            'g-recaptcha-response.required' => 'The capcha field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return Redirect::back()->withInput()->withErrors($validator);
            return Redirect::back()->withErrors($validator)->withInput();
            // return redirect()->route('signup')->withErrors($validator)->with(array('clogin_type'=>$data['clogin_type']));
        } else {
            $users = new User();

            if ($users) {
                $users->full_name                     = $data['full_name'];
                // $users->last_name                     = $data['last_name'];
                $users->email                     = $data['email'];
                $users->phone                     = $data['phone'];
                $users->password                  = md5($data['password']);
                $users->password_salt             = Crypt::encryptString($data['password']);
                $users->country                   = $data['country_code'];
                $users->user_type                 = 4;
                $users->is_approved               = 0;
                $users->verification              = $this->common->gj_random(6);
                $users->is_block                  = 1;
                $users->is_approved               = 1;
                $users->verification              = 1;
                $users->email_verify              = 1;
                $users->login_type                = 1;

                $pass = $data['password'];
                if ($users->save()) {

                    if ($request->has('subscribe_newsletter')) {
                        NewsLetter::create([
                            'email' => $users->email,
                            'is_block'  => 1,
                        ]);
                    }

                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "noreply@parislabelle.in";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }


                    // $brand = "RANGBYBHAVANA"; 
                    //     $validity = 5; 
                    //     $mobile = '91' . $users->phone; 
                    //     $var3 = 'https://instagram.com/rang_by_bhavana';
                    //     $var4 = 'www.rangjewelry.com';
                    //     $var2 = 'www.rangjewelry.com/contact';

                    //     $message = "Dear $users->full_name, Thank you for signing up at RANG BY BHAVANA ! You can now log in and place your First Order with us at $brand. If you have any questions, please don't hesitate to contact us at $var4. RANG BY BHAVANA : $var3 $var4";
                    //     $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                    //     $senderId = "RANGBB";
                    //     $route = "5";
                    //     $templateId = "1007093993080792609";

                    //     $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                    //      . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                    //      . "&number=$mobile&text=" . urlencode($message)
                    //      . "&route=$route&DLTTemplateId=$templateId";

                    //     $ch = curl_init();
                    //     curl_setopt($ch, CURLOPT_URL, $url);
                    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    //     $smsResponse = curl_exec($ch);
                    //     $smsError = curl_error($ch);
                    //     curl_close($ch);

                    // $r_url = url('/activation/'.$users->verification);
                    $r_url = route('activation', ['code' => $users->verification]);
                    $mail_img = asset('images/mail.png');
                    $phone_img = asset('images/phone.png');
                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Paris La Belle";
                    if ($general) {
                        $site_name = $general->site_name;
                    }

                    $email = $users->email;

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    $to = $email;
                    $subject = "Rukmini Fashions : Registration Successful.";

                    $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                    <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;">
                        <a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a>
                    </div>
                     <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                        <h2 style="color: #B73182;margin-top: 0px;">Registration Successful</h2>
                        <p style="font-size:15px;font-weight:600;">Dear ' . $users->full_name . ', </p>
                                           
                        <p style="font-size:12px;font-weight:600;">Congratulations and welcome to the Rukmini Fashions family ! We are thrilled to have you join us.</p>
                        <p style="font-size:12px;font-weight:600;">Your Rukmini Fashions account has been successfully created with the following details:</p>
                        <table align="center" style=" text-align: center;width: 100%;">
                                
                                <tr>
                                    <td style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;"> <b>Email</b> </td>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:center;width: 50%;"> <b>' . $users->email . '</b> </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;"> <b>Password</b> </td>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:center;width: 50%;"> <b>' . $pass . '</b> </td>
                                </tr>
                        
                        
                        </table>
                            <p  style="font-size:13px;font-weight:600;">Please subscribe to our newsletter <a href="' . route('home') . '">here</a> to keep yourself updated on our latest collections. </p>
                            <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our customer support team.</p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"></div>
                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                            <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                             <div style="padding: 20px 0; text-align: center;">
                                <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                </a>
                            </div>
                        </div>
                    </div>';


                    // $mail=mail($to,$subject,$txt,$headers) && mail($admin_email,$subject,$txt,$headers);
                    // if(mail($to,$subject,$txt,$headers) && mail($admin_email,$subject,$txt,$headers)) {
                    //     Session::flash('message', 'Register Successfully & Activation URL Send your Email. Use That Url to Activate and login your Account!'); 
                    //     Session::flash('alert-class', 'alert-success');
                    //     return redirect()->route('signin');
                    // } else {
                    //     Session::flash('message', 'Register Successfully!'); 
                    //     Session::flash('alert-class', 'alert-danger');
                    //     return redirect()->route('signin');
                    // }.
                    //  Session::put('user', $users);
                    // if( $mail){
                    Session::put('signup_email_data', [
                        'to' => $email,
                        'to2' => $admin_email,
                        'subject' => $subject,
                        'body' => $txt,
                        'headers' => $headers,
                    ]);
                    Session::flash('signup_trigger', true);

                    Session::flash('message', 'Registration Successful, Kindly Sign In To Explore Rukmini Fashions');
                    Session::flash('alert-class', 'alert-success');
                    //  echo '<script>hideLoader();</script>';
                    return redirect()->route('home');
                    // }
                } else {
                    Session::flash('message', 'Register Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signup');
                }
            } else {
                Session::flash('message', 'Register Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signup');
            }
        }
    }

    public function sendSignUpEmail(Request $request)
    {
        $data = session()->pull('signup_email_data');

        if ($data) {
            mail($data['to'], $data['subject'], $data['body'], $data['headers']);
            mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
            return response()->json(['status' => 'sent']);
        }

        return response()->json(['status' => 'no_data']);
    }

    public function MobileRegister(Request $request)
    {
        $data = $request->all();
        $rules = array(
            'mobile'                  => 'required|numeric|unique:users,phone',
            'remember_token'          => 'nullable',
            'verification'            => 'nullable',
            'is_approved'             => 'nullable',
            'is_block'                => 'nullable',
            'user_type'               => 'nullable',
            'login_type'              => 'nullable',
            'clogin_type'             => 'nullable',
            'g-recaptcha-response'    => 'required',
        );

        $messages = [
            'password.required' => 'The password field is required.',
            'g-recaptcha-response.required' => 'The capcha field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return Redirect::back()->withInput()->withErrors($validator);
            return View::make('front_end.signup')->withErrors($validator)->with(array('clogin_type' => $data['clogin_type']));
            // return Redirect::to('/signup/')->withErrors($validator)->with(array('clogin_type'=>$data['clogin_type']));
        } else {
            $users = new User();

            if ($users) {
                $users->phone                     = $data['mobile'];
                $users->user_type                 = 4;
                $users->is_approved               = 0;
                $users->verification              = $this->common->gj_random(6);
                $users->is_block                  = 1;
                $users->login_type                = 1;

                if ($users->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "noreply@parislabelle.in";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    // $r_url = url('/activation/'.$users->verification);
                    $r_url = route('activation', ['code' => $users->verification]);
                    $mail_img = asset('images/mail.png');
                    $phone_img = asset('images/phone.png');
                    $logos = \DB::table('logo_settings')->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Pairs La Beller";
                    if ($general) {
                        $site_name = $general->site_name;
                    }

                    $contacts = \DB::table('email_settings')->first();
                    $c_email = "noreply@parislabelle.in";
                    $c_phone = "(+004) 912-3548-07";
                    if ($contacts) {
                        $c_email = $contacts->contact_email;
                        $c_phone = $contacts->contact_phone1;
                    }

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    // $to = $users->email;
                    $subject = "Registration Success";
                    echo $txt = '<div style="margin: 30px auto 20px;border: 1px solid #ff5c00;width: 602px;">
                        <table width="600" align="center" cellpadding="0" cellspacing="0" height="74">
                            <tbody>
                                <tr bgcolor="#ffffff">
                                    <td style="padding-left:20px;padding-top:10px;padding-bottom:10px" height="70"><a href="' . route('home') . '"><img src="' . $logo . '" border="0"></a></td>
                                </tr> 
                                <tr bgcolor="#ff5c00" height="7px">
                                    <td><br></td>
                                </tr>
                            </tbody>
                        </table>

                        <table width="600" align="center">
                            <tbody>
                                <tr>
                                    <td style="padding:10px;font-size:15px;color:#333333;font-weight:bold;font-family:Segoe UI,Arial,Helvetica,sans-serif">Your registration is completed..! Click on the link below to activate your account.<br></td>
                                </tr>
                            </tbody>
                        </table>

                        <table width="600px" align="center" cellpadding="0" cellspacing="0">
                            <tbody>
                                <tr>
                                    <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Your Username</b> </td>
                                    <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b><a href="tel:' . $users->phone . '" target="_blank">' . $users->phone . '</a></b> </td>
                                </tr>
                        
                                <tr>
                                    <td colspan="2" style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Please click on link below to activate your account</b> </td>
                                </tr>
                        
                                <tr>
                                    <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>link</b> </td>
                                    <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b><a href="' . $r_url . '" target="_blank">' . $r_url . '</a></b> </td>
                                </tr>
                            </tbody>
                        </table>

                        <table width="600" align="center" cellpadding="0" cellspacing="0" height="61">
                            <tbody>
                                <tr bgcolor="#ffffff">
                                    <td colspan="5" height="11"><br></td>
                                </tr>
                                
                                <tr bgcolor="#ff5c00" height="7px">
                                    <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec;padding-left:10px" width="100" height="48">Contact Us : </td>

                                    <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec" width="29"><img src="' . $mail_img . '"></td>

                                    <td style="font-family:Segoe UI,Arial;font-size:11px;color:#ececec" width="135"><a href="mailto:' . $c_email . '" style="color:#ececec;text-decoration:none"> ' . $c_email . '</a></td>

                                    <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec" width="28"><img src="' . $phone_img . '" style="margin-left:8px;"></td>

                                    <td style="font-family:Segoe UI,Arial;font-size:11px;color:#ececec" width="300">' . $c_phone . '</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>';
                    die();
                    // if(mail($to,$subject,$txt,$headers) && mail($admin_email,$subject,$txt,$headers)) {
                    if (mail($admin_email, $subject, $txt, $headers)) {
                        Session::flash('message', 'Register Successfully & Activation URL Send your Email. Use That Url to Activate and login your Account!');
                        Session::flash('alert-class', 'alert-success');
                        return redirect()->route('signin');
                    } else {
                        Session::flash('message', 'Register Successfully!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('signin');
                    }
                } else {
                    Session::flash('message', 'Register Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signup');
                }
            } else {
                Session::flash('message', 'Register Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signup');
            }
        }
    }

    public function GoogleSignin(Request $request)
    {
        $error = 0;
        $id = 0;
        if ($request->ajax() && isset($request->first_name) && isset($request->profile) && isset($request->email)) {
            $data['first_name'] = $request->first_name;
            $data['profile'] = $request->profile;
            $data['email'] = $request->email;

            if ($request->last_name) {
                $data['last_name'] = $request->last_name;
            } else {
                $data['last_name'] = "";
            }

            if ($request->social_ref_id) {
                $data['social_ref_id'] = $request->social_ref_id;
            } else {
                $data['social_ref_id'] = "";
            }

            if ($request->id_token) {
                $data['id_token'] = $request->id_token;
            } else {
                $data['id_token'] = "";
            }

            $loged_usr = User::Where('email', $data['email'])->first();
            if ($loged_usr) {
                if (($loged_usr->user_type == 4)) {
                    if ($loged_usr->verification == 1) {
                        if ($loged_usr->is_block == 1) {
                            session()->forget('user');
                            Session::flash('message', 'Login Successfully!');
                            Session::flash('alert-class', 'alert-success');
                            Session::put('user', $user);

                            $users = session()->get('user');
                            $ses_carts = session()->get('cart');
                            $cartData = array();

                            if (isset($ses_carts)) {
                                Carts::Where('user_id', $users->id)->delete();
                                foreach ($ses_carts as $key => $value) {
                                    $carts = new Carts();
                                    if ($carts) {
                                        $carts->product_id  = $value['product_id'];
                                        $carts->user_id     = $users->id;
                                        $carts->name        = (isset($value['name'])) ? $value['name'] : NULL;
                                        $carts->original_price  = (isset($value['original_price'])) ? $value['original_price'] : 0;
                                        $carts->product_cost       = (isset($value['product_cost'])) ? $value['product_cost'] : 0;
                                        $carts->price       = (isset($value['price'])) ? $value['price'] : 0;
                                        $carts->tax_amount   = (isset($value['tax_amount'])) ? $value['tax_amount'] : 0;
                                        $carts->total_price   = (isset($value['total_price'])) ? $value['total_price'] : 0;
                                        $carts->att_name  = (isset($value['att_name'])) ? $value['att_name'] : NULL;
                                        $carts->att_value  = (isset($value['att_value'])) ? $value['att_value'] : NULL;
                                        $carts->tax  = (isset($value['tax'])) ? $value['tax'] : NULL;
                                        $carts->tax_type  = (isset($value['tax_type'])) ? $value['tax_type'] : NULL;
                                        $carts->service_charge  = (isset($value['service_charge'])) ? $value['service_charge'] : NULL;
                                        $carts->shiping_charge  = (isset($value['shiping_charge'])) ? $value['shiping_charge'] : NULL;
                                        $carts->image       = (isset($value['image'])) ? $value['image'] : NULL;
                                        $carts->qty         = (isset($value['qty'])) ? $value['qty'] : 1;
                                        $carts->notes       = (isset($value['notes'])) ? $value['notes'] : NULL;
                                        $carts->is_offer       = (isset($value['is_offer'])) ? $value['is_offer'] : 'No';
                                        $carts->offer_id       = (isset($value['offer_id'])) ? $value['offer_id'] : NULL;
                                        $carts->offer_det_id       = (isset($value['offer_det_id'])) ? $value['offer_det_id'] : NULL;
                                        $carts->cart_key       = (isset($value['cart_key'])) ? $value['cart_key'] : NULL;
                                        $carts->cart_del       = (isset($value['cart_del'])) ? $value['cart_del'] : NULL;
                                        $carts->is_block    = 1;

                                        $carts->save();
                                    }
                                }
                            }

                            echo $error = 1;
                            die();
                        } else {
                            session()->forget('user');
                            if (isset($_COOKIE["user"])) {
                                setcookie("user", "");
                            }
                            Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                            Session::flash('alert-class', 'alert-danger');
                            echo $error = 3;
                            die();
                        }
                    } else {
                        session()->forget('user');
                        if (isset($_COOKIE["user"])) {
                            setcookie("user", "");
                        }
                        Session::flash('message', 'Your account is not yet activated please check your e-mail and activate your account to Login!');
                        Session::flash('alert-class', 'alert-danger');
                        echo $error = 3;
                        die();
                    }
                } else {
                    session()->forget('user');
                    if (isset($_COOKIE["user"])) {
                        setcookie("user", "");
                    }
                    Session::flash('message', 'Login failed!');
                    Session::flash('alert-class', 'alert-danger');
                    echo $error = 4;
                    die();
                }
            } else {
                $users = new User();

                if ($users) {
                    $users->first_name                = $data['first_name'];
                    $users->last_name                 = $data['last_name'];
                    $users->email                     = $data['email'];
                    $users->user_type                 = 4;
                    if (isset($data['profile'])) {
                        $users->profile_img           = $data['profile'];
                    } else {
                        $users->profile_img           = NULL;
                    }

                    if (isset($data['is_approved'])) {
                        $users->is_approved           = $data['is_approved'];
                    } else {
                        $users->is_approved           = 1;
                    }
                    $users->verification              = 1;
                    $users->is_block                  = 1;
                    $users->login_type                = 2;
                    $users->signup                    = "Google Login";
                    $users->social_ref_id             = $data['social_ref_id'];
                    $users->id_token                  = $data['id_token'];

                    if ($users->save()) {
                        $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                        $admin_email = "noreply@parislabelle.in";
                        if ($adm) {
                            $admin_email = $adm->email;
                        }

                        $mail_img = asset('images/mail.png');
                        $phone_img = asset('images/phone.png');
                        $logos = \DB::table('logo_settings')->first();
                        $logo_path = 'images/logo';
                        $logo = "";
                        if ($logos) {
                            $logo = asset($logo_path . '/' . $logos->logo_image);
                        } else {
                            $logo = asset('images/logo.png');
                        }

                        $general = \DB::table('general_settings')->first();
                        $site_name = "Paris La Belle";
                        if ($general) {
                            $site_name = $general->site_name;
                        }

                        $contacts = \DB::table('email_settings')->first();
                        $c_email = "noreply@parislabelle.in";
                        $c_phone = "971 925 6546";
                        if ($contacts) {
                            $c_email = $contacts->contact_email;
                            $c_phone = $contacts->contact_phone1;
                        }

                        $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                        $headers .= "MIME-Version: 1.0\r\n";
                        // $headers.= "From: $admin_email" . "\r\n";
                        $headers .= "From: noreply@folkgems.com" . "\r\n";
                        $to = $users->email;
                        $subject = "Activate Account";
                        $txt = '<div style="margin: 30px auto 20px;border: 1px solid #ff5c00;width: 602px;">
                            <table width="600" align="center" cellpadding="0" cellspacing="0" height="74">
                                <tbody>
                                    <tr bgcolor="#ffffff">
                                        <td style="padding-left:20px;padding-top:10px;padding-bottom:10px" height="70"><a href="' . route('home') . '"><img src="' . $logo . '" border="0"></a></td>
                                    </tr> 
                                    <tr bgcolor="#ff5c00" height="7px">
                                        <td><br></td>
                                    </tr>
                                </tbody>
                            </table>

                            <table width="600px" align="center" cellpadding="0" cellspacing="0">
                                <tbody>
                                    <tr>
                                        <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Your Username</b> </td>
                                        <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b><a href="mailto:' . $users->email . '" target="_blank">' . $users->email . '</a></b> </td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Register And Login Successfully, Please Your Profile Update.</b> </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table width="600" align="center" cellpadding="0" cellspacing="0" height="61">
                                <tbody>
                                    <tr bgcolor="#ffffff">
                                        <td colspan="5" height="11"><br></td>
                                    </tr>
                                    
                                    <tr bgcolor="#ff5c00" height="7px">
                                        <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec;padding-left:10px" width="100" height="48">Contact Us : </td>

                                        <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec" width="29"><img src="' . $mail_img . '"></td>

                                        <td style="font-family:Segoe UI,Arial;font-size:11px;color:#ececec" width="135"><a href="mailto:' . $c_email . '" style="color:#ececec;text-decoration:none"> ' . $c_email . '</a></td>

                                        <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec" width="28"><img src="' . $phone_img . '" style="margin-left:8px;"></td>

                                        <td style="font-family:Segoe UI,Arial;font-size:11px;color:#ececec" width="300">' . $c_phone . '</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>';

                        if (mail($to, $subject, $txt, $headers)) {
                            Session::flash('message', 'Register and Mail Sent Successfully!');
                            Session::flash('alert-class', 'alert-success');
                            echo $error = 1;
                            die();
                        } else {
                            Session::flash('message', 'Register Successfully!');
                            Session::flash('alert-class', 'alert-danger');
                            echo $error = 1;
                            die();
                        }
                    } else {
                        Session::flash('message', 'Added Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        echo $error = 0;
                        die();
                    }
                } else {
                    Session::flash('message', 'Added Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    echo $error = 0;
                    die();
                }
            }
        }
        echo $error;
    }

    // public function Activation ($code) {
    //     $user = User::where('verification', $code)->where('is_block', 1)->first();
    //     if($user) {
    //         if($user->verification != 1) {
    //             $user->verification = 1;
    //             $user->email_verify = 1;
    //             if($user->save()) {
    //                 Session::flash('message', 'Your Account Activated Successfully!'); 
    //                 Session::flash('alert-class', 'alert-success');
    //                 return redirect()->route('signin');
    //             } else {
    //                 Session::flash('message', 'Your Account Activation Failed!'); 
    //                 Session::flash('alert-class', 'alert-danger');
    //                 return redirect()->route('signin');
    //             }
    //         } else {
    //             Session::flash('message', 'Your Account is Already Activated!'); 
    //             Session::flash('alert-class', 'alert-danger');
    //             return redirect()->route('signin');
    //         }
    //     } else {
    //         Session::flash('message', 'Your Account Activation URL Expired!'); 
    //         Session::flash('alert-class', 'alert-danger');
    //         return redirect()->route('signin');
    //     }    
    // }


    public function Activation($code)
    {
        $user = User::where('verification', $code)->where('is_block', 1)->first();
        if ($user) {
            if ($user->verification != 1) {
                $user->verification = 1;
                $user->email_verify = 1;
                if ($user->save()) {
                    // Log in the user
                    // Auth::loginUsingId($user->id);
                    // Auth::loginUsingId($user->id,true);
                    Session::put('user', $user);

                    // dd(Auth::loginUsingId($user->id));
                    // Auth::login($user);

                    Session::flash('message', 'Your Account Activated Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('home'); // Redirect to the user's dashboard or profile page
                } else {
                    Session::flash('message', 'Your Account Activation Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('message', 'Your Account is Already Activated!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'Your Account Activation URL Expired!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }


    public function Verify($on, $id)
    {
        $user = User::where('id', $id)->where('is_block', 1)->first();
        if ($user) {
            $otp = mt_rand(100000, 999999);
            if ($on == 'mobile') {
                $user->mobile_verify = $otp;

                if ($user->save()) {
                    $text = "Please Use this " . $otp . " otp code to Verify Your Mobile Number, Folkgems.com";
                    $text = urlencode($text);

                    $curl = curl_init();

                    // Send the POST request with cURL
                    curl_setopt_array($curl, array(
                        CURLOPT_RETURNTRANSFER => 1,
                        CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                        CURLOPT_POST => 1,
                        CURLOPT_CUSTOMREQUEST => 'POST',
                        CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                        CURLOPT_POSTFIELDS => array(
                            'mobile' => $user->phone,
                            'route' => 'TL',
                            'text' => $text,
                            'sender' => 'GJICAM'
                        )
                    ));

                    // Send the request & save response to $response
                    $response = curl_exec($curl);

                    // Close request to clear up some resources
                    curl_close($curl);
                    $response = json_decode($response);
                    // Print response
                    if (isset($response->data->status) && $response->data->status == "success") {
                        Session::flash('message', 'OTP Code Send on your Mobile Number, Please Enter That code To Verify Now!');
                        Session::flash('alert-class', 'alert-success');
                        return View::make("front_end.verify")->with(array('verf' => 'Mobile Number'));
                    } else {
                        Session::flash('message', 'OTP Code Send Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('my_account');
                    }
                } else {
                    Session::flash('message', 'Sorry Mobile Number Verification Not Possible this time!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }
            } else if ($on == 'email') {
                $user->email_verify = $otp;

                if ($user->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "info@folkgems.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Folkgems";
                    }

                    $name = $user->first_name . ' ' . $user->last_name;
                    $email = $user->email;

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    $to = $email;
                    $subject = "Verify Email Address";
                    $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                            <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 300px; margin: 0 auto;display: block;"></div>
                            <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                <h2 style="color: #ff5c00;margin-top: 0px;">EMail Verification Code</h2>
                                <table align="center" style=" text-align: center;">
                                    <tr>
                                        <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">OTP</th>
                                        <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $otp . '</td>
                                    </tr>
                                </table>
                                <p>Your Email Verification OTP code is <span style="font-weight:bold"> ' . $otp . ' </span></p>
                                <p>Use this OTP to Verify your EMail Address</p>
                                <p>Thank You.</p>
                                 <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p>Thanks & Regards,</p>
                                <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                            </div>
                        </div>';


                    // if(1==1){
                    if (mail($to, $subject, $txt, $headers)) {
                        Session::flash('message', 'OTP Code Send on your EMail Address, Please Enter That code To Verify Now!');
                        Session::flash('alert-class', 'alert-success');
                        return View::make("front_end.verify")->with(array('verf' => 'E-Mail Address'));
                    } else {
                        Session::flash('message', 'OTP Code Send Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('my_account');
                    }
                } else {
                    Session::flash('message', 'Sorry EMail Address Verification Not Possible this time!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }
            } else {
                Session::flash('message', 'Sorry Verification Not Possible this time!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('my_account');
            }
        } else {
            Session::flash('message', 'You Are Not Authenticate User!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function CheckVerify(Request $request)
    {
        $rules = array(
            'otp'         => 'required',
        );

        $messages = [
            'opt.required' => 'The OTP field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('verify')->withErrors($validator);
        } else {
            $data = $request->all();
            $user = User::where('mobile_verify', $data['otp'])->first();

            if ($user) {
                $user->mobile_verify = 1;
                if ($user->save()) {
                    session()->forget('user');
                    Session::flash('message', 'Your Mobile Number Verification Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    Session::put('user', $user);
                    return redirect()->route('my_account');
                } else {
                    Session::flash('message', 'Your Mobile Number Verification Failed, Please Try Again Later!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }
            } else {
                $user = User::where('email_verify', $data['otp'])->first();

                if ($user) {
                    $user->email_verify = 1;
                    if ($user->save()) {
                        session()->forget('user');
                        Session::flash('message', 'Your Email Address Verification Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        Session::put('user', $user);
                        return redirect()->route('my_account');
                    } else {
                        Session::flash('message', 'Your Email Address Verification Failed, Please Try Again Later!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('my_account');
                    }
                } else {
                    Session::flash('message', 'Your OTP is  InValid, Please Try Again!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }
            }
        }
    }

    public function ResendUrl()
    {
        return View::make("front_end.resend_url");
    }

    public function ResendActivateUrl(Request $request)
    {
        $rules = array(
            'email'                   => 'required',
            'password'                => 'required',
        );

        $messages = [
            'password.required' => 'The password field is required.',
            'email.required' => 'The email or mobile no field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return View::make('front_end.resend_url')->withErrors($validator);
        } else {
            $data = $request->all();
            $user = User::where('email', $data['email'])->where('is_block', 1)->where('is_approved', 1)->first();
            if (!$user) {
                $user = User::where('phone', $data['email'])->where('is_block', 1)->where('is_approved', 1)->first();
            }

            if ($user) {
                $pass = md5($data['password']);
                if ($user->password == $pass) {
                    if (($user->user_type == 4)) {
                        $users = $user;
                        $users->verification = "GJ" . uniqid();
                        $pass = $data['password'];
                        if ($users->save()) {
                            $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                            $admin_email = "info@folkgems.com";
                            if ($adm) {
                                $admin_email = $adm->email;
                            }

                            // $r_url = url('/activation/'.$users->verification);
                            $r_url = route('activation', ['code' => $users->verification]);
                            $mail_img = asset('images/mail.png');
                            $phone_img = asset('images/phone.png');
                            $logos = \DB::table('logo_settings')->first();
                            $logo_path = 'images/logo';
                            $logo = "";
                            if ($logos) {
                                $logo = asset($logo_path . '/' . $logos->logo_image);
                            } else {
                                $logo = asset('images/logo.png');
                            }

                            $general = \DB::table('general_settings')->first();
                            $site_name = "Folkgems";
                            if ($general) {
                                $site_name = $general->site_name;
                            }

                            $contacts = \DB::table('email_settings')->first();
                            $c_email = "info@folkgems.com";
                            $c_phone = "971 925 6546";
                            if ($contacts) {
                                $c_email = $contacts->contact_email;
                                $c_phone = $contacts->contact_phone1;
                            }

                            $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                            $headers .= "MIME-Version: 1.0\r\n";
                            // $headers.= "From: $admin_email" . "\r\n";
                            $headers .= "From: noreply@folkgems.com" . "\r\n";
                            $to = $users->email;
                            $subject = "Activate Account";
                            $txt = '<div style="margin: 30px auto 20px;border: 1px solid #ff5c00;width: 602px;">
                                <table width="600" align="center" cellpadding="0" cellspacing="0" height="74">
                                    <tbody>
                                        <tr bgcolor="#ffffff">
                                            <td style="padding-left:20px;padding-top:10px;padding-bottom:10px" height="70"><a href="' . route('home') . '"><img src="' . $logo . '" border="0"></a></td>
                                        </tr> 
                                        <tr bgcolor="#ff5c00" height="7px">
                                            <td><br></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table width="600" align="center">
                                    <tbody>
                                        <tr>
                                            <td style="padding:10px;font-size:15px;color:#333333;font-weight:bold;font-family:Segoe UI,Arial,Helvetica,sans-serif">Your registration is completed..! Click on the link below to activate your account.<br></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table width="600px" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Your Username</b> </td>
                                            <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b><a href="mailto:' . $users->email . '" target="_blank">' . $users->email . '</a></b> </td>
                                        </tr>
                                
                                        <tr>
                                            <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Your Password</b> </td>
                                            <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>' . $pass . '</b> </td>
                                        </tr>
                                
                                        <tr>
                                            <td colspan="2" style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>Please click on link below to activate your account</b> </td>
                                        </tr>
                                
                                        <tr>
                                            <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b>link</b> </td>
                                            <td style="background-color:#ececec;border-top:dotted #ababab 1px;font-family:Segoe UI,Arial,Helvetica,sans-serif;font-size:12px;color:#414042;padding-left:15px;padding-top:10px;padding-bottom:5px"> <b><a href="' . $r_url . '" target="_blank">' . $r_url . '</a></b> </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <table width="600" align="center" cellpadding="0" cellspacing="0" height="61">
                                    <tbody>
                                        <tr bgcolor="#ffffff">
                                            <td colspan="5" height="11"><br></td>
                                        </tr>
                                        
                                        <tr bgcolor="#ff5c00" height="7px">
                                            <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec;padding-left:10px" width="100" height="48">Contact Us : </td>

                                            <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec" width="29"><img src="' . $mail_img . '"></td>

                                            <td style="font-family:Segoe UI,Arial;font-size:11px;color:#ececec" width="135"><a href="mailto:' . $c_email . '" style="color:#ececec;text-decoration:none"> ' . $c_email . '</a></td>

                                            <td style="font-family:Segoe UI,Arial;font-size:14px;font-weight:bold;color:#ececec" width="28"><img src="' . $phone_img . '" style="margin-left:8px;"></td>

                                            <td style="font-family:Segoe UI,Arial;font-size:11px;color:#ececec" width="300">' . $c_phone . '</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>';
                            if (mail($to, $subject, $txt, $headers)) {
                                Session::flash('message', 'Activation URL Resend. Use That Url to verify and login your Account!');
                                Session::flash('alert-class', 'alert-success');
                                return redirect()->route('signin');
                            } else {
                                Session::flash('message', 'URL Resend Failed!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->back();
                            }
                        } else {
                            Session::flash('message', 'URL Send Failed!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->back();
                        }
                    } else {
                        Session::flash('message', 'You Are Not Authenticate User!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->back();
                    }
                } else {
                    Session::flash('message', 'Do Not Match Your Password!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->back();
                }
            } else {
                Session::flash('message', 'Your E-Mail or Mobile Number is Not Valid!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->back();
            }
        }
    }

    public function ChkActQuestion()
    {
        $secure = loginSecurity::all();
        return View::make("front_end.chk_act_question")->with(array('secure' => $secure));
    }

    public function ChkActAnswer(Request $request)
    {
        $rules = array(
            'email'                   => 'required',
            'question'                => 'required',
            'answer'                  => 'required',
        );

        $messages = [
            'email.required' => 'The email or mobile no field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('chk_act_question')->withErrors($validator);
        } else {
            $data = $request->all();
            $user = User::where('email', $data['email'])->where('is_block', 1)->first();
            if (!$user) {
                $user = User::where('phone', $data['email'])->where('is_block', 1)->first();
            }

            $act = false;
            if ($user) {
                $act = User::where('id', $user->id)->where('is_block', 1)->where('question', $data['question'])->first();

                if ($act) {
                    if ($act->answer == $data['answer']) {
                        if (($act->user_type == 4)) {
                            if ($act->verification != 1) {
                                $act->verification = 1;
                                if ($act->save()) {
                                    Session::flash('message', 'Your Account Activated Successfully!');
                                    Session::flash('alert-class', 'alert-success');
                                    return redirect()->route('signin');
                                } else {
                                    Session::flash('message', 'Your Account Activation Failed!');
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('signin');
                                }
                            } else {
                                Session::flash('message', 'Your Account is Already Activated!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('signin');
                            }
                        } else {
                            Session::flash('message', 'You Are Not Authenticate User!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('signin');
                        }
                    } else {
                        Session::flash('message', 'Your Security Answer is Wrong!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('chk_act_question');
                    }
                } else {
                    Session::flash('message', 'Your Security Question is Wrong!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('chk_act_question');
                }
            } else {
                Session::flash('message', 'Your E-Mail or Mobile Number is Not Valid!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('chk_act_question');
            }
        }
    }

    public function MyAccount()
    {
        $value = session()->get('user');

        if (!$value) {
            Session::flash('message', 'You must be logged in to access your account!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
        $user_data = User::findorFail($value->id);


        if ($value) {
            if ($value->user_type == 4) {
                //->Where('payment_status', 1)
                $past_orders = Orders::where('user_id', $value->id)
                    ->where('order_status', 4)
                    ->get();

                if ($past_orders->count() != 0) {
                    foreach ($past_orders as $keys => $values) {
                        $values['details'] = OrderDetails::where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::where('order_id', $values->id)->get();
                        $values['products'] = Products::where('is_block', 1)->get();
                        // $values['is_deleted'] = $values->trashed(); // mark if soft deleted
                    }
                }
                $cancel_orders = Orders::withTrashed()  // include soft-deleted orders
                    ->where('user_id', $value->id)
                    ->where(function ($query) {
                        $query->where('order_status', 5)
                            ->orWhere('cancel_approved', 1)
                            ->orWhereNotNull('deleted_at');
                    })
                    ->get();

                if ($cancel_orders->count() != 0) {
                    foreach ($cancel_orders as $keys => $order) {
                        // Related details
                        $order->details = OrderDetails::where('order_id', $order->id)->get();
                        $order->trans   = OrdersTransactions::where('order_id', $order->id)->get();
                        $order->products = Products::where('is_block', 1)->get();

                        $order->is_deleted = $order->trashed();

                        // ✅ Custom status for deleted orders
                        if ($order->is_deleted) {
                            $order->order_status_text = 'Order Deleted';
                        } else {
                            $order->order_status_text = 'Order Cancelled';
                        }
                    }
                }

                $re_orders = ReturnOrder::Where('user_id', $value->id)->OrderBy('id', 'DESC')->get();
                if (sizeof($re_orders) != 0) {
                    foreach ($re_orders as $keyzz => $valuezz) {
                        $valuezz['details'] = ReturnOrderDetails::Where('return_order_id', $value->id)->get();
                        $valuezz['trans'] = OrdersTransactions::Where('order_id', $valuezz->id)->get();
                        $valuezz['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $orders = Orders::where('user_id', $value->id)
                    ->whereNotIn('order_status', [4, 5])
                    ->whereNotIn('cancel_approved', [1])
                    ->orderBy('id', 'DESC')
                    ->get();

                if ($orders->count() != 0) {
                    foreach ($orders as $key => $value) {
                        $value['details'] = OrderDetails::where('order_id', $value->id)->get();
                        $value['trans'] = OrdersTransactions::where('order_id', $value->id)->get();
                        $value['products'] = Products::where('is_block', 1)->get();
                        // $value['is_deleted'] = $value->trashed(); // mark if soft deleted
                    }
                }
                $address = Address::where('user_id', $user_data->id)->get();
                $wishlist = Wishlist::Where('user_id', $user_data->id)->get();
                $cust_orders = CustomiseProduct::where('user_id', $user_data->id)->OrderBy('id', 'DESC')->get();
                $secure = loginSecurity::all();
                $general = GeneralSettings::first();
                return View::make("front_end.my_account")->with(array('orders' => $orders, 'address' => $address, 'wishlist' => $wishlist, 'cust_orders' => $cust_orders, 'past_orders' => $past_orders, 'cancel_orders' => $cancel_orders, 're_orders' => $re_orders, 'secure' => $secure, 'general' => $general, 'user_data' => $user_data));
            } else {
                Session::flash('message', 'You Are Not Login!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'You Are Not Login!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function ViewOrder($id)
    {
        $value = session()->get('user');
        if ($value) {
            if ($value->user_type == 4) {
                $past_orders = Orders::where('user_id', $value->id)->Where('order_status', 4)->Where('payment_status', 1)->paginate(12);
                if (count($past_orders) != 0) {
                    foreach ($past_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $cancel_orders = Orders::where('user_id', $value->id)->Where('cancel_approved', '!=', 0)->paginate(12);
                if (count($cancel_orders) != 0) {
                    foreach ($cancel_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $re_orders = ReturnOrder::Where('user_id', $value->id)->OrderBy('id', 'DESC')->paginate(12);
                if (sizeof($re_orders) != 0) {
                    foreach ($re_orders as $keyzz => $valuezz) {
                        $valuezz['details'] = ReturnOrderDetails::Where('return_order_id', $value->id)->get();
                        $valuezz['trans'] = OrdersTransactions::Where('order_id', $valuezz->id)->get();
                        $valuezz['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $orders = Orders::withTrashed()->where('id', $id)->first();
                if ($orders) {
                    $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                    $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                    $orders['products'] = Products::Where('is_block', 1)->get();
                    $orders['is_deleted'] = $orders->trashed();
                }

                $secure = loginSecurity::all();
                $general = GeneralSettings::first();
                return View::make("front_end.my_view_orders")->with(array('orders' => $orders, 'past_orders' => $past_orders, 'cancel_orders' => $cancel_orders, 're_orders' => $re_orders, 'secure' => $secure, 'general' => $general));
            } else {
                Session::flash('message', 'You Are Not Login!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'You Are Not Login!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function MyViewReturnOrder($id)
    {
        $value = session()->get('user');
        if ($value) {
            if ($value->user_type == 4) {
                $past_orders = Orders::where('user_id', $value->id)->Where('order_status', 4)->Where('payment_status', 1)->paginate(12);
                if (count($past_orders) != 0) {
                    foreach ($past_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $cancel_orders = Orders::where('user_id', $value->id)->Where('cancel_approved', '!=', 0)->paginate(12);
                if (count($cancel_orders) != 0) {
                    foreach ($cancel_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $re_orders = ReturnOrder::Where('id', $id)->first();
                if ($re_orders) {
                    $re_orders['details'] = ReturnOrderDetails::Where('return_order_id', $re_orders->id)->get();
                    $re_orders['trans'] = OrdersTransactions::Where('order_id', $re_orders->order_id)->get();
                    $re_orders['products'] = Products::Where('is_block', 1)->get();
                }

                $orders = Orders::where('user_id', $value->id)->whereNotIn('order_status', [4, 5])->paginate(12);
                if (count($orders) != 0) {
                    foreach ($orders as $key => $value) {
                        $value['details'] = OrderDetails::Where('order_id', $value->id)->get();
                        $value['trans'] = OrdersTransactions::Where('order_id', $value->id)->get();
                        $value['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $secure = loginSecurity::all();
                $general = GeneralSettings::first();
                return View::make("front_end.my_view_return_order")->with(array('orders' => $orders, 'past_orders' => $past_orders, 'cancel_orders' => $cancel_orders, 're_orders' => $re_orders, 'secure' => $secure, 'general' => $general));
            } else {
                Session::flash('message', 'You Are Not Login!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'You Are Not Login!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function TrackOrder($id)
    {
        $value = session()->get('user');
        if ($value) {
            if ($value->user_type == 4) {
                $past_orders = Orders::where('user_id', $value->id)->Where('order_status', 4)->Where('payment_status', 1)->paginate(12);
                if (count($past_orders) != 0) {
                    foreach ($past_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $cancel_orders = Orders::where('user_id', $value->id)->Where('cancel_approved', '!=', 0)->paginate(12);
                if (count($cancel_orders) != 0) {
                    foreach ($cancel_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $re_orders = ReturnOrder::Where('user_id', $value->id)->OrderBy('id', 'DESC')->paginate(12);
                if (sizeof($re_orders) != 0) {
                    foreach ($re_orders as $keyzz => $valuezz) {
                        $valuezz['details'] = ReturnOrderDetails::Where('return_order_id', $value->id)->get();
                        $valuezz['trans'] = OrdersTransactions::Where('order_id', $valuezz->id)->get();
                        $valuezz['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $orders = Orders::withTrashed()->where('id', $id)->first();
                if ($orders) {
                    $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                    $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                    $orders['products'] = Products::Where('is_block', 1)->get();
                    $orders['shipments'] = Shipment::Where('order_code', $orders->order_code)->first();
                    $orders['is_deleted'] = $orders->trashed();
                }
                $secure = loginSecurity::all();
                $general = GeneralSettings::first();
                return View::make("front_end.my_track_orders")->with(array('orders' => $orders, 'past_orders' => $past_orders, 'cancel_orders' => $cancel_orders, 're_orders' => $re_orders, 'secure' => $secure, 'general' => $general));
            } else {
                Session::flash('message', 'You Are Not Login!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'You Are Not Login!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function LiveTrackOrder($id)
    {
        $value = session()->get('user');
        if ($value) {
            if ($value->user_type == 4) {
                $past_orders = Orders::where('user_id', $value->id)->Where('order_status', 4)->Where('payment_status', 1)->paginate(12);
                if (count($past_orders) != 0) {
                    foreach ($past_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $cancel_orders = Orders::where('user_id', $value->id)->Where('cancel_approved', '!=', 0)->paginate(12);
                if (count($cancel_orders) != 0) {
                    foreach ($cancel_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $re_orders = ReturnOrder::Where('user_id', $value->id)->OrderBy('id', 'DESC')->paginate(12);
                if (sizeof($re_orders) != 0) {
                    foreach ($re_orders as $keyzz => $valuezz) {
                        $valuezz['details'] = ReturnOrderDetails::Where('return_order_id', $value->id)->get();
                        $valuezz['trans'] = OrdersTransactions::Where('order_id', $valuezz->id)->get();
                        $valuezz['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $orders = Orders::Where('id', $id)->first();
                if ($orders) {
                    $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                    $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                    $orders['products'] = Products::Where('is_block', 1)->get();
                    $orders['shipments'] = Shipment::Where('order_code', $orders->order_code)->first();
                    if ($orders['shipments']) {
                        $log_shyp = new ShypliteAuth();
                        $login_shyp = $log_shyp->authenticatShyplite();
                        $login_shyp = json_decode($login_shyp, true);

                        if (!isset($login_shyp['error'])) {
                            $timestamp = time();
                            $appID = $log_shyp->appID;
                            $key = $log_shyp->key;
                            $secret = $log_shyp->secret;
                            if (isset($login_shyp['userToken'])) {
                                $secret = $login_shyp['userToken'];
                            }
                            $SellerID = $log_shyp->SellerID;

                            $sign = "key:" . $key . "id:" . $appID . ":timestamp:" . $timestamp;
                            $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
                            $ch = curl_init();

                            $header = array(
                                "x-appid: $appID",
                                "x-timestamp: $timestamp",
                                "x-sellerid:$SellerID",
                                "Authorization: $authtoken"
                            );

                            curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/track/' . $orders['shipments']->awb);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $server_output = curl_exec($ch);
                            $resp = json_decode($server_output, true);

                            $secure = loginSecurity::all();
                            $general = GeneralSettings::first();
                            return View::make("front_end.live_track_order")->with(array('orders' => $orders, 'past_orders' => $past_orders, 'cancel_orders' => $cancel_orders, 're_orders' => $re_orders, 'secure' => $secure, 'general' => $general, 'response' => $resp));
                        } else {
                            Session::flash('message', 'Track This Order After Sometimes!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('my_account');
                        }
                    } else {
                        Session::flash('message', 'Your order is processing and will be shipped soon!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('my_account');
                    }
                } else {
                    Session::flash('message', 'Could Not Track This Order!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }
            } else {
                Session::flash('message', 'You Are Not Login!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'You Are Not Login!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function ReviewOrder($id)
    {
        $value = session()->get('user');
        if ($value) {
            if ($value->user_type == 4) {
                $past_orders = Orders::where('user_id', $value->id)->Where('order_status', 4)->Where('payment_status', 1)->paginate(12);
                if (count($past_orders) != 0) {
                    foreach ($past_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $cancel_orders = Orders::where('user_id', $value->id)->Where('cancel_approved', '!=', 0)->paginate(12);
                if (count($cancel_orders) != 0) {
                    foreach ($cancel_orders as $keys => $values) {
                        $values['details'] = OrderDetails::Where('order_id', $values->id)->get();
                        $values['trans'] = OrdersTransactions::Where('order_id', $values->id)->get();
                        $values['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $re_orders = ReturnOrder::Where('user_id', $value->id)->OrderBy('id', 'DESC')->paginate(12);
                if (sizeof($re_orders) != 0) {
                    foreach ($re_orders as $keyzz => $valuezz) {
                        $valuezz['details'] = ReturnOrderDetails::Where('return_order_id', $value->id)->get();
                        $valuezz['trans'] = OrdersTransactions::Where('order_id', $valuezz->id)->get();
                        $valuezz['products'] = Products::Where('is_block', 1)->get();
                    }
                }

                $orders = Orders::withTrashed()->where('id', $id)->first();
                if ($orders) {
                    $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
                    $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
                    $orders['products'] = Products::Where('is_block', 1)->get();
                    $orders['is_deleted'] = $orders->trashed();
                }
                $reviews = null;
                foreach ($orders['details'] as $detail) {
                    $reviews = Review::where('user_id', $value->id)
                        ->where('product_id', $detail->product_id)
                        ->first();
                    // Do something with $review
                }
                // dd($reviews);

                // dd($id);
                $secure = loginSecurity::all();
                $general = GeneralSettings::first();
                return View::make("front_end.my_review_orders")->with(array('orders' => $orders, 'reviews' => $reviews, 'past_orders' => $past_orders, 'cancel_orders' => $cancel_orders, 're_orders' => $re_orders, 'secure' => $secure, 'general' => $general));
            } else {
                Session::flash('message', 'You Are Not Login!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'You Are Not Login!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function CustomerCancelOrder(Request $request)
    {
        $id = 0;
        $error = 0;
        if ($request->ajax() && isset($request->id)) {
            $id = $request->id;
            if ($id != 0) {
                $cancel = Orders::where('id', $id)->where('order_status', 1)->first();
                if ($cancel) {
                    $n_date = date('Y-m-d');
                    $c_date = date('Y-m-d', strtotime($cancel->order_date . ' + 1 days'));
                    if ($c_date >= $n_date) {

                        $orderDetails = OrderDetails::where('order_id', $cancel->id)->get();
                        foreach ($orderDetails as $detail) {
                            // $product = Products::find($detail->product_id);
                            // if($product){
                            //     $product->onhand_qty += $detail->order_qty;
                            //     $product->save();
                            // }
                            // $stock_manag = StockManagement::where('product_id', $detail->product_id)->latest()->first();
                            // if($stock_manag){
                            //     $stock_manag->current_qty += $detail->order_qty; // Use updated value directly
                            //     $stock_manag->save();
                            // }


                        }
                        $cancel->cancel_approved = 3;
                        $cancel->cancel_remarks = "processing";

                        $cancel->cancel_date = $n_date;
                        if ($cancel->save()) {
                            $text = "Your Order Cancel Request against " . $cancel->order_code . " has been received, We will  Notify you the status soon";
                            $text = urlencode($text);

                            $curl = curl_init();
                            $user = User::Where('id', $cancel->user_id)->first();
                            if ($user) {
                                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@parislabelle.in";
                                if ($adm) {
                                    $admin_email = $adm->email;
                                }

                                $logos = \DB::table('logo_settings')->latest()->first();
                                $logo_path = 'images/logo';
                                $logo = "";
                                if ($logos) {
                                    $logo = asset($logo_path . '/' . $logos->logo_image);
                                } else {
                                    $logo = asset('images/logo.png');
                                }

                                $general = \DB::table('general_settings')->first();
                                $site_name = "Folkgems";
                                if ($general) {
                                    $site_name = $general->site_name;
                                } else {
                                    $site_name = "Folkgems";
                                }

                                $product_path = 'images/featured_products';
                                $noimage = \DB::table('noimage_settings')->first();
                                $noimage_path = 'images/noimage';


                                $img = '';
                                $details = '';
                                $discount = '';
                                $color = '';

                                foreach ($cancel->orderDetails as $orderDetail) {
                                    if ($orderDetail->color_name) {
                                        $color = '( ' . $orderDetail->color_name . ' )';
                                    }
                                    if ($orderDetail->Products->featured_product_img) {
                                        $img = '<img src="' . asset($product_path . '/' . $orderDetail->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                    } else {
                                        $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                    }
                                    $details .= '<tr>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                            <a href="' . route('view_products', ['id' => $orderDetail->product_id]) . '">
                                                ' . $img . '
                                            </a>
                                        </td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">' . $orderDetail->product_title . ' ' . $color . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">' . $orderDetail->order_qty . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. ' . $orderDetail->unitprice . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  ' . $orderDetail->tax_amount . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs. ' . $orderDetail->totalprice . '</td>
                                    </tr>';
                                }

                                if ($cancel->coupon_code) {
                                    $discount = '
                                        <tr>
                                            <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                                Coupon Discount
                                            </th>
                                            <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                                - Rs. ' . number_format($cancel->coupon_discount, 2) . '
                                            </td>
                                        </tr>';
                                }

                                //  $brand = "RANGBYBHAVANA"; 
                                // $validity = 5; 
                                // $mobile = '91' . $user->phone; 
                                // $var3 = 'https://instagram.com/rang_by_bhavana';
                                // $var4 = 'www.rangjewelry.com';
                                // $var2 = 'www.rangjewelry.com';

                                // $message = "Dear $user->full_name, Your order $cancel->order_code has been cancelled. If you have any questions, please contact us at $var2. Thank you for shopping with RANG BY BHAVANA:$var3 $var4";
                                // $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                                // $senderId = "RANGBB";
                                // $route = "5";
                                // $templateId = "1007787374254465259";

                                // $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                                //  . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                                //  . "&number=$mobile&text=" . urlencode($message)
                                //  . "&route=$route&DLTTemplateId=$templateId";

                                // $ch = curl_init();
                                // curl_setopt($ch, CURLOPT_URL, $url);
                                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                // $smsResponse = curl_exec($ch);
                                // $smsError = curl_error($ch);
                                // curl_close($ch);

                                // $name = $user->first_name.' '.$user->last_name;
                                $name = $user->full_name;
                                $net_tot = $cancel->net_amount;

                                $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                $to1 = $user->email;
                                $to2 = $admin_email;
                                $subject = "Your Rukmini Fashions Order was Cancelled";

                                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0; border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                                        <div style="padding: 5px; color: #333; text-align: center; font-size: 18px;">
                                            <p style="font-size:15px;font-weight:600;">Dear ' . $name . ', </p>
                                           
                                           <p style="font-size:12px;font-weight:600;">We have received your request to <b>Cancel</b> your order #' . $cancel->order_code . ' from Rukmini Fashions.</p>
                                           
                                            <h2 style=" color: #B73182;margin-top: 0px;">Cancel Order Request</h4>
                                            <table align="center" style=" text-align: center;width: 100%;">
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">customer Name</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $name . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $user->phone . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Email</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $user->email . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $cancel->order_code . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $cancel->order_date . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Request Date</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $cancel->cancel_date . '</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Mode</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $cancel->payment->name . '</td>
                                                </tr>
                                            </table>
                                            
                                            <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                                <tr>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                                    <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                                </tr>' . $details . '
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $cancel->total_amount . '</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $cancel->shipping_charge . '</td>
                                                </tr>
                                                
                                                ' . $discount . '
                                               
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $net_tot . '</td>
                                                </tr>
                                            </table>

                                            <p style="font-size:15px;font-weight:600;">We shall update you on the status of the cancellation request shortly.</p>
                                            <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please do not hesitate to reach out to our <a href="' . route('contact') . '">customer support team</a>.</p>
                                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                            <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                             <div style="padding: 20px 0; text-align: center;">
                                                <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>';


                                // if(1==1){
                                // if(mail($to1,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers)){
                                Session::put('cancel_email_data', [
                                    'to' => $to1,
                                    'to2' => $admin_email,
                                    'subject' => $subject,
                                    'body' => $txt,
                                    'headers' => $headers,
                                ]);
                                Session::flash('message', 'Your Order Cancel Request Sent Successfully!');
                                Session::flash('alert-class', 'alert-success');

                                $error = 1;





                                // }

                                // Send the POST request with cURL
                                // curl_setopt_array($curl, array(
                                // CURLOPT_RETURNTRANSFER => 1,
                                // CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                                // CURLOPT_POST => 1,
                                // CURLOPT_CUSTOMREQUEST => 'POST',
                                // CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                                // CURLOPT_POSTFIELDS => array(
                                //     'mobile' => $user->phone,
                                //     'route' => 'TL',
                                //     'text' => $text,
                                //     'sender' => 'GJICAM')));

                                // // Send the request & save response to $response
                                // $response = curl_exec($curl);

                                // // Close request to clear up some resources
                                // curl_close($curl);
                                // $response = json_decode($response);
                                // // Print response
                                // if(isset($response->data->status) && $response->data->status == "success") {
                                //     Session::flash('message', 'Your Order Cancel Request Send Successfully!'); 
                                //     Session::flash('alert-class', 'alert-success');
                                //     echo $error = 1;die();
                                // } else {
                                //     Session::flash('message', 'Your Order Cancel Request Send Successfully!'); 
                                //     Session::flash('alert-class', 'alert-danger');
                                //     echo $error = 1;die();
                                // }
                            }
                            Session::put('cancel_email_data', [
                                'to' => $to1,
                                'to2' => $admin_email,
                                'subject' => $subject,
                                'body' => $txt,
                                'headers' => $headers,
                            ]);
                            $error = 1;
                        } else {
                            $error = 0;
                        }
                    } else {
                        $error = 5;
                    }
                } else {
                    $error = 0;
                }
            } else {
                $error = 0;
            }

            echo $error;
        }
    }

    public function CustomerReturnOrder($id)
    {
        $order = Orders::Where('id', $id)->first();
        if ($order) {
            $odr_dets = OrderDetails::Where('order_id', $order->id)->get();
            if (sizeof($odr_dets) != 0) {
                $order->{'odr_dets'} = $odr_dets;
            } else {
                $order->{'odr_dets'} = array();
            }
            return View::make("front_end.customer_return_order")->with(array('order' => $order));
        } else {
            Session::flash('message', 'Return / Replace Order Not Possible!');
            Session::flash('alert-class', 'alert-danger');
            return Redirect::to('/my_account/#Section4');
        }
    }

    public function SaveReturnOrder(Request $request)
    {
        $log = session()->get('user');
        $data = $request->all();
        // print_r($data);die();

        $rules = array(
            'order_id'             => 'nullable|exists:orders,id',
            'user_id'              => 'nullable|exists:users,id',
            'order_code'           => 'required',
            'order_date'           => 'required',
            'total_items'          => 'required',
            'net_amount'           => 'required',
            'return_total_items'   => 'nullable',
            'return_net_amount'    => 'nullable',
            'return_date'          => 'nullable',
            'is_block'             => 'nullable',

            'check.*'              => 'nullable',
            'det_id.*'             => 'nullable',
            'return_type.*'        => 'nullable',
            'return_qty.*'         => 'nullable',
            'return_amount.*'      => 'nullable',
            // 'return_tax_amount.*'  => 'nullable',
            'reason.*'             => 'nullable',
            'remarks.*'            => 'nullable',
            'rtn_image.*'          => 'nullable',
        );

        $messages = [
            'return_qty.required' => 'The Quantity field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('/customer_return_order/' . $data['order_id'])->withErrors($validator);
        } else {
            $re_odr = new ReturnOrder();

            if ($re_odr) {
                if ($log) {
                    if ($log->id) {
                        $re_odr->user_id  = $log->id;
                    } else {
                        $re_odr->user_id  = NULL;
                    }
                } else {
                    $re_odr->user_id      = NULL;
                }

                $re_odr->order_id         = $data['order_id'];
                $re_odr->order_code       = $data['order_code'];
                $re_odr->order_date       = date('Y-m-d', strtotime($data['order_date']));
                $re_odr->total_items      = $data['total_items'];
                $re_odr->net_amount       = $data['net_amount'];
                $re_odr->return_date      = date('Y-m-d');
                $re_odr->is_block         = 1;

                if ($re_odr->save()) {
                    $order = Orders::Where('id', $re_odr->order_id)->first();
                    if ($order) {
                        $order->return_order_status = 1;
                        $order->save();
                    }

                    $ok = 0;
                    $return_total_items = 0;
                    $return_net_amount = 0;
                    if (isset($data['det_id']) && sizeof($data['det_id']) != 0) {
                        ReturnOrderDetails::Where('return_order_id', $re_odr->id)->delete();
                        foreach ($data['det_id'] as $key => $value) {
                            if ($value) {
                                $re_odr_details = new ReturnOrderDetails();
                                $re_odr_details->return_order_id = $re_odr->id;
                                $re_odr_details->rtn_odr_det_id = $value;
                                $odr_dets = OrderDetails::Where('id', $value)->first();

                                if ($odr_dets) {
                                    $re_odr_details->product_id = $odr_dets->product_id;
                                    $re_odr_details->product_title = $odr_dets->product_title;
                                    $re_odr_details->att_name = $odr_dets->att_name;
                                    $re_odr_details->att_value = $odr_dets->att_value;
                                    $re_odr_details->tax = $odr_dets->tax;
                                    $re_odr_details->tax_type = $odr_dets->tax_type;
                                    $re_odr_details->order_qty = $odr_dets->order_qty;
                                    $re_odr_details->unitprice = $odr_dets->unitprice;
                                    // $re_odr_details->tax_amount = $odr_dets->tax_amount;
                                    $re_odr_details->totalprice = $odr_dets->totalprice;
                                }

                                if (isset($data['return_type'][$key])) {
                                    $re_odr_details->return_type = $data['return_type'][$key];
                                } else {
                                    $re_odr_details->return_type = NULL;
                                }

                                if (isset($data['return_qty'][$key])) {
                                    $re_odr_details->return_qty = $data['return_qty'][$key];
                                } else {
                                    $re_odr_details->return_qty = NULL;
                                }

                                if (isset($data['return_amount'][$key])) {
                                    $re_odr_details->return_amount = $data['return_amount'][$key];
                                } else {
                                    $re_odr_details->return_amount = 0.00;
                                }

                                /*if(isset($data['return_tax_amount'][$key])) {
                                    $re_odr_details->return_tax_amount = $data['return_tax_amount'][$key];
                                } else {
                                    $re_odr_details->return_tax_amount = 0.00;
                                }*/

                                if (isset($data['reason'][$key])) {
                                    $re_odr_details->reason = $data['reason'][$key];
                                } else {
                                    $re_odr_details->reason = NULL;
                                }

                                if (isset($data['remarks'][$key])) {
                                    $re_odr_details->remarks = $data['remarks'][$key];
                                } else {
                                    $re_odr_details->remarks = NULL;
                                }

                                if (isset($data['rtn_image'][$key])) {
                                    $file_name = $data['rtn_image'][$key]->getClientOriginalName();
                                    $date = date('M-Y');
                                    // $file_path = '../public/images/attributes/'.$date;
                                    $file_path = 'images/return_order_image/' . $date;
                                    $data['rtn_image'][$key]->move($file_path, $file_name);

                                    $re_odr_details->rtn_image       = $date . '/' . $file_name;
                                } else {
                                    $re_odr_details->rtn_image       = NULL;
                                }

                                $return_total_items = $return_total_items + $re_odr_details->return_qty;
                                $return_net_amount = $return_net_amount + $re_odr_details->return_amount;
                                $re_odr_details->order_returned  = "No";
                                $re_odr_details->status  = "Process";

                                $re_odr_details->save();
                                $ok = 1;
                            }
                        }

                        if ($ok == 1) {
                            $re_odr->return_total_items = $return_total_items;
                            $re_odr->return_net_amount = $return_net_amount;
                            if ($re_odr->save()) {
                                $ok = 1;
                            }

                            $text = "Your Order Return/Replacemnet Request against " . $re_odr->order_code . " Has been received , we will verify the same and get back to you soon, Folkgems.com";
                            $text = urlencode($text);

                            $curl = curl_init();
                            $user = User::Where('id', $re_odr->user_id)->first();
                            if ($user) {
                                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                $admin_email = "info@folkgems.com";
                                if ($adm) {
                                    $admin_email = $adm->email;
                                }

                                $logos = \DB::table('logo_settings')->first();
                                $logo_path = 'images/logo';
                                $logo = "";
                                if ($logos) {
                                    $logo = asset($logo_path . '/' . $logos->logo_image);
                                } else {
                                    $logo = asset('images/logo.png');
                                }

                                $general = \DB::table('general_settings')->first();
                                $site_name = "Folkgems";
                                if ($general) {
                                    $site_name = $general->site_name;
                                } else {
                                    $site_name = "Folkgems";
                                }

                                $name = $user->first_name . ' ' . $user->last_name;

                                $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers .= "From: jgrrylvmgyxm" . "\r\n";
                                $to1 = $user->email;
                                $to2 = $admin_email;
                                $subject = "Return Order Request";

                                $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 300px; margin: 0 auto;display: block;"></div>
                                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                            <h2 style="color: #ff5c00;margin-top: 0px;">Return Order Request</h2>
                                            <table align="center" style=" text-align: center;">
                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">customer Name</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $name . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Contact No</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $user->phone . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Email</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $user->email . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Order Code</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $re_odr->order_code . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Order Date</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $re_odr->order_date . '</td>
                                                </tr>

                                                <tr>
                                                    <th style=" text-align: center;text-transform: uppercase;padding-bottom: 12px;color: #333;font-weight:bold;width: 120px;">Request Date</th>
                                                    <td style="font-size: 14px;font-weight: bold;color: #333;padding-bottom: 12px;"> : ' . $re_odr->return_date . '</td>
                                                </tr>
                                            </table>

                                            <p>Your Order Return/Replacemnet Request Has been received , we will verify the same and get back to you soon.</p>
                                            <p>Thank You.</p>
                                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                            <p>Thanks & Regards,</p>
                                            <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                                        </div>
                                    </div>';


                                // if(1==1){
                                if (mail($to1, $subject, $txt, $headers) && mail($to2, $subject, $txt, $headers)) {
                                    Session::flash('message', 'Your Order Return/Replacemnet Request Submitted Successfully, we will get back to you soon!');
                                    Session::flash('alert-class', 'alert-success');
                                    // return Redirect::to('/my_account/#Section4');
                                }

                                // Send the POST request with cURL
                                curl_setopt_array($curl, array(
                                    CURLOPT_RETURNTRANSFER => 1,
                                    CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                                    CURLOPT_POST => 1,
                                    CURLOPT_CUSTOMREQUEST => 'POST',
                                    CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                                    CURLOPT_POSTFIELDS => array(
                                        'mobile' => $user->phone,
                                        'route' => 'TL',
                                        'text' => $text,
                                        'sender' => 'GJICAM'
                                    )
                                ));

                                // Send the request & save response to $response
                                $response = curl_exec($curl);

                                // Close request to clear up some resources
                                curl_close($curl);
                                $response = json_decode($response);
                                // Print response
                                if (isset($response->data->status) && $response->data->status == "success") {
                                    Session::flash('message', 'Your Order Return/Replacemnet Request Submitted Successfully, we will get back to you soon!');
                                    Session::flash('alert-class', 'alert-success');
                                    return Redirect::to('/my_account/');
                                } else {
                                    Session::flash('message', 'Your Order Return/Replacemnet Request Submitted Successfully, we will get back to you soon!');
                                    Session::flash('alert-class', 'alert-danger');
                                    return Redirect::to('/my_account/');
                                }
                            }
                        } else {
                            $re_odr->delete();
                            Session::flash('message', 'Your Return or Replacement Order Failed!');
                            Session::flash('alert-class', 'alert-danger');
                            return Redirect::to('/customer_return_order/' . $data['order_id']);
                        }
                    } else {
                        $re_odr->delete();
                        Session::flash('message', 'Your Return or Replacement Order Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        return Redirect::to('/customer_return_order/' . $data['order_id']);
                    }
                } else {
                    Session::flash('message', 'Your Return or Replacement Order Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return Redirect::to('/my_account/');
                }
            } else {
                Session::flash('message', 'Your Return or Replacement Order Failed!');
                Session::flash('alert-class', 'alert-danger');
                return Redirect::to('/my_account/');
            }
        }
    }

    public function SendFeedBack(Request $request)
    {
        $log = session()->get('user');
        $data = $request->all();

        $rules = array(
            'user_id'  => 'nullable',
            'subject'  => 'required',
            'message'  => 'required',
            'is_block' => 'nullable',
        );

        $messages = [
            'subject.required' => 'The subject field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // return redirect()->route('my_account')->withErrors($validator);
            return Redirect::to('/my_account/#Section7')->withErrors($validator);
        } else {
            $feeds = new FeedBack();

            if ($feeds) {
                $feeds->user_id    = $data['user_id'];
                $feeds->subject    = $data['subject'];
                $feeds->message    = $data['message'];
                $feeds->is_block   = 1;

                if ($feeds->save()) {
                    Session::flash('message', 'Feed Back Send Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('my_account');
                } else {
                    Session::flash('message', 'Feed Back Send Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }
            } else {
                Session::flash('message', 'Feed Back Send Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('my_account');
            }
        }
    }

    public function SubmitReview(Request $request)
    {
        $data = $request->all();
        /*$orders = Orders::where('id',$data['order_id'])->first();
        if($orders) {
            $orders['details'] = OrderDetails::Where('order_id', $orders->id)->get();
            $orders['trans'] = OrdersTransactions::Where('order_id', $orders->id)->get();
            $orders['products'] = Products::Where('is_block', 1)->get();
        }*/

        $rules = array(
            'product_id'       => 'required|exists:products,id',
            // 'order_id'         => 'required|exists:orders,id',
            'user_id'          => 'required|exists:users,id',
            'rating'           => 'required',
            // 'description'      => 'required',
            'is_block'         => 'nullable',
        );

        $messages = [
            'product_id.required'  => 'Could Not Reviewed This  Product!',
            'product_id.exists'    => 'Could Not Reviewed This  Product!',
            // 'order_id.required'    =>'Could Not Reviewed This  Product!',
            // 'order_id.exists'      =>'Could Not Reviewed This  Product!',
            'user_id.required'     => 'Could Not Reviewed This  Product!',
            'user_id.exists'       => 'Could Not Reviewed This  Product!',
            'rating.required'      => 'Star Rating Field Required!',
            // 'description.required' =>'Review Field is Required!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // dd( $validator);
            return Redirect::to('/view_products/' . $data['product_id'])->withErrors($validator);
        } else {
            $review = Review::where('product_id', $data['product_id'])
                ->where('user_id', $data['user_id'])
                ->first();

            if ($review) {
                // Update the existing review
                $review->rating = $data['rating'];
                $review->description = $data['description'];
                $message = 'Review Updated Successfully!';
            } else {
                // Create new review
                $review = new Review();
                $review->product_id = $data['product_id'];
                $review->user_id = $data['user_id'];
                $review->rating = $data['rating'];
                $review->description = $data['description'];
                $review->is_block = 0;
                $message = 'Reviewed Successfully!';
            }
            if ($review->save()) {
                Session::flash('message', $message);
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('my_account', ['tab' => 'completedOrders']);
                // return Redirect::back();
            } else {
                Session::flash('message', 'Reviewed Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('my_account', ['tab' => 'completedOrders']);
                // return Redirect::back();
            }
        }
    }

    public function getReview(Request $request)
    {
        $review = Review::where('product_id', $request->product_id)
            ->where('user_id', $request->user_id)
            ->first();

        return response()->json(['review' => $review]);
    }


    public function Contact()
    {
        $contact = ContactUsPage::first();
        if ($contact) {
            return View::make("front_end.contact")->with(array('contact' => $contact));
        } else {
            Session::flash('message', 'Page Not Found');
            Session::flash('alert-class', 'alert-danger');
            // return redirect()->route('home');
            return Redirect::back();
        }
    }

    public function StoreContact(Request $request)
    {
        $rules = array(
            'review_type'            => 'required',
            'contact_email'           => 'required|email:rfc,dns',
            // 'contact_phone'           =>'required',
            // 'subject'                 => 'required',
            'message'                 => 'required',
            // 'is_block'                => 'nullable',
            'g-recaptcha-response'    => 'required',
        );

        $messages = [
            'review_type.required' => 'Please select Purpose of Message',
            'g-recaptcha-response.required' => 'The capcha field is required.',
            // 'contact_email.required'=>'The Email field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return Redirect::to('/contact/')->withErrors($validator)->withInput();
        } else {
            $data = $request->all();
            $contact = new Contacts();

            if ($contact) {
                $contact->review_type       = $data['review_type'];
                $contact->contact_name       = $data['contact_name'];
                $contact->contact_email      = $data['contact_email'];
                $contact->contact_phone      = $data['contact_phone'];
                $contact->subject            = $data['subject'];
                $contact->message            = $data['message'];
                $contact->is_block           = 1;

                if ($contact->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "info@folkgems.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Folkgems";
                    }

                    $subj = "";
                    $feedbacktxt = '';
                    $headtxt = '';
                    if ($contact->review_type == 'enquiry') {
                        $subj = "Your Enquiry to Rukmini Fashions was Received";
                        $feedbacktxt = '
                        <p style="font-size:15px;font-weight:600;">Thank you for reaching out to Rukmini Fashions with your enquiry. We appreciate you taking the time to connect with us. We shall revert back on it shortly. </p>
                                
                        ';
                        $headtxt = '<h2 style="color: #B73182;margin-top: 0px;">Customer Enquiry</h2>';
                    } else {
                        $subj = "Your Brand Review for Rukmini Fashions was Received.";
                        $feedbacktxt = '
                        <p style="font-size:15px;font-weight:600;"> Thank you for taking the time to share your feedback on Rukmini Fashions and your customer experience with us. We truly appreciate your valuable input. Your feedback will be published soon.</p>
                        <p style="font-size:15px;font-weight:600;"> At Rukmini Fashions, we are committed to providing high-quality products and exceptional customer experiences. Your feedback plays a crucial role in our continuous improvement efforts.</p>
                        ';
                        $headtxt = '<h2 style="color: #B73182;margin-top: 0px;">Customer’s Brand Review</h2>';
                    }



                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    $to = $contact->contact_email;
                    $subject = $subj;
                    //   dd($to);

                    $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                            <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"><a/></div>
                            <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                            ' . $headtxt . '
                            
                                <p style="font-size:15px;font-weight:600; text-align:left !important"> Dear ' . $contact->contact_name . ', <br/> ' . $feedbacktxt . ' </p>
                                
                                 
                                  <table align="center" style=" text-align: center;width: 100%;">
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact->contact_name . '</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">E-Mail</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact->contact_email . '</td>
                                </tr>
                                
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Phone No</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact->contact_phone . '</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Message</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . nl2br($contact->message) . '</td>
                                </tr>
                            </table>
                                 
                                <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please reach out to our <a href="' . route('home') . '">customer support team </a>. </p>
                                <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                <div style="padding: 20px 0; text-align: center;">
                                <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                </a>
                            </div>
                            </div>
                        </div>';

                    $txt2 = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                            ' . $headtxt . '
                            <table align="center" style=" text-align: center;width: 100%;">
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact->contact_name . '</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">E-Mail</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact->contact_email . '</td>
                                </tr>
                                
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Phone No</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact->contact_phone . '</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Message</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . nl2br($contact->message) . '</td>
                                </tr>
                            </table>

                            <p></p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                            <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                            <div style="padding: 20px 0; text-align: center;">
                                <a href="https://www.instagram.com/parislabellenta" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                </a>
                            </div>
                        </div>
                    </div>';

                    // if(mail($to,$subject,$txt,$headers) && mail($admin_email,$subject,$txt2,$headers)){
                    if ($data['review_type'] == 'testimonial') {
                        Session::flash('message', 'Brand Review has been submitted successfully, Thank you!');
                    } elseif ($data['review_type'] == 'enquiry') {
                        Session::flash('message', 'Enquiry request has been submitted successfully, Thank you!');
                    } else {
                        Session::flash('message', 'Your request has been submitted successfully!');
                    }
                    Session::flash('alert-class', 'alert-success');
                    Session::put('email_data', [
                        'to' => $contact->contact_email,
                        'to2' => $admin_email,
                        'subject' => $subject,
                        'body' => $txt,
                        'headers' => $headers,
                    ]);
                    return redirect()->route('contact');
                    // } else {
                    //     Session::flash('message', 'Mail Sent Failed!'); 
                    //     Session::flash('alert-class', 'alert-danger');
                    //     return redirect()->route('contact'); 
                    // }
                } else {
                    Session::flash('message', 'Mail Sent Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('contact');
                }
            } else {
                Session::flash('message', 'Mail Sent Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('contact');
            }
        }
    }

    public function sendContactEmail(Request $request)
    {
        $data = session()->pull('email_data');

        if ($data) {
            mail($data['to'], $data['subject'], $data['body'], $data['headers']);
            mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
            return response()->json(['status' => 'sent']);
        }

        return response()->json(['status' => 'no_data']);
    }

    public function HowToFindUs()
    {
        $emails = EmailSettings::first();
        $general = GeneralSettings::first();
        return View::make("front_end.how_to_find_us")->with(array('emails' => $emails, 'general' => $general));
    }

    public function Privacy()
    {
        return View::make("front_end.privacy");
    }

    public function Disclaimer()
    {
        $disc = Disclaimers::first();
        if ($disc) {
            return View::make("front_end.disclaimer")->with(array('disc' => $disc));
        } else {
            Session::flash('message', 'Page Not Found!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('home');
        }
    }

    public function NewsLetters(Request $request)
    {
        $rules = array(
            'email'           => 'required|email:rfc,dns|unique:news_letters,email',
            'is_block'        => 'nullable',
        );

        $messages = [
            'email.required' => 'The Email field is required.',
            'email.unique'   => 'Email Has Already Been Subscribed To RANG',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            // dd($validator->errors());
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $data = $request->all();
            $news_letters = new NewsLetter();

            if ($news_letters) {
                $news_letters->email      = $data['email'];
                $news_letters->is_block   = 1;

                if ($news_letters->save()) {
                    $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                    $admin_email = "info@folkgems.com";
                    if ($adm) {
                        $admin_email = $adm->email;
                    }

                    $logos = \DB::table('logo_settings')->latest()->first();
                    $logo_path = 'images/logo';
                    $logo = "";
                    if ($logos) {
                        $logo = asset($logo_path . '/' . $logos->logo_image);
                    } else {
                        $logo = asset('images/logo.png');
                    }

                    $general = \DB::table('general_settings')->first();
                    $site_name = "Folkgems";
                    if ($general) {
                        $site_name = $general->site_name;
                    } else {
                        $site_name = "Folkgems";
                    }

                    $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    // $headers.= "From: $admin_email" . "\r\n";
                    $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                    $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                    $to = $news_letters->email;
                    $subject = "Thank you for Subscribing to Rukmini Fashions’s Newsletter. ";

                    $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                            <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                            <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                                <p style="font-size:15px;font-weight:600;">Thank you for subscribing to the Rukmini Fashions newsletter! We are excited to have you as part of our community.</p>
                                <p style="font-size:15px;font-weight:600;">As a member of our newsletter, you will receive updates on our latest products, exclusive offers, and insights into the world of Rukmini Fashions. </p>
                                <p style="font-size:13px;font-weight:600;">We hope you will find the content valuable and engaging.If you have any questions or feedback, Please do not hesitate to reach out to our <a href="' . route('contact') . '">customer support team</a>.</p>
                                <p></p>
                                <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                <div style="padding: 20px 0; text-align: center;">
                                    <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                    </a>
                                    <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                    </a>
                                    <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                        <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                    </a>
                                </div>

                            </div>
                        </div>';

                    // if(mail($to,$subject,$txt,$headers)){
                    Session::put('news_email_data', [
                        'to' =>  $news_letters->email,
                        'to2' => $admin_email,
                        'subject' => $subject,
                        'body' => $txt,
                        'headers' => $headers,
                    ]);
                    Session::flash('newsletter_trigger', true);
                    Session::flash('message', 'Successfully subscribed to the newsletter!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('home');
                    // } else {
                    //       $lastError = error_get_last();
                    //     $errorMessage = isset($lastError['message']) ? $lastError['message'] : 'Unknown error occurred while sending the newsletter.';

                    //     Session::flash('message', 'Newsletter Mail Send Failed! Reason: ' . $errorMessage);

                    //     // Session::flash('message', 'Newsletter Mail Send Failed!'); 
                    //     Session::flash('alert-class', 'alert-danger');
                    //     return redirect()->route('home'); 
                    // }
                } else {
                    Session::flash('message', 'Mail Send Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('home');
                }
            } else {
                Session::flash('message', 'Mail Send Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('home');
            }
        }
    }

    public function sendNewsLettersEmail(Request $request)
    {
        $data = session()->pull('news_email_data');

        if ($data) {
            mail($data['to'], $data['subject'], $data['body'], $data['headers']);
            mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
            return response()->json(['status' => 'sent']);
        }

        return response()->json(['status' => 'no_data']);
    }

    public function UnSubscribeNewsLetters($id)
    {
        $news_letters = NewsLetter::where('id', $id)->where('is_block', 1)->first();
        if ($news_letters) {
            $news_letters->is_block   = 0;

            if ($news_letters->save()) {
                $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                $admin_email = "info@folkgems.com";
                if ($adm) {
                    $admin_email = $adm->email;
                }

                $logos = \DB::table('logo_settings')->latest()->first();
                $logo_path = 'images/logo';
                $logo = "";
                if ($logos) {
                    $logo = asset($logo_path . '/' . $logos->logo_image);
                } else {
                    $logo = asset('images/logo.png');
                }

                $general = \DB::table('general_settings')->first();
                $site_name = "Folkgems";
                if ($general) {
                    $site_name = $general->site_name;
                } else {
                    $site_name = "Folkgems";
                }

                $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                // $headers.= "From: $admin_email" . "\r\n";
                $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                $to = $news_letters->email;
                $subject = "UnSubcribe For Email Notification";

                $txt = '<div class="gj_mail" style="width: 500px; padding: 20px 30px; margin: 0 auto; position: relative; background-image: url(' . asset('images/shadow.png') . '); background-repeat: no-repeat; height: 100%;  background-size: 100% 102%;">
                        <div style="margin: 10px 20px; padding: 20px;  border-bottom: 1px solid #ff5c00;"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></div>
                        <div style="padding: 5px; color: #333; margin: 0px 20px; text-align: center; font-size: 18px;">
                            <p>Unsubscribe For Email Notification Successfully.</p>
                            <p></p>
                            <p>Thank You.</p>
                            <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p>Thanks & Regards,</p>
                            <p><a href="' . route('home') . '">' . $site_name . '</a></p>
                        </div>
                    </div>';

                if (mail($to, $subject, $txt, $headers)) {
                    Session::flash('message', 'Unsubscribe & Mail Sent Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('home');
                } else {
                    Session::flash('message', 'Mail Send Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('home');
                }
            } else {
                Session::flash('message', 'Unsubscribed to the Another Time!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('home');
            }
        } else {
            Session::flash('message', 'You Are Not Subscribed User!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('home');
        }
    }

    public function AddToCart(Request $request)
    {
        $id = 0;
        if ($request->ajax() && isset($request->id)) {
            $id = $request->id;
            $qty = $request->qty;
            $price = $request->price;
            $att_name = $request->att_name;
            $att_value = $request->att_value;
            $color_id = $request->color_id;
            $color_name = $request->color_name;
            if ($att_name == 0) {
                $att_name = NULL;
            }
            if ($att_value == 0) {
                $att_value = NULL;
            }

            if (!$qty) {
                $qty = 1;
            }


            $session = $request->session();
            $cartData = ($session->get('cart')) ? $session->get('cart') : array();

            $users = session()->get('user');
            if ($users) {
                if ($users->user_type == 4) {
                    $chk_carts = Carts::Where('product_id', $id)->Where('is_offer', "No")->Where('user_id', $users->id)->first();
                    if ($chk_carts) {
                        Session::flash('message', 'Already Added to Cart!');
                        Session::flash('alert-class', 'alert-danger');
                        echo $error = 2;
                        die();
                    }
                } else {
                    if ($cartData) {
                        foreach ($cartData as $keyz => $valuez) {
                            // if(isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['is_offer'] == 'No') {
                            if (isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['att_name'] == $att_name && $cartData[$keyz]['att_value'] == $att_value && $cartData[$keyz]['is_offer'] == 'No') {
                                Session::flash('message', 'Already Added to Cart!');
                                Session::flash('alert-class', 'alert-danger');
                                echo $error = 2;
                                die();
                            }
                        }
                    }
                }
            } else {
                if ($cartData) {
                    foreach ($cartData as $keyz => $valuez) {
                        // if(isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['is_offer'] == 'No') {
                        if (isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['att_name'] == $att_name && $cartData[$keyz]['att_value'] == $att_value && $cartData[$keyz]['is_offer'] == 'No') {
                            Session::flash('message', 'Already Added to Cart!');
                            Session::flash('alert-class', 'alert-danger');
                            echo $error = 2;
                            die();
                        }
                    }
                }
            }

            $error = 1;
            if ($id) {
                $product = Products::where('id', $id)->first();
                if ($product) {
                    $displayPrice = $product->original_price > 0 ? $product->original_price : $product->discounted_price;
                    $price = $displayPrice;
                    $tax_amount = $product->tax_amount;
                    $onhand_qty = $product->onhand_qty;
                    if ($onhand_qty != 0 && $onhand_qty > 0) {
                        if ($onhand_qty >= $qty) {
                            $att_qty = 0;
                            $p_attrs = ProductsAttributes::Where('product_id', $product->id)->where('att_default', 1)->first();
                            if ($p_attrs) {
                                if (!$att_name && !$att_value) {
                                    $att_name = $p_attrs->attribute_name;
                                    $att_value = $p_attrs->attribute_values;
                                    $att_qty = $p_attrs->att_qty;
                                    $price = $p_attrs->att_cost;
                                    // $tax_amount = $p_attrs->att_tax_amount;
                                    $qty = 1;
                                }
                                // } else {
                                //     $p_attz = ProductsAttributes::Where('product_id', $product->id)->where('attribute_values', $att_value)->where('attribute_name', $att_name)->first();
                                //     if($p_attz) {
                                //         $att_name = $p_attrs->attribute_name;
                                //         $att_value = $p_attrs->attribute_values;
                                //         $att_qty = $p_attrs->att_qty;
                                //         $price = $p_attrs->att_price;
                                //     }
                                // }
                            }

                            if ($att_name && $att_value) {
                                $p_attz = ProductsAttributes::Where('product_id', $product->id)->where('attribute_values', $att_value)->where('attribute_name', $att_name)->first();

                                if ($p_attz) {
                                    $price = $p_attz->att_cost;
                                    // $tax_amount = $p_attz->att_tax_amount;
                                    // $att_qty = $p_attz->att_qty;
                                    $att_qty = $qty;
                                }

                                if ($att_qty >= $qty) {
                                    $session = $request->session();
                                    $cartAllData = array();
                                    $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                    if ($cartData) {
                                        foreach ($cartData as $keyz => $valuez) {
                                            if (isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['att_name'] == $att_name && $cartData[$keyz]['att_value'] == $att_value && $cartData[$keyz]['is_offer'] == 'No') {
                                                Session::flash('message', 'Already Added to Cart!');
                                                Session::flash('alert-class', 'alert-danger');
                                                echo $error = 2;
                                                die();
                                            }
                                        }
                                    }

                                    $sc = 0;
                                    // $shc = 0;
                                    // if($product->tax_type == 2) {
                                    //     $shc = $product->shiping_charge;
                                    // } else {
                                    //     $shc = 0;
                                    // }

                                    if ($product->service_charge) {
                                        $sc = $product->service_charge;
                                    } else {
                                        $sc = 0;
                                    }

                                    if ($qty) {
                                        $qty = $qty;
                                    } else {
                                        $qty = 1;
                                    }

                                    $price = $price > 0 ? $price : $displayPrice;
                                    $t_price = round(($qty * $displayPrice), 2) + $tax_amount;

                                    // $product_cost = $price + $tax_amount;



                                    $cart_key = time() . uniqid();
                                    $cart_del = time();

                                    $cartData[$cart_key] = array(
                                        'product_id' => $product->id,
                                        'qty'   => $qty,
                                        'original_price' => $product->original_price,
                                        'product_cost' => $displayPrice,
                                        'discounted_price'  => $displayPrice,
                                        'price' => $price,
                                        'tax_amount' => $tax_amount,
                                        'total_price' => $t_price,
                                        'att_name' => $att_name,
                                        'att_value' => $att_value,
                                        'tax' => $product->tax,
                                        'tax_type' => $product->tax_type,
                                        'service_charge' => $sc,
                                        'shiping_charge' => $product->shiping_charge,
                                        'image' => $product->featured_product_img,
                                        'name'  => $product->product_title,
                                        'notes' => '',
                                        'is_offer' => 'No',
                                        'offer_id' => NULL,
                                        'offer_det_id' => NULL,
                                        'cart_key' => $cart_key,
                                        'cart_del' => $cart_del,
                                        'color_id' => $color_id ?? '',
                                        'color_name' => $color_name ?? '',
                                    );

                                    $users = session()->get('user');
                                    if ($users) {
                                        if ($users->user_type == 4) {
                                            $carts = new Carts();
                                            if ($carts) {
                                                $carts->product_id  = $product->id;
                                                $carts->user_id     = $users->id;
                                                $carts->name        = $product->product_title;
                                                $carts->original_price = $product->original_price;
                                                $carts->product_cost  = $displayPrice;
                                                $carts->discounted_price  = $displayPrice;
                                                $carts->price       = $price;
                                                $carts->tax_amount = $tax_amount;
                                                $carts->total_price = $t_price;
                                                $carts->image       = $product->featured_product_img;
                                                $carts->att_name  = $att_name;
                                                $carts->att_value  = $att_value;
                                                $carts->tax  = $product->tax;
                                                $carts->tax_type  = $product->tax_type;
                                                $carts->service_charge  = $sc;
                                                $carts->shiping_charge  = $product->shiping_charge;
                                                $carts->qty         = $qty;
                                                $carts->cart_key    = $cart_key;
                                                $carts->cart_del    = $cart_del;
                                                $carts->color_id = $color_id ?? '';
                                                $carts->color_name = $color_name ?? '';
                                                $carts->is_offer    = "No";
                                                $carts->offer_id    = NULL;
                                                $carts->offer_det_id    = NULL;
                                                $carts->is_block    = 1;

                                                if ($carts->save()) {
                                                    $error = "Added to Cart Successfully!";
                                                }
                                            }
                                        }
                                    }

                                    $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                    $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                    $request->session()->put('cart', $cartData);
                                    $request->session()->put('cart_total', $cartAllData);

                                    $error = "Added to Cart Successfully!";
                                    Session::flash('message', 'Added to Cart Successfully!');
                                    Session::flash('alert-class', 'alert-success');
                                } else {
                                    Session::flash('message', 'Sorry, we are out of stock for this product, we shall add more soon :)');
                                    Session::flash('alert-class', 'alert-danger');
                                    echo $error = 7;
                                    die();
                                }
                            } else {
                                $session = $request->session();
                                $cartAllData = array();
                                $cartData = ($session->get('cart')) ? $session->get('cart') : array();

                                if ($cartData) {
                                    foreach ($cartData as $keyz => $valuez) {
                                        // if(isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['is_offer'] == 'No') {
                                        if (isset($cartData[$keyz]) && $cartData[$keyz]['product_id'] == $id && $cartData[$keyz]['att_name'] == $att_name && $cartData[$keyz]['att_value'] == $att_value && $cartData[$keyz]['is_offer'] == 'No') {
                                            Session::flash('message', 'Already Added to Cart!');
                                            Session::flash('alert-class', 'alert-danger');
                                            echo $error = 2;
                                            die();
                                        }
                                    }
                                }

                                $sc = 0;
                                // $shc = 0;
                                // if($product->tax_type == 2) {
                                //     $shc = $product->shiping_charge;
                                // } else {
                                //     $shc = 0;
                                // }

                                if ($product->service_charge) {
                                    $sc = $product->service_charge;
                                } else {
                                    $sc = 0;
                                }

                                if ($qty) {
                                    $qty = $qty;
                                } else {
                                    $qty = 1;
                                }

                                $price = $price > 0 ? $price : $displayPrice;
                                $t_price = round(($qty * $displayPrice), 2) + $tax_amount;
                                $product_cost = $displayPrice;

                                $cart_key = time() . uniqid();
                                $cart_del = time();

                                $cartData[$cart_key] = array(
                                    'product_id' => $product->id,
                                    'qty'   => $qty,
                                    'original_price' => $product->original_price,
                                    'product_cost' => $product_cost,
                                    'discounted_price'  => $product_cost,
                                    'price' => $price,
                                    'tax_amount' => $tax_amount,
                                    'total_price' => $t_price,
                                    'att_name' => $att_name,
                                    'att_value' => $att_value,
                                    'tax' => $product->tax,
                                    'tax_type' => $product->tax_type,
                                    'service_charge' => $sc,
                                    'shiping_charge' => $product->shiping_charge,
                                    'image' => $product->featured_product_img,
                                    'name'  => $product->product_title,
                                    'notes' => '',
                                    'is_offer' => 'No',
                                    'offer_id' => NULL,
                                    'offer_det_id' => NULL,
                                    'cart_key' => $cart_key,
                                    'cart_del' => $cart_del,
                                    'color_id' => $color_id ?? '',
                                    'color_name' => $color_name ?? '',
                                );

                                $users = session()->get('user');
                                if ($users) {
                                    if ($users->user_type == 4) {
                                        $carts = new Carts();
                                        if ($carts) {
                                            $carts->product_id  = $product->id;
                                            $carts->user_id     = $users->id;
                                            $carts->name        = $product->product_title;
                                            $carts->original_price = $product->original_price;
                                            $carts->product_cost       = $product_cost;
                                            $carts->price       = $price;
                                            $carts->tax_amount = $tax_amount;
                                            $carts->total_price = $t_price;
                                            $carts->image       = $product->featured_product_img;
                                            $carts->att_name  = $att_name;
                                            $carts->att_value  = $att_value;
                                            $carts->tax  = $product->tax;
                                            $carts->tax_type  = $product->tax_type;
                                            $carts->service_charge  = $sc;
                                            $carts->shiping_charge  = $product->shiping_charge;
                                            $carts->qty         = $qty;
                                            $carts->discounted_price  = $product_cost;
                                            $carts->cart_key    = $cart_key;
                                            $carts->cart_del    = $cart_del;
                                            $carts->color_id = $color_id ?? '';
                                            $carts->color_name = $color_name ?? '';
                                            $carts->is_offer    = "No";
                                            $carts->offer_id    = NULL;
                                            $carts->offer_det_id    = NULL;
                                            $carts->is_block    = 1;

                                            if ($carts->save()) {
                                                $error = "Added to Cart Successfully!";
                                            }
                                        }

                                        $wishlistItem = Wishlist::where('product_id', $product->id)
                                            ->where('user_id', $users->id)
                                            ->first();

                                        if ($wishlistItem) {
                                            $wishlistItem->delete();
                                        }
                                    }
                                }


                                $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                $request->session()->put('cart', $cartData);
                                $request->session()->put('cart_total', $cartAllData);

                                $error = "Added to Cart Successfully!";
                                Session::flash('message', 'Added to Cart Successfully!');
                                Session::flash('alert-class', 'alert-success');
                            }
                        } else {
                            Session::flash('message', 'Out of Stock. Only ' . $onhand_qty . '  Products Avaliable!');
                            Session::flash('alert-class', 'alert-danger');
                            $error = 7;
                        }
                    } else {
                        Session::flash('message', 'Sorry, we are out of stock for this product, we shall add more soon :)');
                        Session::flash('alert-class', 'alert-danger');
                        $error = 7;
                    }
                } else {
                    Session::flash('message', 'Added to Cart Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    $error = 1;
                }
            } else {
                Session::flash('message', 'Added to Cart Failed!');
                Session::flash('alert-class', 'alert-danger');
                $error = 1;
            }
            echo $error;
        }
    }

    public function OfferAddToCart(Request $request)
    {
        $data = $request->all();
        $page = "Offers";
        $log = session()->get('user');

        $rules = array(
            'select_offer_id.*'       => 'required|exists:offers,id',
            'select_offer_det_id.*'   => 'required|exists:offers_subs,id',
            'select_offer_type.*'     => 'required',
        );

        $messages = [
            'select_offer_id.*.required' => 'Offer Field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            Session::flash('message', 'Added to Cart Failed!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('offer_products');
        } else {
            $o_id = $data['select_offer_id'][0];
            $error = 0;
            $err = 0;
            $vals = array_count_values($data['select_offer_type']);
            $offers = Offers::Where('id', $o_id)->first();
            $offer_cost = 0;
            $offer_tax_amount = 0;
            $price = 0;

            if ($offers) {
                if (sizeof($vals) != 0) {
                    if ($offers->offer_type == 1) {
                        if (isset($vals[1]) && isset($vals[2]) && $offers->x_pro_cnt == $vals[1] && $offers->y_pro_cnt == $vals[2]) {
                            if ((date('Y-m-d H:i:s', strtotime($offers->offer_start)) <= date('Y-m-d H:i:s'))) {
                                if ((date('Y-m-d H:i:s', strtotime($offers->offer_end)) >= date('Y-m-d H:i:s'))) {
                                    if ($data['select_offer_det_id'] && sizeof($data['select_offer_det_id']) != 0) {
                                        $qty = 1;
                                        foreach ($data['select_offer_det_id'] as $okey => $ovalue) {
                                            $cart_key = time() . uniqid();

                                            $cart_del = time();

                                            $off_subs = OffersSub::Where('id', $ovalue)->first();
                                            if ($off_subs) {
                                                $offer_cost = $off_subs->offer_cost;
                                                $offer_tax_amount = $off_subs->offer_tax_amount;
                                                $price = $off_subs->offer_price;
                                                $att_name = $off_subs->att_name;
                                                $att_value = $off_subs->att_value;

                                                $product = Products::where('id', $off_subs->product_id)->first();
                                                if ($product) {
                                                    $id = $product->id;
                                                    $onhand_qty = $off_subs->qty;
                                                    if ($onhand_qty && $onhand_qty != 0 && $onhand_qty > 0) {
                                                        if ($onhand_qty >= $qty) {
                                                            $session = $request->session();
                                                            $cartAllData = array();
                                                            $cartData = ($session->get('cart')) ? $session->get('cart') : array();

                                                            $sc = 0;
                                                            $shc = 0;

                                                            if ($off_subs->type == 1) {
                                                                if ($product->tax_type == 2) {
                                                                    $shc = $product->shiping_charge;
                                                                } else {
                                                                    $shc = 0;
                                                                }

                                                                if ($product->service_charge) {
                                                                    $sc = $product->service_charge;
                                                                } else {
                                                                    $sc = 0;
                                                                }

                                                                if (!isset($price) && $price == 0) {
                                                                    $offer_cost = $product->discounted_price;
                                                                    $offer_tax_amount = $product->tax_amount;
                                                                    $price = $product->product_cost;
                                                                }

                                                                if ($price) {
                                                                    $price = $price;
                                                                } else {
                                                                    $offer_cost = $product->discounted_price;
                                                                    $offer_tax_amount = $product->tax_amount;
                                                                    $price = $product->product_cost;
                                                                }
                                                            }

                                                            if ($qty) {
                                                                $qty = $qty;
                                                            } else {
                                                                $qty = 1;
                                                            }

                                                            $tax_amount = round($offer_tax_amount, 2);

                                                            $product_cost = $price + $offer_tax_amount;

                                                            $t_price = round(($qty * $product_cost), 2);

                                                            $cartData[$cart_key] = array(
                                                                'product_id' => $product->id,
                                                                'qty'   => $qty,
                                                                'original_price' => $product->original_price,
                                                                'product_cost' => $product_cost,
                                                                'price' => $price,
                                                                'tax_amount' => $tax_amount,
                                                                'total_price' => $t_price,
                                                                'att_name' => $att_name,
                                                                'att_value' => $att_value,
                                                                'tax' => $product->tax,
                                                                'tax_type' => $product->tax_type,
                                                                'service_charge' => $sc,
                                                                'shiping_charge' => $shc,
                                                                'image' => $product->featured_product_img,
                                                                'name'  => $product->product_title,
                                                                'notes' => '',
                                                                'is_offer' => 'Yes',
                                                                'offer_id' => $off_subs->offer,
                                                                'offer_det_id' => $off_subs->id,
                                                                'cart_key' => $cart_key,
                                                                'cart_del' => $cart_del,
                                                            );

                                                            $users = session()->get('user');
                                                            if ($users) {
                                                                if ($users->user_type == 4) {
                                                                    $carts = new Carts();
                                                                    if ($carts) {
                                                                        $carts->product_id  = $product->id;
                                                                        $carts->user_id     = $users->id;
                                                                        $carts->name        = $product->product_title;
                                                                        $carts->original_price = $product->original_price;
                                                                        $carts->product_cost       = $product_cost;
                                                                        $carts->price       = $price;
                                                                        $carts->tax_amount = $tax_amount;
                                                                        $carts->total_price = $t_price;
                                                                        $carts->image       = $product->featured_product_img;
                                                                        $carts->att_name  = $att_name;
                                                                        $carts->att_value  = $att_value;
                                                                        $carts->tax  = $product->tax;
                                                                        $carts->tax_type  = $product->tax_type;
                                                                        $carts->service_charge  = $sc;
                                                                        $carts->shiping_charge  = $shc;
                                                                        $carts->qty         = $qty;
                                                                        $carts->cart_key    = $cart_key;
                                                                        $carts->cart_del    = $cart_del;
                                                                        $carts->is_offer    = "Yes";
                                                                        $carts->offer_id = $off_subs->offer;
                                                                        $carts->offer_det_id = $off_subs->id;
                                                                        $carts->is_block    = 1;

                                                                        if ($carts->save()) {
                                                                            $err = 1;
                                                                        } else {
                                                                            $error = 1;
                                                                        }
                                                                    } else {
                                                                        $err = 1;
                                                                    }
                                                                } else {
                                                                    $err = 1;
                                                                }
                                                            } else {
                                                                $err = 1;
                                                            }

                                                            $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                            $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                            $request->session()->put('cart', $cartData);
                                                            $request->session()->put('cart_total', $cartAllData);
                                                        } else {
                                                            Session::flash('message', 'Out of Stock. Only ' . $onhand_qty . '  Products Avaliable!');
                                                            Session::flash('alert-class', 'alert-danger');
                                                            $error = 7;
                                                            $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                            if (array_key_exists($cart_key, $cartData)) {
                                                                foreach ($cartData as $index => $data) {
                                                                    if ($data['cart_del'] == $cart_del) {
                                                                        unset($cartData[$index]);
                                                                    }
                                                                }
                                                            }
                                                            $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                            $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                            $request->session()->put('cart', $cartData);
                                                            $request->session()->put('cart_total', $cartAllData);
                                                            Carts::Where('offer_id', $o_id)->delete();
                                                            return redirect()->route('offer_products');
                                                        }
                                                    } else {
                                                        Session::flash('message', 'Out of Stock. Products Not Avaliable!');
                                                        Session::flash('alert-class', 'alert-danger');
                                                        $error = 7;
                                                        $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                        if (array_key_exists($cart_key, $cartData)) {
                                                            foreach ($cartData as $index => $data) {
                                                                if ($data['cart_del'] == $cart_del) {
                                                                    unset($cartData[$index]);
                                                                }
                                                            }
                                                        }
                                                        $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                        $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                        $request->session()->put('cart', $cartData);
                                                        $request->session()->put('cart_total', $cartAllData);
                                                        Carts::Where('offer_id', $o_id)->delete();
                                                        return redirect()->route('offer_products');
                                                    }
                                                } else {
                                                    Session::flash('message', 'Added to Cart Failed, Product Not Matched!');
                                                    Session::flash('alert-class', 'alert-danger');
                                                    $error = 1;
                                                    $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                    if (array_key_exists($cart_key, $cartData)) {
                                                        foreach ($cartData as $index => $data) {
                                                            if ($data['cart_del'] == $cart_del) {
                                                                unset($cartData[$index]);
                                                            }
                                                        }
                                                    }
                                                    $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                    $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                    $request->session()->put('cart', $cartData);
                                                    $request->session()->put('cart_total', $cartAllData);
                                                    Carts::Where('offer_id', $o_id)->delete();
                                                    return redirect()->route('offer_products');
                                                }
                                            } else {
                                                Session::flash('message', 'Added to Cart Failed, Invalid Offer Products!');
                                                Session::flash('alert-class', 'alert-danger');
                                                $error = 1;
                                                $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                if (array_key_exists($cart_key, $cartData)) {
                                                    foreach ($cartData as $index => $data) {
                                                        if ($data['cart_del'] == $cart_del) {
                                                            unset($cartData[$index]);
                                                        }
                                                    }
                                                }
                                                $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                $request->session()->put('cart', $cartData);
                                                $request->session()->put('cart_total', $cartAllData);
                                                Carts::Where('offer_id', $o_id)->delete();
                                                return redirect()->route('offer_products');
                                            }
                                        }

                                        if ($error == 0 && $err == 1) {
                                            Session::flash('message', 'Added to Cart Successfully!');
                                            Session::flash('alert-class', 'alert-success');
                                            return redirect()->route('offer_products');
                                        } else {
                                            Session::flash('message', 'Added to Cart Failed!');
                                            $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                            if (array_key_exists($cart_key, $cartData)) {
                                                foreach ($cartData as $index => $data) {
                                                    if ($data['cart_del'] == $cart_del) {
                                                        unset($cartData[$index]);
                                                    }
                                                }
                                            }
                                            $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                            $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                            $request->session()->put('cart', $cartData);
                                            $request->session()->put('cart_total', $cartAllData);
                                            Session::flash('alert-class', 'alert-danger');
                                            Carts::Where('offer_id', $o_id)->delete();
                                            return redirect()->route('offer_products');
                                        }
                                    } else {
                                        Session::flash('message', 'Added to Cart Failed, Offer Items Not Available!');
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('offer_products');
                                    }
                                } else {
                                    Session::flash('message', 'Offer End, Please Try Another Offers!');
                                    Session::flash('alert-class', 'alert-danger');
                                    return Redirect::to('/offer_products/' . $o_id);
                                }
                            } else {
                                Session::flash('message', 'Offer Not Started, Please Try Another Offers!');
                                Session::flash('alert-class', 'alert-danger');
                                return Redirect::to('/offer_products/' . $o_id);
                            }
                        } else {
                            Session::flash('message', 'Its Buy ' . $offers->x_pro_cnt . ' Get ' . $offers->y_pro_cnt . ' Offer. So You have Select Only ' . $offers->x_pro_cnt . ' Main Products and ' . $offers->y_pro_cnt . ' Offer Products!');
                            Session::flash('alert-class', 'alert-danger');
                            return Redirect::to('/offer_products/' . $o_id);
                        }
                    } else if ($offers->offer_type == 2) {
                        if (isset($vals[1]) && $offers->x_pro_cnt == $vals[1]) {
                            if ((date('Y-m-d H:i:s', strtotime($offers->offer_start)) <= date('Y-m-d H:i:s'))) {
                                if ((date('Y-m-d H:i:s', strtotime($offers->offer_end)) >= date('Y-m-d H:i:s'))) {
                                    if ($data['select_offer_det_id'] && sizeof($data['select_offer_det_id']) != 0) {
                                        $qty = 1;
                                        foreach ($data['select_offer_det_id'] as $okey => $ovalue) {
                                            $cart_key = time() . uniqid();

                                            $cart_del = time();

                                            $off_subs = OffersSub::Where('id', $ovalue)->first();
                                            if ($off_subs) {
                                                $offer_cost = $off_subs->offer_cost;
                                                $offer_tax_amount = $off_subs->offer_tax_amount;
                                                $price = $off_subs->offer_price;
                                                $att_name = $off_subs->att_name;
                                                $att_value = $off_subs->att_value;

                                                $product = Products::where('id', $off_subs->product_id)->first();
                                                if ($product) {
                                                    $id = $product->id;
                                                    $onhand_qty = $off_subs->qty;
                                                    if ($onhand_qty && $onhand_qty != 0 && $onhand_qty > 0) {
                                                        if ($onhand_qty >= $qty) {
                                                            $session = $request->session();
                                                            $cartAllData = array();
                                                            $cartData = ($session->get('cart')) ? $session->get('cart') : array();

                                                            $sc = 0;
                                                            $shc = 0;

                                                            if ($off_subs->type == 1) {
                                                                if ($product->tax_type == 2) {
                                                                    $shc = $product->shiping_charge;
                                                                } else {
                                                                    $shc = 0;
                                                                }

                                                                if ($product->service_charge) {
                                                                    $sc = $product->service_charge;
                                                                } else {
                                                                    $sc = 0;
                                                                }

                                                                if (!isset($price) && $price == 0) {
                                                                    $offer_cost = $product->discounted_price;
                                                                    $offer_tax_amount = $product->tax_amount;
                                                                    $price = $product->product_cost;
                                                                }

                                                                if ($price) {
                                                                    $price = $price;
                                                                } else {
                                                                    $offer_cost = $product->discounted_price;
                                                                    $offer_tax_amount = $product->tax_amount;
                                                                    $price = $product->product_cost;
                                                                }
                                                            }

                                                            if ($qty) {
                                                                $qty = $qty;
                                                            } else {
                                                                $qty = 1;
                                                            }

                                                            $tax_amount = round($offer_tax_amount, 2);

                                                            $product_cost = $price + $offer_tax_amount;

                                                            $t_price = round(($qty * $product_cost), 2);

                                                            $cartData[$cart_key] = array(
                                                                'product_id' => $product->id,
                                                                'qty'   => $qty,
                                                                'original_price' => $product->original_price,
                                                                'product_cost' => $product_cost,
                                                                'price' => $price,
                                                                'tax_amount' => $tax_amount,
                                                                'total_price' => $t_price,
                                                                'att_name' => $att_name,
                                                                'att_value' => $att_value,
                                                                'tax' => $product->tax,
                                                                'tax_type' => $product->tax_type,
                                                                'service_charge' => $sc,
                                                                'shiping_charge' => $shc,
                                                                'image' => $product->featured_product_img,
                                                                'name'  => $product->product_title,
                                                                'notes' => '',
                                                                'is_offer' => 'Yes',
                                                                'offer_id' => $off_subs->offer,
                                                                'offer_det_id' => $off_subs->id,
                                                                'cart_key' => $cart_key,
                                                                'cart_del' => $cart_del,
                                                            );

                                                            $users = session()->get('user');
                                                            if ($users) {
                                                                if ($users->user_type == 4) {
                                                                    $carts = new Carts();
                                                                    if ($carts) {
                                                                        $carts->product_id  = $product->id;
                                                                        $carts->user_id     = $users->id;
                                                                        $carts->name        = $product->product_title;
                                                                        $carts->original_price = $product->original_price;
                                                                        $carts->product_cost       = $product_cost;
                                                                        $carts->price       = $price;
                                                                        $carts->tax_amount = $tax_amount;
                                                                        $carts->total_price = $t_price;
                                                                        $carts->image       = $product->featured_product_img;
                                                                        $carts->att_name  = $att_name;
                                                                        $carts->att_value  = $att_value;
                                                                        $carts->tax  = $product->tax;
                                                                        $carts->tax_type  = $product->tax_type;
                                                                        $carts->service_charge  = $sc;
                                                                        $carts->shiping_charge  = $shc;
                                                                        $carts->qty         = $qty;
                                                                        $carts->cart_key    = $cart_key;
                                                                        $carts->cart_del    = $cart_del;
                                                                        $carts->is_offer    = "Yes";
                                                                        $carts->offer_id = $off_subs->offer;
                                                                        $carts->offer_det_id = $off_subs->id;
                                                                        $carts->is_block    = 1;

                                                                        if ($carts->save()) {
                                                                            $err = 1;
                                                                        } else {
                                                                            $error = 1;
                                                                        }
                                                                    } else {
                                                                        $err = 1;
                                                                    }
                                                                } else {
                                                                    $err = 1;
                                                                }
                                                            } else {
                                                                $err = 1;
                                                            }

                                                            $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                            $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                            $request->session()->put('cart', $cartData);
                                                            $request->session()->put('cart_total', $cartAllData);
                                                        } else {
                                                            Session::flash('message', 'Out of Stock. Only ' . $onhand_qty . '  Products Avaliable!');
                                                            Session::flash('alert-class', 'alert-danger');
                                                            $error = 7;
                                                            $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                            if (array_key_exists($cart_key, $cartData)) {
                                                                foreach ($cartData as $index => $data) {
                                                                    if ($data['cart_del'] == $cart_del) {
                                                                        unset($cartData[$index]);
                                                                    }
                                                                }
                                                            }
                                                            $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                            $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                            $request->session()->put('cart', $cartData);
                                                            $request->session()->put('cart_total', $cartAllData);
                                                            Carts::Where('offer_id', $o_id)->delete();
                                                            return redirect()->route('offer_products');
                                                        }
                                                    } else {
                                                        Session::flash('message', 'Out of Stock. Products Not Avaliable!');
                                                        Session::flash('alert-class', 'alert-danger');
                                                        $error = 7;
                                                        $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                        if (array_key_exists($cart_key, $cartData)) {
                                                            foreach ($cartData as $index => $data) {
                                                                if ($data['cart_del'] == $cart_del) {
                                                                    unset($cartData[$index]);
                                                                }
                                                            }
                                                        }
                                                        $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                        $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                        $request->session()->put('cart', $cartData);
                                                        $request->session()->put('cart_total', $cartAllData);
                                                        Carts::Where('offer_id', $o_id)->delete();
                                                        return redirect()->route('offer_products');
                                                    }
                                                } else {
                                                    Session::flash('message', 'Added to Cart Failed, Product Not Matched!');
                                                    Session::flash('alert-class', 'alert-danger');
                                                    $error = 1;
                                                    $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                    if (array_key_exists($cart_key, $cartData)) {
                                                        foreach ($cartData as $index => $data) {
                                                            if ($data['cart_del'] == $cart_del) {
                                                                unset($cartData[$index]);
                                                            }
                                                        }
                                                    }
                                                    $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                    $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                    $request->session()->put('cart', $cartData);
                                                    $request->session()->put('cart_total', $cartAllData);
                                                    Carts::Where('offer_id', $o_id)->delete();
                                                    return redirect()->route('offer_products');
                                                }
                                            } else {
                                                Session::flash('message', 'Added to Cart Failed, Invalid Offer Products!');
                                                Session::flash('alert-class', 'alert-danger');
                                                $error = 1;
                                                $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                                if (array_key_exists($cart_key, $cartData)) {
                                                    foreach ($cartData as $index => $data) {
                                                        if ($data['cart_del'] == $cart_del) {
                                                            unset($cartData[$index]);
                                                        }
                                                    }
                                                }
                                                $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                                $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                                $request->session()->put('cart', $cartData);
                                                $request->session()->put('cart_total', $cartAllData);
                                                Carts::Where('offer_id', $o_id)->delete();
                                                return redirect()->route('offer_products');
                                            }
                                        }

                                        if ($error == 0 && $err == 1) {
                                            Session::flash('message', 'Added to Cart Successfully!');
                                            Session::flash('alert-class', 'alert-success');
                                            return redirect()->route('offer_products');
                                        } else {
                                            Session::flash('message', 'Added to Cart Failed!');
                                            $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                                            if (array_key_exists($cart_key, $cartData)) {
                                                foreach ($cartData as $index => $data) {
                                                    if ($data['cart_del'] == $cart_del) {
                                                        unset($cartData[$index]);
                                                    }
                                                }
                                            }
                                            $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                                            $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                                            $request->session()->put('cart', $cartData);
                                            $request->session()->put('cart_total', $cartAllData);
                                            Session::flash('alert-class', 'alert-danger');
                                            Carts::Where('offer_id', $o_id)->delete();
                                            return redirect()->route('offer_products');
                                        }
                                    } else {
                                        Session::flash('message', 'Added to Cart Failed, Offer Items Not Available!');
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('offer_products');
                                    }
                                } else {
                                    Session::flash('message', 'Offer End, Please Try Another Offers!');
                                    Session::flash('alert-class', 'alert-danger');
                                    return Redirect::to('/offer_products/' . $o_id);
                                }
                            } else {
                                Session::flash('message', 'Offer Not Started, Please Try Another Offers!');
                                Session::flash('alert-class', 'alert-danger');
                                return Redirect::to('/offer_products/' . $o_id);
                            }
                        } else {
                            Session::flash('message', 'Its Buy ' . $offers->x_pro_cnt . ' Get ' . $offers->discount . '% Discount. So You have Select Only ' . $offers->x_pro_cnt . ' Main Products!');
                            Session::flash('alert-class', 'alert-danger');
                            return Redirect::to('/offer_products/' . $o_id);
                        }
                    } else {
                        Session::flash('message', 'Please Try Again Later!');
                        Session::flash('alert-class', 'alert-danger');
                        return Redirect::to('/offer_products/' . $o_id);
                    }
                } else {
                    Session::flash('message', 'Added to Cart Failed, Main Products and Offer Products Not Available!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('offer_products');
                }
            } else {
                Session::flash('message', 'Added to Cart Failed, Please Try Another Time!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('offer_products');
            }
        }
    }

    public function DeleteCart(Request $request)
    {
        $id = 0;
        if ($request->ajax() && isset($request->id) && isset($request->cart_id) && isset($request->cart_key) && isset($request->cart_del)) {
            $id = $request->id;
            $cart_id = $request->cart_id;
            $cart_key = $request->cart_key;
            $cart_del = $request->cart_del;
            $error = 1;
            if ($id) {
                $product = Products::where('id', $id)->first();
                if ($product) {
                    $del_carts = "";
                    $users = session()->get('user');
                    if ($users) {
                        if ($users->user_type == 4) {
                            $del_carts = Carts::Where('id', $cart_id)->Where('user_id', $users->id)->Where('product_id', $id)->first();
                        }
                    }

                    $session = $request->session();
                    $cartAllData = array();
                    $cartData = ($session->get('cart')) ? $session->get('cart') : array();
                    if (array_key_exists($cart_key, $cartData)) {
                        foreach ($cartData as $index => $data) {
                            if ($data['cart_del'] == $cart_del) {
                                unset($cartData[$index]);
                            }
                        }

                        $users = session()->get('user');
                        if ($users) {
                            if ($users->user_type == 4) {
                                $carts = Carts::Where('id', $cart_id)->Where('user_id', $users->id)->Where('product_id', $id)->first();
                                if ($carts) {
                                    if ($carts->is_offer == 'Yes') {
                                        if (Carts::Where('cart_del', $carts->cart_del)->delete()) {
                                            $error = 'Item Removed From Cart Successfully!';
                                        }
                                    } else {
                                        if ($carts->delete()) {
                                            $error = 'Item Removed From Cart Successfully';
                                        }
                                    }
                                }
                            }
                        }

                        $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                        $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                        $request->session()->put('cart', $cartData);
                        $request->session()->put('cart_total', $cartAllData);
                        Session::flash('message', 'Item Removed From Cart Successfully!');
                        Session::flash('alert-class', 'alert-success');
                        $error = 0;
                    } else if ($del_carts) {
                        $users = session()->get('user');
                        if ($users) {
                            if ($users->user_type == 4) {
                                $carts = Carts::Where('id', $cart_id)->Where('user_id', $users->id)->Where('product_id', $id)->first();
                                if ($carts) {
                                    if ($carts->is_offer == 'Yes') {
                                        if (Carts::Where('cart_del', $carts->cart_del)->delete()) {
                                            $error = 'Item Removed From Cart Successfully';
                                        }
                                    } else {
                                        if ($carts->delete()) {
                                            $error = 'Item Removed From Cart Successfully';
                                        }
                                    }
                                }
                            }
                        }

                        Session::flash('message', 'Item Removed From Cart Successfully!');
                        Session::flash('alert-class', 'alert-success');
                    } else {
                        Session::flash('message', 'Item Removed From Cart Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        $error = 1;
                    }

                    session()->forget('coupon');
                } else {
                    Session::flash('message', 'Item Removed From Cart Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    $error = 1;
                }
            } else {
                Session::flash('message', 'Item Removed From Cart Failed!');
                Session::flash('alert-class', 'alert-danger');
                $error = 1;
            }
        } else {
            Session::flash('message', 'Item Removed From Cart Failed!');
            Session::flash('alert-class', 'alert-danger');
            $error = 1;
        }
        echo $error;
    }


    public function CheckOnHandQty(Request $request)
    {
        $error = 1;
        $id = 0;
        $qty = 1;
        $price = 0;
        $att_name = 0;
        $att_value = 0;
        $att_qty = 0;
        $is_offer = "No";
        $offer_det_id = 0;

        if ($request->ajax() && isset($request->id) && isset($request->qty) && isset($request->price)) {
            $id = $request->id;
            $qty = $request->qty;
            $price = $request->price;

            if (isset($request->att_name) && $request->att_name) {
                $att_name = $request->att_name;
            }

            if (isset($request->att_value) && $request->att_value) {
                $att_value = $request->att_value;
            }

            if (isset($request->is_offer) && $request->is_offer) {
                $is_offer = $request->is_offer;
            }

            if (isset($request->offer_det_id) && $request->offer_det_id) {
                $offer_det_id = $request->offer_det_id;
            }

            if ($id) {
                $product = Products::where('id', $id)->first();

                if ($product) {
                    if ($is_offer == "Yes") {
                        $off_sub = OffersSub::Where('id', $offer_det_id)->first();
                        if ($off_sub) {
                            if ($off_sub->qty != 0) {
                                if ($off_sub->qty >= $qty) {
                                    $error = $qty * $price;
                                } else {
                                    $error = array('onhand_qty' => $off_sub->qty, 'error' => '2');
                                    echo $error = json_encode($error);
                                    die();
                                }
                            } else {
                                $error = array('onhand_qty' => $onhand_qty, 'error' => '3');
                                echo $error = json_encode($error);
                                die();
                            }
                        } else {
                            $error = 1;
                        }
                    }

                    $onhand_qty = $product->onhand_qty;
                    if ($onhand_qty != 0) {
                        if ($onhand_qty >= $qty) {
                            if ($att_name && $att_value) {
                                $p_atts = ProductsAttributes::Where('product_id', $id)->Where('attribute_name', $att_name)->Where('attribute_values', $att_value)->first();
                                if ($p_atts) {
                                    $att_qty = $p_atts->att_qty;
                                }

                                if ($att_qty >= $qty) {
                                    if ($qty != 0 && $price != 0) {
                                        $error = $qty * $price;
                                    }
                                } else {
                                    $error = array('onhand_qty' => $att_qty, 'error' => '2');
                                    $error = json_encode($error);
                                }
                            } else {
                                if ($qty != 0 && $price != 0) {
                                    $error = $qty * $price;
                                }
                            }
                        } else {
                            // $error = 2;
                            $error = array('onhand_qty' => $onhand_qty, 'error' => '2');
                            $error = json_encode($error);
                        }
                    } else {
                        $error = array('onhand_qty' => $onhand_qty, 'error' => '3');
                        $error = json_encode($error);
                    }
                } else {
                    $error = 1;
                }
            } else {
                $error = 1;
            }
        } else {
            $error = 1;
        }

        echo $error;
    }

    public function CartQtyUpdate(Request $request)
    {
        $error = 1;
        $id = 0;
        $qty = 1;
        $tot_price = 0.00;
        $cart_key = 0;
        $cart_id = 0;
        $users = session()->get('user');
        $ses_carts = session()->get('cart');


        if ($request->ajax() && isset($request->id) && isset($request->qty) && isset($request->tot_price)) {
            $id = $request->id;
            $qty = $request->qty;
            $tot_price = $request->tot_price;

            if (isset($request->cart_key) && $request->cart_key) {
                $cart_key = $request->cart_key;
            }

            if (isset($request->cart_id) && $request->cart_id) {
                $cart_id = $request->cart_id;
            }

            if ($id) {
                $product = Products::where('id', $id)->first();

                if ($product) {
                    if ($users) {
                        if ($users->user_type == 4) {
                            if ($cart_id) {
                                $carts = Carts::Where('id', $cart_id)->Where('product_id', $id)->first();
                                if ($carts) {
                                    $carts->qty  = $qty;
                                    $carts->total_price  = $tot_price;
                                    $carts->save();
                                }

                                $error = 11;
                            }
                        }
                    }

                    if ($cart_key) {
                        $ses_carts[$cart_key]['qty'] = $qty;
                        $ses_carts[$cart_key]['total_price'] = $tot_price;
                        $request->session()->forget('cart');
                        $request->session()->put('cart', $ses_carts);
                        $error = 11;
                    }
                } else {
                    $error = 1;
                }
            } else {
                $error = 1;
            }
        } else {
            $error = 1;
        }

        echo $error;
    }

    public function CartSave(Request $request)
    {
        $data = $request->all();
        $users = session()->get('user');
        $ses_carts = session()->get('cart');
        $cartData = array();

        if ($users) {
            if ($users->user_type == 4) {
                if (count($data['cart_key']) != 0) {

                    foreach ($data['cart_key'] as $key => $value) {

                        $product = Products::find($data['product_id'][$key]);
                        if ($product) {
                            $available_stock = $product->onhand_qty;
                            $requested_qty = $data['qty'][$key];

                            if ($requested_qty > $available_stock) {
                                // If requested qty exceeds available stock, flash error and redirect
                                Session::flash('message', 'Only ' . $available_stock . ' piece(s) available in stock for "' . $product->product_title . '"!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('cart');
                            }
                        }
                    }

                    $request->session()->forget('cart');
                    Carts::Where('user_id', $users->id)->delete();

                    foreach ($data['cart_key'] as $key => $value) {
                        if (isset($data['is_offer'][$key]) && $data['is_offer'][$key] == 'Yes') {
                            $data['qty'][$key] = 1;
                        }

                        $cartData[$value] = array(
                            'product_id' => (isset($data['product_id'][$key])) ? $data['product_id'][$key] : NULL,
                            'qty'        => (isset($data['qty'][$key])) ? $data['qty'][$key] : 1,
                            'original_price'      => (isset($data['original_price'][$key])) ? $data['original_price'][$key] : 0,
                            'product_cost'      => (isset($data['product_cost'][$key])) ? $data['product_cost'][$key] : 0,
                            'discounted_price'      => (isset($data['discounted_price'][$key])) ? $data['discounted_price'][$key] : 0,
                            'price'      => (isset($data['price'][$key])) ? $data['price'][$key] : 0,
                            'tax_amount'      => (isset($data['tax_amount'][$key])) ? $data['tax_amount'][$key] : 0,
                            'total_price'      => (isset($data['total_price'][$key])) ? $data['total_price'][$key] : 0,
                            'att_name'      => (isset($data['att_name'][$key])) ? $data['att_name'][$key] : NULL,
                            'att_value'      => (isset($data['att_value'][$key])) ? $data['att_value'][$key] : NULL,
                            'image'      => (isset($data['image'][$key])) ? $data['image'][$key] : NULL,
                            'tax' => (isset($data['tax'][$key])) ? $data['tax'][$key] : NULL,
                            'tax_type' => (isset($data['tax_type'][$key])) ? $data['tax_type'][$key] : NULL,
                            'service_charge' => (isset($data['service_charge'][$key])) ? $data['service_charge'][$key] : 0,
                            'shiping_charge' => (isset($data['shiping_charge'][$key])) ? $data['shiping_charge'][$key] : 0,
                            'name'       => (isset($data['name'][$key])) ? $data['name'][$key] : NULL,
                            'notes'      => (isset($data['notes'])) ? $data['notes'] : NULL,
                            'is_offer'      => (isset($data['is_offer'][$key])) ? $data['is_offer'][$key] : 'No',
                            'offer_id'      => (isset($data['offer_id'][$key])) ? $data['offer_id'][$key] : NULL,
                            'offer_det_id'      => (isset($data['offer_det_id'][$key])) ? $data['offer_det_id'][$key] : NULL,
                            'cart_key'      =>  $value,
                            'cart_del'      => (isset($data['cart_del'][$key])) ? $data['cart_del'][$key] : NULL,
                        );


                        $carts = new Carts();
                        if ($carts) {
                            $carts->product_id  = (isset($data['product_id'][$key])) ? $data['product_id'][$key] : NULL;
                            $carts->user_id     = $users->id;
                            $carts->name        = (isset($data['name'][$key])) ? $data['name'][$key] : NULL;
                            $carts->original_price       = (isset($data['original_price'][$key])) ? $data['original_price'][$key] : 0;
                            $carts->product_cost       = (isset($data['product_cost'][$key])) ? $data['product_cost'][$key] : 0;
                            $carts->discounted_price      = (isset($data['discounted_price'][$key])) ? $data['discounted_price'][$key] : 0;
                            $carts->price       = (isset($data['price'][$key])) ? $data['price'][$key] : 0;
                            $carts->tax_amount       = (isset($data['tax_amount'][$key])) ? $data['tax_amount'][$key] : 0;
                            $carts->total_price       = (isset($data['total_price'][$key])) ? $data['total_price'][$key] : 0;
                            $carts->att_name     = (isset($data['att_name'][$key])) ? $data['att_name'][$key] : NULL;
                            $carts->att_value     = (isset($data['att_value'][$key])) ? $data['att_value'][$key] : NULL;
                            $carts->tax  = (isset($data['tax'][$key])) ? $data['tax'][$key] : NULL;
                            $carts->tax_type  = (isset($data['tax_type'][$key])) ? $data['tax_type'][$key] : NULL;
                            $carts->service_charge  = (isset($data['service_charge'][$key])) ? $data['service_charge'][$key] : 0;
                            $carts->shiping_charge  = (isset($data['shiping_charge'][$key])) ? $data['shiping_charge'][$key] : 0;
                            $carts->image       = (isset($data['image'][$key])) ? $data['image'][$key] : NULL;
                            $carts->qty         = (isset($data['qty'][$key])) ? $data['qty'][$key] : 1;
                            $carts->notes       = (isset($data['notes'])) ? $data['notes'] : NULL;
                            $carts->is_offer       = (isset($data['is_offer'][$key])) ? $data['is_offer'][$key] : 'No';
                            $carts->offer_id       = (isset($data['offer_id'][$key])) ? $data['offer_id'][$key] : NULL;
                            $carts->offer_det_id       = (isset($data['offer_det_id'][$key])) ? $data['offer_det_id'][$key] : NULL;
                            $carts->cart_key       = $value;
                            $carts->cart_del       = (isset($data['cart_del'][$key])) ? $data['cart_del'][$key] : NULL;
                            $carts->is_block    = 1;

                            $carts->save();
                        }
                    }

                    // $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                    $cartAllData['tot_qty'] = count($cartData);
                    $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                    $request->session()->put('cart', $cartData);
                    $request->session()->put('cart_total', $cartAllData);

                    Session::flash('message', 'Cart Updated Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('cart');
                } else {
                    Session::flash('message', 'Cart Updated Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('cart');
                }
            } else if (isset($ses_carts)) {
                if (count($data['cart_key']) != 0) {

                    foreach ($data['cart_key'] as $key => $value) {
                        $product = Products::find($data['product_id'][$key]);
                        if ($product) {
                            $available_stock = $product->onhand_qty;
                            $requested_qty = $data['qty'][$key];

                            if ($requested_qty > $available_stock) {
                                // If requested qty exceeds available stock, flash error and redirect
                                Session::flash('message', 'Only ' . $available_stock . ' piece(s) available in stock for "' . $product->product_title . '"!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('cart');
                            }
                        }
                    }

                    $request->session()->forget('cart');
                    foreach ($data['cart_key'] as $key => $value) {

                        $cartData[$value] = array(
                            'product_id' => (isset($data['product_id'][$key])) ? $data['product_id'][$key] : NULL,
                            'qty'        => (isset($data['qty'][$key])) ? $data['qty'][$key] : 1,
                            'original_price'      => (isset($data['original_price'][$key])) ? $data['original_price'][$key] : 0,
                            'product_cost'      => (isset($data['product_cost'][$key])) ? $data['product_cost'][$key] : 0,
                            'discounted_price'      => (isset($data['discounted_price'][$key])) ? $data['discounted_price'][$key] : 0,
                            'price'      => (isset($data['price'][$key])) ? $data['price'][$key] : 0,
                            'tax_amount'      => (isset($data['tax_amount'][$key])) ? $data['tax_amount'][$key] : 0,
                            'total_price'      => (isset($data['total_price'][$key])) ? $data['total_price'][$key] : 0,
                            'att_name'      => (isset($data['att_name'][$key])) ? $data['att_name'][$key] : NULL,
                            'att_value'      => (isset($data['att_value'][$key])) ? $data['att_value'][$key] : NULL,
                            'tax' => (isset($data['tax'][$key])) ? $data['tax'][$key] : NULL,
                            'tax_type' => (isset($data['tax_type'][$key])) ? $data['tax_type'][$key] : NULL,
                            'service_charge' => (isset($data['service_charge'][$key])) ? $data['service_charge'][$key] : 0,
                            'shiping_charge' => (isset($data['shiping_charge'][$key])) ? $data['shiping_charge'][$key] : 0,
                            'image'      => (isset($data['image'][$key])) ? $data['image'][$key] : NULL,
                            'name'       => (isset($data['name'][$key])) ? $data['name'][$key] : NULL,
                            'notes'      => (isset($data['notes'])) ? $data['notes'] : NULL,
                            'is_offer'      => (isset($data['is_offer'][$key])) ? $data['is_offer'][$key] : 'No',
                            'offer_id'      => (isset($data['offer_id'][$key])) ? $data['offer_id'][$key] : NULL,
                            'offer_det_id'      => (isset($data['offer_det_id'][$key])) ? $data['offer_det_id'][$key] : NULL,
                            'cart_key'      =>  $value,
                            'cart_del'      => (isset($data['cart_del'][$key])) ? $data['cart_del'][$key] : NULL,
                        );
                    }
                    // $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                    $cartAllData['tot_qty'] = count($cartData);
                    $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                    $request->session()->put('cart', $cartData);
                    $request->session()->put('cart_total', $cartAllData);

                    Session::flash('message', 'Updated to Cart Successfully!');
                    Session::flash('alert-class', 'alert-success');
                    return redirect()->route('cart');
                } else {
                    Session::flash('message', 'Updated to Cart Failed!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('cart');
                }
            } else {
                Session::flash('message', 'Updated to Cart Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('cart');
            }
        } else if (isset($ses_carts)) {
            if (count($data['cart_key']) != 0) {

                foreach ($data['cart_key'] as $key => $value) {
                    $product = Products::find($data['product_id'][$key]);
                    if ($product) {
                        $available_stock = $product->onhand_qty;
                        $requested_qty = $data['qty'][$key];

                        if ($requested_qty > $available_stock) {
                            // If requested qty exceeds available stock, flash error and redirect
                            Session::flash('message', 'Only ' . $available_stock . ' piece(s) available in stock for "' . $product->product_title . '"!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('cart');
                        }
                    }
                }

                $request->session()->forget('cart');
                foreach ($data['cart_key'] as $key => $value) {

                    $cartData[$value] = array(
                        'product_id' => (isset($data['product_id'][$key])) ? $data['product_id'][$key] : NULL,
                        'qty'        => (isset($data['qty'][$key])) ? $data['qty'][$key] : 1,
                        'original_price'      => (isset($data['original_price'][$key])) ? $data['original_price'][$key] : 0,
                        'product_cost'      => (isset($data['product_cost'][$key])) ? $data['product_cost'][$key] : 0,
                        'discounted_price'      => (isset($data['discounted_price'][$key])) ? $data['discounted_price'][$key] : 0,
                        'price'      => (isset($data['price'][$key])) ? $data['price'][$key] : 0,
                        'tax_amount'      => (isset($data['tax_amount'][$key])) ? $data['tax_amount'][$key] : 0,
                        'total_price'      => (isset($data['total_price'][$key])) ? $data['total_price'][$key] : 0,
                        'att_name'      => (isset($data['att_name'][$key])) ? $data['att_name'][$key] : NULL,
                        'att_value'      => (isset($data['att_value'][$key])) ? $data['att_value'][$key] : NULL,
                        'tax'  => (isset($data['tax'][$key])) ? $data['tax'][$key] : NULL,
                        'tax_type'  => (isset($data['tax_type'][$key])) ? $data['tax_type'][$key] : NULL,
                        'service_charge'  => (isset($data['service_charge'][$key])) ? $data['service_charge'][$key] : 0,
                        'shiping_charge'  => (isset($data['shiping_charge'][$key])) ? $data['shiping_charge'][$key] : 0,
                        'image'      => (isset($data['image'][$key])) ? $data['image'][$key] : NULL,
                        'name'       => (isset($data['name'][$key])) ? $data['name'][$key] : NULL,
                        'notes'      => (isset($data['notes'])) ? $data['notes'] : NULL,
                        'cart_key'      =>  $value,
                        'cart_del'      => (isset($data['cart_del'][$key])) ? $data['cart_del'][$key] : NULL,
                    );
                }

                // $cartAllData['tot_qty'] = array_sum(array_column($cartData, 'qty'));
                $cartAllData['tot_qty'] = count($cartData);
                $cartAllData['tot_pce'] = array_sum(array_column($cartData, 'price'));

                $request->session()->put('cart', $cartData);
                $request->session()->put('cart_total', $cartAllData);

                Session::flash('message', 'Updated to Cart Successfully!');
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('cart');
            } else {
                Session::flash('message', 'Updated to Cart Failed!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('cart');
            }
        } else {
            Session::flash('message', 'Updated to Cart Failed!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('cart');
        }
    }

    public function WishList()
    {
        $users = session()->get('user');

        $wishlist = "";
        if ($users) {
            if ($users->user_type == 4) {
                $wishlist = WishList::Where('user_id', $users->id)->get();
                return View::make("front_end.wishlist")->with(array('wishlist' => $wishlist));
            } else {
                return redirect()->route('signin');
            }
        } else {
            return redirect()->route('signin');
        }
    }

    public function WishListSave(Request $request)
    {
        $id = 0;
        if ($request->ajax() && isset($request->id)) {
            $id = $request->id;
            $error = 1;
            if ($id) {
                $product = Products::where('id', $id)->first();
                $users = session()->get('user');
                if ($users) {
                    if ($users->user_type == 4) {
                        if ($product) {
                            $check_wish = WishList::Where('product_id', $id)->Where('user_id', $users->id)->first();

                            if ($check_wish) {
                                Session::flash('message', 'Already Added to Wish List!');
                                Session::flash('alert-class', 'alert-danger');
                                echo $error = 2;
                                die();
                            } else {
                                $wish = new WishList();
                                if ($wish) {
                                    $wish->product_id       = $product->id;
                                    $wish->user_id          = $users->id;
                                    $wish->name             = $product->product_title;
                                    $wish->original_price   = $product->original_price;
                                    $wish->discounted_price = $product->discounted_price;
                                    $wish->image            = $product->featured_product_img;
                                    $wish->is_block         = 1;

                                    if ($wish->save()) {
                                        $error = "Added to Wish List Successfully!";
                                        Session::flash('message', 'Added to Wish List Successfully!');
                                        Session::flash('alert-class', 'alert-success');
                                    } else {
                                        $error = 1;
                                        Session::flash('message', 'Added to Wish List Failed!');
                                        Session::flash('alert-class', 'alert-danger');
                                    }
                                } else {
                                    $error = 1;
                                    Session::flash('message', 'Added to Wish List Failed!');
                                    Session::flash('alert-class', 'alert-danger');
                                }
                            }
                        } else {
                            Session::flash('message', 'Add To Wish List Could Not Possible This Time!');
                            Session::flash('alert-class', 'alert-danger');
                            $error = 1;
                        }
                    } else {
                        Session::flash('message', 'You Must Login and Continue Add Wish List!');
                        Session::flash('alert-class', 'alert-danger');
                        $error = 3;
                    }
                } else {
                    Session::flash('message', 'You Must Login and Continue Add Wish List!');
                    Session::flash('alert-class', 'alert-danger');
                    $error = 3;
                }
            } else {
                Session::flash('message', 'Add To Wish List Could Not Possible This Time!');
                Session::flash('alert-class', 'alert-danger');
                $error = 1;
            }
            echo $error;
        }
    }

    public function DeleteWishList(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        if ($id) {
            $users = session()->get('user');
            if ($users) {
                if ($users->user_type == 4) {
                    $wishlist = WishList::Where('id', $id)->Where('user_id', $users->id)->first();
                    if ($wishlist) {
                        if ($wishlist->delete()) {
                            Session::flash('message', 'Item Removed From Wishlist Successfully');
                            Session::flash('alert-class', 'alert-success');
                            return redirect()->back();
                        } else {
                            Session::flash('message', 'Deleted Failed!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('wishlist');
                        }
                    } else {
                        Session::flash('message', 'Deleted Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('wishlist');
                    }
                } else {
                    Session::flash('message', 'You Must Login and Continue Add Wish List!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('signin');
                }
            } else {
                Session::flash('message', 'You Must Login and Continue Add Wish List!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'Deleted To Wish List Item Could Not Possible This Time!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('wishlist');
        }
    }

    public function Checkout()
    {
        $users = session()->get('user');
        $ships = array();
        $items = "";
        if ($users) {
            if ($users->user_type == 4) {
                // if($users->mobile_verify == 1) {                
                // if($users->email_verify == 1) {                
                $lusr = User::Where('id', $users->id)->first();
                if (!$lusr->checkout_verify) {
                    session()->forget('chk_verify');
                }
                $enabled_methods = PaymentMethod::where('is_enabled', 1)->get();
                $country = CountriesManagement::Where('is_block', 1)->get();
                $state = StateManagements::Where('is_block', 1)->get();
                $city = CityManagement::Where('is_block', 1)->get();
                $ships = ShippingAddress::Where('user_id', $users->id)->Where('is_block', 1)->first();
                $cutoff = TaxCutoff::Where('is_block', 1)->get();
                $cutoff = json_decode($cutoff);

                $items = Carts::Where('user_id', $users->id)->get();
                $addresses = Address::where('user_id', $users->id)->get();
                $shipping = ShippingSetting::first();
                $free_shipping_limit = $shipping->free_shipping ?? 0;

                $offer_discounts = 0.00;
                if (sizeof($items) != 0) {
                    $off_cart = Carts::Where('user_id', $users->id)->Where('is_offer', "Yes")->GroupBy('offer_id')->get();
                    if (sizeof($off_cart) != 0) {
                        foreach ($off_cart as $ofkey => $ofvalue) {
                            $off_det = Offers::Where('id', $ofvalue->offer_id)->first();
                            if ($off_det) {
                                $ofcs = Carts::Where('user_id', $users->id)->Where('offer_id', $off_det->id)->get();
                                $off_price = $ofcs->sum('product_cost');
                                $offer_price_discounts = $off_price * ($off_det->discount / 100);
                                $offer_discounts .= $offer_discounts + $offer_price_discounts;
                            }
                        }
                    }
                }

                $offer_discounts = round($offer_discounts, 2);

                return View::make("front_end.checkout")->with(array('items' => $items, 'free_shipping_limit' => $free_shipping_limit, 'shipping' => $shipping, 'enabled_methods' => $enabled_methods, 'lusr' => $lusr, 'users' => $users, 'addresses' => $addresses, 'country' => $country, 'state' => $state, 'city' => $city, 'ships' => $ships, 'cutoff' => $cutoff, 'offer_discounts' => $offer_discounts));
                /*} else {
                        Session::flash('message', 'You Must Verify Your E-Mail Address!'); 
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('my_account');
                    }*/
                /*} else {
                    Session::flash('message', 'You Must Verify Your Mobile Number!'); 
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('my_account');
                }*/
            } else {
                Session::flash('message', 'Kindly Sign-In / Sign-Up to continue using Rukmini Fashions');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } else {
            Session::flash('message', 'Kindly Sign-In / Sign-Up to continue using Rukmini Fashions');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function UpdateQty(Request $request)
    {
        $id = 0;
        if ($request->ajax() && isset($request->cart_id) && isset($request->qtys) && isset($request->totals)) {
            $id = $request->cart_id;
            $qtys = $request->qtys;
            $totals = $request->totals;
            $error = 1;

            $cart = Carts::where('id', $id)->first();
            if ($cart) {
                $cart->qty = $qtys;
                $cart->total_price = $totals;
                if ($cart->save()) {
                    $error = 0;
                } else {
                    $error = 1;
                }
            } else {
                $error = 1;
            }
        } else {
            $error = 1;
        }

        echo $error;
    }

    public function CheckCutOffs(Request $request)
    {
        $sum = 0;
        $shc = 0;
        $sc = 0;
        $cod_amount = 0;
        $data = array('error' => '0');

        if ($request->ajax() && isset($request->sum) && isset($request->shc) && isset($request->sc) && isset($request->is_cod) && isset($request->tax_tot) && isset($request->cnt_shc)) {
            $sum = $request->sum;
            $tax_tot = $request->tax_tot;
            $cnt_shc = $request->cnt_shc;
            $shc = $request->shc;
            $p_shc = $request->shc;
            $sc = $request->sc;
            $is_cod = $request->is_cod;

            $cutoff = TaxCutoff::Where('is_block', 1)->get();
            $cutoff = $cutoff->sortBy('above_amount');
            $cod = Cod::Where('is_block', 1)->get();
            $cod = $cod->sortBy('above_amount');
            $cod_amount = 0.00;
            if ($is_cod == 1) {
                if (sizeof($cod) != 0) {
                    foreach ($cod as $keyz => $valuez) {
                        if ($valuez->above_amount < $sum) {
                            $cod_amount = $valuez->cod_amount;
                        }
                    }
                }
            }

            if (sizeof($cutoff) != 0) {
                foreach ($cutoff as $key => $value) {
                    if ($value->above_amount < $sum) {
                        $shc = $value->shiping_amount;
                    }
                }

                if ($cnt_shc == 1) {
                    if ($p_shc == 0) {
                        $shc = 0.00;
                    }
                }

                // $tot = $sum + $shc + $cod_amount + $tax_tot;
                $tot = $sum + $shc + $cod_amount;
                $sum = round($sum, 2);
                $tax_tot = round($tax_tot, 2);
                $shc = round($shc, 2);
                $sc = round($sc, 2);
                $cod_amount = round($cod_amount, 2);
                $tot = round($tot, 2);
                $data = array('error' => '1', 'sum' => $sum, 'tax_tot' => $tax_tot, 'shc' => $shc, 'sc' => $sc, 'cod_amount' => $cod_amount, 'tot' => $tot);
            }
        }

        $data = json_encode($data);
        echo $data;
    }

    public function DataBilling(Request $request)
    {
        $id = 0;
        $data = array('error' => '0');

        if ($request->ajax() && isset($request->id) && isset($request->type)) {
            $id = $request->id;
            $type = $request->type;

            if ($type == "data_billing") {
                $user = User::Where('is_block', 1)->Where('id', $id)->first();
                if ($user) {
                    $data = array('error' => '1', 'user' => $user);
                }
            } else if ($type == "data_shipping") {
                $user = ShippingAddress::Where('is_block', 1)->Where('user_id', $id)->first();
                if ($user) {
                    $data = array('error' => '1', 'user' => $user);
                }
            }
        }

        $data = json_encode($data);
        echo $data;
    }

    public function CheckoutTrans(Request $request)
    {
        $data = $request->all();
        $user = User::Where('id', $data['user_id'])->Where('is_block', 1)->first();
        if ($user) {
            $rules = array(
                'first_name'        => 'required',
                'last_name'         => 'nullable',
                'email'             => 'required|unique:users,email,' . $data['user_id'] . ',id',
                'phone'             => 'required|numeric|unique:users,phone,' . $data['user_id'] . ',id',
                'alternate_contact' => 'nullable|numeric|unique:users,phone2,' . $data['user_id'] . ',id',
                'pincode'           => 'required|numeric|digits:6',
                'address1'          => 'required',
                'address2'          => 'required',
                'landmark'          => 'required',
                'country'           => 'required',
                'state'             => 'required',
                'city'              => 'required',
                'payment_method'    => 'nullable',
            );

            if (isset($data['shipping']) && $data['shipping'] == 1) {
                $rules['s_first_name'] = 'required';
                $rules['s_last_name']  = 'required';
                $rules['contact_no']   = 'required|numeric';
                $rules['address']      = 'required';
                $rules['s_landmark']   = 'required';
                $rules['s_city']       = 'required';
                $rules['s_pincode']    = 'required|numeric|digits:6';
                $rules['s_state']      = 'required';
                $rules['s_country']    = 'required';
            }

            $messages = [
                'address1.required' => 'The address field is required.',
                'address2.required' => 'The address field is required.',
                's_first_name.required' => 'The shipping first name field is required.',
                's_last_name.required' => 'The shipping last name field is required.',
                's_landmark.required' => 'The shipping landmark field is required.',
                's_city.required' => 'The shipping city field is required.',
                's_pincode.required' => 'The shipping pincode field is required.',
                's_pincode.numeric' => 'The shipping pincode field is input only numbers.',
                's_state.required' => 'The shipping state field is required.',
                's_country.required' => 'The shipping country field is required.',
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                // return View::make('front_end.checkout')->withErrors($validator);
                return redirect()->route('checkout')->withErrors($validator);
            } else {
                $sus1 = 0;
                $sus2 = 0;
                $sus3 = 0;
                $sus4 = 0;

                $user->first_name = $data['first_name'];
                $user->last_name  = $data['last_name'];
                $user->email      = $data['email'];
                $user->phone      = $data['phone'];
                $user->phone2     = $data['alternate_contact'];
                $user->pincode    = $data['pincode'];
                $user->address1   = $data['address1'];
                $user->address2   = $data['address2'];
                $user->landmark   = $data['landmark'];
                $user->country    = $data['country'];
                $user->state      = $data['state'];
                $user->city       = $data['city'];

                $ship = "";
                if ($user->save()) {
                    $sus1 = 1;

                    if (isset($data['shipping']) && $data['shipping'] == 1) {
                        if ($data['s_id']) {
                            $ship = ShippingAddress::Where('id', $data['s_id'])->first();
                        } else {
                            $ship = new ShippingAddress();
                        }

                        if ($ship) {
                            $ship->user_id    = $user->id;
                            $ship->first_name = $data['s_first_name'];
                            $ship->last_name  = $data['s_last_name'];
                            $ship->contact_no = $data['contact_no'];
                            $ship->address    = $data['address'];
                            $ship->landmark   = $data['s_landmark'];
                            $ship->city       = $data['s_city'];
                            $ship->pincode    = $data['s_pincode'];
                            $ship->state      = $data['s_state'];
                            $ship->country    = $data['s_country'];
                            $ship->is_block   = 1;

                            if ($ship->save()) {
                                $sus4 = 1;
                            } else {
                                Session::flash('message', 'Your Shipping Address Add Failed!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('checkout');
                            }
                        }
                    }

                    $log_user = session()->get('user');
                    if ($log_user) {
                        if ($log_user->user_type == 4) {
                            if ($log_user->id == $user->id) {
                                session()->forget('user');
                                $users = User::Where('id', $user->id)->first();
                                if ($users) {
                                    session()->put('user', $users);
                                }
                            }
                        }
                    }
                }

                $postal_code = "";
                $ava_deliv = 0;
                // $ava_deliv = 1;
                if (isset($data['shipping']) && $data['shipping'] == 1) {
                    $postal_code = $data['s_pincode'];
                } elseif ($user) {
                    $postal_code = $user->pincode;
                }

                if ($postal_code) {
                    if ($postal_code && strlen($postal_code) == 6) {
                        $log_shyp = new ShypliteAuth();
                        $login_shyp = $log_shyp->authenticatShyplite();
                        $login_shyp = json_decode($login_shyp, true);
                        // print_r($login_shyp);die();

                        if (!isset($login_shyp['error'])) {
                            $timestamp = time();
                            $appID = $log_shyp->appID;
                            $key = $log_shyp->key;
                            $secret = $log_shyp->secret;
                            if (isset($login_shyp['userToken'])) {
                                $secret = $login_shyp['userToken'];
                            }
                            $SellerID = $log_shyp->SellerID;

                            $sign = "key:" . $key . "id:" . $appID . ":timestamp:" . $timestamp;
                            $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
                            $ch = curl_init();

                            $header = array(
                                "x-appid: $appID",
                                "x-timestamp: $timestamp",
                                "x-sellerid:$SellerID",
                                "Authorization: $authtoken"
                            );

                            curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getserviceability/691021/' . $postal_code);
                            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $server_output = curl_exec($ch);
                            // var_dump($server_output);
                            $resp = json_decode($server_output, true);
                            // print_r($resp);
                            // die();
                            $airCod = false;
                            $surfaceCod = false;
                            $surface10kgPrepaid = false;
                            $surface10kgCod = false;
                            $surface5kgPrepaid = false;
                            $surface5kgCod = false;
                            $lite2kgPrepaid = false;
                            $lite2kgCod = false;
                            $lite1kgPrepaid = false;
                            $lite1kgCod = false;
                            $liteHalfKgPrepaid = false;
                            $liteHalfKgCod = false;
                            if (isset($resp['serviceability']['surface10kgPrepaid']) && isset($resp['serviceability']['surface10kgCod']) && isset($resp['serviceability']['surface5kgPrepaid']) && isset($resp['serviceability']['surface5kgCod']) && isset($resp['serviceability']['lite2kgPrepaid']) && isset($resp['serviceability']['lite2kgCod']) && isset($resp['serviceability']['lite1kgPrepaid']) && isset($resp['serviceability']['lite1kgCod']) && isset($resp['serviceability']['lite0.5kgPrepaid']) && isset($resp['serviceability']['lite0.5kgCod'])) {
                                $surface10kgPrepaid = $resp['serviceability']['surface10kgPrepaid'];
                                $surface10kgCod = $resp['serviceability']['surface10kgCod'];
                                $surface5kgPrepaid = $resp['serviceability']['surface5kgPrepaid'];
                                $surface5kgCod = $resp['serviceability']['surface5kgCod'];
                                $lite2kgPrepaid = $resp['serviceability']['lite2kgPrepaid'];
                                $lite2kgCod = $resp['serviceability']['lite2kgCod'];
                                $lite1kgPrepaid = $resp['serviceability']['lite1kgPrepaid'];
                                $lite1kgCod = $resp['serviceability']['lite1kgCod'];
                                $liteHalfKgPrepaid = $resp['serviceability']['lite0.5kgPrepaid'];
                                $liteHalfKgCod = $resp['serviceability']['lite0.5kgCod'];
                            }

                            // if(1==1) {
                            if ($surface10kgPrepaid == TRUE && $surface10kgCod == TRUE && $surface5kgPrepaid == TRUE && $surface5kgCod == TRUE && $lite2kgPrepaid == TRUE && $lite2kgCod == TRUE && $lite1kgPrepaid == TRUE && $lite1kgCod == TRUE && $liteHalfKgPrepaid == TRUE && $liteHalfKgCod == TRUE) {
                                $ava_deliv = 1;
                            } elseif (isset($resp['error'])) {
                                Session::flash('message', 'Delivery Option Not Checked This Time!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('checkout');
                            } else {
                                Session::flash('message', 'Delivery Not Available for this Pincode!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('checkout');
                            }
                            curl_close($ch);
                        } else {
                            Session::flash('message', 'Delivery Option Not Checked This Time!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('checkout');
                        }
                    } else {
                        Session::flash('message', 'Enter Valid Pincode and Pincode Must 6 Numbers only!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('checkout');
                    }
                } else {
                    Session::flash('message', 'Your Pincode is Not Correct!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('checkout');
                }

                if ($ava_deliv == 1) {
                    $cart = Carts::Where('user_id', $data['user_id'])->get();
                    $otp = mt_rand(100000, 999999);
                    $user->checkout_verify = $otp;
                    if ($user->save()) {
                        $text = "Please Use this " . $otp . " reference code to verify your checkout process, Folkgems.com";
                        $text = urlencode($text);

                        $curl = curl_init();

                        // Send the POST request with cURL
                        curl_setopt_array($curl, array(
                            CURLOPT_RETURNTRANSFER => 1,
                            CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                            CURLOPT_POST => 1,
                            CURLOPT_CUSTOMREQUEST => 'POST',
                            CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                            CURLOPT_POSTFIELDS => array(
                                'mobile' => $user->phone,
                                'route' => 'TL',
                                'text' => $text,
                                'sender' => 'GJICAM'
                            )
                        ));

                        // Send the request & save response to $response
                        $response = curl_exec($curl);

                        // Close request to clear up some resources
                        curl_close($curl);
                        $response = json_decode($response);
                        // Print response
                        if (isset($response->data->status) && $response->data->status == "success") {
                            Session::flash('message', 'Order Verification Code Send Successfully, Verify this Code to Checkout Process Complete!');
                            Session::flash('alert-class', 'alert-success');
                            Session::put('chk_verify', 1);
                            return redirect()->route('checkout');
                        } else {
                            Session::flash('message', 'Order Verification Code Send Failed!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('checkout');
                        }
                    } else {
                        Session::flash('message', 'Order Verification Code Send Failed!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('checkout');
                    }
                } else {
                    Session::flash('message', 'Your Pincode is Not Available For Delivery!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('checkout');
                }
            }
        } else {
            Session::flash('message', 'You Must Login And Continue to Checkout!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('signin');
        }
    }

    public function CheckoutVerif(Request $request)
    {
        try {
            $data = $request->all();
            $user = User::Where('id', $data['user_id'])->Where('is_block', 1)->first();

            if ($user) {

                $data['payment_method'] = $request->payment_method;
                $rules = array(
                    'full_name'        => 'required',
                    'email'             => 'required|email:rfc,dns',
                    'contact_no'        => 'required|digits:10',
                    'address'           => 'required',
                    'pincode'           => 'required|numeric',
                    'landmark'          => 'required',
                    'payment_method'    => 'required',
                );

                $messages = [
                    'full_name.required' => 'The full name field is required.',
                    'address.required' => 'The Address field is required.',
                    'landmark.required' => 'The Locality / Town field is required.',
                    'pincode.required' => 'The Pincode field is required.',
                    'payment_method.required' => 'The Payment Method is required.',
                ];
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return response()->json([
                        'success' => false,
                        'errors' => $validator->errors()
                    ], 422);
                } else {
                    $sus1 = 0;
                    $sus2 = 0;
                    $sus3 = 0;
                    $sus4 = 0;

                    if ($request->address_id !== 'new') {
                        if ($request->has('default_address')) {
                            $address =    Address::where('user_id', $request->user_id)->update(['is_default' => 0]);
                            $address =   Address::where('id', $request->address_id)->update(['is_default' => 1]);
                        }
                    }

                    if ($request->address_id === 'new' && $request->has('save_address')) {

                        if ($request->has('default_address')) {
                            $address =  Address::where('user_id', $request->user_id)->update(['is_default' => 0]);
                        }

                        $existingAddress = Address::where('user_id', $request->user_id)
                            ->where('title', $request->title)
                            ->first();

                        $isDefault = $request->has('default_address') ? 1 : 0;

                        if ($existingAddress) {
                            $address =  $existingAddress->update([
                                'address_type' => $request->title,
                                'address2'     => $request->address,
                                'address3'     => $request->address3 ?? '',
                                'pincode'      => $request->pincode,
                                'locality'     => $request->landmark,
                                'is_default'   => $isDefault,
                            ]);
                        } else {
                            $address =   Address::create([
                                'user_id'      => $request->user_id,
                                'address_type' => $request->title,
                                'title'        => $request->title,
                                'address2'     => $request->address,
                                'address3'     => $request->address3 ?? '',
                                'pincode'      => $request->pincode,
                                'locality'     => $request->landmark,
                                'is_default'   => $isDefault,
                            ]);
                        }
                    }

                    $ship = ShippingAddress::Where('user_id', $user->id)->first();
                    if (!$ship) {
                        $ship = new ShippingAddress();
                    }
                    if ($ship) {
                        $ship->user_id    = $user->id;
                        $ship->full_name = $data['full_name'];
                        $ship->first_name = $data['first_name'] ?? '0';
                        $ship->last_name  = $data['last_name'] ?? '0';
                        $ship->email      = $data['email'];
                        $ship->contact_no = $data['contact_no'];
                        $ship->address    = $data['address'];
                        $ship->pincode    = $data['pincode'];
                        $ship->landmark   = $data['landmark'];
                        $ship->state      = $data['state'] ?? '0';
                        $ship->city       = $data['city'] ?? '0';

                        if (isset($data['default']) && $data['default']) {
                            $ship->default   = 1;

                            $ship_def = ShippingAddress::Where('user_id', $user->id)->get();
                            if (sizeof($ship_def) != 0) {
                                foreach ($ship_def as $keysd => $valuesd) {
                                    $sdf = ShippingAddress::Where('id', $valuesd->id)->first();
                                    if ($sdf) {
                                        $sdf->default = 0;
                                        $sdf->save();
                                    }
                                }
                            }
                        }

                        $ship->is_block   = 1;

                        if ($ship->save()) {

                            $sus4 = 1;
                        } else {
                            Session::flash('message', 'Your Shipping Address Add Failed!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('checkout');
                        }
                    }

                    $sus1 = 1;

                    $postal_code = "";
                    $ava_deliv = 0;
                    $ava_deliv = 1;

                    if ($ava_deliv == 1) {
                        if (in_array($data['payment_method'], [2, 4])) {
                            $order = new DemoOrders();
                        } else {
                            $order = new Orders();
                        }
                        $cart = Carts::Where('user_id', $data['user_id'])->get();

                        if ($order) {
                            $total_items = 0;
                            $total_amount = 0;
                            $net_amount = 0;
                            $total_service = 0;
                            $total_shiping = 0;
                            $total_discount = 0;
                            $tax_amount = 0;
                            if (count($cart) != 0) {
                                $total_items = $cart->sum('qty');

                                $product_serv = DB::table('carts')
                                    ->select(DB::raw('sum(carts.service_charge) AS serv_total'))
                                    ->join('products', 'products.id', '=', 'carts.product_id')
                                    ->where('carts.user_id', $data['user_id'])
                                    ->first();
                                if ($product_serv->serv_total) {
                                    $total_service = $product_serv->serv_total;
                                } else {
                                    $total_service = 0;
                                }

                                // ->where('products.tax_type', 2)
                                $product_ships = DB::table('carts')
                                    ->select(DB::raw('MAX(carts.shiping_charge) AS ship_total'))
                                    ->join('products', 'products.id', '=', 'carts.product_id')
                                    ->where('carts.user_id', $data['user_id'])
                                    ->first();

                                if (is_array($request->shiping_charge)) {
                                    $total_shiping = floatval($request->shiping_charge[0]); // take only the first value
                                } else {
                                    $total_shiping = floatval($request->shiping_charge); // single value case
                                }

                                $net_total = DB::table('carts')
                                    ->select(DB::raw('sum(total_price) AS total'))
                                    // ->select(DB::raw('Round(sum(total_price) ,2) AS total'))
                                    ->where('user_id', $data['user_id'])
                                    ->first();
                                if ($net_total->total) {
                                    $total_amount = $net_total->total;
                                } else {
                                    $total_amount = 0;
                                }

                                $tax_total = DB::table('carts')
                                    ->select(DB::raw('sum(tax_amount* qty) AS taxs'))
                                    // ->select(DB::raw('Round(sum(total_price) ,2) AS total'))
                                    ->where('user_id', $data['user_id'])
                                    ->first();
                                if ($tax_total->taxs) {
                                    $tax_amount = $tax_total->taxs;
                                } else {
                                    $tax_amount = 0;
                                }

                                $cod = Cod::Where('is_block', 1)->get();
                                $coupon_discount = floatval(Session::get('coupon.discount', 0));
                                $total_discount = $coupon_discount;

                                // $net_amount = $total_amount + $tax_amount + $total_shiping + $cod_amount;
                                $net_amount = $total_amount + $total_shiping;
                                $net_amount = $net_amount - $total_discount;

                                $total_amount = round($total_amount, 2);
                                $tax_amount = round($tax_amount, 2);
                                $net_amount = round($net_amount, 2);
                                $total_service = round($total_service, 2);
                                $total_shiping = round($total_shiping, 2);
                            }

                            if ($net_amount != 0) {
                                $max_st = "Order";
                                $max_id = "00001";

                                // Get last order number correctly even if some orders are deleted
                                $lastOrder = Orders::withTrashed()
                                    ->whereNotNull('order_code')
                                    ->orderByRaw("CAST(SUBSTRING(order_code, 6) AS UNSIGNED) DESC")
                                    ->first();

                                if ($lastOrder && isset($lastOrder->order_code)) {
                                    // Extract numeric part
                                    preg_match('/(\d+)/', $lastOrder->order_code, $matches);
                                    $last_num = isset($matches[1]) ? (int)$matches[1] : 0;
                                    $next_num = $last_num + 1;
                                    $data['order_code'] = $max_st . sprintf("%05d", $next_num);
                                } else {
                                    $data['order_code'] = $max_st . $max_id;
                                }

                                $order->order_code = $data['order_code'];
                                $order->order_date = date('Y-m-d');
                                $order->user_id = $data['user_id'];
                                $order->payment_mode = $data['payment_method'];
                                $order->contact_person = $data['full_name'];
                                $order->contact_email = $data['email'];
                                $order->contact_no = $data['contact_no'];

                                $deli_pincode = "";
                                $deli_city = "";
                                $ship_city = "";
                                $ship_state = "";
                                $ship_country = "";

                                $user_city = "";
                                $user_state = "";
                                $user_country = "";

                                if (isset($user->City->city_name) && $user->City->city_name) {
                                    $user_city = $user->City->city_name;
                                }

                                if (isset($user->State->state) && $user->State->state) {
                                    $user_state = $user->State->state;
                                }

                                if (isset($user->Country->country_name) && $user->Country->country_name) {
                                    $user_country = $user->Country->country_name;
                                }

                                if ($ship) {
                                    if (isset($ship->city) && $ship->city) {
                                        if (isset($ship->Citys->city_name) && $ship->Citys->city_name) {
                                            $ship_city = $ship->Citys->city_name;
                                        }
                                    }

                                    if (isset($ship->States->state) && $ship->States->state) {
                                        $ship_state = $ship->States->state;
                                    }

                                    if (isset($ship->Countrys->country_name) && $ship->Countrys->country_name) {
                                        $ship_country = $ship->Countrys->country_name;
                                    }

                                    $order->shipping_address = $ship->address . ',' . $ship_city . ',' . $ship->pincode . ',' . $ship_state . ',' . $ship_country;
                                    $deli_pincode = $ship->pincode;
                                    $deli_city = $ship_city;
                                } else {
                                    $order->shipping_address = $user->address1 . ',' . $user->address2 . ',' . $user_city . ',' . $user->pincode . ',' . $user_state . ',' . $user_country;
                                    $deli_pincode = $user->pincode;
                                    $deli_city = $user_city;
                                }

                                $order->city = $deli_city;
                                $order->pincode = $deli_pincode;
                                $order->total_items = $total_items;
                                $order->total_amount = $total_amount;
                                $order->tax_amount = $tax_amount;
                                $order->service_charge = $total_service;
                                $order->shipping_charge = $total_shiping;
                                $order->offer_discount = 0;
                                $order->cod_charge = 0;
                                $order->net_amount = $net_amount;
                                $order->coupon_code = Session::get('coupon.code', null);
                                $order->coupon_discount = $coupon_discount;
                                $order->order_status = 1;
                                $order->payment_status = 0;
                                $order->remarks = NULL;
                                $order->is_block = 1;

                                if ($order->save()) {
                                    if (isset($cart) && count($cart) != 0) {
                                        foreach ($cart as $key => $value) {
                                            if (in_array($data['payment_method'], [2, 4])) {
                                                $order_details = new DemoOrderDetails();
                                            } else {
                                                $order_details = new OrderDetails();
                                            }
                                            $order_details->order_id = $order->id;
                                            $order_details->product_id = $value->product_id;

                                            if (isset($value->name)) {
                                                $order_details->product_title = $value->name;
                                            } else {
                                                $order_details->product_title = NULL;
                                            }

                                            if (isset($value->qty)) {
                                                $order_details->order_qty = $value->qty;
                                            } else {
                                                $order_details->order_qty = NULL;
                                            }

                                            if (isset($value->att_name)) {
                                                $order_details->att_name = $value->att_name;
                                            } else {
                                                $order_details->att_name = NULL;
                                            }

                                            if (isset($value->att_value)) {
                                                $order_details->att_value = $value->att_value;
                                            } else {
                                                $order_details->att_value = NULL;
                                            }

                                            if (isset($value->color_id)) {
                                                $order_details->color_id = $value->color_id;
                                            } else {
                                                $order_details->color_id = NULL;
                                            }

                                            if (isset($value->color_name)) {
                                                $order_details->color_name = $value->color_name;
                                            } else {
                                                $order_details->color_name = NULL;
                                            }

                                            if (isset($value->tax)) {
                                                $order_details->tax = $value->tax;
                                            } else {
                                                $order_details->tax = NULL;
                                            }

                                            if (isset($value->shiping_charge)) {
                                                $order_details->shiping_charge = $value->shiping_charge;
                                            } else {
                                                $order_details->shiping_charge = NULL;
                                            }


                                            if (isset($value->tax_type)) {
                                                $order_details->tax_type = $value->tax_type;
                                            } else {
                                                $order_details->tax_type = NULL;
                                            }

                                            if (isset($value->discounted_price)) {
                                                $order_details->unitprice = $value->discounted_price;
                                            } else {
                                                $order_details->unitprice = 0.00;
                                            }

                                            if (isset($value->total_price)) {
                                                $order_details->totalprice = $value->total_price;
                                            } else {
                                                $order_details->totalprice = 0.00;
                                            }

                                            if (isset($data['tax_amount'][$key])) {
                                                $order_details->tax_amount = $data['tax_amount'][$key];
                                            } else {
                                                $order_details->tax_amount = 0.00;
                                            }

                                            if (isset($value->is_offer) && $value->is_offer == "Yes") {
                                                $order_details->is_offer = "Yes";
                                            } else {
                                                $order_details->is_offer = "No";
                                            }

                                            if (isset($value->offer_id) && $value->offer_id) {
                                                $order_details->offer_id = $value->offer_id;
                                            }

                                            if (isset($value->offer_det_id) && $value->offer_det_id) {
                                                $order_details->offer_det_id = $value->offer_det_id;
                                            }

                                            $order_details->is_block = 1;

                                            if ($order_details->save()) {
                                                $sus2 = 1;
                                            }
                                        }
                                    }

                                    if (in_array($data['payment_method'], [2, 4])) {
                                        $order_trans = new DemoOrdersTransactions();
                                        $t_max = DemoOrdersTransactions::max('trans_code');
                                    } else {
                                        $order_trans = new OrdersTransactions();

                                        $t_max = OrdersTransactions::max('trans_code');
                                    }
                                    $t_max_id = "00001";
                                    $t_max_st = "Trans";

                                    if ($t_max) {
                                        $t_max_no = substr($t_max, 5);        // remove "Trans"
                                        $t_increment = (int)$t_max_no + 1;
                                        $data['trans_code'] = $t_max_st . sprintf("%05d", $t_increment);
                                    } else {
                                        $data['trans_code'] = $t_max_st . $t_max_id;
                                    }


                                    $order_trans->trans_code = $data['trans_code'];
                                    $order_trans->trans_date = date('Y-m-d H:i:s');
                                    $order_trans->order_id = $order->id;
                                    $order_trans->net_amount = $net_amount;
                                    $order_trans->amountpaid = "Unpaid";
                                    $order_trans->paymentmode = $order->payment_mode;
                                    $order_trans->gatewaytransactionid = NULL;
                                    $order_trans->trans_status = "PENDING";
                                    $order_trans->remarks = NULL;
                                    $order_trans->is_block = 1;

                                    if ($order_trans->save()) {
                                        $sus3 = 1;
                                    }

                                    if ($sus2 == 1 && $sus3 == 1) {
                                        $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                                        $admin_email = "info@folkgems.com";
                                        if ($adm) {
                                            $admin_email = $adm->email;
                                        }

                                        $logos = \DB::table('logo_settings')->latest()->first();
                                        $logo_path = 'images/logo';
                                        $logo = "";
                                        if ($logos) {
                                            $logo = asset($logo_path . '/' . $logos->logo_image);
                                        } else {
                                            $logo = asset('images/logo.png');
                                        }

                                        $general = \DB::table('general_settings')->first();
                                        $site_name = "Folkgems";
                                        if ($general) {
                                            $site_name = $general->site_name;
                                        } else {
                                            $site_name = "Folkgems";
                                        }

                                        $net_comis = 0.00;
                                        $net_mer_amt = 0.00;
                                        $customer_name = "";
                                        $contact = "";
                                        $address = "";
                                        $order_code = $order->order_code;
                                        $order_date = date('d-m-Y', strtotime($order->order_date));
                                        $net_tot = $order->net_amount;
                                        // $tax_tot = $order->tax_amount;
                                        $details = "";
                                        $order_detail = OrderDetails::Where('is_block', 1)->Where('order_id', $order->id)->get();
                                        $details = "";
                                        if ($order_detail) {
                                            foreach ($order_detail as $key => $value) {
                                                $stock = Products::Where('id', $value->product_id)->first();

                                                $off_avi  = 0;
                                                if (isset($data['is_offer'][$key])) {
                                                    if ($data['is_offer'][$key] == "Yes") {
                                                        if (isset($data['offer_det_id'][$key])) {
                                                            $off_sub = OffersSub::Where('id', $data['offer_det_id'][$key])->first();
                                                            if ($off_sub) {

                                                                $off_trans = new OfferTransaction();
                                                                $off_trans->order_code   = $order_code;
                                                                $off_trans->offer = $off_sub->offer;
                                                                $off_trans->offer_det_id = $off_sub->id;
                                                                $off_trans->product_id = $off_sub->product_id;
                                                                $off_trans->att_name = $off_sub->att_name;
                                                                $off_trans->att_value = $off_sub->att_value;
                                                                $off_trans->previous_qty = $off_sub->qty;
                                                                $off_trans->current_qty = $off_sub->qty - $value->order_qty;
                                                                $off_trans->date = date('Y-m-d');

                                                                $off_trans->save();


                                                                $off_sub->qty = $off_sub->qty - $value->order_qty;
                                                                $off_sub->save();
                                                            }
                                                        }
                                                    } else {
                                                        $off_avi  = 1;
                                                    }
                                                } else {
                                                    $off_avi  = 1;
                                                }

                                                if ($off_avi  == 1) {
                                                    if ($stock && ($stock->onhand_qty != 0)) {
                                                        $stock_trans = new StockTransactions();
                                                        $stock_trans->order_code   = $order_code;
                                                        $stock_trans->product_id   = $value->product_id;
                                                        $stock_trans->att_name     = $value->att_name;
                                                        $stock_trans->att_value    = $value->att_value;
                                                        $stock_trans->previous_qty = $stock->onhand_qty;
                                                        $stock_trans->current_qty  = $stock->onhand_qty - $value->order_qty;
                                                        $stock_trans->date         = date('Y-m-d');
                                                        $stock_trans->remarks      = $value->product_title . ' is ordered.';

                                                        $stock->onhand_qty = $stock->onhand_qty - $value->order_qty;

                                                        $p_atts = ProductsAttributes::Where('product_id', $value->product_id)->Where('attribute_name', $value->att_name)->Where('attribute_values', $value->att_value)->first();
                                                        if ($p_atts) {
                                                            $stock_trans->att_previous_qty = $p_atts->att_qty;
                                                            $stock_trans->att_current_qty  = $p_atts->att_qty - $value->order_qty;

                                                            $p_atts->att_qty = $p_atts->att_qty - $value->order_qty;
                                                            $p_atts->save();
                                                        }

                                                        if ($stock->save() && $stock_trans->save()) {
                                                            $sck = 1;
                                                        }

                                                        $stock_manag = StockManagement::where('product_id', $value->product_id)->latest()->first();
                                                        if ($stock_manag) {
                                                            $stock_manag->current_qty = $stock->onhand_qty; // Use updated value directly
                                                            $stock_manag->save();
                                                        }
                                                    }
                                                }

                                                if ($stock && $stock->created_user != 1) {
                                                    if ($stock->Creatier->user_type == 2 || $stock->Creatier->user_type == 3) {
                                                        $com_per = $stock->Creatier->commission;
                                                        $t_pce = $value->totalprice;
                                                        $admin_com = round($t_pce * ($com_per / 100), 2);
                                                        $mer_amt = round($t_pce - $admin_com, 2);

                                                        $comis = new AdminCommision();
                                                        $comis->order_code   = $order_code;
                                                        $comis->order_dets   = $value->id;
                                                        $comis->product_id   = $value->product_id;
                                                        $comis->att_name     = $value->att_name;
                                                        $comis->att_value    = $value->att_value;
                                                        $comis->merchant_id  = $stock->Creatier->id;
                                                        $comis->amount       = $admin_com;
                                                        $comis->merchant_amount = $mer_amt;
                                                        $comis->paid_status  = 0;
                                                        $comis->remarks      = $value->product_title . ' product against Admin Commision is Rs. ' . $admin_com . ' set.';
                                                        $comis->save();

                                                        $net_comis   = $net_comis + $admin_com;
                                                        $net_mer_amt = $net_mer_amt + $mer_amt;
                                                    }
                                                }

                                                $att_tit = "";
                                                if (isset($value->att_name) && $value->att_name != 0) {
                                                    if (isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                                        $att_tit = '<span>(' . $value->AttName->att_name . ' : ' . $value->AttValue->att_value . ')</span>';
                                                    }
                                                }

                                                $color = "";
                                                if (!empty($value->color_name)) {
                                                    $color = '( ' . $value->color_name . ' )';
                                                }


                                                $img = '';
                                                $product_path = 'images/featured_products';
                                                $noimage = DB::table('noimage_settings')->first();
                                                $noimage_path = 'images/noimage';

                                                if ($value->Products->featured_product_img) {
                                                    $img = '<img src="' . asset($product_path . '/' . $value->Products->featured_product_img) . '" style="max-width:80px; max-height:80px;">';
                                                } else {
                                                    $img = '<img src="' . asset($noimage_path . '/' . $noimage->product_no_image) . '" style="max-width:80px; max-height:80px;">';
                                                }

                                                $details .= '<tr>
                                            <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;"> <a href="' . route('view_products', ['id' => $value->product_id]) . '">
                                            ' . $img . '
                                            </a> </td>
                                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">
                                                    ' . $value->product_title . ' ' . $color . ' ' . $att_tit . '
                                                </td>

                                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;"> ' . $value->order_qty . '</td>
                                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  ' . $value->unitprice . '</td>
                                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  ' . $value->tax_amount . '</td>
                                                <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  ' . $value->totalprice . '</td>
                                            </tr>';
                                            }
                                        }

                                        if ($order->coupon_code) {
                                            // Save coupon usage
                                            CouponUsage::create([
                                                'user_id'     => $user->id,
                                                'coupon_code' => $order->coupon_code,
                                                'order_id'    => $order->id,
                                                'used_at'     => now(),
                                            ]);

                                            // Update coupon usage count
                                            $coupon = Coupon::where('code', $order->coupon_code)->first();
                                            if ($coupon) {
                                                $coupon->used_count = $coupon->used_count + 1;

                                                if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
                                                    $coupon->status = 0; // deactivate coupon

                                                }
                                                $coupon->save();
                                            }
                                        }

                                        if ($order) {
                                            $order->net_commision = $net_comis;
                                            $order->net_merchant_amout = $net_mer_amt;
                                            $order->save();
                                        }


                                        if ($ship) {
                                            $customer_name = $ship->full_name;
                                            $address = $ship->address . ',' . $ship_city . ',' . $ship->pincode . ',' . $ship_state . ',' . $ship_country;
                                            $contact = $ship->contact_no;
                                        } else if ($user) {
                                            $customer_name = $user->full_name;
                                            $address = $user->address1 . ',' . $user->address2 . ',' . $user_city . ',' . $user->pincode . ',' . $user_state . ',' . $user_country;
                                            $contact = $user->phone . ',' . $user->phone2;
                                        }



                                        if (in_array($order->payment_mode, [1, 3])) {
                                            // $brand = "RANGBYBHAVANA"; 
                                            //     $validity = 5; 
                                            //     $mobile = '91' . $contact; 
                                            // $var3 = 'https://instagram.com/rang_by_bhavana';
                                            // $var4 = 'www.rangjewelry.com';

                                            //     $message = "Dear $customer_name, Thank you for your order! Your order $order_code has been received successfully. We'll notify you once it's shipped. RANG BY BHAVANA $var3 $var4 Thank you";

                                            //     $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                                            //     $senderId = "RANGBB";
                                            //     $route = "5";
                                            //     $templateId = "1007284028019038386";

                                            //     $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                                            //      . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                                            //      . "&number=$mobile&text=" . urlencode($message)
                                            //      . "&route=$route&DLTTemplateId=$templateId";

                                            //     $ch = curl_init();
                                            //     curl_setopt($ch, CURLOPT_URL, $url);
                                            //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            //     $smsResponse = curl_exec($ch);
                                            //     $smsError = curl_error($ch);
                                            //     curl_close($ch);
                                        }

                                        // dd($ship);
                                        $bodytxt = '';
                                        $discount = '';

                                        if ($order->payment_mode == 3) {

                                            $sub = "Your Rukmini Fashions Order is ready to be picked up";
                                            $bodytxt = '<p style="font-size:12px;font-weight:600;">We are pleased to inform you that your order #' . $order_code . ' from Rukmini Fashions is ready for pickup.</p>
                                        <p style="font-size:12px;font-weight:600;"> You can contact us on <a href="https://wa.me/9633052041" target="_blank">watsapp</a> / <a href="mailto:rukmini6869@gmail.com" target="_blank">email</a> for the pickup address.</p>
                                        ';
                                        } else {
                                            $sub = "Your Rukmini Fashions Order was Placed";
                                            $bodytxt = '<p style="font-size:12px;font-weight:600;">Thank you for your recent order from Rukmini Fashions. It has been successfully <b>Placed</b>. We appreciate your business with us.</p>
                                            ';
                                        }

                                        if ($order->coupon_code) {
                                            $discount = '
                                        <tr>
                                            <th colspan="5" style="padding:10px 10px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:green;border:1px solid #aba7a7;padding-right:10px;font-size:12px;">
                                                Coupon Discount
                                            </th>
                                            <td style="padding:10px 10px;font-size:13px;font-weight:bold;color:green;border:1px solid #aba7a7;text-align:right;">
                                                - Rs. ' . number_format($order->coupon_discount, 2) . '
                                            </td>
                                        </tr>';
                                        }


                                        $name = $user->full_name;
                                        $email = $user->email;

                                        $headers  = "MIME-Version: 1.0\r\n";
                                        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                                        // $headers.= "From: $admin_email" . "\r\n";
                                        $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
                                        $headers .= "Reply-To: rukmini6869@gmail.com\r\n";
                                        $to = $email;
                                        $to2 = $admin_email;
                                        $subject = $sub;
                                        $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '" ><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                            <h2 style="color: #B73182;margin-top: 0px;">Orders Details</h2>
                                           
                                            <p style="font-size:15px;font-weight:600;">Dear ' . $customer_name . ', </p>
                                            
                                            ' . $bodytxt . '
                                           
                                            <table align="center" style=" text-align: center;width: 100%;">
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name : </th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;">  ' . $customer_name . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No : </th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;">' . $contact . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Address : </th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;">' . $address . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code : </th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;">' . $order_code . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date : </th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;">' . $order_date . '</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Payment Mode</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px; text-align:left;width: 50%;"> : ' . $order->payment->name . '</td>
                                                </tr>
                                            </table>

                                            <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                                <tr>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;"></th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Tax Amount</th>
                                                    <th style="padding: 10px 10px;width: 100px;background-color:#d993bdb5;color: #fff;text-align: center;text-transform: uppercase;padding-bottom: 5px;border: 1px solid #cccc;font-size: 13px;font-weight: 700;">Total</th>
                                                </tr>' . $details . '
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $order->total_amount . '</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $order->shipping_charge . '</td>
                                                </tr>
                                                
                                                ' . $discount . '
                                               
                                                <tr>
                                                    <th colspan="5" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $net_tot . '</td>
                                                </tr>
                                            </table>

                                            <p></p>
                                            <p style="font-size:13px;font-weight:600;">If you have any questions or concerns, please dont hesitate to reach out to our <a href="' . route('contact') . '">customer support team </a>. </p>
                                            <p  style="font-size:13px;font-weight:600;">We look forward to serving you again soon. Thank you </p>
                                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                                            <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                            <div style="padding: 20px 0; text-align: center;">
                                               <a href="https://www.instagram.com/" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                                </a>
                                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                                </a>
                                            </div>
                                        </div>
                                    </div>';

                                        // if(1==1){
                                        //   $mail= mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
                                        //     if($mail){

                                        // Session::flash('message', 'Order Placed Successfully!'); 
                                        // Session::flash('alert-class', 'alert-success');
                                        Session::put('checkout_email_data', [
                                            'to' => $email,
                                            'to2' => $admin_email,
                                            'subject' => $subject,
                                            'body' => $txt,
                                            'headers' => $headers,
                                        ]);

                                        $order->order_email_subject = $subject;
                                        $order->order_email_body = $txt;
                                        $order->save();

                                        if ($order->payment_mode == "2") {

                                            $phonePeResponse = $this->initiatePhonePePayment($order);

                                            // dd($phonePeResponse['success']);
                                            if ($phonePeResponse['success']) {
                                                return response()->json([
                                                    'success' => true,
                                                    'payment_url' => $phonePeResponse['payment_url'],
                                                ]);
                                            } else {
                                                return response()->json([
                                                    'success' => false,
                                                    'message' => 'Failed to initiate PhonePe payment: ' . $phonePeResponse['message'],
                                                ]);
                                            }
                                        } elseif ($order->payment_mode == "4") {
                                            $easeResp = $this->initiateEasebuzzPayment($order);
                                            if ($easeResp['success']) {
                                                return response()->json([
                                                    'success' => true,
                                                    'payment_url' => $easeResp['payment_url']
                                                ]);
                                            } else {
                                                return response()->json([
                                                    'success' => false,
                                                    'message' => $easeResp['message'] ?? 'Easebuzz initiation failed'
                                                ]);
                                            }
                                        } else {


                                            Carts::Where('user_id', $data['user_id'])->delete();
                                            session()->forget('cart');
                                            session()->forget('coupon');
                                            // return redirect()->route('home');
                                            return response()->json([
                                                'success' => true,
                                                'message' => 'Order placed successfully!'
                                            ]);
                                        }



                                        // }
                                    } else {
                                        Orders::where('id', $order->id)->delete();
                                        Session::flash('message', 'Orders Placed Failed!');
                                        Session::flash('alert-class', 'alert-danger');
                                        return redirect()->route('checkout');
                                    }
                                } else {
                                    Session::flash('message', 'Orders Placed Failed!');
                                    Session::flash('alert-class', 'alert-danger');
                                    return redirect()->route('checkout');
                                }
                            } else {
                                Session::flash('message', 'Orders Placed Failed!');
                                Session::flash('alert-class', 'alert-danger');
                                return redirect()->route('checkout');
                            }
                        } else {
                            Session::flash('message', 'Orders Placed Failed!');
                            Session::flash('alert-class', 'alert-danger');
                            return redirect()->route('checkout');
                        }
                    } else {
                        Session::flash('message', 'Your Pincode is Not Available For Delivery!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('checkout');
                    }
                }
            } else {
                Session::flash('message', 'You Must Login And Continue to Checkout!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('signin');
            }
        } catch (\Exception $e) {
            \Log::error('Checkout Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage()
            ], 500);
        }
    }
    //  <tr>
    //                                                 <th colspan="3" style="width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid black;padding-right:10px;font-size: 16px;">COD Charge</th>
    //                                                 <td style="font-size: 14px;font-weight: bold;color: black;border: 1px solid black;text-align: right;">Rs. '.$order->cod_charge.'</td>
    //                                             </tr>


    /**
     * Initiate PhonePe Payment
     */
    private function initiatePhonePePayment($order)
    {
        try {
            $orderTransaction = DemoOrdersTransactions::where('order_id', $order->id)->first();

            if (!$orderTransaction) {
                return [
                    'success' => false,
                    'message' => 'Order transaction not found',
                ];
            }

            $merchantOrderId = $orderTransaction->trans_code;
            $amount = $order->net_amount;
            $callbackUrl = route('phonepe.callback');

            // Use PhonePe class to create order
            $phonePe = PhonePe::getInstance();
            $response = $phonePe->createOrder($merchantOrderId, $amount, $callbackUrl);

            // Store order ID in session for callback
            session(['phonepe_order_id' => $merchantOrderId]);

            if (!empty($response['redirectUrl'])) {
                return [
                    'success' => true,
                    'payment_url' => $response['redirectUrl'],
                ];
            } else {
                return [
                    'success' => false,
                    'message' => $response['message'] ?? 'Failed to initiate PhonePe payment',
                ];
            }
        } catch (\Exception $e) {
            \Log::error('PhonePe Payment Initiation Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ];
        }
    }

    private function initiateEasebuzzPayment($order)
    {
        $user = User::find($order->user_id);
        $orderTransaction = DemoOrdersTransactions::where('order_id', $order->id)->first();

        $txnid = $orderTransaction->trans_code;
        $amount = number_format($order->net_amount, 2, '.', '');
        $ENV = 'prod';

        $postData = [
            'key'        => 'E4WYLD0YYX',
            'salt'       => '1ATVT88UFG',
            'txnid'      => $txnid,
            'amount'     => $amount,
            'productinfo' => 'Order ' . $order->order_code,
            'firstname'  => $user->full_name ?? 'Customer',
            'email'      => $user->email ?? '',
            'phone'      => $user->phone ?? '',
            'surl'       => route('easebuzz.callback'),
            'furl'       => route('easebuzz.callback'),
        ];

        $hashString = $postData['key'] . "|" . $postData['txnid'] . "|" . $postData['amount'] . "|" . $postData['productinfo'] . "|" . $postData['firstname'] . "|" . $postData['email'] . "|||||||||||" . $postData['salt'];
        $postData['hash'] = strtolower(hash("sha512", $hashString));

        $baseUrl = $ENV === 'prod'
            ? "https://pay.easebuzz.in/payment/initiateLink"
            : "https://testpay.easebuzz.in/payment/initiateLink";

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $baseUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);

            $response = curl_exec($ch);

            // dd($response);
            if (curl_errno($ch)) {
                return ['success' => false, 'message' => curl_error($ch)];
            }

            curl_close($ch);

            $res = json_decode($response, true);

            if (isset($res['status']) && intval($res['status']) === 1) {
                $paymentUrl = ($ENV === 'prod'
                    ? "https://pay.easebuzz.in/pay/"
                    : "https://testpay.easebuzz.in/pay/"
                ) . $res['data'];

                return [
                    'success' => true,
                    'payment_url' => $paymentUrl,
                    'raw' => $res
                ];
            }

            return ['success' => false, 'message' => $res['data'] ?? 'Easebuzz error', 'raw' => $res];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function easebuzzCallback(Request $request)
    {
        $payload = $request->all();
        \Log::info('Easebuzz Callback', $payload);

        $txnid = $payload['txnid'] ?? null;
        $status = $payload['status'] ?? null;

        if (!$txnid) {
            return response('Invalid callback', 400);
        }

        $orderTransaction = DemoOrdersTransactions::where('trans_code', $txnid)->first();

        $order = DemoOrders::find($orderTransaction->order_id);
        $user = $order->Users;


        if ($status === 'success') {
            if ($order) {
                $orderTransaction->amountpaid = $order->net_amount;
                $orderTransaction->gatewaytransactionid = $payload['easepayid'] ?? null;
                $orderTransaction->trans_status = "SUCCESS";
                $orderTransaction->remarks = "Payment successful via Easebuzz";
                $orderTransaction->save();

                $order->payment_status = 1;
                $order->order_status = 1;
                $invoice_no = 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                $invoice_date = now();

                $order->invoice_no = $invoice_no;
                $order->invoice_date = $invoice_date;
                $order->save();

                $newOrder = $order->replicate();
                $newOrder->setTable('orders');
                $newOrder->save();

                $order->OrderDetails->each(function ($detail) use ($newOrder) {
                    $newDetail = $detail->replicate();
                    $newDetail->order_id = $newOrder->id;
                    $newDetail->setTable('order_details');
                    $newDetail->save();
                });

                $newTransaction = $orderTransaction->replicate();
                $newTransaction->order_id = $newOrder->id;
                $newTransaction->setTable('orders_transactions');
                $newTransaction->save();


                Carts::where('user_id', $user->id)->delete();
                session()->forget('cart');

                // $brand = "RANGBYBHAVANA"; 
                // $validity = 5; 
                // $mobile = '91' . $order->contact_no; 
                // $var3 = 'https://instagram.com/rang_by_bhavana';
                // $var4 = 'www.rangjewelry.com';

                // $message = "Dear $order->contact_person, Thank you for your order! Your order $order->order_code has been received successfully. We'll notify you once it's shipped. RANG BY BHAVANA $var3 $var4 Thank you";

                // $apiKey = "HbIkrciaNUyvecWAgU7PXA";
                // $senderId = "RANGBB";
                // $route = "5";
                // $templateId = "1007284028019038386";

                // $url = "http://cloud.smsindiahub.in/api/mt/SendSMS?APIKey=$apiKey"
                //  . "&senderid=$senderId&channel=2&DCS=0&flashsms=0"
                //  . "&number=$mobile&text=" . urlencode($message)
                //  . "&route=$route&DLTTemplateId=$templateId";

                // $ch = curl_init();
                // curl_setopt($ch, CURLOPT_URL, $url);
                // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // $smsResponse = curl_exec($ch);
                // $smsError = curl_error($ch);
                // curl_close($ch);

                $html = view('invoice_template', compact('order', 'user'))->render();

                $to = $user->email;
                $subject = "Invoice - Order #{$order->invoice_no}";
                $headers  = "MIME-Version: 1.0\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";

                mail($to, $subject, $html, $headers);

                // ================= ORDER PLACED MAIL =================
                \Log::info("Sending order placed email for order #{$order->id}");

                $orderHeaders  = "MIME-Version: 1.0\r\n";
                $orderHeaders .= "Content-type:text/html;charset=UTF-8\r\n";
                $orderHeaders .= "From: Rukmini Fashions <syjd250oi96g>\r\n";
                $orderHeaders .= "Reply-To: rukmini6869@gmail.com\r\n";

                $mailResult = mail(
                    $user->email,
                    $order->order_email_subject,
                    $order->order_email_body,
                    $orderHeaders
                );

                if ($mailResult) {
                    $order->order_email_sent = 1;
                    $order->save();
                }

                \Log::info("Order mail result", [
                    'order_id' => $order->id,
                    'sent' => $mailResult ? 'YES' : 'NO'
                ]);
            }
            Session::flash('message', 'Order Placed Successfully!');
            Session::flash('alert-class', 'alert-success');
            return redirect()->route('home');
        } else {
            if ($order) {
                $order->payment_status = 2;
                $order->order_status = 5;
                $order->save();

                if ($orderTransaction) {
                    $orderTransaction->trans_status = 'FAILED';
                    $orderTransaction->remarks = "Payment failed via Easebuzz";
                    $orderTransaction->save();
                }
            }

            Session::flash('message', 'Payment failed. Please try again.');
            Session::flash('alert-class', 'alert-danger');

            return redirect()->route('home');
        }
    }


    /**
     * PhonePe Payment Callback Handler
     */
    public function phonepeCallback(Request $request)
    {
        \Log::info('PhonePe Callback Data: ', $request->all());

        try {
            // Get merchant order ID from request or session
            $merchantOrderId = $request->input('orderId') ?? session('phonepe_order_id');

            if (!$merchantOrderId) {
                \Log::error('Merchant transaction ID missing in PhonePe callback.');
                return redirect()->route('home')->with('error', 'Invalid transaction.');
            }

            // Check order status using PhonePe class
            $phonePe = PhonePe::getInstance();
            $statusData = $phonePe->checkOrderStatus($merchantOrderId);

            \Log::info('PhonePe Status Response', $statusData);

            // Extract transaction details
            $transactionStatus = $statusData['state'] ?? 'FAILED';
            $gatewayTxnId = $statusData['paymentDetails'][0]['transactionId'] ?? null;
            $amount = $statusData['amount'] ?? 0;

            \Log::info('PhonePe Transaction Status', [
                'status' => $transactionStatus,
                'gatewayTxnId' => $gatewayTxnId,
                'amount' => $amount
            ]);

            // Find order transaction
            $orderTransaction = DemoOrdersTransactions::where('trans_code', $merchantOrderId)->first();
            if (!$orderTransaction) {
                \Log::error('Order transaction not found for PhonePe callback', ['merchantOrderId' => $merchantOrderId]);
                return redirect()->route('home')->with('error', 'Invalid transaction.');
            }

            $order = DemoOrders::find($orderTransaction->order_id);
            $user = $order->Users;

            if (strtoupper($transactionStatus) === 'COMPLETED') {
                // Payment successful
                $orderTransaction->amountpaid = $amount / 100;
                $orderTransaction->gatewaytransactionid = $gatewayTxnId;
                $orderTransaction->trans_status = "SUCCESS";
                $orderTransaction->remarks = "Payment successful via PhonePe";
                $orderTransaction->save();

                $order->payment_status = 1;
                $order->order_status = 1;
                $invoice_no = 'INV-' . str_pad($order->id, 6, '0', STR_PAD_LEFT);
                $invoice_date = now();

                $order->invoice_no = $invoice_no;
                $order->invoice_date = $invoice_date;
                $order->save();

                // Reduce stock for each order item
                $order_detail = DemoOrderDetails::where('order_id', $order->id)->get();
                if ($order_detail) {
                    foreach ($order_detail as $key => $value) {
                        $stock = Products::Where('id', $value->product_id)->first();

                        $off_avi  = 0;
                        if (isset($value->is_offer)) {
                            if ($value->is_offer == "Yes") {
                                if (isset($value->offer_det_id)) {
                                    $off_sub = OffersSub::Where('id', $value->offer_det_id)->first();
                                    if ($off_sub) {
                                        $off_trans = new OfferTransaction();
                                        $off_trans->order_code   = $order->order_code;
                                        $off_trans->offer = $off_sub->offer;
                                        $off_trans->offer_det_id = $off_sub->id;
                                        $off_trans->product_id = $off_sub->product_id;
                                        $off_trans->att_name = $off_sub->att_name;
                                        $off_trans->att_value = $off_sub->att_value;
                                        $off_trans->previous_qty = $off_sub->qty;
                                        $off_trans->current_qty = $off_sub->qty - $value->order_qty;
                                        $off_trans->date = date('Y-m-d');
                                        $off_trans->save();

                                        $off_sub->qty = $off_sub->qty - $value->order_qty;
                                        $off_sub->save();
                                    }
                                }
                            } else {
                                $off_avi  = 1;
                            }
                        } else {
                            $off_avi  = 1;
                        }

                        if ($off_avi  == 1) {
                            if ($stock && ($stock->onhand_qty != 0)) {
                                $stock_trans = new StockTransactions();
                                $stock_trans->order_code   = $order->order_code;
                                $stock_trans->product_id   = $value->product_id;
                                $stock_trans->att_name     = $value->att_name;
                                $stock_trans->att_value    = $value->att_value;
                                $stock_trans->previous_qty = $stock->onhand_qty;
                                $stock_trans->current_qty  = $stock->onhand_qty - $value->order_qty;
                                $stock_trans->date         = date('Y-m-d');
                                $stock_trans->remarks      = $value->product_title . ' is ordered via PhonePe.';

                                $stock->onhand_qty = $stock->onhand_qty - $value->order_qty;

                                $p_atts = ProductsAttributes::Where('product_id', $value->product_id)->Where('attribute_name', $value->att_name)->Where('attribute_values', $value->att_value)->first();
                                if ($p_atts) {
                                    $stock_trans->att_previous_qty = $p_atts->att_qty;
                                    $stock_trans->att_current_qty  = $p_atts->att_qty - $value->order_qty;

                                    $p_atts->att_qty = $p_atts->att_qty - $value->order_qty;
                                    $p_atts->save();
                                }

                                if ($stock->save() && $stock_trans->save()) {
                                    $sck = 1;
                                }

                                $stock_manag = StockManagement::where('product_id', $value->product_id)->latest()->first();
                                if ($stock_manag) {
                                    $stock_manag->current_qty = $stock->onhand_qty;
                                    $stock_manag->save();
                                }
                            }
                        }
                    }
                }

                // Replicate to main orders table
                $newOrder = $order->replicate();
                $newOrder->setTable('orders');
                $newOrder->save();

                $order->OrderDetails->each(function ($detail) use ($newOrder) {
                    $newDetail = $detail->replicate();
                    $newDetail->order_id = $newOrder->id;
                    $newDetail->setTable('order_details');
                    $newDetail->save();
                });

                $newTransaction = $orderTransaction->replicate();
                $newTransaction->order_id = $newOrder->id;
                $newTransaction->setTable('orders_transactions');
                $newTransaction->save();

                // Clear cart
                Carts::where('user_id', $user->id)->delete();
                session()->forget('cart');
                session()->forget('coupon');

                // Send invoice email
                try {
                    $html = view('invoice_template', compact('order', 'user'))->render();
                    $to = $user->email;
                    $subject = "Invoice - Order #{$order->invoice_no}";
                    $headers  = "MIME-Version: 1.0\r\n";
                    $headers .= "Content-type:text/html;charset=UTF-8\r\n";
                    $headers .= "From: Rukmini Fashions <syjd250oi96g>\r\n";

                    @mail($to, $subject, $html, $headers);
                } catch (\Exception $mailException) {
                    \Log::warning('Failed to send invoice email: ' . $mailException->getMessage());
                }

                // Send order placed email
                try {
                    \Log::info("Sending order placed email for order #{$order->id}");

                    $orderHeaders  = "MIME-Version: 1.0\r\n";
                    $orderHeaders .= "Content-type:text/html;charset=UTF-8\r\n";
                    $orderHeaders .= "From: Rukmini Fashions <syjd250oi96g>\r\n";

                    if (isset($order->order_email_body) && !empty($order->order_email_body)) {
                        $mailResult = @mail(
                            $user->email,
                            $order->order_email_subject ?? 'Order Confirmation',
                            $order->order_email_body,
                            $orderHeaders
                        );

                        if ($mailResult) {
                            $order->order_email_sent = 1;
                            $order->save();
                        }
                    }
                } catch (\Exception $mailException) {
                    \Log::warning('Failed to send order confirmation email: ' . $mailException->getMessage());
                }

                Session::flash('message', 'Order Placed Successfully!');
                Session::flash('alert-class', 'alert-success');
            } else {
                // Payment failed
                $orderTransaction->trans_status = "FAILED";
                $orderTransaction->remarks = "Payment failed via PhonePe: " . ($statusData['message'] ?? 'Unknown error');
                $orderTransaction->save();

                $order->payment_status = 2;
                $order->order_status = 5;
                $order->save();

                Session::flash('message', 'Payment failed. Please try again.');
                Session::flash('alert-class', 'alert-danger');
            }

            // Clear session
            session()->forget(['phonepe_order_id']);

            // Redirect to order view page on success, home on failure
            if (strtoupper($transactionStatus) === 'COMPLETED') {
                return redirect()->route('my_view_orders', $newOrder->id);
            } else {
                return redirect()->route('home');
            }
        } catch (\Exception $e) {
            \Log::error('PhonePe Callback Error: ' . $e->getMessage());
            Session::flash('message', 'An error occurred while processing your payment.');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('home');
        }
    }


    private function getAccessToken($clientId, $clientSecret, $clientVersion)
    {
        $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/v1/oauth/token";

        $data = http_build_query([
            'client_id' => 'TEST-M23GA5VSW3PLX_25091',
            'client_version' => '1',
            'client_secret' => 'MmFmOWRkNWMtYzY3ZC00ZGE2LTkwMzEtZmZiNGM0OGJhNTdj',
            'grant_type' => 'client_credentials',
        ]);

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/x-www-form-urlencoded",
            "Accept: application/json",
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);

        return $result['access_token'] ?? null;
    }


    public function sendCancelEmail(Request $request)
    {
        $data = session()->pull('cancel_email_data');

        if ($data) {
            mail($data['to'], $data['subject'], $data['body'], $data['headers']);
            mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
            return response()->json(['status' => 'sent']);
        }

        return response()->json(['status' => 'no_data']);
    }

    public function sendCheckoutEmail(Request $request)
    {
        $data = session()->get('checkout_email_data');

        if (!empty($data['to']) && !empty($data['subject']) && !empty($data['body'])) {
            @mail($data['to'], $data['subject'], $data['body'], $data['headers'] ?? '');
            @mail($data['to2'], $data['subject'], $data['body'], $data['headers'] ?? '');
            return response()->json(['status' => 'sent']);
        }

        return response()->json(['status' => 'no_data']);
    }


    public function PaymentRequest(Request $request)
    {
        $data = $request->all();
        if (isset($data) && sizeof($data) != 0) {
            return View::make("front_end.payment_request")->with(array('data' => $data));
        } else {
            return redirect()->route('checkout');
        }
    }

    public function PaymentResponse(Request $request)
    {
        $data = $request->all();
        $user = session()->get('user');

        if ($user) {
            if ($user->user_type == 4) {
                if (isset($data) && sizeof($data) != 0) {
                    $order_trans = new OrdersTransactions();
                    $t_max = OrdersTransactions::max('trans_code');
                    $t_max_id = "00001";
                    $t_max_st = "Trans";
                    if ($t_max) {
                        $t_max_no = substr($t_max, 5);
                        $t_increment = (int)$t_max_no + 1;
                        $data['trans_code'] = $t_max_st . sprintf("%05d", $t_increment);
                    } else {
                        $data['trans_code'] = $t_max_st . $t_max_id;
                    }

                    $order = Orders::Where('order_code', $data['orderId'])->first();

                    $order_trans->trans_code = $data['trans_code'];
                    $order_trans->trans_date = $data['txTime'];

                    if ($order) {
                        $order_trans->order_id = $order->id;
                    } else {
                        $order_trans->order_id = $data['orderId'];
                    }

                    $order_trans->net_amount = $data['orderAmount'];

                    if ($data['txStatus'] == "SUCCESS") {
                        $order_trans->amountpaid = "Paid";
                    } else {
                        $order_trans->amountpaid = "Unpaid";
                    }

                    $order_trans->paymentmode = 2;
                    $order_trans->pay_method = $data['paymentMode'];
                    $order_trans->gatewaytransactionid = $data['referenceId'];
                    $order_trans->trans_status = $data['txStatus'];
                    $order_trans->remarks = $data['txMsg'];
                    $order_trans->signature = $data['signature'];
                    $order_trans->is_block = 1;

                    if ($order_trans->save()) {
                        if ($order && ($data['txStatus'] == "SUCCESS")) {
                            $order->payment_status = 1;
                        } else if ($order && ($data['txStatus'] == "FAILED")) {
                            $order->payment_status = 2;
                        } else if ($order && ($data['txStatus'] == "FLAGGED")) {
                            $order->payment_status = 3;
                        } else if ($order && ($data['txStatus'] == "CANCELLED")) {
                            $order->payment_status = 4;
                        } else if ($order && ($data['txStatus'] == "PENDING")) {
                            $order->payment_status = 0;
                        } else {
                            $order->payment_status = 0;
                        }
                        $order->order_status = 1;
                        $order->save();

                        $adm = User::where('user_type', 1)->where('is_block', 1)->first();
                        $admin_email = "info@folkgems.com";
                        if ($adm) {
                            $admin_email = $adm->email;
                        }

                        $logos = \DB::table('logo_settings')->first();
                        $logo_path = 'images/logo';
                        $logo = "";
                        if ($logos) {
                            $logo = asset($logo_path . '/' . $logos->logo_image);
                        } else {
                            $logo = asset('images/logo.png');
                        }

                        $general = \DB::table('general_settings')->first();
                        $site_name = "Folkgems";
                        if ($general) {
                            $site_name = $general->site_name;
                        } else {
                            $site_name = "Folkgems";
                        }

                        $customer_name = "";
                        $contact = "";
                        $address = "";

                        if ($order) {
                            $order_code = $order->order_code;
                            $order_date = date('d-m-Y', strtotime($order->order_date));
                            $net_tot = $order->net_amount;
                            // $tax_tot = $order->tax_amount;
                            $details = "";
                            $order_detail = OrderDetails::Where('is_block', 1)->Where('order_id', $order->id)->get();
                            $sck = 0;
                            $net_comis = 0.00;
                            $net_mer_amt = 0.00;

                            if ($order_detail) {
                                foreach ($order_detail as $key => $value) {
                                    if ($order_trans->trans_status == "SUCCESS") {
                                        $stock = Products::Where('id', $value->product_id)->first();

                                        if ($stock && ($stock->onhand_qty != 0)) {
                                            $stock_trans = new StockTransactions();
                                            $stock_trans->order_code   = $order_code;
                                            $stock_trans->product_id   = $value->product_id;
                                            $stock_trans->att_name     = $value->att_name;
                                            $stock_trans->att_value    = $value->att_value;
                                            $stock_trans->previous_qty = $stock->onhand_qty;
                                            $stock_trans->current_qty  = $stock->onhand_qty - $value->order_qty;
                                            $stock_trans->date         = date('Y-m-d');
                                            $stock_trans->remarks      = $value->product_title . ' is ordered.';

                                            $p_atts = ProductsAttributes::Where('product_id', $value->product_id)->Where('attribute_name', $value->att_name)->Where('attribute_values', $value->att_value)->first();
                                            if ($p_atts) {
                                                $stock_trans->att_previous_qty = $p_atts->att_qty;
                                                $stock_trans->att_current_qty  = $p_atts->att_qty - $value->order_qty;

                                                $p_atts->att_qty = $p_atts->att_qty - $value->order_qty;
                                                $p_atts->save();
                                            }

                                            $stock->onhand_qty = $stock->onhand_qty - $value->order_qty;
                                            if ($stock->save() && $stock_trans->save()) {
                                                $sck = 1;
                                            }
                                        }

                                        if ($stock && $stock->created_user != 1) {
                                            if ($stock->Creatier->user_type == 2 || $stock->Creatier->user_type == 3) {
                                                $com_per = $stock->Creatier->commission;
                                                $t_pce = $value->totalprice;
                                                $admin_com = round($t_pce * ($com_per / 100), 2);
                                                $mer_amt = round($t_pce - $admin_com, 2);

                                                $comis = new AdminCommision();
                                                $comis->order_code   = $order_code;
                                                $comis->order_dets   = $value->id;
                                                $comis->product_id   = $value->product_id;
                                                $comis->att_name     = $value->att_name;
                                                $comis->att_value    = $value->att_value;
                                                $comis->merchant_id  = $stock->Creatier->id;
                                                $comis->amount       = $admin_com;
                                                $comis->merchant_amount = $mer_amt;
                                                $comis->paid_status  = 0;
                                                $comis->remarks      = $value->product_title . ' product against Admin Commision is Rs. ' . $admin_com . ' set.';
                                                $comis->save();

                                                $net_comis = $net_comis + $admin_com;
                                                $net_mer_amt = $net_mer_amt + $mer_amt;
                                            }
                                        }
                                    }

                                    $att_tit = "";
                                    if (isset($value->att_name) && $value->att_name != 0) {
                                        if (isset($value->AttName->att_name) && isset($value->AttValue->att_value)) {
                                            $att_tit = '<span>(' . $value->AttName->att_name . ' : ' . $value->AttValue->att_value . ')</span>';
                                        }
                                    }

                                    $details .= '<tr>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;"> ' . $value->product_title . ' ' . $att_tit . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;"> ' . $value->order_qty . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color:black;border:1px solid #aba7a7;text-align:center;">Rs.  ' . $value->unitprice . '</td>
                                        <td style="padding:10px !important;font-size: 13px !important;font-weight: 600;color: black;border: 1px solid #aba7a7;text-align: center;">Rs.  ' . $value->totalprice . '</td>
                                    </tr>';
                                }
                            }

                            if ($order) {
                                $order->net_commision = $net_comis;
                                $order->net_merchant_amout = $net_mer_amt;
                                $order->save();
                            }

                            if ($sck == 1) {
                                if ($order->shipping_address_flag == 1 && $user) {
                                    $ship = ShippingAddress::Where('user_id', $user->id)->first();
                                    if ($ship) {
                                        $customer_name = $ship->first_name . ' ' . $ship->last_name;
                                        $address = $ship->address . ',' . $ship->City->city_name . ',' . $ship->pincode . ',' . $ship->State->state . ',' . $ship->Country->country_name;
                                        $contact = $ship->contact_no;
                                    } else if ($user) {
                                        $customer_name = $user->first_name . ' ' . $user->last_name;
                                        $address = $user->address1 . ',' . $user->address2 . ',' . $user->City->city_name . ',' . $user->pincode . ',' . $user->State->state . ',' . $user->Country->country_name;
                                        $contact = $user->phone . ',' . $user->phone2;
                                    }
                                } else if ($user) {
                                    $customer_name = $user->first_name . ' ' . $user->last_name;
                                    $address = $user->address1 . ',' . $user->address2 . ',' . $user->City->city_name . ',' . $user->pincode . ',' . $user->State->state . ',' . $user->Country->country_name;
                                    $contact = $user->phone . ',' . $user->phone2;
                                }

                                $name = $user->first_name . ' ' . $user->last_name;
                                $email = $user->email;

                                $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
                                $headers .= "MIME-Version: 1.0\r\n";
                                // $headers.= "From: $admin_email" . "\r\n";
                                $headers .= "From: noreply@folkgems.com" . "\r\n";
                                $to = $email;
                                $to2 = $admin_email;
                                $subject = "Orders Details";

                                $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                                        <div style="margin: 10px 20px; padding: 20px;padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></div>
                                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                                            <h2 style="color: #B73182;margin-top: 0px;">Orders Details</h2>
                                            <table align="center" style=" text-align: center;width: 100%;">
                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $customer_name . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Address</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $address . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $order_code . '</td>
                                                </tr>

                                                <tr>
                                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $order_date . '</td>
                                                </tr>
                                            </table>

                                            <table style="width: 100%;border: 1px solid #222; border-collapse:collapse;">
                                                <tr >
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Product Title</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Quantity</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Price</th>
                                                    <th style="padding: 10px 10px;width:100px;background-color:#d993bdb5;color: #fff;text-align:center;text-transform:uppercase;padding-bottom: 5px;border:1px solid #ccc;font-size: 13px;font-weight: 700;">Total</th>
                                                </tr>' . $details . '
                                                <tr>
                                                    <th colspan="3" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Sub Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $order->total_amount . '</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Shipping Charge</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $order->shipping_charge . '</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">COD Charge</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $order->cod_charge . '</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" style="padding: 10px 10px;width:100px;text-align:right;text-transform:uppercase;padding-bottom:5px;color:black;border:1px solid #aba7a7;padding-right:10px;font-size: 12px;">Net Total</th>
                                                    <td style="padding: 10px 10px;font-size: 13px;font-weight: bold;color: black;border: 1px solid #aba7a7;text-align: right;">Rs. ' . $net_tot . '</td>
                                                </tr>
                                            </table>

                                            <p></p>
                                            <p style="font-size:13px;font-weight:600;">Thank You.</p>
                                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                                            <p style="font-size:13px;font-weight:600;">Thanks & Regards,</p>
                                            <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                                        </div>
                                    </div>';

                                // if(1==1){
                                if (mail($to, $subject, $txt, $headers)) {
                                    mail($to2, $subject, $txt, $headers);
                                    if ($user->phone) {
                                        $text = "Thanks for shopping with us.Plz note the Order Code - " . $order_code . ", Folkgems.com";
                                        $text = urlencode($text);

                                        $curl = curl_init();

                                        // Send the POST request with cURL
                                        curl_setopt_array($curl, array(
                                            CURLOPT_RETURNTRANSFER => 1,
                                            CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                                            CURLOPT_POST => 1,
                                            CURLOPT_CUSTOMREQUEST => 'POST',
                                            CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                                            CURLOPT_POSTFIELDS => array(
                                                'mobile' => $user->phone,
                                                'route' => 'TL',
                                                'text' => $text,
                                                'sender' => 'GJICAM'
                                            )
                                        ));

                                        // Send the request & save response to $response
                                        $response = curl_exec($curl);

                                        // Close request to clear up some resources
                                        curl_close($curl);
                                        $response = json_decode($response);
                                        // Print response

                                        if (isset($response->data->status) && $response->data->status == "success") {
                                            Session::flash('message', 'Order confirmation Message and Email Sent Successfully!');
                                            Session::flash('alert-class', 'alert-success');
                                            Carts::Where('user_id', $user->id)->delete();
                                            session()->forget('cart');
                                        } else {
                                            Session::flash('message', 'Order placed & Email Send Successfully!');
                                            Session::flash('alert-class', 'alert-success');
                                            Carts::Where('user_id', $user->id)->delete();
                                            session()->forget('cart');
                                        }
                                        return redirect()->route('home');
                                    } else {
                                        Session::flash('message', 'Order Placed & Mail Send Successfully!');
                                        Session::flash('alert-class', 'alert-success');

                                        Carts::Where('user_id', $data['user_id'])->delete();
                                        session()->forget('cart');
                                    }
                                    return redirect()->route('home');
                                } else {
                                    if ($user->phone) {
                                        $text = "Thanks for shopping with us.Plz note the Order Code - " . $order_code . ", Folkgems.com";
                                        $text = urlencode($text);

                                        $curl = curl_init();

                                        // Send the POST request with cURL
                                        curl_setopt_array($curl, array(
                                            CURLOPT_RETURNTRANSFER => 1,
                                            CURLOPT_URL => "http://smschub.com/api/sms/format/json",
                                            CURLOPT_POST => 1,
                                            CURLOPT_CUSTOMREQUEST => 'POST',
                                            CURLOPT_HTTPHEADER => array('X-Authentication-Key:01fe318b290f9f9cb686a6bc28a4affa', 'X-Api-Method:MT'),
                                            CURLOPT_POSTFIELDS => array(
                                                'mobile' => $user->phone,
                                                'route' => 'TL',
                                                'text' => $text,
                                                'sender' => 'GJICAM'
                                            )
                                        ));

                                        // Send the request & save response to $response
                                        $response = curl_exec($curl);

                                        // Close request to clear up some resources
                                        curl_close($curl);
                                        $response = json_decode($response);
                                        // Print response

                                        if (isset($response->data->status) && $response->data->status == "success") {
                                            Session::flash('message', 'Order confirmation Message and Email Send Successfully!');
                                            Session::flash('alert-class', 'alert-success');
                                            Carts::Where('user_id', $user->id)->delete();
                                            session()->forget('cart');
                                        } else {
                                            Session::flash('message', 'Order placed Successfully!');
                                            Session::flash('alert-class', 'alert-success');
                                            Carts::Where('user_id', $user->id)->delete();
                                            session()->forget('cart');
                                        }
                                        return redirect()->route('home');
                                    } else {
                                        Session::flash('message', 'Order Placed Successfully!');
                                        Session::flash('alert-class', 'alert-success');

                                        Carts::Where('user_id', $user->id)->delete();
                                        session()->forget('cart');
                                    }
                                    return redirect()->route('home');
                                }
                            } else {
                                Session::flash('message', 'Stock Not Maintained!');
                                Session::flash('alert-class', 'alert-danger');

                                Carts::Where('user_id', $user->id)->delete();
                                session()->forget('cart');

                                return View::make("front_end.payment_response")->with(array('data' => $data));
                            }
                        } else {
                            Session::flash('message', 'Order Placed Successfully!');
                            Session::flash('alert-class', 'alert-danger');
                            Carts::Where('user_id', $user->id)->delete();
                            session()->forget('cart');
                            return redirect()->route('home');
                        }
                    } else {
                        Session::flash('message', 'Order Placed Successfully!');
                        Session::flash('alert-class', 'alert-danger');
                        return redirect()->route('checkout');
                    }
                } else {
                    Session::flash('message', 'Order Placed Successfully!');
                    Session::flash('alert-class', 'alert-danger');
                    return redirect()->route('checkout');
                }
            } else {
                Session::flash('message', 'Order Placed Successfully!');
                Session::flash('alert-class', 'alert-danger');
                return redirect()->route('checkout');
            }
        } else {
            Session::flash('message', 'Order Placed Successfully!');
            Session::flash('alert-class', 'alert-danger');
            return redirect()->route('checkout');
        }
    }

    public function PincodeCheck(Request $request)
    {
        $pincode = 0;
        $error = 1;
        if ($request->ajax() && isset($request->pincode)) {
            $pincode = $request->pincode;
            if ($pincode && strlen($pincode) == 6) {
                $log_shyp = new ShypliteAuth();
                $login_shyp = $log_shyp->authenticatShyplite();
                $login_shyp = json_decode($login_shyp, true);
                // print_r($login_shyp);die();

                if (!isset($login_shyp['error'])) {
                    $timestamp = time();
                    $appID = $log_shyp->appID;
                    $key = $log_shyp->key;
                    $secret = $log_shyp->secret;
                    if (isset($login_shyp['userToken'])) {
                        $secret = $login_shyp['userToken'];
                    }
                    $SellerID = $log_shyp->SellerID;

                    $sign = "key:" . $key . "id:" . $appID . ":timestamp:" . $timestamp;
                    $authtoken = rawurlencode(base64_encode(hash_hmac('sha256', $sign, $secret, true)));
                    $ch = curl_init();

                    $header = array(
                        "x-appid: $appID",
                        "x-timestamp: $timestamp",
                        "x-sellerid:$SellerID",
                        "Authorization: $authtoken"
                    );

                    curl_setopt($ch, CURLOPT_URL, 'https://api.shyplite.com/getserviceability/691021/' . $pincode);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $server_output = curl_exec($ch);
                    // var_dump($server_output);
                    $resp = json_decode($server_output, true);
                    // print_r($resp);
                    // die();
                    $airCod = false;
                    $surfaceCod = false;
                    $surface10kgPrepaid = false;
                    $surface10kgCod = false;
                    $surface5kgPrepaid = false;
                    $surface5kgCod = false;
                    $lite2kgPrepaid = false;
                    $lite2kgCod = false;
                    $lite1kgPrepaid = false;
                    $lite1kgCod = false;
                    $liteHalfKgPrepaid = false;
                    $liteHalfKgCod = false;
                    if (isset($resp['serviceability']['surface10kgPrepaid']) && isset($resp['serviceability']['surface10kgCod']) && isset($resp['serviceability']['surface5kgPrepaid']) && isset($resp['serviceability']['surface5kgCod']) && isset($resp['serviceability']['lite2kgPrepaid']) && isset($resp['serviceability']['lite2kgCod']) && isset($resp['serviceability']['lite1kgPrepaid']) && isset($resp['serviceability']['lite1kgCod']) && isset($resp['serviceability']['lite0.5kgPrepaid']) && isset($resp['serviceability']['lite0.5kgCod'])) {
                        $surface10kgPrepaid = $resp['serviceability']['surface10kgPrepaid'];
                        $surface10kgCod = $resp['serviceability']['surface10kgCod'];
                        $surface5kgPrepaid = $resp['serviceability']['surface5kgPrepaid'];
                        $surface5kgCod = $resp['serviceability']['surface5kgCod'];
                        $lite2kgPrepaid = $resp['serviceability']['lite2kgPrepaid'];
                        $lite2kgCod = $resp['serviceability']['lite2kgCod'];
                        $lite1kgPrepaid = $resp['serviceability']['lite1kgPrepaid'];
                        $lite1kgCod = $resp['serviceability']['lite1kgCod'];
                        $liteHalfKgPrepaid = $resp['serviceability']['lite0.5kgPrepaid'];
                        $liteHalfKgCod = $resp['serviceability']['lite0.5kgCod'];
                    }

                    // if(1==1) {
                    if ($surface10kgPrepaid == TRUE && $surface10kgCod == TRUE && $surface5kgPrepaid == TRUE && $surface5kgCod == TRUE && $lite2kgPrepaid == TRUE && $lite2kgCod == TRUE && $lite1kgPrepaid == TRUE && $lite1kgCod == TRUE && $liteHalfKgPrepaid == TRUE && $liteHalfKgCod == TRUE) {
                        $ava_deliv = 1;
                        $error = "1";
                    } elseif (isset($resp['error'])) {
                        $error = "Delivery Option Not Checked This Time!";
                    } else {
                        $error = "Delivery Not Available for this Pincode!";
                    }
                    curl_close($ch);
                } else {
                    $error = "Delivery Availability Not Checked This Time!";
                }
            } else {
                $error = "Enter Valid Pincode and Pincode Must 6 Numbers only!";
            }
        } else {
            $error = "Enter Valid Pincode and Pincode Must 6 Numbers only!";
        }

        echo $error;
    }

    public function BrandAutoComplete(Request $request)
    {
        $keywrd = "";
        $li = "";
        $error = array('error' => 1);

        if ($request->ajax() && isset($request->keywrd)) {
            $keywrd = $request->keywrd;
            if ($keywrd) {
                $expl = explode(' ', $keywrd);

                $brands = Brands::Where('is_block', 1)->where(function ($q) use ($expl) {
                    foreach ($expl as $ekey => $evalue) {
                        $q->orWhere('brand_name', 'LIKE', '%' . $evalue . '%');
                    }
                })->get();

                if ($brands && sizeof($brands) != 0) {
                    foreach ($brands as $key => $value) {
                        $li .= '<li class="ss_megamenu_lv2 "><a href="' . route('brands_products', ['id' => $value->id]) . '" title="' . $value->brand_name . '">' . $value->brand_name . '</a></li>';
                    }

                    $error = array(
                        'error' => 0,
                        'data' => $li
                    );
                }
            }
        }

        echo json_encode($error);
    }

    public function customise_store(Request $request)
    {

        $data = $request->all();
        $user = session()->get('user');
        $rules = array(
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'phone_number' => 'required|regex:/^[0-9]{10,15}$/',
            'message' => 'required|string',
            'uploaded_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'g-recaptcha-response'    => 'required',
        );

        $messages = [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'message.required' => 'The message field is required.',
            'g-recaptcha-response.required' => 'The capcha field is required.',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect()->route('made_to_order')->withErrors($validator)->withInput();
        } else {

            $img_files = $request->file('uploaded_image');
            $imagePath = null;

            if ($img_files) {
                $file_name = $img_files->getClientOriginalName();
                $date = date('M-Y');
                $file_path = 'images/customise_products/' . $date;
                if (!file_exists($file_path)) {
                    mkdir($file_path, 0777, true);
                }

                $img_files->move($file_path, $file_name);
                $imagePath = 'images/customise_products/' . $date . '/' . $file_name;
            }
            $max = CustomiseProduct::max('order_code');
            $max_id = "00001";
            $max_st = "Order";
            if ($max) {
                $max_no = substr($max, 5);
                $increment = (int)$max_no + 1;
                $order_code = $max_st . sprintf("%05d", $increment);
            } else {
                $order_code = $max_st . $max_id;
            }

            $cust = CustomiseProduct::create([
                'user_id' => $user->id ?? '',
                'order_code' => $order_code,
                'name' => $request->name,
                'email' => $request->email,
                'uploaded_image' => $imagePath,
                'phone_number' => $request->phone_number,
                'message' => $request->message,
                'payment_mode' => 1,
                'payment_status' => 0,
                'order_status' => 1,
            ]);
            // session()->forget('temp_uploaded_image');

            $adm = User::where('user_type', 1)->where('is_block', 1)->first();
            $admin_email = "info@folkgems.com";
            if ($adm) {
                $admin_email = $adm->email;
            }
            $general = \DB::table('general_settings')->first();
            $site_name = "Folkgems";
            if ($general) {
                $site_name = $general->site_name;
            } else {
                $site_name = "Folkgems";
            }
            $logos = \DB::table('logo_settings')->latest()->first();
            $logo_path = 'images/logo';
            $logo = "";
            if ($logos) {
                $logo = asset($logo_path . '/' . $logos->logo_image);
            } else {
                $logo = asset('images/logo.png');
            }
            $name = $request->name;
            $email = $request->email;
            $contact =  $request->phone_number;
            $order_date = Carbon::now();
            $order_code = $cust->order_code;
            $imgUrl = asset($imagePath);
            $headers = "Content-Type: text/html; charset=ISO-8859-1\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            // $headers.= "From: $admin_email" . "\r\n";
            $headers .= "From: Rukmini Fashions <syjd250oi96g>" . "\r\n";
            $headers .= "Reply-To:rukmini6869@gmail.com\r\n";
            $to = $email;
            $to2 = $admin_email;
            $subject = "Your Made-To-Order request for Rukmini Fashions was Received";
            $txt = '<div class="gj_mail" style="width: 600px; padding: 20px 20px; margin: 0 auto; position: relative; ; background-repeat: no-repeat;  background-size: 100% 102%; border:1px solid #ccc; border-radius:20px">
                        <div style="margin: 10px 20px; padding: 20px; padding-top:0; margin-top:0;  border-bottom: 1px solid #B73182;"><a href="' . route('home') . '"><img src="' . $logo . '" style="width: 90px; margin: 0 auto;display: block;"></a></div>
                        <div style="padding: 5px; color: #333;  text-align: center; font-size: 18px;">
                            <p style="font-size:13px;font-weight:600;">Dear ' . $name . ',</p>
                            <p style="font-size:13px;font-weight:600;">We are pleased to inform you that your Made-to-order request has been received by Rukmini Fashions.  We shall revert back to it shortly. 
</p>
                            <table align="center" style=" text-align: center;width: 100%;">
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Customer Name</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $name . '</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Contact No</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $contact . '</td>
                                </tr>
                                  <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Code</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $order_code . '</td>
                                </tr>

                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Order Date</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $order_date . '</td>
                                </tr>
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Message</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : ' . $request->message . '</td>
                                </tr>
                                ' . (!empty($cust->uploaded_image) ? '
                                <tr>
                                    <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Image</th>
                                    <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> <img src="' . $imgUrl . '" alt="Custom Image" style="max-width:100%;height:auto;border:1px solid #ccc;margin-bottom:15px;"></td>
                                </tr>
                                ' : '') . '
                                
                            </table>

                            <p></p>
                            <p style="font-size:14px; line-height: 1.6;">
                                If you have any questions or concerns, please do not hesitate to reach out to our <a href="' . route('contact') . '">customer support team</a>. </p>
                             <div style="padding:10px 0px 0px; border-bottom: 1px solid #ff5c00;"> </div>
                            <p style="font-size:13px;font-weight:600;">Best Regards,</p>
                            <p style="font-size:13px;font-weight:600;"><a href="' . route('home') . '">' . $site_name . '</a></p>
                            <div style="padding: 20px 0; text-align: center;">
                                 <a href="https://www.instagram.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384063.png" alt="Instagram" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="https://wa.me/9633052041" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" alt="WhatsApp" width="20" style="vertical-align: middle;">
                                </a>
                                <a href="mailto:rukmini6869@gmail.com" target="_blank" style="margin: 0 10px; display: inline-block;">
                                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" alt="Email" width="20" style="vertical-align: middle;">
                                </a>
                            </div>
                        </div>
                    </div>';

            //   $mail= mail($to,$subject,$txt,$headers) && mail($to2,$subject,$txt,$headers);
            //     if($mail){
            // <tr>
            //     <th style="text-align:left;text-transform:uppercase;padding-bottom:12px;color:#333;width: 50%;font-size: 12px;font-weight: 900;">Image</th>
            //     <td style="font-size: 12px;font-weight:bold;color:#333;padding-bottom:12px;text-align:left;width: 50%;"> : 
            //         <img src="'.asset($imagePath).'" style="max-width: 100px; border: 1px solid #ccc; padding: 4px; border-radius: 5px;" alt="Uploaded Image">
            //     </td>
            // </tr>

            Session::flash('message', 'Customised Request Has Been Submitted Successfully, Thank you.');
            Session::flash('alert-class', 'alert-success');
            Session::put('email_data', [
                'to' => $email,
                'to2' => $admin_email,
                'subject' => $subject,
                'body' => $txt,
                'headers' => $headers,
            ]);
            return redirect()->route('made_to_order');
            // }

            //   Session::flash('message', 'Customise Product submitted successfully!'); 
            //     Session::flash('alert-class', 'alert-success');
            //     return redirect()->route('all_products');

            // return response()->json(['success' => 'Customise Product submitted successfully']);
        }
    }
    public function sendMadeOrderEmail(Request $request)
    {
        $data = session()->pull('email_data');

        if ($data) {
            mail($data['to'], $data['subject'], $data['body'], $data['headers']);
            mail($data['to2'], $data['subject'], $data['body'], $data['headers']);
            return response()->json(['status' => 'sent']);
        }

        return response()->json(['status' => 'no_data']);
    }

    public function made_to_order()
    {
        $general = GeneralSettings::first();
        return view('front_end.made_to_order', compact('general'));
    }


    public function notification_update(Request $request)
    {
        $value = session()->get('user');
        $user_data = User::find($value->id);

        if (!$user_data) {
            return redirect()->back()->with('error', 'User not found.');
        }

        $data = [
            'order_related' => $request->has('order_related'),
            'newsletter_updates' => $request->has('newsletter_updates'),
            'news_items' => $request->has('news_items'),
        ];

        $user_data->notificationPreference()->updateOrCreate(['user_id' => $user_data->id], $data);
        Session::flash('message', 'Notification Preferences updated successfully.');
        Session::flash('alert-class', 'alert-success');
        return redirect()->route('my_account', ['tab' => 'notifications']);
    }

    public function compareProduct($id)
    {
        $product = Products::with('MainCat')->findOrFail($id);
        $relatedProducts = Products::with('MainCat')->where('main_cat_name', $product->main_cat_name)
            ->where('id', '!=', $product->id)
            ->get();


        return response()->json([
            'product' => $product->toArray(),
            'related' => $relatedProducts->toArray()
        ]);
    }

    public function getAddress(Request $request)
    {
        $address = Address::find($request->address_id);

        if ($address) {
            return response()->json([
                'status' => 'success',
                'data' => $address
            ]);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Address not found']);
        }
    }


    public function addMultipleToCart(Request $request)
    {
        $users = session()->get('user');
        $items = $request->input('items');
        $success = true;
        $messages = [];
        $cart_items = [];
        $wishlist_items = [];

        // dd($items);
        foreach ($items as $item) {
            $product = Products::find($item['product_id']);

            // dd($product);
            if ($product) {
                $quantity = isset($item['quantity']) ? $item['quantity'] : 1;

                if ($quantity > $product->onhand_qty) {
                    $messages[] = "Not enough stock for product: {$product->product_title}. Only {$product->onhand_qty} available.";
                    $success = false;
                    continue;
                }

                $t_price = round(($quantity * $product->discounted_price), 2) +  $product->tax_amount;
                $cart_key = time() . uniqid();
                $cart_del = time();

                $cartItem = new Carts();
                $cartItem->product_id = $product->id;
                $cartItem->user_id = $users->id;
                $cartItem->qty = $quantity;
                $cartItem->original_price = $product->original_price;
                $cartItem->product_cost = $product->product_cost;
                $cartItem->discounted_price = $product->discounted_price;
                $cartItem->price = $product->product_cost;
                $cartItem->tax_amount = $product->tax_amount;
                $cartItem->total_price = $t_price;
                $cartItem->att_name = $product->att_name;
                $cartItem->att_value = $product->att_value;
                $cartItem->tax = $product->tax;
                $cartItem->tax_type = $product->tax_type;
                $cartItem->service_charge = $product->service_charge;
                $cartItem->shiping_charge = $product->shiping_charge;
                $cartItem->image = $product->featured_product_img;
                $cartItem->name = $product->product_title;
                $cartItem->notes = '';
                $cartItem->is_offer = 'No';
                $cartItem->offer_id = null;
                $cartItem->offer_det_id = null;
                $cartItem->cart_key = $cart_key;
                $cartItem->cart_del = $cart_del;
                $cartItem->save();
                $cart_items[] = $cartItem;
                $wishlistItem = Wishlist::where('user_id', $users->id)
                    ->where('product_id', $product->id)
                    ->first();

                if ($wishlistItem) {
                    $wishlistItem->delete();
                    $wishlist_items[] = $product->product_title;
                }
            } else {
                $messages[] = "Product with ID {$item['product_id']} not found.";
                $success = false;
            }
        }

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Items Added To Cart Successfully!',
                'cart_items' => $cart_items,
                'removed_from_wishlist' => $wishlist_items
            ]);
        } else {
            return response()->json([
                'error' => 'Some products could not be added to the cart due to out of stock .',
                'messages' => $messages
            ], 400);
        }
    }

    // or validation issues

    public function deleteMultipleFromWishlist(Request $request)
    {
        $wishlistIds = $request->input('items');
        $users = session()->get('user');
        if (empty($wishlistIds)) {
            return response()->json([
                'success' => false,
                'error' => 'No items selected for deletion.'
            ], 400);
        }

        $success = true;
        $messages = [];

        foreach ($wishlistIds as $wishlistId) {
            $wishlistItem = Wishlist::where('product_id', $wishlistId)->where('user_id', $users->id);
            if ($wishlistItem) {
                $wishlistItem->delete();
            } else {
                $success = false;
                $messages[] = "Wishlist item with ID {$wishlistId} not found.";
            }
        }

        if ($success) {
            return response()->json([
                'success' => true,
                'message' => 'Selected items deleted from wishlist.'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Some items could not be deleted.',
                'messages' => $messages
            ], 400);
        }
    }

    public function buyNow(Request $request)
    {
        $user = session()->get('user');

        if (!$user) {
            Session::flash('message', 'Kindly Sign In to continue using Rukmini Fashions');
            Session::flash('alert-class', 'alert-danger');

            return response()->json([
                'status' => 'unauthenticated',
                'redirect_url' => route('signin')
            ]);
        }


        $product = Products::where('id', $request->product_id)->first();
        if (!$product) {
            return response()->json(['status' => 'error', 'message' => 'Product not found.']);
        }

        $qty = $request->quantity ?? 1;
        $product_cost = $product->product_cost;
        $cart_key = time() . uniqid();
        $cart_del = time();

        if ($product->discounted_price > 0) {
            $total = round(($qty * $product->discounted_price), 2) + $product->tax_amount;
            $disc_cost = $product->discounted_price;
        } else {
            $total = round(($qty * $product->product_cost), 2) + $product->tax_amount;
            $disc_cost = $product->product_cost;
        }

        $existingCart = Carts::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingCart) {
            $existingCart->qty += $qty;
            $existingCart->total_price = round(($existingCart->qty * $product_cost), 2);
            $existingCart->cart_del = $cart_del;
            $existingCart->save();
        } else {
            // Create a new cart entry
            $cart = new Carts();
            $cart->user_id = $user->id;
            $cart->product_id = $product->id;
            $cart->name = $product->product_title;
            $cart->product_cost = $product_cost;
            $cart->original_price = $product->original_price;
            $cart->discounted_price = $disc_cost;
            $cart->price = $product->product_cost;
            $cart->total_price = $total;
            $cart->tax_amount = $product->tax_amount;
            $cart->tax = $product->tax;
            $cart->tax_type = $product->tax_type;
            $cart->shiping_charge = $product->shiping_charge ?? 0;
            $cart->service_charge = $product->service_charge ?? 0;
            $cart->qty = $qty;
            $cart->image = $product->featured_product_img;
            $cart->notes = NULL;
            $cart->is_offer = 'No';
            $cart->offer_id = NULL;
            $cart->offer_det_id = NULL;
            $cart->cart_key = $cart_key;
            $cart->cart_del = $cart_del;
            $cart->save();
        }

        return response()->json(['status' => 'success']);
    }

    public function apply_coupon(Request $request)
    {
        $user = session()->get('user');
        $coupon = Coupon::where('code', $request->coupon_code)->where('status', 1)->first();

        if (!$coupon) {
            return response()->json(['success' => false, 'message' => 'Applied Coupon is not valid anymore, Thank you !']);
        }

        $today = now()->format('Y-m-d');

        if ($coupon->start_date && $today < $coupon->start_date) {
            return response()->json(['success' => false, 'message' => 'Coupon not active yet.']);
        }

        if ($coupon->end_date && $today > $coupon->end_date) {
            return response()->json(['success' => false, 'message' => 'Coupon expired.']);
        }

        // Global usage limit
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json(['success' => false, 'message' => 'Coupon usage limit reached.']);
        }

        // Per user usage limit (assumes you have `coupon_user` pivot table or a `CouponUsage` model)
        if ($user) {
            $alreadyUsed = CouponUsage::where('user_id', $user->id)
                ->where('coupon_code', $coupon->code)
                ->exists();

            if ($alreadyUsed) {
                return response()->json(['success' => false, 'message' => 'You have already used this coupon.']);
            }
        }

        $cart = session('cart') ?? [];
        $cartTotal = 0;

        // Optional: Check if coupon is restricted to specific products/categories
        $applicable = false;
        foreach ($cart as $item) {
            $price = $item['discounted_price'] > 0 ? $item['discounted_price'] : $item['product_cost'];
            $lineTotal = $item['qty'] * $price;

            // Check if coupon is applicable to any of the product/category
            if (
                !$coupon->applicable_products ||
                in_array($item['product_id'], $coupon->applicable_products) ||
                ($coupon->applicable_categories && in_array($item['category_id'], $coupon->applicable_categories))
            ) {
                $applicable = true;
                $cartTotal += $lineTotal;
            }
        }

        // if (!$applicable) {
        //     return response()->json(['success' => false, 'message' => 'Coupon not applicable to items in your cart.']);
        // }

        if ($coupon->min_cart_amount && $cartTotal < $coupon->min_cart_amount) {
            return response()->json(['success' => false, 'message' => 'Minimum cart amount not met.']);
        }

        // Calculate discount
        $discount = $coupon->type === 'fixed'
            ? $coupon->value
            : ($cartTotal * $coupon->value / 100);

        session([
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => round($discount, 2)
            ]
        ]);

        $html = view('front_end.cart', [
            'code' => $coupon->code,
            'discount' => round($discount, 2)
        ])->render();

        return response()->json([
            'success' => true,
            'discount' => round($discount, 2),
            'html' => $html
        ]);
    }


    public function remove_coupon(Request $request)
    {
        session()->forget('coupon');


        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }

        return redirect()->back();
    }

    public function getShippingCharge(Request $request)
    {
        $isIndian = true;
        $pincode = $request->pincode;

        if ($pincode) {
            $isIndian = preg_match('/^\d{6}$/', $pincode);
        } elseif ($request->address_id) {
            $address = Address::find($request->address_id);
            if ($address && isset($address->country_code)) {
                $isIndian = strtoupper($address->country_code) === 'IN';
            }
        }

        $cart = session('cart') ?? [];

        $shippingCharges = [];
        foreach ($cart as $item) {
            $product = Products::find($item['product_id']);
            if ($product) {
                $shippingCharges[$product->id] = $isIndian
                    ? $product->shipping_charge
                    : $product->inter_shipping_charge;
            }
        }

        return response()->json([
            'status' => 'success',
            'shipping_charges' => $shippingCharges
        ]);
    }
}
