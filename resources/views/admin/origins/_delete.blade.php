<form action="{{ route('origins.destroy', $origin)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover essa origem de cadastro?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
