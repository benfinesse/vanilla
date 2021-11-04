<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>Print Out</title>
    <link href="{{ storage_path('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    {{--<link rel='stylesheet' href='{{ asset('app/assets/css/dashlite.css') }}'>--}}
    {{--<link rel="stylesheet" href="{{ asset('app/assets/css/theme.css') }}">--}}

    <style>.half_width{width: 50%}.purchase_slip{display: block}</style>
    <style type="text/css">
        @page  {size: landscape}
        @media print{.page-break{page-break-before: always}}
        div.card{
            border: none !important;
        }
    </style>

</head>
    <body>
        <div class="purchase_slip">
            <h6 class="mb-4 mt-4">Purchase Details</h6>
            <div class=" mt-1">

                <?php $grand_total = 0; ?>
                <?php $grand_true_total = 0; ?>
                <?php $page_count = 0; ?>
                @foreach($record->groups as $group_rec)
                    <div class="mb-5 mt-5 {{ $page_count>0?"page-break":"" }}">
                        <div class="card">
                            <div class="row mb-3">
                                <div class="col-6">
                                    <h6 class="">
                                        {{ $group_rec->group->name }} Records
                                    </h6>
                                </div>
                                <div class="col-6">
                                    <h6>
                                        Date: ............................................................
                                    </h6>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered">
                                    <thead class="thead-dark">
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th colspan="3" class="text-uppercase text-center">Shopping Budget</th>
                                        <th colspan="4" class="text-uppercase text-center">Shopping List</th>
                                    </tr>
                                    <tr>
                                        <th scope="col" style="width: 50px">SUP</th>
                                        <th scope="col">ITEM </th>
                                        <th scope="col" style="font-size: 12px">Measure</th>
                                        <th scope="col">Stock <br> Outside</th>
                                        <th scope="col">Stock <br> Store</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Qty</th>
                                        <th scope="col">Item</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody class="card_table_content">
                                    <?php $total = 0; ?>
                                    <?php $true_total = 0; ?>
                                    <?php $table_items = $group_rec->recordItems->count(); ?>
                                    <?php $solved = 0; ?>
                                    <?php $gtotal = 0; ?>

                                    @foreach($group_rec->recordItems as $item)
                                        <?php $ttotal = 0; ?>
                                        <tr>
                                            <td>{{ $item->supplier }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td>{{ $item->measure }}</td>
                                            <td>{{ $item->stock_outside }}</td>
                                            <td>{{ $item->stock_store }}</td>
                                            <td>
                                                <div>
                                                    {{ $item->qty }}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ number_format($item->price) }}
                                                </div>
                                            </td>
                                            <td>

                                                <div>
                                                    {{ number_format($item->total) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if(!empty($item->true_qty))
                                                    @if($item->true_qty)
                                                        {{ $item->true_qty }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td></td>
                                            <td>
                                                @if(!empty($item->true_price))
                                                    @if($item->true_price>0)
                                                        {{ number_format($item->true_price) }}
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($item->true_qty) && !empty($item->true_price))
                                                    <?php $ttotal+= $item->true_qty * $item->true_price; ?>
                                                    {{ number_format($ttotal) }}
                                                @endif
                                            </td>
                                        </tr>

                                        <?php $total+=$item->total; ?>
                                        <?php $gtotal+= $ttotal; ?>

                                        <?php $solved++; ?>
                                        @if($solved===$table_items)
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td style="font-size: 12px">
                                                    <b>SubTotal <br> Cash:</b>
                                                </td>
                                                <td>
                                                    <b>{{ number_format($total) }}</b>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td style="font-size: 12px">
                                                    <b>SubTotal <br> Cash:</b>
                                                </td>
                                                <td>
                                                    <b></b>
                                                </td>

                                            </tr>

                                        @endif
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <br>
                        </div>
                    </div>
                    <?php $page_count++; ?>
                @endforeach

            </div>
        </div>
    </body>
</html>


