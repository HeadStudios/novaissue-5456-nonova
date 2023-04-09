<style>
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