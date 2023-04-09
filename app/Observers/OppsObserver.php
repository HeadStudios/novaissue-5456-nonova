<?php

namespace App\Observers;

use App\Models\Opps;
use Illuminate\Support\Facades\Http;
use App\Jobs\ProcessLinkmeister;
use App\Http\Controllers\OppsController;
use App\Hydraulics\Contracting;
use App\Hydraulics\ZohoInvoice;
use Illuminate\Http\File;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class OppsObserver
{
    /**
     * Handle the Opp "created" event.
     *
     * @param  \App\Models\Opp  $opp
     * @return void
     */
    public function created(Opps $opp)
    {

                /*$items = array();
                foreach($opp->products as $product) {
                    $items[] = ['rate' => $product['attributes']['price'], 'productname' => $product['attributes']['product_name'], 'productfeature' => $product['attributes']['product_benefit']];
                }


                $invoicer = new ZohoInvoice();
                //$items = [['rate' => 300, 'productname'=>'The Nullifier','productfeature'=>'The Great Reset'],['rate' => 300, 'productname'=>'The Nullifier 2','productfeature'=>'The Great Reset 2']];
                $contact_id = $invoicer->getContactIDByName($opp->contact);
                if(!$contact_id) {
                $contact_id = $invoicer->createContact($opp->contact, $opp->email, $opp->company, $opp->website); }
                $items = $invoicer->lineItemParser($items);
                $inv_id = $invoicer->createInvoiceDraft($items,$contact_id);

                $auth = 'Zoho-oauthtoken '.$invoicer->access_token;
                $url = 'https://books.zoho.com/api/v3/invoices/'.$inv_id.'?organization_id=637404798&accept=pdf&print=true';

                //return response()->file($url);
                  $file = Http::withHeaders([
                  'Content-Type' => 'application/json',
                  'Authorization' => $auth
                  ])->get($url);
                  $path = 'invoice_'.rand(0, 1000).'.pdf';
                  Storage::put($path, $file);
                  $invoice_url = Storage::disk('s3')->url($path);




                $stakeholders = $opp->stakeholders;
                $products = $opp->products;
                $schedule = $opp->schedule;
                $terms = $opp->terms;
                $html = '<style>
                @font-face {
                  font-family: body;
                  src: url(\'fonts/roboto.ttf\') format(\'truetype\');
              }
              @font-face {
                font-family:headings;
                src: url(\'fonts/mont-bold.ttf\') format(\'truetype\');
            }

            .head_2 {
                font-family:headings;
                font-size:32px;
                page-break-before:always;
                page-break-inside: auto; 
            }


                    table,
                    th,
                    td {
                      border: 1px solid black;
                      border-collapse: collapse;
                      padding: 8px;
                      vertical-align:top;
                    }
                    h3, h1, th, strong {
                      font-family:body;
                    }
                    p, td, span, strong {
                        font-family:body;
                    }
                    .th {
                        background-color:#e2e2e2;
                        font-family:body;
                    }
                </style>
      <h1><span style="color: #0b6374;"><strong>Video AI Rent Roll Acceleration System</strong></span></h1>
                <h3>PREPARED FOR</h3>
                <span style="color: #424242;">{{client_name}}</span><br />
                <span style="color: #424242;">{{client_company}}</span>
                <h3>PREPARED BY</h3>
                <p><span style="color: #424242;">Kosta Kondratenko</span></p>
                <p style="text-align: right;"><span style="color: #424242;">{{date}}</span></p>
                <p style="text-align: right;">{{client_name}}</h3>
                <p style="text-align: right;">{{client_company}}</h3>
                <p style="text-align: right;"><span style="color: #31394d;">{{client_address}}</span></p>
                <p><span style="color: #424242;">Dear {{client_name}},</span></p>
                <p><span style="color: #424242;">{{email_body}}</span></p>
                <p><span style="color: #424242;">Yours Truly,</span><br /><span style="color: #424242;">Kosta Kondratenko</span></p>
                <p class="head_2">Executive Summary</h1>
                <p><span style="color: #424242;">{{executive_summary}}</span></p>
                <div>
                </div>
                <p class="head_2">1. Understanding the Challenge</p>
                <p>{{challenge}}</p>
                <p class="head_2">2. Proposed Solution</p>
                <p>{{solution}}</p>
                <div>
                <table style="border:1px black !important;">
                <tbody>
                <tr>
                <td class="th"><strong>Product</strong></td>
                <td class="th"><strong>Description</strong></td>
                <td class="th"><strong>Benefit</strong></td>
                </tr>
                '.Contracting::table_merge($products, 1).'</tbody>
                </table></div>
                <p class="head_2">3. Stakeholders</p>
                <p><span style="color: #424242;">Below will be the direct contact details of the Stakeholders involved in the Dashboard deliverable as well as their roles (minor and more major)</span></p>
                <div>
                <table>
                <tbody>
                <tr>
                <td class="th"><strong>Stakeholder Name<strong></td>
                <td class="th"><strong>Position<strong></td>
                <td class="th"><strong>Best Contact Details</strong></td>
                <td class="th"><strong>Responsibility</strong></td>
                </tr>'.Contracting::table_merge($stakeholders, 2).'</tbody>
                </table>
                </div>
                <p class="head_2">8. Proposed Schedule</p>
                <div>
                <table>
                <tbody>
                <tr>
                <td class="th"><span><strong>Project Activity</strong></span></td>
                <td class="th"><strong>Description</strong></td>
                <td class="th"><span><strong>Date of Completion</strong></span></td>
                </tr>'.Contracting::table_merge($schedule, 3).'</tbody>
                </table>
                </div><p class="head_2">7. Terms &amp; Conditions</p>'.Contracting::term_spit($terms);
                $html = Contracting::merge($html, $opp->contact, $opp->company, $opp->exec_summary, $opp->email_body, $opp->challenge, $opp->address, $opp->solution);
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
                /*
                $pdf = Pdf::loadHTML($html);
                Storage::put('agreement/Rent_Roll_Growth_Framework_Agreement.pdf', $pdf->stream());
                $url = Storage::disk('s3')->url('agreement/Rent_Roll_Growth_Framework_Agreement.pdf');
                $guarantee = Storage::disk('s3')->url('pdf/Your_Guarantee.pdf');
                $details = [
                    'title' => 'Mail from The Meastro',
                    'name' => $opp->contact,
                    'body' => $opp->email_body,
                    'image' => $url,
                    'guarantee' => $guarantee,
                    'invoice' => $invoice_url
                ];

                \Mail::to($opp->email)->cc('kosta@headstudios.com.au')->send(new \App\Mail\OppsEmail($details));

                $client = new \HelloSign\Client('2db138074a1580285659e1f4b87ca25944f66b5c8c6723d7719f14b0a585ecd3');
                $request = new \HelloSign\SignatureRequest;
                $request->enableTestMode();
                $request->setTitle('Rent Roll Growth Agreement Signature');
                $request->setSubject('Rent Roll Growth Agreement');
                $request->setMessage('Please sign this agreement to proceed with the Rent Roll Growth Implmentation Framework. Let me know if you have any questions.');
                $request->addSigner($opp->email, $opp->contact);
                $request->addFileURL($url);
                $response = $client->sendSignatureRequest($request);
*/

    }

    /**
     * Handle the Opp "updated" event.
     *
     * @param  \App\Models\Opp  $opp
     * @return void
     */
    public function updated(Opps $opp)
    {
        /*$stakes = $opp->stakeholders;
        OppsController::doIt();
        //name = $stake[1]['attributes']['name'];
        foreach($stakes as $stake) {
            $response = Http::post('https://webhook.site/7058c084-b629-4f76-bd4e-d42e856339fb', [
                'Value' => $opp->contact,
                'Now' => 'Awake',
                'Position' => $stake['attributes']['name']
            ]);
        }*/

    }

    /**
     * Handle the Opp "deleted" event.
     *
     * @param  \App\Models\Opps  $opp
     * @return void
     */
    public function deleted(Opps $opp)
    {
        //
    }

    /**
     * Handle the Opp "restored" event.
     *
     * @param  \App\Models\Opps  $opp
     * @return void
     */
    public function restored(Opps $opp)
    {
        //
    }

    /**
     * Handle the Opp "force deleted" event.
     *
     * @param  \App\Models\Opps  $opp
     * @return void
     */
    public function forceDeleted(Opps $opp)
    {
        //
    }
}
