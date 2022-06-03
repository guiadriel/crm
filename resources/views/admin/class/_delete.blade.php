<form action="{{ route('class.destroy', $class ?? $groupclass)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover essa turma?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
