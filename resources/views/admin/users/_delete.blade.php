<form action="{{ route('users.destroy', $user)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover esse usuário?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
