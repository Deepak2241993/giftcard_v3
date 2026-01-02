<div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">
    <div class="panel" style="line-height: 24px; padding-left: 20px; font-size: 16px; word-wrap: break-word; font-family: arial, helvetica, sans-serif;">
        <strong>Refund Amount:</strong> ${{ number_format($maildata->amount / 100, 2) }}<br>
        <strong>Refund Reason:</strong> {{ $maildata->reason ?? 'N/A' }}<br>
        <strong>Refund Status:</strong> {{ ucfirst($maildata->status) }}<br>
        <strong>Payment Intent:</strong> {{ $maildata->payment_intent }}<br>
    </div>
</div>