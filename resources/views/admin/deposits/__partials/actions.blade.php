@if($deposit->status == 'pending')
    <a class="btn btn-sm btn-success"
       href="{{ route('admin.deposits.edit', $deposit->id) }}">Accept</a>
    <button data-id="{{ $deposit->id }}"
            class="btn btn-sm btn-danger cancel">Cancel
    </button>
@else
    @if($deposit->status == 'cancelled')
        <button data-id="{{ $deposit->id }}"
                class="btn btn-sm btn-warning recover">Recover
        </button>
    @endif
    <a class="btn btn-sm btn-info"
       href="{{ route('admin.deposits.show', $deposit->id) }}">View
        details</a>
@endif
