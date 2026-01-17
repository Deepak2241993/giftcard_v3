<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use Illuminate\Http\Request;
use Purifier;
use Illuminate\Support\Facades\Storage;

class EmailTemplateController extends Controller
{
    /* ==============================
     * SHOW ALL TEMPLATES
     * ============================== */
    public function index()
    {
        $data = EmailTemplate::orderBy('id', 'DESC')->get();
        return view('admin.email_template.index', compact('data'));
    }

    /* ==============================
     * CREATE FORM
     * ============================== */
    public function create()
    {
        return view('admin.email_template.create');
    }

    /* ==============================
     * STORE TEMPLATE
     * ============================== */
    public function store(Request $request)
    {
        $data = $request->all();

        /* ---------- SANITIZE HTML ---------- */
        if (!empty($data['message_email'])) {
            $data['message_email'] = Purifier::clean($data['message_email'], 'email');
        }

        /* ---------- FILE UPLOADS ---------- */
        $data = $this->handleUploads($request, $data);

        EmailTemplate::create($data);

        return redirect()
            ->route('email-template.index')
            ->with('success', 'Email template created successfully');
    }

    /* ==============================
     * EDIT TEMPLATE
     * ============================== */
    public function edit(EmailTemplate $emailTemplate)
    {
        return view('admin.email_template.create', compact('emailTemplate'));
    }

    /* ==============================
     * UPDATE TEMPLATE
     * ============================== */
    public function update(Request $request, $id)
    {
        $template = EmailTemplate::findOrFail($id);
        $data = $request->all();

        /* ---------- SANITIZE HTML ---------- */
        if (!empty($data['message_email'])) {
            $data['message_email'] = Purifier::clean($data['message_email'], 'email');
        }

        /* ---------- FILE UPLOADS ---------- */
        $data = $this->handleUploads($request, $data, $template);

        $template->update($data);

        return back()->with('success', 'Email template updated successfully');
    }

    /* ==============================
     * DELETE TEMPLATE
     * ============================== */
    public function destroy(EmailTemplate $emailTemplate)
    {
        $emailTemplate->delete();

        return redirect()
            ->route('email-template.index')
            ->with('success', 'Template deleted successfully');
    }

