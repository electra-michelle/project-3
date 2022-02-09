@if($payout->status == 'pending')
    <button data-id="{{ $payout->id }}" class="btn btn-sm btn-success send">Send</button>
    <button data-id="{{ $payout->id }}" class="btn btn-sm btn-danger cancel">Cancel</button>
@endif
