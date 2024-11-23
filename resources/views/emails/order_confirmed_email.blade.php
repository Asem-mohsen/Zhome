@extends('layouts.email')

@section('title','Order Confirmed')

@section('content')

    <td class="content-cell">
        <div class="f-fallback">
            <h1>Hi, {{ $userName }}!</h1>
            <p>Thank you for your order with {{ $appName }}. We’re processing your order and will let you know once it’s on its way.</p>

            <h2>Order Summary</h2>

            @foreach($orders as $order)
                <h2>Order ID: {{ $order->id }}</h2>
                <p>Total Amount: {{ number_format($order->total_amount, 2) }} {{ $order->currency }}</p>
                <h3>Items:</h3>
                <table class="order-items" role="presentation" width="100%" style="border-collapse: collapse;">
                    @foreach($order->items as $item)
                        <tr style="border-bottom: 1px solid #eee;">
                            <td width="15%">
                                <img src="{{ $item->product->image_url }}" alt="{{ $item->product->transaltions->name }}" style="max-width: 100%; border-radius: 4px;">
                            </td>
                            <td width="60%">
                                <p style="margin: 0;"><strong>{{ $item->product->transaltions->name }}</strong></p>
                                <p style="margin: 0; color: #555;">{{ $item->product->description }}</p>
                            </td>
                            <td width="10%" style="text-align: center;">
                                <p style="margin: 0;">Quantity: {{ $item->quantity }}</p>
                            </td>
                            <td width="15%" style="text-align: right;">
                                <p style="margin: 0;">{{ number_format($item->total_price, 2) }} {{ $order->currency }}</p>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endforeach

            <p>If you have any questions, feel free to reach out to us at <a href="mailto:{{ $supportMail }}">{{ $supportMail }}</a>.</p>

            <p>Thank you for choosing {{ $appName }}!</p>

            <!-- Sub copy -->
            <table class="body-sub" role="presentation">
                <tr>
                    <td>
                        <p class="f-fallback sub">
                            Best regards, <br>
                            The {{ $appName }} Team
                        </p>
                    </td>
                </tr>
            </table>
        </div>
    </td>
@endsection
