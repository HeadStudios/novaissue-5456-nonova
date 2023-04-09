<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Opps;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;
use App\Hydraulics\Contracting;
use App\Hydraulics\ZohoInvoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class SendContractJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */

     public $opp_id;
     public $start;

    public function __construct($opp_id, $start)
    {
        $this->opp_id = $opp_id;
        $this->start = $start;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        
        /* Trying to just send a Contract */

        $opp = Opps::find($this->opp_id);
        //$client_logo = Storage::disk('s3')->url($opp->client_logo);
        $paylink = Contracting::generatePriceURL(1000, false); // Contracting::generatePriceURL($price, false);

        $guarantee = Storage::disk('s3')->url('pdf/Your_Guarantee.pdf');

        

        $price = $opp->price;
        $period = $opp->period;

        
        $terms = $opp->terms;
        $terms = $opp->terms->toArray();

        foreach ($terms as $key => $term) {
            if (isset($opp->setup_fee)) {
                $terms[$key] = $this->process_data_array($term, $price, $period, $opp->setup_fee);
            } else {
                $terms[$key] = $this->process_data_array($term, $price, $period);
            }
        }

        $terms = json_encode($terms);
        $terms = json_decode($terms);


        

        dump($terms);

        $pay_opt = Contracting::generatePriceUrl(1000, true); 

        $invoice_url = Contracting::generateInvoice($opp->id);
        
        $data = [
            'title' => 'Mail from The Meastro',
            'name' => $opp->name,
            'company' => $opp->company,
            'contact' => $opp->contact,
            'body' => $opp->email_body,
            'challenge' => $opp->challenge,
            'summary' => $opp->exec_summ,
            'products' => $opp->products,
            'terms' => $terms,
            'stakeholders' => $opp->contact->stakeholders ?? collect(),
            'schedule' => $opp->schedule,
            'paylink' => $paylink,
            'payopt' => $pay_opt,
            'subject' => "Let's goooo",
            'guarantee' => $guarantee,
            'invoice' => $invoice_url

        ];

        Mail::to($opp->email)->cc('enquiries@headstudios.com.au')->send(new \App\Mail\OppsEmail($data));

        

        return "It's done";

        


        /* Does email even work? */



        
        $opp = Opps::find($this->opp_id);
        $date_start = $this->start;
        $date = new Carbon($date_start);
        $two_weeks = $date->addDays(14);
        $two_weeks = $two_weeks->toFormattedDateString();
        
        

         
         
         
         

 

        $items = array();
        $price = 0;


        $oppProducts = $opp->products;
        $oppStakeholders = $opp->stakeholders;
        $oppSchedule = $opp->schedule;

        

        
        
        
        




        $stakeholders = $oppStakeholders;
        $products = $oppProducts;
        $schedule = $oppSchedule;

        $price = $opp->price;
        $period = $opp->period;

        


        $guarantee = Storage::disk('s3')->url('pdf/Your_Guarantee.pdf');
        $client_logo = Storage::disk('s3')->url($opp->client_logo);
        $details = [
            'title' => 'Mail from The Meastro',
            'name' => $opp->name,
            'company' => $opp->company,
            'logo' => $client_logo,
            'body' => $opp->email_body,
            'challenge' => $opp->challenge,
            'summary' => $opp->exec_summary,
            'guarantee' => $guarantee,
            'invoice' => $invoice_url,
            'products' => $products,
            'terms' => $terms,
            'stakeholders' => $stakeholders,
            'schedule' => $schedule,
            'paylink' => $paylink,
            'payopt' => $pay_opt
        ];

        Mail::to($opp->email)->cc('enquiries@headstudios.com.au')->send(new \App\Mail\OppsEmail($details));
        
        

    }

    protected function process_data_array($data_array, $price, $period, $setup_fee = null) {

        if (isset($data_array['headline']) && $data_array['headline'] === "Payment Terms") {
            dump("We got a headline?");
    
            $data_array['description'] = $this->get_price_message($price, $period, $setup_fee);
        }
    
        return $data_array;
    }
    
    protected function get_price_message($price, $period = null, $setup_fee = null) {
        dump("We inside price_message function... we're getting the price of ".$price);
        if ($period === null) {
            dump("Period is null");
            //return "This costs $price";
            return "The total investment for this program is $" . number_format($price, 2, '.', ',');
        } else {
            dump("Period is not null");
            $total_price = $price * $period;
            if ($setup_fee !== null) {
                $total_price_with_setup_fee = $total_price + $setup_fee;
                return "A setup fee of $".$setup_fee." will be charged. The investment for this package will be a monthly rate of $".$price." for ".$period." months. The total cost, including the setup fee, will be $".$total_price_with_setup_fee;
            } else {
                return "The investment for this package will be a monthly rate of $".$price." for ".$period." months. The total cost for this will be $".$total_price;
            }
        }
    }


}
