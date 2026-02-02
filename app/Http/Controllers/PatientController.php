<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\TransactionHistory;
use App\Models\Giftsend;
use App\Models\GiftcardsNumbers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\TimelineEvent;
use App\Imports\PatientsImport;
use Maatwebsite\Excel\Facades\Excel;
use Auth;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;
use DB;
use Session;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.patient.index'); // No data loaded here
    }




public function patientTableData(Request $request)
{
    $query = Patient::where('is_deleted', 0)
        ->select(['id','fname','lname','email','phone','status']);

    return DataTables::of($query)
        ->addIndexColumn()

        ->addColumn('patient_name', function ($row) {
            return trim($row->fname . ' ' . $row->lname);
        })

        // 🔥 GLOBAL SEARCH (name + email + phone)
        ->filter(function ($query) use ($request) {
            if ($search = $request->input('search.value')) {
                $query->where(function ($q) use ($search) {
                    $q->where('fname', 'LIKE', "%{$search}%")
                      ->orWhere('lname', 'LIKE', "%{$search}%")
                      ->orWhereRaw("CONCAT(fname,' ',lname) LIKE ?", ["%{$search}%"])
                      ->orWhere('email', 'LIKE', "%{$search}%")
                      ->orWhere('phone', 'LIKE', "%{$search}%");
                });
            }
        })

        ->addColumn('action', function ($row) {
            return '
                <div class="btn-group mb-2">
                    <a href="'.route('patient.edit',$row->id).'" class="btn btn-outline-primary btn-sm">
                        <i class="fa fa-user"></i>
                    </a>
                    <a href="'.route('giftcards-sale').'?patient_id='.$row->id.'" class="btn btn-outline-success btn-sm">
                        <i class="fa fa-gift"></i>
                    </a>
                    <a href="'.route('product.index').'?patient_id='.$row->id.'" class="btn btn-outline-info btn-sm">
                        <i class="fa fa-dna"></i>
                    </a>
                    <a href="'.route('program.index').'?patient_id='.$row->id.'" class="btn btn-outline-warning btn-sm">
                        <i class="fa fa-stethoscope"></i>
                    </a>
                </div>';
        })

        ->addColumn('status_badge', function ($row) {
            return $row->status == 1
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        })

        ->rawColumns(['action','status_badge'])
        ->make(true);
}





    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.patient.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function edit(Patient $patient, Request $request, TransactionHistory $transaction)
{
     if(isset($_GET['patient_id']))
         {
            $request->session()->put('internal_patient_id', $request->get('patient_id'));
        }
    $patient_login_id = $patient->patient_login_id;
    $patient_email = $patient->email;

    // -----------------------------
    // 1. Timeline Events
    // -----------------------------
    $query = TimelineEvent::where('patient_id', $patient_login_id);

    if ($request->start_time && $request->end_time) {
        $startTime = Carbon::parse($request->start_time)->startOfDay();
        $endTime = Carbon::parse($request->end_time)->endOfDay();
        $query->whereBetween('created_at', [$startTime, $endTime]);
    } else {
        $query->latest()->limit(10);
    }

    $timeline = $query->get();

    // -----------------------------
    // 2. All Giftsend Records
    // -----------------------------
    $giftcards = Giftsend::where(function ($query) use ($patient_login_id) {
            $query->whereColumn('gift_send_to', 'receipt_email')
                  ->whereNull('recipient_name')
                  ->where('gift_send_to', $patient_login_id);
        })
        ->orWhere(function ($query) use ($patient_login_id) {
            $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                  ->whereNotNull('recipient_name')
                  ->where('gift_send_to', $patient_login_id);
        })
        ->orderBy('id', 'DESC')
        ->get();

    // -----------------------------
    // 3. Giftcards Received by Patient
    // -----------------------------
    $mygiftcards = Giftsend::where('gift_send_to', $patient_login_id)
        ->orWhere('gift_send_to', $patient_email)
        ->orderBy('id', 'DESC')
        ->paginate(10);

    // -----------------------------
    // 4. Giftcards Sent by Patient
    // -----------------------------
       $sendgiftcards = Giftsend::where('receipt_email', $patient_login_id)
        ->orWhere('receipt_email', $patient_email)
        ->orderBy('id', 'DESC')
        ->paginate(10);
    // $sendgiftcards = Giftsend::getSentGiftcards($patient_login_id)
    //     ->orderBy('id', 'DESC')
    //     ->paginate(10);

    // -----------------------------
    // 5. Service Orders
    // -----------------------------
    $sevice_orders = $transaction
        ->where('email', $patient_email)
        ->orderBy('id', 'DESC')
        ->paginate(10);

    // -----------------------------
    // Return to View
    // -----------------------------
    return view('admin.patient.create', compact(
        'patient',
        'timeline',
        'giftcards',
        'mygiftcards',
        'sendgiftcards',
        'sevice_orders'
    ));
}


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Patient $patient)
    {
        try {
            // Update patient fields
            $patient->fname = $request->fname;
            $patient->lname = $request->input('lname', $patient->lname); // Optional field
            $patient->email = $request->email;
            $patient->phone = $request->phone;
            $patient->address = $request->input('address', $patient->address);
            $patient->city = $request->input('city', $patient->city);
            $patient->country = $request->input('country', $patient->country);
            $patient->zip_code = $request->input('zip_code', $patient->zip_code);

            // Update password if provided
            if ($request->filled('password')) {
                $patient->password = Hash::make($request->password);
            }

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete the old image if exists
                if ($patient->image && Storage::exists('public/patient_images/' . $patient->image)) {
                    Storage::delete('public/patient_images/' . $patient->image);
                }

                // Store the new image
                $imagePath = $request->file('image')->store('public/patient_images');
                $patient->image = url('/').Storage::url($imagePath);
            }

            // Save the updated patient record
            // dd($patient);
            $patient->save();

            return redirect()->back()->with('success', 'Patient details updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function destroy(Patient $patient)
    {
        //
    }

    public function PatientSearch(Request $request, Patient $patient)
            {
                // Start with a base query
                $query = $patient->query();

                // Apply filters if present in the request
                if ($request->filled('fname')) {
                    $query->whereRaw('LOWER(fname) LIKE ?', ['%' . strtolower($request->fname) . '%']);
                }

                if ($request->filled('lname')) {
                    $query->whereRaw('LOWER(lname) LIKE ?', ['%' . strtolower($request->lname) . '%']);
                }

                if ($request->filled('email')) {
                    $query->whereRaw('LOWER(email) LIKE ?', ['%' . strtolower($request->email) . '%']);
                }
                if ($request->filled('phone')) {
                    $query->whereRaw('LOWER(phone) LIKE ?', ['%' . strtolower($request->phone) . '%']);
                }

                // Order and paginate results
                $data = $query->orderBy('id', 'DESC')->paginate(10);

                // Return response as JSON
                return response()->json([
                    'status' => 'success',
                    'message' => 'Search results retrieved successfully.',
                    'data' => $data,
                ], 200);
            }

        //  For Dashboard
        public function PatientDashboard()
        {
            if (Auth::guard('patient')->check()) {
                $patient_login_id = Auth::guard('patient')->user()->patient_login_id;
                $order = TransactionHistory::where('patient_login_id',  $patient_login_id)->count();

                $giftcards = Giftsend::where(function($query) use ($patient_login_id) {
                    $query->whereColumn('gift_send_to', 'receipt_email')
                          ->where('recipient_name', null)
                          ->where('gift_send_to', $patient_login_id);
                })
                ->orWhere(function($query) use ($patient_login_id) {
                    $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                          ->whereNotNull('recipient_name')
                          ->where('gift_send_to', $patient_login_id);
                })
                ->orderBy('id', 'DESC')
                ->count();
                return view('patient.patient_dashboad', compact('order','giftcards'));                
            }
            else{

                return redirect()->route('patient-login')->withErrors(['patient_login_id' => 'Please log in first.']);
            }
        }
        // PAtient Profile
        public function PatientProfile(Patient $patient, Request $request)
        {
            $id = Auth::guard('patient')->user()->id;
        
            // Get the logged-in patient
            $patient = Patient::find($id);
        
            // Start building the timeline query filtered by patient ID
            $query = TimelineEvent::where('patient_id', $patient->patient_login_id);
        
            // Apply date range filter if provided
            if ($request->start_time && $request->end_time) {
                $startTime = Carbon::parse($request->start_time)->startOfDay();
                $endTime = Carbon::parse($request->end_time)->endOfDay();
                $query->whereBetween('created_at', [$startTime, $endTime]);
            } else {
                // Show latest 10 entries by default
                $query->latest()->limit(10);
            }
        
            // Execute the query
            $timeline = $query->get();
        
            return view('patient.patient_profile.profile', compact('patient', 'timeline'));
        }
        

        //  For purchased Gift cards Show
         public function Mygiftcards(Patient $patient)
            {
                $patient_login_id = Auth::guard('patient')->user()->patient_login_id;
                $mygiftcards = Giftsend::getReceivedGiftcards($patient_login_id)->orderBy('id', 'DESC')->paginate(10);
                $sendgiftcards = Giftsend::getSentGiftcards($patient_login_id)->orderBy('id', 'DESC')->paginate(10);
                return view('patient.giftcards.my-giftcards', compact('mygiftcards', 'sendgiftcards'));
            }


        //   Fro GiftcardRedeem View Page
        public function GiftcardsStatement(Request $request,Patient $patient,$id,GiftcardsNumbers $numbers)
        {
            $giftcards = GiftcardsNumbers::where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
            $token ='FOREVER-MEDSPA';
        //  For Statement of Giftcard
            $data=$numbers->select('giftcards_numbers.transaction_id','giftcards_numbers.user_token','giftcards_numbers.giftnumber','giftcards_numbers.amount','giftcards_numbers.comments','giftcards_numbers.actual_paid_amount','giftcards_numbers.updated_at')->Where('giftnumber',$giftcards[0]['giftnumber'])->where('user_token',$token)->get();
            $totalAmount = 0;
            $actual_paid_amount = 0;
        
            // Iterate over each record in the collection and sum up the 'amount' values
            foreach ($data as $record) {
                $totalAmount += $record->amount;
                $actual_paid_amount += $record->actual_paid_amount;
            }
        
            return view('patient.giftcards.redeem_statement',compact('giftcards','data','totalAmount','actual_paid_amount'));
        }

           //   Fro GiftcardRedeem View Page
       public function GiftcardsStatementAdminView(Request $request,Patient $patient,$id,GiftcardsNumbers $numbers)
            {
            $previousUrl = url()->previous();
            $giftcards = GiftcardsNumbers::where('user_id', $id)
            ->orderBy('id', 'DESC')
            ->get();
            $token ='FOREVER-MEDSPA';
        //  For Statement of Giftcard
            $data=$numbers->select('giftcards_numbers.transaction_id','giftcards_numbers.user_token','giftcards_numbers.giftnumber','giftcards_numbers.amount','giftcards_numbers.comments','giftcards_numbers.actual_paid_amount','giftcards_numbers.updated_at')->Where('giftnumber',$giftcards[0]['giftnumber'])->where('user_token',$token)->get();
            $totalAmount = 0;
            $actual_paid_amount = 0;
        
            // Iterate over each record in the collection and sum up the 'amount' values
            foreach ($data as $record) {
                $totalAmount += $record->amount;
                $actual_paid_amount += $record->actual_paid_amount;
            }
        
            return view('patient.giftcards.giftcard_statement_admin_view',compact('giftcards','data','totalAmount','actual_paid_amount','previousUrl'));
        }

        // My Services
       public function Myservices(TransactionHistory $transaction){
        $email = Auth::guard('patient')->user()->email;
        $patient = Patient::where('email', $email)
                    ->where('is_deleted', 0)
                    ->whereNotIn('status', [0, 2])
                    ->first();
        if($patient->patient_login_id!=null){
            $data = $transaction->where('patient_login_id', $patient->patient_login_id)->orderBy('id','DESC')->paginate(10);;
        }
        else{
           $data = $transaction->where('email',$email)->orderBy('id','DESC')->paginate(10);
        }
        return view('patient.services.my-services',compact('data'));
       }

    //     For Showing Invoice
    public function Patientinvoice($transaction_data) {
        try {
            $id = decrypt($transaction_data);           
            $transaction_data = TransactionHistory::findOrFail($id);
            return view('patient.patient-invoice', compact('transaction_data'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid Invoice Link');
        }
    }
    
   public function storeAmount(Request $request)
    {
        // Validate the amount input
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        // Store amount in session
        Session::put('amount', $request->amount);

        // Check if the patient is logged in
        if (Auth::guard('patient')->check()) {
            $patient = Auth::guard('patient')->user();

            // Optionally store patient name in session if not already there
            Session::put('result.name', $patient->fname . ' ' . $patient->lname);
            Session::put('patient_details', $patient);

            return response()->json([
                'logged_in' => true,
                'message' => 'Amount saved and patient is logged in.',
            ]);
        } else {
            return response()->json([
                'logged_in' => false,
                'message' => 'Please login first to continue.',
            ]);
        }
    }

    public function unsetAmont(Request $request)
    {
        // Retrieve 'amount' from session
        if(Session::has('amount')){
           Session::pull('amount', $request->amount);
            return response()->json([
                'message' => 'Select Amount has been removed.',
            ]);
        }
       
    }


    public function removeAmount(Request $request)
    {
        // Remove 'amount' from session
        $request->session()->forget('amount');

        // Optionally, redirect to a page (e.g., dashboard or home) after removal
        return redirect()->route('home')->with('success', 'Amount has been removed.');
    }
    public function emailSuggestions(Request $request)
    {
        $query = $request->input('query');

        $emails = Patient::where('email', 'LIKE', "%{$query}%")
                    ->pluck('email'); // Get only emails

        return response()->json($emails);
    }

    public function nameSuggestions(Request $request)
    {
        $query = $request->input('query');
        $patients = Patient::where('fname', 'LIKE', "%{$query}%")
        ->orWhere('lname', 'LIKE', "%{$query}%")
        ->selectRaw("CASE 
                        WHEN lname IS NULL OR lname = '' THEN fname
                        ELSE CONCAT(fname, ' ', lname) 
                     END as full_name")
        ->get();
    
        return response()->json($patients);
    
    }

    //  For Collect Patient Data
    // PatientData method in your controller
    public function PatientData(Request $request)
    {
        // Search patient by email OR phone (partial match)
        $patientData = Patient::find($request->search);

    // If no patient found
        if (!$patientData) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data not found. Try with Email/ Number',
            ],); // Use 404 or any other status code appropriate
        }
        // Get giftcards related to the patient
        $mygiftcards = Giftsend::where(function($query) use ($patientData) {
                $query->whereColumn('gift_send_to', 'receipt_email')
                      ->whereNull('recipient_name')
                      ->where('gift_send_to', $patientData->patient_login_id);
            })
            // Gifts Receive by Others  using patient Login
            ->orWhere(function($query) use ($patientData) {
                $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                      ->whereNotNull('recipient_name')
                      ->where('gift_send_to', $patientData->patient_login_id);
            })
             ->orWhere(function($query) use ($patientData) {
                 $query->whereColumn('gift_send_to', 'receipt_email')
                      ->whereNull('recipient_name')
                      ->where('gift_send_to', $patientData->email);
            })
            // Gifts Receive by Others  using patient Email
            ->orWhere(function($query) use ($patientData) {
                $query->whereColumn('gift_send_to', '!=', 'receipt_email')
                      ->whereNotNull('recipient_name')
                      ->where('gift_send_to', $patientData->email);
            })
            ->orderBy('id', 'DESC')
            ->get();
    
        $formattedGiftcards = [];
    
        foreach ($mygiftcards as $value) {
            $giftcards = GiftcardsNumbers::where('transaction_id', $value->transaction_id)
                ->pluck('giftnumber')->toArray();
    
            if (!empty($giftcards)) {
                $final_results = GiftcardsNumbers::select(
                        'giftnumber as card_number',
                        DB::raw('SUM(actual_paid_amount) as total_paid_amount'),
                        DB::raw('SUM(amount) as total_value_amount')
                    )
                    ->whereIn('giftnumber', $giftcards)
                    ->where('user_token', 'FOREVER-MEDSPA')
                    ->where('status', 1)
                    ->groupBy('giftnumber')
                    ->get();
    
                foreach ($final_results as $result) {
                    $formattedGiftcards[$result->card_number] = [
                        'card_number' => $result->card_number,
                        'value_amount' => $result->total_value_amount,
                        'actual_paid_amount' => $result->total_paid_amount ?? 'N/A',
                    ];
                }
            }
        }
    
        // Convert associative to indexed array
        $formattedGiftcards = array_values($formattedGiftcards);
    
        // Return JSON response
       return response()->json([
        'status' => 'success',
        'message' => 'Patient data and gift cards retrieved successfully.',
        'giftcards' => $formattedGiftcards,
        'patient' => [
            'fname' => $patientData->fname,
            'lname' => $patientData->lname,
            'phone' => $patientData->phone,
            'email' => $patientData->email,
            'patient_id' => $patientData->id,
        ]
    ]);

    }



 public function importPatients(Request $request)
    {
        ini_set('max_execution_time', 300);

        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $import = new PatientsImport();
        Excel::import($import, $request->file('file'));

        $skippedData = $import->skipped;

        return view('admin.patient.import_result', compact('skippedData'));
    }

    // Patient Data Mearge View
   public function preview(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|size:2',
            'ids.*' => 'exists:patients,id'
        ]);

        $patients = Patient::whereIn('id', $request->ids)->get();

        // Define Patient A (KEEP) and Patient B (MERGE)
        $patientA = $patients[0];  //Keep
        $patientB = $patients[1]; //Merge
        

        // Transaction counts
        $patientA->transaction_count = DB::table('transaction_histories')
            ->where('patient_login_id', $patientA->patient_login_id)
            ->count();

        $patientB->transaction_count = DB::table('transaction_histories')
            ->where('patient_login_id', $patientB->patient_login_id)
            ->count();

        // Service counts
        $patientA->service_count = DB::table('service_orders')
            ->where('patient_login_id', $patientA->patient_login_id)
            ->count();

        $patientB->service_count = DB::table('service_orders')
            ->where('patient_login_id', $patientB->patient_login_id)
            ->count();

        return response()->json([
            'patientA' => view('admin.patient.merge.patient_card', [
                'patient' => $patientA,
                'type'    => 'KEEP'
            ])->render(),

            'patientB' => view('admin.patient.merge.patient_card', [
                'patient' => $patientB,
                'type'    => 'MERGE'
            ])->render(),
        ]);
    }

    public function merge(Request $request)
    {
        $request->validate([
            'keep_id'  => 'required|exists:patients,id',
            'merge_id' => 'required|different:keep_id'
        ]);

        DB::transaction(function () use ($request) {

            $keep  = DB::table('patients')->where('id', $request->keep_id)->first();
            $merge = DB::table('patients')->where('id', $request->merge_id)->first();
    // dd($keep,$merge);
            // 1️⃣ Move transaction history
            DB::table('transaction_histories')
                ->where('patient_login_id', $merge->patient_login_id)
                ->update([
                    'patient_login_id' => $keep->patient_login_id,
                    'user_token'       => $keep->user_token,
                    'email'            => $keep->email,
                    'phone'            => $keep->phone,
                    'updated_at'       => now(),
                ]);

            // 2️⃣ Move service orders
            DB::table('service_orders')
                ->where('patient_login_id', $merge->patient_login_id)
                ->update([
                    'patient_login_id' => $keep->patient_login_id,
                    'user_token'       => $keep->user_token,
                    'updated_by'       => auth()->id(),
                    'updated_at'       => now(),
                ]);

            // 3️⃣ Soft-merge patient record
            DB::table('patients')
                ->where('id', $merge->id)
                ->update([
                    'status'     => 2, // Merged
                    'is_deleted' => 1,
                    'updated_by'=> auth()->id(),
                    'updated_at'=> now(),
                ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Patients merged successfully'
        ]);
    }
}

