<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\GiftcardsNumbers;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\GiftCoupon;
use App\Models\Giftsend;
use App\Models\GiftcardRedeem;
use App\Models\Search_keyword;
use App\Models\ServiceRedeem;
use App\Models\TransactionHistory;

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
    if (Auth::user()->user_type == 1) {

        // -----------------------------
        // BASIC DASHBOARD NUMBERS
        // -----------------------------
        $cardnumbers            = GiftcardsNumbers::distinct('giftnumber')->count();
        $alltransaction         = Giftsend::count();
        $successTransaction     = Giftsend::where('payment_status', 'succeeded')->count();
        $faildTransaction       = Giftsend::where('payment_status', 'payment_failed')
                                    ->orWhereNull('payment_status')
                                    ->count();
        $processingTransaction  = Giftsend::where('payment_status', 'processing')->count();
        $giftCoupon             = GiftCoupon::count();
        $ProductCategory        = ProductCategory::count();
        $Product                = Product::count();
        $user                   = User::where('user_type', 1)->count();
        $search_keyword         = Search_keyword::count();
        $cancel_deals           = ServiceRedeem::where('status', 0)->count();
        $TotalServiceSale       = TransactionHistory::where('payment_status', 'paid')->count();


        // -----------------------------
        // GIFT CARD TRANSACTION COUNTS
        // -----------------------------
        $todayGiftcards     = Giftsend::where('payment_status','succeeded')->whereDate('created_at', today())->count();
        $yesterdayGiftcards = Giftsend::where('payment_status','succeeded')->whereDate('created_at', today()->subDay())->count();
        $last7DaysGiftcards = Giftsend::where('payment_status','succeeded')->where('created_at', '>=', now()->subDays(7))->count();

        $lastMonthGiftcards = Giftsend::where('payment_status','succeeded')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $thisMonthGiftcards = Giftsend::where('payment_status','succeeded')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();


        // -----------------------------
        // SERVICE SALES COUNTS
        // -----------------------------
        $todayServiceSales      = TransactionHistory::where('payment_status', 'paid')->whereDate('created_at', today())->count();
        $yesterdayServiceSales  = TransactionHistory::where('payment_status', 'paid')->whereDate('created_at', today()->subDay())->count();
        $last7DaysServiceSales  = TransactionHistory::where('payment_status', 'paid')->where('created_at', '>=', now()->subDays(7))->count();

        $lastMonthServiceSales = TransactionHistory::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $thisMonthServiceSales  = TransactionHistory::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();


        // -----------------------------------------
        // GIFT CARD SALES AMOUNT
        // -----------------------------------------
        $totalGiftcardSales = Giftsend::where('payment_status','succeeded')->sum('amount');

        $thisMonthGiftcardSales = Giftsend::where('payment_status', 'succeeded')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('amount');

        $lastMonthGiftcardSales = Giftsend::where('payment_status', 'succeeded')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->sum('amount');

        $giftcardSalesGrowth = $lastMonthGiftcardSales > 0
            ? (($thisMonthGiftcardSales - $lastMonthGiftcardSales) / $lastMonthGiftcardSales) * 100
            : 100;


        // -----------------------------------------
        // MONTH-WISE GIFT CARD SALES (OLD CHART)
        // -----------------------------------------
        $giftcardSalesMonthly = Giftsend::selectRaw("SUM(amount) as total, MONTH(created_at) as month")
            ->where('payment_status', 'succeeded')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $months = $giftcardSalesMonthly->pluck('month')->map(function ($m) {
            return date("M", mktime(0, 0, 0, $m, 1));
        });

        $monthWiseSales = $giftcardSalesMonthly->pluck('total');


        // -----------------------------------------
        // NEW: LAST YEAR vs CURRENT YEAR COMPARISON
        // -----------------------------------------
        $currentYear = now()->year;
        $lastYear = now()->subYear()->year;

        // Current Year Monthly
        $currentYearSales = Giftsend::selectRaw("SUM(amount) as total, MONTH(created_at) as month")
            ->where('payment_status', 'succeeded')
            ->whereYear('created_at', $currentYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Last Year Monthly
        $lastYearSales = Giftsend::selectRaw("SUM(amount) as total, MONTH(created_at) as month")
            ->where('payment_status', 'succeeded')
            ->whereYear('created_at', $lastYear)
            ->groupBy('month')
            ->pluck('total', 'month');

        // Build aligned 12-month arrays (Jan–Dec)
        $monthsList = collect(range(1, 12))->map(function ($m) {
            return date("M", mktime(0, 0, 0, $m, 1));
        });

        $currentYearData = collect(range(1, 12))->map(fn($m) => $currentYearSales[$m] ?? 0);
        $lastYearData    = collect(range(1, 12))->map(fn($m) => $lastYearSales[$m] ?? 0);



        // -------------------------------------------------------------
// SERVICE SALES – YEAR OVER YEAR COMPARISON (NEW CHART)
// -------------------------------------------------------------
$currentYear = now()->year;
$lastYear = now()->subYear()->year;

// Current Year Monthly Service Sales
$currentYearServiceSales = TransactionHistory::selectRaw("SUM(transaction_amount) as total, MONTH(created_at) as month")
    ->where('payment_status', 'paid')
    ->whereYear('created_at', $currentYear)
    ->groupBy('month')
    ->pluck('total', 'month');

// Last Year Monthly Service Sales
$lastYearServiceSales = TransactionHistory::selectRaw("SUM(transaction_amount) as total, MONTH(created_at) as month")
    ->where('payment_status', 'paid')
    ->whereYear('created_at', $lastYear)
    ->groupBy('month')
    ->pluck('total', 'month');

// Month labels Jan–Dec
$serviceMonthsList = collect(range(1, 12))->map(fn($m) => date("M", mktime(0, 0, 0, $m, 1)));

$serviceCurrentYearData = collect(range(1, 12))->map(fn($m) => $currentYearServiceSales[$m] ?? 0);
$serviceLastYearData    = collect(range(1, 12))->map(fn($m) => $lastYearServiceSales[$m] ?? 0);


        // -----------------------------------------
        // RETURN VIEW
        // -----------------------------------------
        return view(
            'admin.admin_dashboad',
            compact(
                // Basic Counts
                'cancel_deals', 'TotalServiceSale', 'cardnumbers', 'alltransaction', 'user',
                'successTransaction', 'faildTransaction', 'processingTransaction', 'giftCoupon',
                'ProductCategory', 'Product', 'search_keyword',

                // Giftcard Counts
                'todayGiftcards','yesterdayGiftcards','last7DaysGiftcards','lastMonthGiftcards','thisMonthGiftcards',

                // Service Sales Counts
                'todayServiceSales','yesterdayServiceSales','last7DaysServiceSales','lastMonthServiceSales','thisMonthServiceSales',

                // Giftcard Revenue
                'totalGiftcardSales','thisMonthGiftcardSales','lastMonthGiftcardSales','giftcardSalesGrowth',

                // Old Chart
                'months','monthWiseSales',

                // NEW Comparison Chart
                'monthsList', 'currentYearData', 'lastYearData'

                // For Service Sales Chart
                ,'serviceMonthsList',
'serviceCurrentYearData',
'serviceLastYearData',

            )
        );
    }
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
