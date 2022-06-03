<form action="{{ route('categories.destroy', $category)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover essa categoria?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary mt-1'>REMOVER</button>
</form>
