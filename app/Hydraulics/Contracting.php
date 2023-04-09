<?php

namespace App\Hydraulics;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use PDF;
use App\Models\Opps;
use Illuminate\Support\Facades\Storage;

class Contracting {

    protected $its_all_mine = array();

    function __construct($the_cut) {



            //echo "I see you Mr. Sharpe!";

            $this->its_all_mine = $the_cut;



    }

    public static function caster() {

        $opp = Opps::where('ID', 11)->first();
        ray($opp->stakeholders);

    }

    public static function merge($html, $name, $company, $exec_summary, $email_body, $challenge, $address, $solution) {

        $my_html = $html;

        $my_html = str_replace("{{client_name}}", $name, $my_html);
        $my_html = str_replace("{{challenge}}", nl2br($challenge), $my_html);
        $my_html = str_replace("{{client_address}}", $address, $my_html);
        $my_html = str_replace("{{client_company}}", $company, $my_html);
        $my_html = str_replace("{{solution}}", nl2br($solution), $my_html);
        $my_html = str_replace("{{date}}", date('l jS \of F Y') , $my_html);
        //$my_html = str_replace("{{client_address}}", $this->its_all_mine['clientaddress'] , $my_html);
        //$my_html = str_replace("{{email_body}}", nl2br($parser->text($this->its_all_mine['emailbody'])) , $my_html);
        $my_html = str_replace("{{email_body}}", nl2br($email_body), $my_html);
        $my_html = str_replace("{{executive_summary}}", nl2br($exec_summary), $my_html);
        $my_html = str_replace("{{company}}", $company, $my_html);

        return $my_html;

    }

    public static function table_merge($array, $merge_num) {
        $html = "";
        
        if($merge_num==1) {
            foreach($array as $product) {

                //$product = $product->attributesToArray();
                //if($product->attributes) { $product = $product->attributes; }
                $html .= "<tr><td>".$product->attributes->product_name."</td><td>".nl2br($product->attributes->product_feature)."</td><td>".nl2br($product->attributes->product_benefit)."</td></tr>";
            }
            return $html;
        }
        if($merge_num==2) {
            foreach($array as $stakeholder) {
                //if($stakeholder->attributes) { $stakeholder = $stakeholder->attributes; }
                $html .= "<tr><td>".$stakeholder->attributes->name."</td><td>".$stakeholder->attributes->position."</td><td>".$stakeholder->attributes->contact_details."</td><td>".$stakeholder->attributes->responsibility."</td></tr>";

            }
            return $html;
        }
        if($merge_num==3) {
            foreach($array as $schedule) {
                //if($schedule->attributes) { $schedule = $schedule->attributes; }
                $html .= "<tr><td>".nl2br($schedule->attributes->activity)."</td><td>".nl2br($schedule->attributes->description)."</td><td>".date('d-m-Y', strtotime($schedule->attributes->completion))."</td></tr>";

            }
            return $html;
        }
    }

    public static function term_spit($terms) {
        $html = '';
        foreach($terms as $term) {
            //if($term->attributes) { $term = $term->attributes; }
            $html .= '<p class="h2">'.$term->attributes->headline.'</p><p>'.nl2br($term->attributes->description).'</p>';

        }
        return $html;

    }

    function cleanseFormidableArray(array $input) {
        unset($input['form']);
        $input = array_values($input);
        return $input;
    }

    function talk_your_shit() {

        var_dump($this->its_all_mine);

    }

    function terms_spit($terms_array) {

        $terms_array = $this->cleanseFormidableArray($terms_array);
        $terms_html = '';

        foreach($terms_array as $term) {
            if($term->attributes) { $term = $term->attributes; }

            $headline = $term['headline'];
            $description = $term['description2'];

            $terms_html .= '<h3>'.$headline.'</h3>
            <p>'.$description.'</p>';

        }
        return $terms_html;

    }

