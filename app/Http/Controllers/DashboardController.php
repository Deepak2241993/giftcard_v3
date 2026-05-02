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
use App\Models\Employee;
use App\Models\ServiceUnit;
use App\Models\Banner;
use App\Models\TransactionHistory;
use AuthenticatesUsers;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class DashboardController extends Controller
{
    public function employeeDashboard()
    {
        $user = Auth::user();
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
    $TotalTransactions     = TransactionHistory::count();
    $transactioncompleted = TransactionHistory::where('payment_status', 'paid')->count();
    $TransactionPending   = TransactionHistory::whereNull('payment_status')->count();
    $transactioncancelled = TransactionHistory::whereNotNull('payment_status')
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

   
        // --------------------------------------------------
        // RETURN VIEW
        // --------------------------------------------------
        
        return view('employee.dashboard', compact(
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
        'TotalTransactions', 'transactioncompleted', 'TransactionPending', 'transactioncancelled',

        // Most-sold products + product-wise sales
        'topProducts', 'productSalesReport',

        // Campaign / deals revenue
        'campaignRevenue', 'totalDealsRevenue',
        // Giftcard metrics
            'totalGiftcardsSold','totalGiftcardsRedeemed','totalGiftcardsCancelled','redemptionRatio','soldValue','redeemedValue','trendMonths','trendCount',
            //  For Giftcard Redeem Status
            // 'notRedeemed',
            // 'partialRedeemed',
            // 'fullyRedeemed',
        ));
    }



    







    // For Admin Dashboard
    public function adminDashboard( GiftcardRedeem $redeem, User $user, GiftcardsNumbers $number, Giftsend $giftsend) {

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
    $TotalTransactions     = TransactionHistory::count();
    $transactioncompleted = TransactionHistory::where('payment_status', 'paid')->count();
    $TransactionPending   = TransactionHistory::whereNull('payment_status')->count();
    $transactioncancelled = TransactionHistory::whereNotNull('payment_status')
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

 // Giftcard status summary
        $giftcardStatus = DB::table('giftcards_numbers')
            ->select(
                'giftnumber',
                DB::raw("SUM(CASE WHEN amount > 0 THEN amount ELSE 0 END) as total_purchase"),
                DB::raw("SUM(CASE WHEN amount < 0 THEN ABS(amount) ELSE 0 END) as total_redeem")
            )
            ->groupBy('giftnumber')
            ->get();

        $notRedeemed = 0;
        $partialRedeemed = 0;
        $fullyRedeemed = 0;

        foreach ($giftcardStatus as $card) {

            $purchase = $card->total_purchase;
            $redeem   = $card->total_redeem;
            $remaining = $purchase - $redeem;

            if ($redeem == 0) {
                $notRedeemed++;
            } elseif ($remaining == 0) {
                $fullyRedeemed++;
            } else {
                $partialRedeemed++;
            }
        }


        // For Service Redeem Status

// STEP 1: Summary Query (Correct)
$redeems = DB::table('service_redeems')
    ->select(
        'order_id',
        'product_id',
        DB::raw('SUM(number_of_session_use) as total_redeem')
    )
    ->groupBy('order_id', 'product_id');


$services = DB::table('service_orders as so')
    ->leftJoinSub($redeems, 'sr', function ($join) {
        $join->on('so.order_id', '=', 'sr.order_id')
             ->on('so.service_id', '=', 'sr.product_id');
    })
    ->select(
        'so.order_id',
        'so.service_id',
        DB::raw('SUM(so.qty) as total_purchase'),
        DB::raw('COALESCE(sr.total_redeem,0) as total_redeem')
    )
    ->where(function($q){
        $q->where('so.is_deleted', 0)
          ->orWhereNull('so.is_deleted');
    })
    ->groupBy('so.order_id', 'so.service_id', 'sr.total_redeem')
    ->get();


$totalPurchasedServices   = $services->count();
$notRedeemedServices      = 0;
$partialRedeemedServices  = 0;
$fullyRedeemedServices    = 0;

foreach ($services as $s) {

    $purchase = (int) $s->total_purchase;
    $redeem   = (int) $s->total_redeem;

    if ($redeem == 0) {
        $notRedeemedServices++;
    } elseif ($purchase == $redeem) {
        $fullyRedeemedServices++;
    } else {
        $partialRedeemedServices++;
    }
}

// For Units Sold vs Redeemed (Product-wise)
$redeemSub = DB::table('service_redeems')
    ->select(
        'service_order_id',
        DB::raw('SUM(IFNULL(number_of_session_use,0)) as used_sessions')
    )
    ->groupBy('service_order_id');

$units = DB::table('service_orders as so')
    ->join('service_units as su', 'su.id', '=', 'so.service_id')

    // ✅ FIX: use subquery instead of direct join
    ->leftJoinSub($redeemSub, 'sr', function ($join) {
        $join->on('sr.service_order_id', '=', 'so.id');
    })

    ->where('su.product_is_deleted', 0)

    ->select(
        'so.service_id',
        'su.product_name',

        DB::raw('COUNT(DISTINCT so.id) as total_sales'),

        DB::raw('SUM(IFNULL(so.number_of_session,0)) as total_sessions'),

        DB::raw('SUM(IFNULL(sr.used_sessions,0)) as used_sessions'),

        DB::raw('
            SUM(IFNULL(so.number_of_session,0)) 
            - SUM(IFNULL(sr.used_sessions,0)) 
            as remaining_sessions
        '),

        DB::raw('SUM(IFNULL(so.qty,0) * IFNULL(so.discounted_amount,0)) as total_revenue')
    )
    ->groupBy('so.service_id', 'su.product_name')
    ->get();
// dd($units);
    
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
        'TotalTransactions', 'transactioncompleted', 'TransactionPending', 'transactioncancelled',

        // Most-sold products + product-wise sales
        'topProducts', 'productSalesReport',

        // Campaign / deals revenue
        'campaignRevenue', 'totalDealsRevenue',
        // Giftcard metrics
            'totalGiftcardsSold','totalGiftcardsRedeemed','totalGiftcardsCancelled','redemptionRatio','soldValue','redeemedValue','trendMonths','trendCount'
            ,// For Giftcard Redeem Status
            'notRedeemed','partialRedeemed','fullyRedeemed',
            // For Service Redeem Status
            'totalPurchasedServices',
            'notRedeemedServices',
            'partialRedeemedServices',
            'fullyRedeemedServices',
            'units'
    ));
}



