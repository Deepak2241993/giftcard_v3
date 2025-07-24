<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Giftsend;
use Illuminate\Http\Request;
use Mail;
use App\Mail\GeftcardMail;
use App\Mail\GiftReceipt;
use Session;
class FutureCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Email for Buy Future Giftcards';

    /**
     * Execute the console command.
     *
     * @return int
     */
     
     public function __construct()
{
    parent::__construct();
}
     
      public function handle(Giftsend $giftsend)
    {
        info("Cron Job running at " . now());
        
        // Fetch records where 'in_future' date matches today's date
        $data = Giftsend::whereDate('in_future', now()->toDateString())
                         ->where('future_mail_status', 0)
                         ->get();
    
        
        // Update future_mail_status for each fetched record
        foreach ($data as $record) {
            if (Mail::to($record->gift_send_to)->send(new GeftcardMail($record))) {
                // Email sent successfully
                $record->future_mail_status = 1;
                $record->save();
            } else {
                // Log the failure
                \Log::error('Failed to send email to: ' . $record->gift_send_to);
            }
        }
    }

    
}