    /* ==============================
     * PREVIEW TEMPLATE
     * ============================== */
    public function preview($id)
    {
        $template = EmailTemplate::findOrFail($id);

        // Dummy preview data
        $maildata = (object) [
            'fname'          => 'John',
            'lname'          => 'Doe',
            'order_id'       => 'PREVIEW-001',
            'sub_amount'     => '150.00',
            'taxrate'        => 8,
            'tax_amount'     => '12.00',
            'final_amount'   => '162.00',
        
        ];
    
        switch ($id) {

    case 1:    // Order Confirmation
      
        $maildata = (object) [
            "fname" => "Deepak",
            "lname" => "Prasad",
            "email" => "deepakprasad224@gmail.com",
            "phone" => "9891340730",
            "gift_card_applyed" => "FEMS-1766397611140",
            "gift_card_amount" => "10",
            "sub_amount" => "115",
            "final_amount" => "99.75",
            "transaction_amount" => "99.75",
            "tax_amount" => "4.75",
            "discount" => "10",
            "user_token" => "FOREVER-MEDSPA",
            "payment_mode" => "store",
            "patient_login_id" => "Deepak_123",
            "updated_at" => "2025-12-26 00:38:23",
            "created_at" => "2025-12-26 00:38:23",
            "id" => 309,
            "order_id" => "FMSWCSU000000309",
            "payment_session_id" => "MEDSPA-CENTER-309",
            "transaction_status" => "complete",
            "payment_status" => "paid",
            "status" => 1,
            "payment_intent" => "MEDSPA-CENTER-309",
            "taxrate" => "5",
        ];
        break;

    case 2: // Service Redeemed Mail
        $maildata = (object) [
            "id" => 308,
            "order_id" => "FMSWCSU000000308",
            "fname" => "Deepak",
            "lname" => "Prasad",
            "city" => null,
            "country" => null,
            "zip_code" => null,
            "phone" => "9891340730",
            "address" => null,
            "email" => "deepakprasad224@gmail.com",
            "transaction_id" => null,
            "sub_amount" => "515",
            "tax_amount" => "0.00",
            "final_amount" => "515",
            "transaction_amount" => "515",
            "payment_session_id" => "MEDSPA-CENTER-308",
            "status" => "1",
            "payment_status" => "paid",
            "transaction_status" => "complete",
            "gift_card_applyed" => null,
            "gift_card_amount" => null,
            "user_token" => "FOREVER-MEDSPA",
            "payment_mode" => "store",
            "payment_intent" => "MEDSPA-CENTER-308",
            "created_at" => "2025-12-24 04:25:39",
            "updated_at" => "2025-12-24 04:25:39",
            "patient_login_id" => "Deepak_123",
            "discount" => 0.0,
            "comments" => null,
        ];
        break;
     case 3: // Deal Cancellation Mail
        
        $maildata = (object) [
        "id" => 312,
        "order_id" => "FMSWCSU00000312",
        "fname" => "Deepak",
        "lname" => "Prasad",
        "city" => "Delhi",
        "country" => "India",
        "zip_code" => 11004,
        "phone" => "9891340730",
        "address" => "New Delhi",
        "email" => "deepakprasad224@gmail.com",
        "transaction_id" => null,
        "sub_amount" => "660",
        "tax_amount" => "0",
        "final_amount" => "660",
        "transaction_amount" => "660",
        "payment_session_id" => "cs_test_a1GduGmecn2oQtrpW6wICsMegPHt79GpaeLkVS34FBWMiXeTY77HDDUHHn",
        "status" => "1",
        "payment_status" => "paid",
        "transaction_status" => "complete",
        "gift_card_applyed" => null,
        "gift_card_amount" => null,
        "user_token" => "FOREVER-MEDSPA",
        "payment_mode" => "online",
        "payment_intent" => "pi_3SiUCOHXhy3bfGAt1W7hgcPL",
        "created_at" => null,
        "updated_at" => "2025-12-26 01:08:33",
        "patient_login_id" => "Deepak_123",
        "discount" => 0.0,
        "comments" => null
  ];
        break;
        case 4: // Refund Mail
        
        $maildata = (object) [
        "fname" => "Deepak",
        "lname" => "Prasad", 
        "amount" => "660",
        "status" => "Succeeded",
        "payment_intent" => "pi_3SiUCOHXhy3bfGAt1W7hgcPL",
        "reason" => "requested_by_customer",
        "comments" => null
    ];
        break;
        case 5: // Email Verification Mail
        
        $maildata = (object) [
        "tokenverify" => "bdfb6e8f94e3f4c3a5e8e9f6c7d8e9f0",
        "fname" => null,
        "lname" => null
  ];
  break;
    case 6: // Registration Mail
        
        $maildata = (object) [
        "tokenverify" => "bdfb6e8f94e3f4c3a5e8e9f6c7d8e9f0",
        "fname" => 'Deepak',
        "lname" => 'Prasad',
        "patient_login_id" => "Deepak_123"
  ];
    break;
       case 7: //Forget Password Mail
        $maildata = (object) [
        "tokenverify" => "bdfb6e8f94e3f4c3a5e8e9f6c7d8e9f0",
        "fname" => 'Deepak',
        "lname" => 'Prasad',
        "patient_login_id" => "Deepak_123"
  ];
    break;
      case 8: //Gift Card Purchase Mail
        $maildata = (object) [
        "id" => 127,
        "future_mail_status" => 0,
        "qty" => 4,
        "amount" => "75.00",
        "your_name" => "Deepak Prasad",
        "recipient_name" => "Deepak Kesarwani",
        "message" => "This is Test mail",
        "gift_card_send_type" => "other",
        "in_future" => null,
        "status" => 0,
        "coupon_code" => null,
        "gift_send_to" => "rrgraphic224@gmail.com",
        "user_token" => "FOREVER-MEDSPA",
        "created_at" => "2026-01-03 03:32:44",
        "updated_at" => "2026-01-03 03:33:10",
        "receipt_email" => "Deepak_123",
        "discount" => 0.0,
        "transaction_id" => "card_1SlQGgHXhy3bfGAtrzaCK94N",
        "payment_status" => "succeeded",
        "payment_time" => 1767429187,
        "transaction_amount" => 300,
        "usertype" => "regular",
        "payment_mode" => "Payment Gateway",
        "event_id" => null
  ];
    break;
          case 9: //Gift Card Purchase Receipt Mail
        $maildata = (object) [
        "your_name" => "Deepak Prasad",
        "recipient_name" => 'Deepak Kesarwani',
        "gift_send_to" =>'Deepak Kesarwani',
        "qty" => 4,
        'amount' => 75,
        "patient_login_id" => "Deepak_123",
        "fname"=>"",
        "lname"=>"",
        "message"=>"Wishing you a wonderful birthday filled with joy and laughter!",
        "cardnumber"=>"GIFT-1234567890"
  ];
    break;
       case 10: //Gift Card Cancel Receipt Mail
       $maildata = (object) [
    'result' => [
        [
            'transaction_id' => 'card_1SlLBvHXhy3bfGAt1kzQ90a1',
            'user_token' => 'FOREVER-MEDSPA',
            'giftnumber' => 'FEMS-1767409674162',
            'amount' => 50,
            'comments' => 'TestMail',
            'actual_paid_amount' => 50,
            'updated_at' => '2026-01-03T06:43:58.000000Z',
        ],
        [
            'transaction_id' => 'CANCEL20260103014357',
            'user_token' => 'FOREVER-MEDSPA',
            'giftnumber' => 'FEMS-1767409674162',
            'amount' => 0,
            'comments' => 'cancel',
            'actual_paid_amount' => null,
            'updated_at' => '2026-01-03T06:43:58.000000Z',
        ],
    ],

    'TotalAmount' => 50,
    'actual_paid_amount' => 50,
    'status' => 200,
    'success' => 'Gift History Found Successfully',

    'receiverAndSenderDetails' => (object) [
        'id' => 122,
        'future_mail_status' => 0,
        'qty' => 4,
        'amount' => '50.00',
        'your_name' => 'Deepak Prasad',
        'recipient_name' => 'RR',
        'message' => 'TestMail',
        'gift_card_send_type' => 'other',
        'in_future' => null,
        'status' => 0,
        'coupon_code' => null,
        'gift_send_to' => 'deepakprasad224@gmail.com',
        'user_token' => 'FOREVER-MEDSPA',
        'created_at' => '2026-01-03T03:07:19.000000Z',
        'updated_at' => '2026-01-03T03:07:54.000000Z',
        'receipt_email' => 'Deepak098',
        'discount' => 0,
        'transaction_id' => 'card_1SlLBvHXhy3bfGAt1kzQ90a1',
        'payment_status' => 'succeeded',
        'payment_time' => '1767409672',
        'transaction_amount' => 200,
        'usertype' => 'regular',
        'payment_mode' => 'Payment Gateway',
        'event_id' => null,
    ],
];

    break;
     case 11: //Gift Card Purchase Self Mail
        $maildata = (object) [
        "id" => 127,
        "future_mail_status" => 0,
        "qty" => 4,
        "amount" => "75.00",
        "your_name" => "Deepak Prasad",
        "recipient_name" => "",
        "message" => "This is Test mail",
        "gift_card_send_type" => "other",
        "in_future" => null,
        "status" => 0,
        "coupon_code" => null,
        "gift_send_to" => "rrgraphic224@gmail.com",
        "user_token" => "FOREVER-MEDSPA",
        "created_at" => "2026-01-03 03:32:44",
        "updated_at" => "2026-01-03 03:33:10",
        "receipt_email" => "Deepak_123",
        "discount" => 0.0,
        "transaction_id" => "card_1SlQGgHXhy3bfGAtrzaCK94N",
        "payment_status" => "succeeded",
        "payment_time" => 1767429187,
        "transaction_amount" => 300,
        "usertype" => "regular",
        "payment_mode" => "Payment Gateway",
        "event_id" => null
  ];
    break;
    case 11: //Gift Card Purchase Self Mail
        $maildata = (object) [
        "id" => 127,
        "full_name" => "Mr.Jone Kumar",
        "password" => "yvNNYcUEKq",
        "user_name" => "Jone_123",

  ];
    break;
    case 12: //Gift Card Purchase Self Mail
        $maildata = (object) [
        "id" => 127,
        "full_name" => "Mr.Jone Kumar",
        "password" => "yvNNYcUEKq",
        "user_name" => "Jone_123",

  ];
   break;
    case 13: //Gift Card Purchase Self Mail
         $maildata = (object) [
        "id" => 127,
        "future_mail_status" => 0,
        "qty" => 4,
        "amount" => "75.00",
        "your_name" => "Deepak Prasad",
        "recipient_name" => "Deepak Kesarwani",
        "message" => "This is Test mail",
        "gift_card_send_type" => "other",
        "in_future" => null,
        "status" => 0,
        "coupon_code" => null,
        "gift_send_to" => "rrgraphic224@gmail.com",
        "user_token" => "FOREVER-MEDSPA",
        "created_at" => "2026-01-03 03:32:44",
        "updated_at" => "2026-01-03 03:33:10",
        "receipt_email" => "Deepak_123",
        "discount" => 0.0,
        "transaction_id" => "card_1SlQGgHXhy3bfGAtrzaCK94N",
        "payment_status" => "succeeded",
        "payment_time" => 1767429187,
        "transaction_amount" => 300,
        "usertype" => "regular",
        "payment_mode" => "Payment Gateway",
        "event_id" => null
        ];
    break;
    default:
        // Default preview data
        $maildata = (object) [
            "fname"        => "John",
            "lname"        => "Doe",
            "order_id"     => "PREVIEW-001",
            "sub_amount"   => "150.00",
            "taxrate"      => 8,
            "tax_amount"   => "00",
            "final_amount" => "00",
        ];
        break;
}


        return view('admin.email_template.emailpreview', compact('template', 'maildata'));
    }

    /* ==============================
     * SUMMERNOTE IMAGE UPLOAD
     * ============================== */
    public function uploadImage(Request $request)
    {
        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded'], 422);
        }

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        $path = $file->storeAs('email_images', $filename, 'public');

        return response()->json([
            'url' => asset('storage/' . $path)
        ]);
    }

    /* ==============================
     * FILE UPLOAD HANDLER (REUSABLE)
     * ============================== */
    private function handleUploads(Request $request, array $data, $template = null)
    {
        $fileFields = [
            'logo',
            'header_image',
            'social_media_1',
            'social_media_2',
            'social_media_3',
            'social_media_4',
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('email_assets', $filename, 'public');

                $data[$field] = asset('storage/' . $path);
            } else {
                // keep old file during update
                if ($template && isset($template->$field)) {
                    $data[$field] = $template->$field;
                }
            }
        }

        return $data;
    }
}
