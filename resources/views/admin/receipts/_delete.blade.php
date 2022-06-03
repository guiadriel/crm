<form action="{{ route('receipts.destroy', $receipt)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover esse registro? <br/> <strong>Caso já foi confirmado como pago, o registro será removido dos lançamentos</strong>', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
