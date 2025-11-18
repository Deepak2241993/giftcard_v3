<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GiftcardsNumbers;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\GiftCoupon;
use App\Models\Giftsend;
use App\Models\ServiceOrder;
use App\Models\GiftcardRedeem;
use App\Models\Search_keyword;
use App\Models\ServiceRedeem;
use App\Models\TransactionHistory;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

   public function root(
    GiftcardRedeem $redeem,
    User $user,
    GiftcardsNumbers $number,
    Giftsend $giftsend
) {
    if (Auth::user()->user_type != 1) {
        abort(403);
    }

    // -----------------------------------------------------------------
    // COMMON DATES / YEAR VARIABLES
    // -----------------------------------------------------------------
    $now           = now();
    $today         = $now->copy()->startOfDay();
    $yesterday     = $today->copy()->subDay();
    $sevenDaysAgo  = $now->copy()->subDays(7);
    $lastMonthDate = $now->copy()->subMonth();

    $currentMonth  = (int) $now->format('m');
    $currentYear   = (int) $now->format('Y');
    $lastYear      = (int) $lastMonthDate->format('Y');

    // -----------------------------------------------------------------
    // BASIC DASHBOARD NUMBERS
    // -----------------------------------------------------------------
    $cardnumbers           = GiftcardsNumbers::distinct('giftnumber')->count();
    $alltransaction        = Giftsend::count();
    $successTransaction    = Giftsend::where('payment_status', 'succeeded')->count();
    $faildTransaction      = Giftsend::where('payment_status', 'payment_failed')
                                ->orWhereNull('payment_status')
                                ->count();
    $processingTransaction = Giftsend::where('payment_status', 'processing')->count();
    $giftCoupon            = GiftCoupon::count();
    $ProductCategory       = ProductCategory::count();
    $Product               = Product::count();
    $user                  = User::where('user_type', 1)->count();
    $search_keyword        = Search_keyword::count();
    $cancel_deals          = ServiceRedeem::where('status', 0)->count();
    $TotalServiceSale      = TransactionHistory::where('payment_status', 'paid')->count();

    // -----------------------------------------------------------------
    // GIFT CARD TRANSACTION COUNTS
    // -----------------------------------------------------------------
    $todayGiftcards     = Giftsend::where('payment_status', 'succeeded')
                            ->whereDate('created_at', $today)
                            ->count();

    $yesterdayGiftcards = Giftsend::where('payment_status', 'succeeded')
                            ->whereDate('created_at', $yesterday)
                            ->count();

    $last7DaysGiftcards = Giftsend::where('payment_status', 'succeeded')
                            ->where('created_at', '>=', $sevenDaysAgo)
                            ->count();

    $lastMonthGiftcards = Giftsend::where('payment_status', 'succeeded')
                            ->whereMonth('created_at', $lastMonthDate->month)
                            ->whereYear('created_at', $lastMonthDate->year)
                            ->count();

    $thisMonthGiftcards = Giftsend::where('payment_status', 'succeeded')
                            ->whereMonth('created_at', $currentMonth)
                            ->whereYear('created_at', $currentYear)
                            ->count();

    // -----------------------------------------------------------------
    // SERVICE SALES COUNTS (ORDERS)
    // -----------------------------------------------------------------
    $todayServiceSales      = TransactionHistory::where('payment_status', 'paid')
                                    ->whereDate('created_at', $today)
                                    ->count();

    $yesterdayServiceSales  = TransactionHistory::where('payment_status', 'paid')
                                    ->whereDate('created_at', $yesterday)
                                    ->count();

    $last7DaysServiceSales  = TransactionHistory::where('payment_status', 'paid')
                                    ->where('created_at', '>=', $sevenDaysAgo)
                                    ->count();

    $lastMonthServiceSales  = TransactionHistory::where('payment_status', 'paid')
                                    ->whereMonth('created_at', $lastMonthDate->month)
                                    ->whereYear('created_at', $lastMonthDate->year)
                                    ->count();

    $thisMonthServiceSales  = TransactionHistory::where('payment_status', 'paid')
                                    ->whereMonth('created_at', $currentMonth)
                                    ->whereYear('created_at', $currentYear)
                                    ->count();

    // -----------------------------------------------------------------
    // GIFT CARD SALES AMOUNT + GROWTH (THIS MONTH vs LAST MONTH)
    // -----------------------------------------------------------------
    $totalGiftcardSales = Giftsend::where('payment_status', 'succeeded')
                            ->sum('amount');

    $thisMonthGiftcardSales = Giftsend::where('payment_status', 'succeeded')
                                ->whereMonth('created_at', $currentMonth)
                                ->whereYear('created_at', $currentYear)
                                ->sum('amount');

    $lastMonthGiftcardSales = Giftsend::where('payment_status', 'succeeded')
                                ->whereMonth('created_at', $lastMonthDate->month)
                                ->whereYear('created_at', $lastMonthDate->year)
                                ->sum('amount');

    $giftcardSalesGrowth = $lastMonthGiftcardSales > 0
        ? (($thisMonthGiftcardSales - $lastMonthGiftcardSales) / $lastMonthGiftcardSales) * 100
        : 100;

    // -----------------------------------------------------------------
    // YEAR-OVER-YEAR GIFT CARD SALES (BAR CHART)
    // -----------------------------------------------------------------
    $currentYearSales = Giftsend::selectRaw('SUM(amount) as total, MONTH(created_at) as month')
        ->where('payment_status', 'succeeded')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->pluck('total', 'month');

    $lastYearSales = Giftsend::selectRaw('SUM(amount) as total, MONTH(created_at) as month')
        ->where('payment_status', 'succeeded')
        ->whereYear('created_at', $lastYear)
        ->groupBy('month')
        ->pluck('total', 'month');

    $monthsList = collect(range(1, 12))->map(function ($m) {
        return date('M', mktime(0, 0, 0, $m, 1));
    });

    $currentYearData = collect(range(1, 12))->map(function ($m) use ($currentYearSales) {
        return $currentYearSales[$m] ?? 0;
    });

    $lastYearData = collect(range(1, 12))->map(function ($m) use ($lastYearSales) {
        return $lastYearSales[$m] ?? 0;
    });

    // -----------------------------------------------------------------
    // YEAR-OVER-YEAR SERVICE SALES (BAR CHART)
    // -----------------------------------------------------------------
    $currentYearServiceSales = TransactionHistory::selectRaw('SUM(transaction_amount) as total, MONTH(created_at) as month')
        ->where('payment_status', 'paid')
        ->whereYear('created_at', $currentYear)
        ->groupBy('month')
        ->pluck('total', 'month');

    $lastYearServiceSales = TransactionHistory::selectRaw('SUM(transaction_amount) as total, MONTH(created_at) as month')
        ->where('payment_status', 'paid')
        ->whereYear('created_at', $lastYear)
        ->groupBy('month')
        ->pluck('total', 'month');

    $serviceMonthsList = collect(range(1, 12))->map(function ($m) {
        return date('M', mktime(0, 0, 0, $m, 1));
    });

    $serviceCurrentYearData = collect(range(1, 12))->map(function ($m) use ($currentYearServiceSales) {
        return $currentYearServiceSales[$m] ?? 0;
    });

    $serviceLastYearData = collect(range(1, 12))->map(function ($m) use ($lastYearServiceSales) {
        return $lastYearServiceSales[$m] ?? 0;
    });

    // -----------------------------------------------------------------
    // ORDER-TRACKING METRICS (FOR PIE CHARTS)
    // -----------------------------------------------------------------
    // Giftcard orders
    $giftcardTotalOrders     = Giftsend::count();
    $giftcardCompletedOrders = $successTransaction; // already counted
    $giftcardPendingOrders   = Giftsend::where('payment_status', 'processing')->count();
    $giftcardCancelledOrders = Giftsend::where('payment_status', 'payment_failed')
                                    ->orWhereNull('payment_status')
                                    ->count();

    // Service orders (TransactionHistory)
    $serviceTotalOrders     = TransactionHistory::count();
    $serviceCompletedOrders = TransactionHistory::where('payment_status', 'paid')->count();
    $servicePendingOrders   = TransactionHistory::whereNull('payment_status')->count();
    $serviceCancelledOrders = TransactionHistory::whereNotNull('payment_status')
                                ->where('payment_status', '!=', 'paid')
                                ->count();
    // (Adjust the above status logic if you use explicit "pending / cancelled" values)

    // -----------------------------------------------------------------
    // MOST SOLD PRODUCTS + PRODUCT-WISE SALES REPORT
    // -----------------------------------------------------------------
    $completedOrders = TransactionHistory::where('payment_status', 'paid')
                        ->pluck('order_id');

    $productsQuery = ServiceOrder::select(
            'service_orders.service_id',
            'products.product_name',
            'product_categories.cat_name',
            DB::raw('SUM(service_orders.qty) as total_qty'),
            DB::raw('SUM(service_orders.discounted_amount * service_orders.qty) as total_revenue')
        )
        ->join('products', 'products.id', '=', 'service_orders.service_id')
        ->leftJoin('product_categories', 'product_categories.id', '=', 'products.cat_id')
        ->whereIn('service_orders.order_id', $completedOrders)
        ->where('service_orders.is_deleted', 0)
        ->groupBy('service_orders.service_id', 'products.product_name', 'product_categories.cat_name')
        ->orderByDesc('total_qty');

    // Top 5 products for "Most Sold Products" widget
    $topProducts = $productsQuery->take(5)->get();

    // Full product-wise sales report (if needed elsewhere)
    $productSalesReport = $productsQuery->get();

    // -----------------------------------------------------------------
    // CAMPAIGN / CATEGORY REVENUE BREAKDOWN
    // -----------------------------------------------------------------
    $campaignRevenue = ServiceOrder::select(
            'product_categories.cat_name',
            DB::raw('SUM(service_orders.discounted_amount * service_orders.qty) as total_revenue')
        )
        ->join('products', 'products.id', '=', 'service_orders.service_id')
        ->leftJoin('product_categories', 'product_categories.id', '=', 'products.cat_id')
        ->whereIn('service_orders.order_id', $completedOrders)
        ->where('service_orders.is_deleted', 0)
        ->groupBy('product_categories.cat_name')
        ->orderByDesc('total_revenue')
        ->get();

    $totalDealsRevenue = $campaignRevenue->sum('total_revenue');


    // -----------------------------------------------------------------
    // Giftcard Total Sales
    // -----------------------------------------------------------------
    $totalGiftcardsSold = GiftcardsNumbers::where(function($q){
            $q->where('transaction_id', 'LIKE', 'card_%')    // Online
            ->orWhere('transaction_id', 'LIKE', 'FEMS-%'); // Offline
        })
        ->count();
    // -----------------------------------------------------------------
    // Giftcard: Total Redeemed
    // -----------------------------------------------------------------
    $totalGiftcardsRedeemed = GiftcardsNumbers::where('transaction_id', 'LIKE', 'REDEEM%')
        ->count();

    // -----------------------------------------------------------------
    // Giftcard: Total Cancelled
    // -----------------------------------------------------------------
    $totalGiftcardsCancelled = GiftcardsNumbers::where('transaction_id', 'LIKE', 'CANCEL%')
        ->count();


    // -----------------------------------------------------------------
    // Redemption Ratio
    // -----------------------------------------------------------------
    $redemptionRatio = $totalGiftcardsSold > 0
        ? round(($totalGiftcardsRedeemed / $totalGiftcardsSold) * 100, 2)
        : 0;

    // -----------------------------------------------------------------
    // Total Monetary Sold vs Redeemed
    // -----------------------------------------------------------------
    $soldValue = GiftcardsNumbers::where(function($q){
            $q->where('transaction_id', 'LIKE', 'card_%')
            ->orWhere('transaction_id', 'LIKE', 'FEMS-%');
        })->sum('actual_paid_amount');

    $redeemedValue = GiftcardsNumbers::where('transaction_id', 'LIKE', 'REDEEM%')
        ->sum('amount');

    // -----------------------------------------------------------------
    // Last 12-Month Redemption Trends
    // -----------------------------------------------------------------

    $redemptionTrend = GiftcardsNumbers::selectRaw("
            COUNT(id) as total_redeemed,
            MONTH(created_at) as month
        ")
        ->where('transaction_id', 'LIKE', 'REDEEM%')
        ->where('created_at', '>=', now()->subMonths(12))
        ->groupBy('month')
        ->orderBy('month')
        ->pluck('total_redeemed','month');

    $trendMonths = collect(range(1,12))->map(fn($m) => date("M", mktime(0,0,0,$m,1)));
    $trendCount  = collect(range(1,12))->map(fn($m) => $redemptionTrend[$m] ?? 0);



    // -----------------------------------------------------------------
    // RETURN VIEW
    // -----------------------------------------------------------------
    return view('admin.admin_dashboad', compact(

        // Basic counts
        'cancel_deals', 'TotalServiceSale', 'cardnumbers', 'alltransaction', 'user',
        'successTransaction', 'faildTransaction', 'processingTransaction', 'giftCoupon',
        'ProductCategory', 'Product', 'search_keyword',

        // Giftcard counts
        'todayGiftcards', 'yesterdayGiftcards', 'last7DaysGiftcards',
        'lastMonthGiftcards', 'thisMonthGiftcards',

        // Service sales counts
        'todayServiceSales', 'yesterdayServiceSales', 'last7DaysServiceSales',
        'lastMonthServiceSales', 'thisMonthServiceSales',

        // Giftcard revenue
        'totalGiftcardSales', 'thisMonthGiftcardSales', 'lastMonthGiftcardSales',
        'giftcardSalesGrowth',

        // Giftcard YoY chart data
        'monthsList', 'currentYearData', 'lastYearData',

        // Service YoY chart data
        'serviceMonthsList', 'serviceCurrentYearData', 'serviceLastYearData',

        // Order-tracking metrics (for pie charts)
        'giftcardTotalOrders', 'giftcardCompletedOrders', 'giftcardPendingOrders', 'giftcardCancelledOrders',
        'serviceTotalOrders', 'serviceCompletedOrders', 'servicePendingOrders', 'serviceCancelledOrders',

        // Most-sold products + product-wise sales
        'topProducts', 'productSalesReport',

        // Campaign / deals revenue
        'campaignRevenue', 'totalDealsRevenue',
        // Giftcard metrics
            'totalGiftcardsSold','totalGiftcardsRedeemed','totalGiftcardsCancelled','redemptionRatio','soldValue','redeemedValue','trendMonths','trendCount'
    ));
}




   
    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            return response()->json([
                'isSuccess' => true,
                'Message' => "User Details Updated successfully!"
            ], 200); // Status code here
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            return response()->json([
                'isSuccess' => true,
                'Message' => "Something went wrong!"
            ], 200); // Status code here
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }


    public function ProductDashboard(){
        return view('admin.product_dashboard');
    }

  
}