    function table_spit($table_array,$num=1) {

        $table_array = $this->cleanseFormidableArray($table_array);

       //$table = '<table>';
       if($num==1) {
       $table = '';
       foreach($table_array as $keybit) {

            $table .= '<tr>';
            $table .= '<td>'.$keybit['productname'].'</td>';
            $table .= '<td>'.$keybit['productfeature'].'</td>';
            $table .= '<td>'.$keybit['productbenefit'].'</td>';
            $table .= '</tr>';

        }
        //$table .= '</table>';
        return $table;
        }
        if($num==2) {
        $table = '';
        foreach($table_array as $keybit) {

            $table .= '<tr>';
            $table .= '<td>'.$keybit['name'].'</td>';
            $table .= '<td>'.$keybit['position'].'</td>';
            $table .= '<td>'.$keybit['contact'].'</td>';
            $table .= '<td>'.$keybit['responsibility'].'</td>';
            $table .= '</tr>';

        }
        //$table .= '</table>';
        return $table;
        }
        if($num==3) {
            $table = '';
            foreach($table_array as $keybit) {

                $table .= '<tr>';
                $table .= '<td>'.$keybit['activity'].'</td>';
                $table .= '<td>'.$keybit['description'].'</td>';
                $table .= '<td>'.$keybit['date2'].'</td>';
                $table .= '</tr>';

            }
            //$table .= '</table>';
            return $table;
        }


    }




function in_n_out($html, $parser) {



    $my_html = $html;

    //if(isset($this->its_all_mine['clientname'])) {

        // Provides: <body text='black'>
        // Use this as a key code for naming of form fields in Incognito or anyone that submits
        $my_html = str_replace("{{client_name}}", $this->its_all_mine['clientname'] , $my_html);
        //echo "Client name is....".$this->its_all_mine['clientname'];
        $my_html = str_replace("{{client_company}}", $this->its_all_mine['clientcompany'] , $my_html);
        $my_html = str_replace("{{date}}", $this->its_all_mine['date'] , $my_html);
        $my_html = str_replace("{{client_address}}", $this->its_all_mine['clientaddress'] , $my_html);
        $my_html = str_replace("{{email_body}}", nl2br($parser->text($this->its_all_mine['emailbody'])) , $my_html);
        $my_html = str_replace("{{executive_summary}}", $parser->text($this->its_all_mine['execsummary']) , $my_html);

    //}

    return $my_html;



}



public static function generatePriceURL($price, $variable, $product='prod_N3K5NnPyQ8O9Rb') {

    //return "https://invoice.com/";

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

    public static function generateInvoice($opp_id) {
        $opp = Opps::find($opp_id);
        $price = 0;
        
        foreach ($opp->products as $product) {

            if (isset($opp->period)) {
        
                $rate = $opp->price;
                $period = $opp->period;
        
                if ($opp->setup_fee !== null) {
                    $total = ($rate * $period) + $opp->setup_fee;
                    $feature = $product->product_feature.' - '.$product->product_benefit . "\n\nSetup fee of $" . $opp->setup_fee . " then a monthly cost of $" . $rate . " over " . $period . " months (or until cancellation from either party) for a Total cost of $" . $total . "\n$" . $rate . " remittable immediately to begin project";
                    $price = $opp->setup_fee;
                    $items[] = ['rate' => $opp->setup_fee, 'productname' => $product->product_name, 'productfeature' => $feature];
                } else {
                    $total = $rate * $period;
                    $feature = $product->product_feature.' - '.$product->product_benefit . "\n\nMonthly Cost of $" . $rate . " over " . $period . " months (or until cancellation from either party) for a Total cost of $" . $total . "\n$" . $rate . " remittable immediately to begin project";
                    $price = $product->price;
                    $items[] = ['rate' => $rate, 'productname' => $product->product_name, 'productfeature' => $feature];
                }
        
            } else {
                $feature = $product->product_feature.' - '.$product->product_benefit;

                $items[] = ['rate' => $product->price, 'productname' => $product->product_name, 'productfeature' => $feature];
                $price = $product->price;
            }
        
        }

        $invoicer = new ZohoInvoice();
        //$items = [['rate' => 300, 'productname'=>'The Nullifier','productfeature'=>'The Great Reset'],['rate' => 300, 'productname'=>'The Nullifier 2','productfeature'=>'The Great Reset 2']];
        $contact_id = $invoicer->getContactIDByName($opp->name);
        if(!$contact_id) {
            $contact_id = $invoicer->createContact($opp->name, $opp->email, $opp->company, $opp->website); }
        $items = $invoicer->lineItemParser($items);
        if (isset($opp->period) && !isset($opp->setup_fee)) {
            $price = $opp->price;
            $recurring_invoice_id = $invoicer->createInvoiceDraft($items, $contact_id, true);

        $child_invoices = $invoicer->getChildInvoices($recurring_invoice_id);
        if (count($child_invoices) > 0) {
            $first_child_invoice = $child_invoices[0];
            $inv_id = $first_child_invoice['invoice_id'];
        } else {
            // No child invoices found, handle this case if necessary
        }
        } else {
            $inv_id = $invoicer->createInvoiceDraft($items,$contact_id);
        }
        

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
        return $invoice_url;
    }

    private static function getChildInvoices($recurring_invoice_id)
{
    $url = 'https://books.zoho.com/api/v3/recurringinvoices/' . $recurring_invoice_id . '/invoices?organization_id=' . env('zoho_org');

    $response = Http::withHeaders($this->headers)->get($url);
    $data = json_decode($response->body(), true);

    if (isset($data['invoice_history'])) {
        return $data['invoice_history'];
    }

    return [];
}



}
