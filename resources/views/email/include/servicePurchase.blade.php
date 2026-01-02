<div style="margin: 20px;">
    {{-- Service Details --}}
    <div style="width: 100%; overflow-x: auto; margin: 20px 0;">


        <table style="width: 100%; border-collapse: collapse; font-family: arial, helvetica, sans-serif;">
            <thead>
                <tr>
                    <th
                        style="width: 25%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc;">
                        Service
                        Name</th>
                    <th
                        style="width: 15%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc;">
                        Price</th>
                    <th
                        style="width: 15%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc;">
                        Qty</th>
                    <th
                        style="width: 25%; padding: 10px; font-weight: 600; color: #333; background-color: #f0f0f0; border: 1px solid #ccc; text-align: right;">
                        Total</th>
                </tr>
            </thead>
            @php
                $orderdata = \App\Models\ServiceOrder::where('order_id', $maildata->order_id)->get();

            @endphp
            {{-- {{
                                    dd($maildata->order_id
                                    ); }} --}}

            <tbody>
                @foreach ($orderdata as $key => $value)
                    @php
                        if ($value->service_type == 'product') {
                            $ServiceData = \App\Models\Product::find($value->service_id);
                        }
                        if ($value->service_type == 'unit') {
                            $ServiceData = \App\Models\ServiceUnit::find($value->service_id);
                        }

                    @endphp
                    <tr>
                        <td style="width: 25%; padding: 10px; color: #333; border: 1px solid #ccc;">
                            {{ $ServiceData->product_name }}
                        </td>

                        <td style="width: 15%; padding: 10px; color: #333; border: 1px solid #ccc;">
                            ${{ number_format($ServiceData->discounted_amount ?? $ServiceData->amount, 2) }}
                        </td>

                        <td style="width: 15%; padding: 10px; color: #333; border: 1px solid #ccc;">
                            {{ $value->qty }}
                        </td>

                        <td style="width: 25%; padding: 10px; color: #333; border: 1px solid #ccc; text-align: right;">
                            ${{ number_format($value->qty * ($ServiceData->discounted_amount ?? $ServiceData->amount), 2) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Services Details End
                                --}}
    {{-- {{
                                dd($maildata->sub_amount);
                                }} --}}
    @php $Totalgiftamount = 0; @endphp

    @if (!empty($maildata->gift_card_amount))
        @php
            $giftamount = explode('|', $maildata->gift_card_amount);
            foreach ($giftamount as $value) {
                $Totalgiftamount += (float) $value;
            }
        @endphp
    @endif


    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr style="background-color: #f0f0f0; border: 1px solid #ccc;">
                <td style="width: 50%; padding: 10px; color: #333; font-weight: bold; border: none;">
                    Subtotal
                </td>
                <td style="width: 50%; text-align: right; padding: 10px; color: #333; font-weight: bold; border: none;">
                    ${{ $maildata->sub_amount }}
                </td>
            </tr>
            <tr style="background-color: #f0f0f0; border: 1px solid #ccc;">
                <td style="width: 50%; padding: 10px; color: #333; border: none;">
                    Giftcard
                    Applied
                </td>
                <td style="width: 50%; text-align: right; padding: 10px; color: #d9534f; border: none;">
                    - ${{ $Totalgiftamount }}
                </td>
            </tr>
            <tr style="background-color: #f0f0f0; border: 1px solid #ccc;">
                <td style="width: 50%; padding: 10px; color: #333; border: none;">
                    Tax <span style="color: #666;">({{ $maildata->taxrate ?? 0 }}%)</span>
                </td>
                <td style="width: 50%; text-align: right; padding: 10px; color: #333; border: none;">
                    +${{ $maildata->tax_amount }}
                </td>
            </tr>
            <tr style="background-color: #e0e0e0; border: 1px solid #ccc;">
                <td
                    style="width: 50%; padding: 10px; color: #333; font-weight: bold; font-size: 18px; border-top: none;">
                    Grand Total
                </td>
                <td
                    style="width: 50%; text-align: right; padding: 10px; color: #333; font-weight: bold; font-size: 18px; border-top: none;">
                    ${{ $maildata->final_amount }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- For Terms &amp;
                                Condition --}}
    <div style="width: 100%; margin: 20px 0; font-family: Arial, Helvetica, sans-serif;">
        <h2 style="margin-bottom: 10px;">Terms
            &amp;
            Conditions</h2>

        @php
            $orders = \App\Models\ServiceOrder::where('order_id', $maildata->order_id)->get();
            $grouped = [];
        @endphp

        @foreach ($orders as $item)
            @php
                $service = null;
                $desc = 'No terms available.';

                if ($item->service_type === 'product') {
                    $service = \App\Models\Product::find($item->service_id);

                    $term = \DB::table('terms')
                        ->where('status', 1)
                        ->whereRaw("FIND_IN_SET(?, REPLACE(service_id, '|', ','))", [$item->service_id])
                        ->first();

                    $desc = $term->description ?? $desc;
                } elseif ($item->service_type === 'unit') {
                    $service = \App\Models\ServiceUnit::find($item->service_id);

                    $term = \DB::table('terms')
                        ->where('status', 1)
                        ->whereRaw("FIND_IN_SET(?, REPLACE(unit_id, '|', ','))", [$item->service_id])
                        ->first();

                    $desc = $term->description ?? $desc;
                }

                if ($service && $service->product_name) {
                    $grouped[$desc][] = $service->product_name;
                }
            @endphp
        @endforeach

        {{-- Render grouped rows
                                    --}}


        {{-- 📌 READABLE SERVICE
                                    NAME UI (Bullet List)
                                    --}}



        <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
            <thead>

                <tr>
                    <th style="padding: 10px; background: #f7f7f7; border: 1px solid #ddd; text-align: left;">
                        Service
                        Name</th>
                    <th style="padding: 10px; background: #f7f7f7; border: 1px solid #ddd; text-align: left;">
                        Terms
                        &amp;
                        Conditions</th>
                </tr>

            </thead>

            <tbody>
                @foreach ($grouped as $description => $names)
                    <tr>
                        <td style="padding: 10px; border: 1px solid #ddd; width: 35%; line-height: 1.6;">
                            <ul style="margin: 0; padding-left: 18px;">
                                @foreach ($names as $sname)
                                    <li style="margin-bottom: 4px;">{{ $sname }}</li>
                                @endforeach
                            </ul>
                        </td>

                        <td style="padding: 10px; border: 1px solid #ddd; width: 65%; line-height: 1.6;">
                            {!! $description !!}
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    {{-- End Terms And
                                Conditions --}}
</div>
