<form action="{{ route('contracts-models.destroy', $model)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover esse modelo?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
