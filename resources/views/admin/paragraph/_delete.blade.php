<form action="{{ route('paragraph.destroy', $paragraph)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover esse registro?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
