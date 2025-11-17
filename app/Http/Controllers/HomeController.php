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

        // FIXED: Last Month Giftcards
        $lastMonthGiftcards = Giftsend::where('payment_status','succeeded')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $thisMonthGiftcards = Giftsend::where('payment_status','succeeded')
                                ->whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();


        // -----------------------------
        // SERVICE SALES (TRANSACTION HISTORY)
        // -----------------------------
        $todayServiceSales      = TransactionHistory::where('payment_status', 'paid')->whereDate('created_at', today())->count();
        $yesterdayServiceSales  = TransactionHistory::where('payment_status', 'paid')->whereDate('created_at', today()->subDay())->count();
        $last7DaysServiceSales  = TransactionHistory::where('payment_status', 'paid')->where('created_at', '>=', now()->subDays(7))->count();

        // FIXED: Last Month Service Sales
        $lastMonthServiceSales = TransactionHistory::where('payment_status', 'paid')
            ->whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $thisMonthServiceSales  = TransactionHistory::where('payment_status', 'paid')
                                        ->whereMonth('created_at', now()->month)
                                        ->whereYear('created_at', now()->year)
                                        ->count();


        // -----------------------------------------
        // GIFT CARD SALES AMOUNT (DYNAMIC)
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

        // % Growth
        $giftcardSalesGrowth = $lastMonthGiftcardSales > 0
            ? (($thisMonthGiftcardSales - $lastMonthGiftcardSales) / $lastMonthGiftcardSales) * 100
            : 100;


        // -----------------------------------------
        // MONTH-WISE GIFT CARD SALES (CHART.JS)
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

                // Chart Data
                'months','monthWiseSales'
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
