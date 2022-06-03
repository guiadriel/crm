<form action="{{ route('roles.destroy', $role)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover essa função?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
