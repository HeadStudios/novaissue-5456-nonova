@php
use App\Hydraulics\Contracting;
use Illuminate\Support\Str;
$data = (object) $data;

@endphp
<style>
                @font-face {
                  font-family: body;
                  src: url('fonts/roboto.ttf') format('truetype');
              }
              @font-face {
                font-family: headings;
                src: url('fonts/mont-bold.ttf') format('truetype');
            }

            @font-face {
    font-family: 'Montseratt';
    src: url('fonts/mont-regular.ttf') format('truetype');
}

body, p {
    font-family: 'Montseratt', sans-serif;
  color: #424242;
}

.monts, span, p {
    font-family: 'Montseratt', sans-serif;
    margin: 0;
  padding: 0;
  line-height: 1;
  color: #424242;
}

            .head_2 {
                font-family:headings;
                font-size:32px;
                page-break-before:always;
                page-break-inside: auto; 
            }

            .h2 {
              font-family:headings;
                font-size:24px;
            }



                    table,
                    th,
                    td {
                      border: 1px solid black;
                      border-collapse: collapse;
                      padding: 8px;
                      vertical-align:top;
                    }

                    h1 {
                      font-family: 'Montseratt', sans-serif;
                      font-size: 48px;
                      color: #0b6374;
                      font-weight: 1000;
                    }

                    h3, th, strong {
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
      <h1>Video AI Rent Roll Acceleration System</h1>
                <h3 class="monts">PREPARED FOR</h3>
                <span style="text-align: right;" class="monts">{{ $data->name }}</span><br />
                <span style="text-align: right;" class="monts">{{ $data->company }}</span>
                <h3 class="monts" style="text-align:right;">PREPARED BY</h3>
                <span style="float:right;" class="monts">Kosta Kondratenko</span><br />
                <span style="float:right;" class="monts">{{ \Carbon\Carbon::now()->toFormattedDateString() }}</span>
                
                <p class="monts">Dear {{ $data->name }},</p>                
                <div class="monts">{!! Str::markdown($data->body) !!} </div>
                <p><span style="color: #424242;">Yours Truly,</span><br /><span style="color: #424242;">Kosta Kondratenko</span></p>
                <p class="head_2">Executive Summary</h1>
                @php
                
                
                @endphp
                <div class="monts">{{ nl2br($data->summary) }}</div>
                <div class="monts"><p>Here is some text</p><p>Let's go now</p></div>
                <div class="monts">I guess as soon as paragraphs come through it's over right -t his text is good</div>
                <div>
                </div>
                <p class="head_2">1. Understanding the Challenge</p>
                <p class="monts">{{ nl2br($data->challenge) }}</p>
                <p class="head_2">2. Proposed Solution</p>
                <p></p>
                <div>

                <table style="border:1px black !important;">
                <tbody>
                <tr>
                      <td colspan="3" class="th"><strong>Deliverable Summary</strong></td>
                  </tr>
                @foreach($data->products as $product)
                    <tr>
                      <td colspan="3" class="th"><strong>{{ $product->attributes->product_name }}</strong></td>
                  </tr>
                  <tr>
                <td class="th"><strong>Product</strong></td>
                <td class="th"><strong>Description</strong></td>
                <td class="th"><strong>Benefit</strong></td>
                </tr>
                  @foreach($product->attributes->itemised_price as $item)
                  <tr>
                <td><strong>{{$item->attributes->product_name}}</strong></td>
                <td><strong>{{$item->attributes->product_feature}}</strong></td>
                <td><strong>{{$item->attributes->product_benefit}}</strong></td>
                </tr>
                 
                    
                  @endforeach
                @endforeach
                  </tbody>
                  </table>

                <table style="border:1px black !important;">
                <tbody>
                <tr>
                <td class="th"><strong>Product</strong></td>
                <td class="th"><strong>Description</strong></td>
                <td class="th"><strong>Benefit</strong></td>
                </tr>
                {!! Contracting::table_merge($data->products, 1) !!}
               </tbody>
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
                </tr>{!! Contracting::table_merge($data->stakeholders, 2) !!}</tbody>
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
                </tr>{!! Contracting::table_merge($data->schedule, 3) !!}</tbody>
                </table>
                </div><p class="head_2">7. Terms &amp; Conditions</p>
                {!! Contracting::term_spit($data->terms) !!}