<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Whitecube\NovaFlexibleContent\Layouts\Collection as FlexCollection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Date;
use Carbon\Carbon;
use App\Models\User;
use App\Jobs\SendContractJob;
use App\Models\Contact;
use App\Models\Opps;
use Whitecube\NovaFlexibleContent\Value\FlexibleCast;
use Illuminate\Support\Facades\Log;
use App\Hydraulics\Contracting;
use App\Hydraulics\ZohoInvoice;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Lednerb\ActionButtonSelector\ShowAsButton;



class SendContract extends Action implements ShouldQueue
{
    use InteractsWithQueue, Queueable;
    use ShowAsButton;

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */

    public $name = 'Send Contract';

    // Is it gone

    public function handle(ActionFields $fields, Collection $models)
    {
        
        
        
        $opp = $models[0];

        
        

        SendContractJob::dispatch($opp->id, $fields->start);
        return Action::message("Pweek!");

        $opp = Opps::find($opp->id);

        
        
        






        /*if (json_decode($opp->products) !== null) {
            $booya = new FlexCollection($opp->products);
        }
        */
         
         

        

        $date_start = $fields->start;
        
        $date = new Carbon($date_start);
        $two_weeks = $date->addDays(14);
        $two_weeks = $two_weeks->toFormattedDateString();
        
        

         
         
         
         

 

        $items = array();
        $price = 0;


        $oppProducts = $opp->products;
        $oppStakeholders = $opp->stakeholders;
        $oppSchedule = $opp->schedule;
        $oppTerms = $opp->terms;
        

        
        
        
        foreach($oppProducts as $product) {
             
             
            $items[] = ['rate' => $product->price, 'productname' => $product->product_name, 'productfeature' => $product->product_benefit];
             
            $price += (int)$product->price;
        }

    $paylink = self::generatePriceURL($price, false);

    $pay_opt = self::generatePriceUrl(1000, true);


        $invoicer = new ZohoInvoice();
        //$items = [['rate' => 300, 'productname'=>'The Nullifier','productfeature'=>'The Great Reset'],['rate' => 300, 'productname'=>'The Nullifier 2','productfeature'=>'The Great Reset 2']];
        $contact_id = $invoicer->getContactIDByName($opp->contact);
        if(!$contact_id) {
            $contact_id = $invoicer->createContact($opp->name, $opp->email, $opp->company, $opp->website); }
        $items = $invoicer->lineItemParser($items);
        $inv_id = $invoicer->createInvoiceDraft($items,$contact_id);

        $auth = 'Zoho-oauthtoken '.$invoicer->access_token;
        $url = 'https://books.zoho.com/api/v3/invoices/'.$inv_id.'?organization_id='.env('zoho_org').'&accept=pdf&print=true';

        //return response()->file($url);
        $file = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => $auth
        ])->get($url);
        $path = 'invoice_'.rand(0, 1000).'.pdf';
        $false_or_true = Storage::put($path, $file);
        $invoice_url = Storage::disk('s3')->url($path);




        $stakeholders = $oppStakeholders;
        $products = $oppProducts;
        $schedule = $oppSchedule;
        $terms = $oppTerms;
        /*$html = '<style>

        table { width: 100%; border-collapse: collapse; border: 1px solid black;  }
        td, th {
            border: 1px solid black;
        }
        html,body,table,td,th { font-family:Roboto; }
        </style>
        <h1>This is generated just to demonstrate fonts and tables.. is this a good font?</h1>
        <table style="border:1px black !important;">
        <tbody>
        <tr>
        <td><span><strong>Product</strong></span></td>
        <td><span><strong>Description</strong></span></td>
        <td><span><strong>Benefit</strong></span></td>
        </tr>
        <tr>
        <td><span><strong>Product #1</strong></span></td>
        <td><span><strong>Description #1</strong></span></td>
        <td><span><strong>Benefit #1</strong></span></td>
        </tr>
        </tbody>
        </table>
        ';*/

        $guarantee = Storage::disk('s3')->url('pdf/Your_Guarantee.pdf');
        $client_logo = Storage::disk('s3')->url($opp->client_logo);
        $details = [
            'title' => 'Mail from The Meastro',
            'name' => $opp->contact,
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

        Mail::to($opp->email)->cc('kosta@headstudios.com.au')->send(new \App\Mail\OppsEmail($details));
        /*
        $client = new \HelloSign\Client(env('HELLO_API_KEY'));
        $request = new \HelloSign\SignatureRequest;
        $request->enableTestMode();
        $request->setTitle('Rent Roll Growth Agreement Signature');
        $request->setSubject('Rent Roll Growth Agreement');
        $request->setMessage('Please sign this agreement to proceed with the Rent Roll Growth Implmentation Framework. Let me know if you have any questions.');
        $request->addSigner($opp->email, $opp->contact);
        $request->addFileURL($url);
        $response = $client->sendSignatureRequest($request); */

        return Action::message("Pweek!");

        //return $pdf->stream();


        //return $opp->contact; try again

        //ray($value);
        //ray($value->attributes->product_name);

    }

    protected function generatePriceURL($price, $variable, $product='prod_N3K5NnPyQ8O9Rb') {

        return "https://invoice.com/";

        $price = $price * 100;

        $stripe = new \Stripe\StripeClient(
            env('STRIPE_SECRET')
          );

        if($variable == true) {
        $price = $stripe->prices->create([
            'custom_unit_amount' => [
              'enabled' => true,
              'preset' => $price
            ],
            'currency' => 'aud',
            'product' => $product,
          ]);
        } else {
            $price = $stripe->prices->create([
                'unit_amount' => $price,
                'currency' => 'aud',
                'product' => $product,
              ]);
        }
    
          $price_id = $price->id;
    
          $links = $stripe->paymentLinks->create(
            [
              'line_items' => [['price' => $price_id, 'quantity' => 1]],
            ]
          );
    
        return $links->url;
    }

    /**
     * Get the fields available on the action.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            Date::make('Start')->resolveUsing(function ($date) {
                return $date->format('d/m/Y');
            })
        ];

    }
}
