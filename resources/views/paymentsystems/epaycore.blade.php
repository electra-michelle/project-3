<form action="https://api.epaycore.com/checkout/form" method="POST">
    @foreach($params AS $key => $value)
        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
    @endforeach
    <input type="hidden" name="epc_sign" value="{{ $sign }}">
    <button type="submit"  class="custom-btn">Make Payment</button>
</form>