public function UnitHistoryOfPatient(Request $request, $unitid)
{
    $type = $request->type; // 👈 get filter

    $redeemSub = DB::table('service_redeems')
        ->select(
            'service_order_id',
            DB::raw('SUM(IFNULL(number_of_session_use,0)) as used_sessions')
        )
        ->groupBy('service_order_id');

    $query = DB::table('service_orders as so')
        ->leftJoin('service_units as su', 'su.id', '=', 'so.service_id')
        ->leftJoin('transaction_histories as th', 'th.order_id', '=', 'so.order_id')
        ->leftJoin('patients as p', 'p.id', '=', 'th.patient_login_id')
        ->leftJoinSub($redeemSub, 'sr', function ($join) {
            $join->on('sr.service_order_id', '=', 'so.id');
        })
        ->select(
            'so.id',
            'so.service_id',
            'so.qty',
            'so.number_of_session',
            'so.order_id',
            'su.product_name',

            DB::raw('COALESCE(p.fname, th.fname) as first_name'),
            DB::raw('COALESCE(p.lname, th.lname) as last_name'),
            DB::raw('COALESCE(p.email, th.email) as email'),
            DB::raw('COALESCE(p.phone, th.phone) as phone'),

            'th.payment_status',
            'th.payment_intent',

            DB::raw('
                IFNULL(so.number_of_session,0) 
                - IFNULL(sr.used_sessions,0) 
                as remaining_sessions
            ')
        );

    // ✅ Apply filters
    if ($type == 'not_redeemed') {
        $query->whereRaw('IFNULL(sr.used_sessions,0) = 0');
    }

    if ($type == 'partial') {
        $query->whereRaw('IFNULL(sr.used_sessions,0) > 0 
                          AND IFNULL(sr.used_sessions,0) < IFNULL(so.number_of_session,0)');
    }

    if ($type == 'full') {
        $query->whereRaw('IFNULL(sr.used_sessions,0) >= IFNULL(so.number_of_session,0)');
    }

    // optional unit filter (keep your existing logic safe)
    if ($unitid != 0) {
        $query->where('so.service_id', $unitid);
    }

    $data = $query->orderBy('so.id', 'desc')->get();

    return view('admin.dashboard.unit_history_of_patient', compact('data'));
}

}
