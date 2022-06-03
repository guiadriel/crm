<form action="{{ route('contracts-payment.renderpdf', $contract)}}"
    method="POST"
    target="_blank">
    @csrf
    @method('POST')
    <button class="btn {{ $large ?? 'btn-sm' }} btn-dark mr-2">GERAR PDF</button>
</form>
