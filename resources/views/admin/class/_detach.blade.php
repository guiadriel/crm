<form action="{{ route('class.detach', $class ?? $groupclass)}}"
      method="delete"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover esse aluno da turma?', this)">
  @csrf
  @method('DELETE')
  <input type="hidden" id="student" name="student" value="{{$student->id}}">
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
