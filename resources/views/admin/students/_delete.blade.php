<form action="{{ route('students.destroy', $student)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover esse aluno?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
