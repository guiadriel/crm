<form id="subcategory_form" name="subcategory_form" action="{{ route('sub-categories.destroy', $subcategory)}}"
      method="post"
      class='d-inline'
      onSubmit="CustomDialog.submit('Deseja remover essa sub-categoria?', this)">
  @csrf
  @method('DELETE')
  <button type="submit" class='btn {{ $large ?? 'btn-sm' }}  btn-outline-primary'>REMOVER</button>
</form>
