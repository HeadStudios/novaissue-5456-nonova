@php
use App\Hydraulics\Contracting;
use Illuminate\Support\Str;
use Illuminate\Mail\Markdown;
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
                font-family: 'Montseratt Bold';
                font-style: normal;
                font-weight: bold;
                src: url('fonts/mont-bold.ttf') format('truetype');
            }

            @font-face {
    font-family: 'Montseratt';
    src: url('fonts/mont-regular.ttf') format('truetype');
}

body, p, div {
    /*font-family: 'Montseratt', sans-serif;*/
  color: #424242;
}

.monts, span, p, td, span {
    font-family: 'Montseratt', sans-serif;
    padding: 0;
    line-height: 2;
    color: #424242;
}


            

            .head_2 {
              font-family: 'Montseratt Bold';
                font-size:32px;
                page-break-before:always;
                page-break-inside: auto; 
            }

            .h2 {
              font-family: 'Montseratt Bold';
                font-size:24px;
            }

            



                    table,
                    th,
                    td {
                      border: 1px solid black;
                      border-collapse: collapse;
                      padding: 8px;
                      vertical-align:top;
                      line-height: 1.3;
                      
                    }
                    .th {
                      background-color:#e2e2e2;
                      line-height: 1.5;
                    }

                    h1 {
                      font-family: 'Montseratt Bold', sans-serif;
                      font-size: 60px;
                      color: #0b6374;
                      line-height: 1;
                      margin: 0;
                    }

                    .noheight { 
                      line-height: 1;
                    }

                    
                
                    strong {
                        
                        font-family: 'Montseratt Bold';
                       
                    }
                    h3 + p {
                    margin-top: 0;
                  }
                  h5 + p {
                    margin-top: 0;
                  }
                    h3 {
                    font-family: 'Montseratt Bold';
                    font-size: 36px;
                    page-break-before:always;

                    margin:0;
                    margin-bottom: 10px;
                    line-height: 1;
                     }
                     h5 {
                      font-size: 18px;
                      margin: 0;
                     }
                </style>
      <h1>Video AI Rent Roll Acceleration System</h1>
      <div class="monts">
                <h5 ><strong>PREPARED FOR</strong></h5>
                <div style="text-align: left" class="monts noheight">
                {{ $data->name }}<br />
                {{ $data->company }}
                  </div>
                <h5 style="text-align:right;"><strong>PREPARED BY</strong></h5>
                <div style="text-align: right" class="monts noheight">
                Kosta Kondratenko noheight<br />
               {{ \Carbon\Carbon::now()->toFormattedDateString() }}
                  </div>
                
                <p class="monts">Dear {{ $data->name }},</p>                
                <div class="monts">{!! Str::markdown($data->body) !!} </div>
                <p><span style="color: #424242;">Yours Truly,</span><br /><span style="color: #424242;">Kosta Kondratenko</span></p>
                <h3>Executive Summary</h3>
                <div class="monts">{!! nl2br($data->summary) !!}</div>
                <div>
                </div>
                <h3>1. Understanding the Challenge</h3>
                <p class="monts">{!! nl2br($data->challenge) !!}</p>
                <h3>2. Proposed Solution</h3>
                <p></p>
                <div>

                <table style="border:1px black !important;width:100%">
                <tbody>
                <!--<tr>
                      <td colspan="3" class="th"><strong>Deliverable Summary</strong></td>
                  </tr>-->
                @foreach($data->products as $product)
                    <tr>
                      <td colspan="3" class="th"><strong>{{ $product->product_name }} walked in on demon time</strong><br />
                      {{ $product->product_feature }}</td>
                  </tr>
                  <tr>
                <td class="th"><strong>Product</strong></td>
                <td class="th"><strong>Description</strong></td>
                <td class="th"><strong>Benefit</strong></td>
                </tr>
                  @foreach($product->itemised_price as $item)
                  <tr>
                <td>{{$item->attributes->product_name}}</td>
                <td>{{$item->attributes->product_feature}}</td>
                <td>{{$item->attributes->product_benefit}}</td>
                </tr>
                 
                    
                  @endforeach
                @endforeach
                  </tbody>
                  </table>

              </div>
                <h3>3. Stakeholders</h3>
                <p><span style="color: #424242;">Below will be the direct contact details of the Stakeholders involved in the Dashboard deliverable as well as their roles (minor and more major)</span></p>
                <div>
                <table style="width:100%">
                <tbody>
                <tr>
                <td class="th"><strong>Stakeholder Name<strong></td>
                <td class="th"><strong>Position<strong></td>
                <td class="th"><strong>Best Contact Details</strong></td>
                <td class="th"><strong>Responsibility</strong></td>
                </tr>
              
                                <!-- First table row with Contact model's details -->
                <!-- First table row with Contact model's details -->
                <tr>
                    <td>{{ $data->contact->name }}</td>
                    <td>Principal</td>
                    <td>{{ $data->contact->mobile }}, {{ $data->contact->email }}</td>
                    <td>Main decision maker</td>
                </tr>

                <!-- Subsequent table rows with Stakeholder model's details -->
                @foreach($data->stakeholders as $stakeholder)
                    <tr>
                        <td>{{ $stakeholder->name }}</td>
                        <td>{{ $stakeholder->position }}</td>
                        <td>{{ $stakeholder->mobile }}, {{ $stakeholder->email }}</td>
                        <td>{{ $stakeholder->responsibility }}</td>
                    </tr>
                @endforeach

              
                </tbody>
                </table>
                </div>
                <h3>8. Proposed Schedule</h3>
                <div>
                <table>
                <tbody>
                <tr>
                <td class="th"><span><strong>Project Activity</strong></span></td>
                <td class="th"><strong>Description</strong></td>
                <td class="th"><span><strong>Date of Completion</strong></span></td>
                </tr>
                @foreach($data->schedule as $schedule)
                <tr>
                  <td> {{$schedule->activity }}</td>
                  <td>{!! Markdown::parse($schedule->description) !!}</td>
                  <td> {{ date('l, jS F Y', strtotime($schedule->completion)) }}</td>
                </tr>
                @endforeach

                </tbody>
                </table>
                </div>
                <h3>7. Terms &amp; Conditions</h3>
                @foreach($data->terms as $term)
                <h5><strong> {{ $term->headline }}</strong></h5>
                <p> {!! Markdown::parse($term->description) !!} </p>
                @endforeach
                  </div>