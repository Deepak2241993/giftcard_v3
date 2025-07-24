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

    public function root(GiftcardRedeem $redeem,User $user,GiftcardsNumbers $number,Giftsend $giftsend)
    {
        if(Auth::user()->user_type==1)
        {
            $cardnumbers = GiftcardsNumbers::distinct('giftnumber')->count();
            $alltransaction = Giftsend::count();
            $successTransaction = Giftsend::where('payment_status','succeeded')->count();
            $faildTransaction = Giftsend::where('payment_status','payment_failed')->orWhere('payment_status',null)->count();
            $processingTransaction = Giftsend::where('payment_status','processing')->count();
            $giftCoupon = GiftCoupon::count();
            $ProductCategory = ProductCategory::count();
            $Product = Product::count();
            $user=User::where('user_type',1)->count();
            $search_keyword=Search_keyword::all()->count();
            $cancel_deals=ServiceRedeem::where('status',0)->count();
            $TotalServiceSale=TransactionHistory::where('payment_status','paid')->count();
            

            return view('admin.admin_dashboad',compact('cancel_deals','TotalServiceSale','cardnumbers','alltransaction','user','successTransaction','faildTransaction','processingTransaction','giftCoupon','ProductCategory','Product','search_keyword'));
        }
        else{
            $user_email=Auth::user()->email;
            $user_data=User::where('email',$user_email)->first();
            $gift_buy=Giftsend::where('user_id',$user_data->id)->count();
            return redirect(route('dashboard'));
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
