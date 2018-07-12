
<div class="row">
    <div class="col-md-4">
        <button class="btn btn-success" id="print_button"><i class="fa fa-print"></i>Print Check</button>
        <div id="page_print">
            <div id="page_content">
                <h5 class="text-center">Central Park Wheels</h5>
                <h2>BIKE RENTAL & GUIDED TOURS</h2>
                <table>
                    <tr>
                        <td style="top: 0; margin-top: 0">address:</td>
                        <td>1409 6th Ave, New York, NY 10019  </td>
                    </tr>
                    <tr>
                        <td>phone:</td>
                        <td>212-960-3637</td>
                    </tr>
                    <tr>
                        <td>Served By:</td>
                        <td>{{ Auth::user()->name }}</td>
                    </tr>
                    <tr>
                        <td>Rent Date:</td>
                        <td>{{ date('m-d-Y',strtotime($rental->created_at)) }}</td>
                    </tr>
                    <tr>
                        <td>Rent time:</td>
                        <td>{{ date('h:i A',strtotime($rental->created_at)) }}</td>
                    </tr>
                    <tr><td colspan="2">
                            <b>Customer info</b>
                        </td>
                    </tr>
                    <tr>
                        <td>Name:</td>
                        <td>{{ $rental->user_get->name.' '.$rental->user_get->second_name }}</td>
                    </tr>
                    <tr>
                        <td>Phone:</td>
                        <td>{{ $rental->user_get->phone }}</td>
                    </tr>
                    <tr>
                        <td>Hotel:</td>
                        <td>{{ $rental->user_get->address }}</td>
                    </tr>
                    <tr>
                        <td>Bikes:</td>
                         <td>
                        @foreach($biketypes as $biketype)
                            @foreach($rental_bikes as $rental_bike)
                                @if ($biketype->id == $rental_bike->bike_type_id)
                                     {{$biketype->name}}: <b>{{$rental_bike->count}}</b>/
                                @endif
                             @endforeach
                         @endforeach
                        </td>
                    </tr>
                    <tr>
                        <td>Duration:</td>
                        <td>{{ date('m-d-Y h:i A',strtotime($rental->sale->date_time_out)) }}</td>
                    </tr>
                    <tr>
                        <td>Must return by:</td>
                        <td>{{ date('m-d-Y h:i A',strtotime($rental->sale->date_time_in)) }}</td>
                    </tr>
                    @if(!empty($accessories))
                    <tr>
                        <td>Accessories:</td>
                        <td>Helmet: <b>{{$accessories->helmet}}</b>/
                            Lock: <b>{{$accessories->lock}}</b>/
                            Basket: <b>{{$accessories->basket}} </b>/
                            Baby seat: <b>{{$accessories->baby_seat}}</b>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Insurance:</td>
                        <td>${{$rental->sale->insurance}}</td>
                    </tr>
                    <tr>
                        <td>Deposit/ID:</td>
                        <td>{{ $rental->sale->id }}</td>
                    </tr>
                    <tr>
                        <td>Discount:</td>
                        <td>${{$rental->sale->dis}} </td>
                    </tr>
                    <tr>
                        <td>Total:</td>
                        <td><b>${{$rental->sale->total-($rental->sale->tax)}}</b></td>
                    </tr>
                    <tr>
                        <td>NYC Tax({{ $tax }}%)</td>
                        <td><b>${{($rental->sale->tax)}}</b></td>
                    </tr>
                    <tr>
                        <td>Total after Tax(cash):</td>
                        <td><b>${{ $rental->sale->total }}</b></td>
                    </tr>
                </table>
                <h5 class="text-center">Terms and Conditions</h5>
                <p class="page_content_text">
                    <b>Activity.</b> I have chosen to rent and participate in bike rental services (hereinafter referred to as “the Activity,” which is organized by Central Park Wheels (hereinafter referred to as “CPW”). I understand that the Activity is inherently hazardous and i may be exposed to dangers and hazards, including some of the following: falls, injuries associated with a fall, injuries from lack of fitness, death, equipment failures and negligence of others. As a consequence of these riskis, i may be seriously hurt or disabled or may die from the resulting injuries and my property may also be damaged. In consideration of the permission to participate in the Activity, i agree to the terms and contained in this contract. I agree to the follow the rules and directions for the Activity, including any New York State traffic laws and park rules.
                </p>
                <p class="page_content_text">
                    <b>Liability.</b> All adult customers assume full liability and ride at their own risk. If you feel that you or anyone in your party cannot operate a bicycle safely and competently, that person should not rent or ride bicycle. All children are to be supervised at all times by their parents or adult over the age of 18. Children under the age of 14 must wear a helmet pursuant to New York State Law. With the purchase of bicycle services, you hereby release and hold harmless from all liabilities, causes of action, claims and demands that may arise in any way from injury, death, loss or harm that may occur. This release does not extend to any claims for gross negligence, international or reckless misconduct. I acknowledge that CPW has to control over and assumes no responsibility for the actions of any independent contractors providing any services for the Activity.
                </p>
                <p class="page_content_text">
                    <b>Bike Rental Insurance:</b> Bike rental insurance is available at additional cost. Customer who didn’t purchase bike rental insurance, have to pay full amount $400 for a lost or stolen bike. Customers who had purchased Bike Rental Insurance are indemnified and protected against 100% of the cost of damages and repairs; and 50% of replacement cost. Customers are not responsible for costs of repairs to damages bicycles during normal use, wear and tear when they purchase Bike Rental Insurance. Bike Rental Insurance does not indemnify for any cost or liability that arises as a result of personal injury, coverage shall apply only to property damage. Bike Rental Insurance includes damaged bike pick up within Central Park only.
                </p>
                <p class="page_content_text">
                    <b>Late Fee:</b> A 15 minute grace period shall be allowed for the return of bicycles following the cessation of bike rental period, with no late fee charged. If you don’t return any bicycle or child seat for any reason before that 15 - minute grace period, the hourly late fee begins calculating and you will be required to pay an appropriate late fee. Late Fee Prices: Adult Bikes, Child Bikes and Child Bike Trailers =$10 per bike-per hour, Tandem Bikes, Road Bikes, Mountain Bikes and Hand-cycles =$20 per hour per bike; Child Seat $5 per hour per seat. Late Fee may not be waived except by cause or emergency, and only approval of Manager.
                </p>
                <p class="page_content_text">
                    <b>All Sales Are Final:​</b> No bicycle may be rented without signature and liability acceptance of responsible adult. No cash refund for any reason; nor may the store credit be applied for unused bicycle during rental time.
                </p>
                <br>
                <p>
                    ____________________________________ Signature
                </p>
            </div>
        </div>
    </div>
</div>