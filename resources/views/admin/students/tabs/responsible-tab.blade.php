<div class="form-group row">
    <div class="col-9 pb-3">
        <div class="custom-control custom-switch">
            <input
                type="checkbox"
                class="custom-control-input"
                id="has_responsible"
                name="has_responsible"
                @if( isset($student->responsible_id) && $student->responsible_id ) checked @endif
                >
            <label class="custom-control-label" for="has_responsible">Possui responsável</label>
        </div>
    </div>
    <div class="col-9">
        <label for="responsible_name">Nome do responsável</label>
        <input type="text"
                name="responsible_name"
                id="responsible_name"
                value="{{ $student->responsible->name ?? old('responsible_name') }}"
                class="@error('responsible_name') is-invalid @enderror">

        @error('responsible_name')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-3">
        <label for="responsible_phone">Telefone</label>
        <input type="text"
                name="responsible_phone"
                id="responsible_phone"
                value="{{ $student->responsible->phone ?? old('responsible_phone') }}"
                class="@error('responsible_phone') is-invalid @enderror mask-phone"
                >

        @error('responsible_phone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <div class="col-2">
        <label class="my-1 mr-2" for="responsible_gender">Gênero</label>
        <select name="responsible_gender"
                id="responsible_gender"
                class='w-100'>
            <option value="M" @if( isset($student->responsible->gender) && $student->responsible->gender === 'M') selected @endif>Masculino</option>
            <option value="F" @if( isset($student->responsible->gender) && $student->responsible->gender === 'F') selected @endif>Feminino</option>
        </select>
    </div>

    <div class="col-3">
        <label for="responsible_rg">RG</label>
        <input type="responsible_rg"
                name="responsible_rg"
                id="responsible_rg"
                value="{{ $student->responsible->rg ?? old('responsible_rg') }}"
                class="@error('responsible_rg') is-invalid @enderror">

        @error('responsible_rg')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-3">
        <label for="responsible_cpf">CPF</label>
        <input type="responsible_cpf"
                name="responsible_cpf"
                id="responsible_cpf"
                value="{{ $student->responsible->cpf ?? old('responsible_cpf') }}"
                class="@error('responsible_cpf') is-invalid @enderror">

        @error('responsible_cpf')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>



    <div class="col-2">
        <label for="responsible_birthday_date">Dt. Nascimento</label>
        <input type="text"
                name="responsible_birthday_date"
                id="responsible_birthday_date"
                value="{{ $student->responsible->birthday_date ?? old('responsible_birthday_date') }}"
                class="@error('responsible_birthday_date') is-invalid @enderror mask-date">

        @error('responsible_birthday_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <label for="responsible_email">Email</label>
        <input type="responsible_email"
                name="responsible_email"
                id="responsible_email"
                value="{{ $student->responsible->email ?? old('responsible_email') }}"
                class="@error('responsible_email') is-invalid @enderror">

        @error('responsible_email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-2">
    <div class="col-2">
        <label for="responsible_zip_code">Cep</label>
        <input type="responsible_zip_code"
                name="responsible_zip_code"
                id="responsible_zip_code"
                value="{{ $student->responsible->zip_code ?? old('responsible_zip_code') }}"
                class="@error('responsible_zip_code') is-invalid @enderror">

        @error('responsible_zip_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-8">
        <label for="responsible_address">Endereço</label>
        <input type="text"
                name="responsible_address"
                id="responsible_address"
                value="{{ $student->responsible->address ?? old('responsible_address') }}"
                class="@error('responsible_address') is-invalid @enderror">

        @error('responsible_address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-2">
        <label for="responsible_number">Número</label>
        <input type="text"
                name="responsible_number"
                id="responsible_number"
                value="{{ $student->responsible->number ?? old('responsible_number') }}"
                class="@error('responsible_number') is-invalid @enderror">

        @error('responsible_number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="row mb-2">
    <div class="col-5">
        <label for="responsible_neighborhood">Bairro</label>
        <input type="text"
                name="responsible_neighborhood"
                id="responsible_neighborhood"
                value="{{ $student->responsible->neighborhood ?? old('responsible_neighborhood') }}"
                class="@error('responsible_neighborhood') is-invalid @enderror">

        @error('responsible_neighborhood')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-5">
        <label for="responsible_city">Cidade</label>
        <input type="text"
                name="responsible_city"
                id="responsible_city"
                value="{{ $student->responsible->city ?? old('responsible_city') }}"
                class="@error('responsible_city') is-invalid @enderror">

        @error('responsible_city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-2">
        <label for="responsible_state">Estado</label>
        <input type="text"
                name="responsible_state"
                id="responsible_state"
                value="{{ $student->responsible->state ?? old('responsible_state') }}"
                class="@error('responsible_state') is-invalid @enderror">

        @error('responsible_state')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<script>
    $(function () {
        $("#responsible_zip_code").blur( async function(){
            if($(this).val() != ""){
                const formattedZipCode = $(this).val().replace(/[^0-9]/g, '');

                $("body").LoadingOverlay('show');
                const address = await  window.axios.get(`https://viacep.com.br/ws/${formattedZipCode}/json/`).then(res => res.data);
                $("body").LoadingOverlay('hide');

                $("#responsible_address").val(address.logradouro);
                $("#responsible_neighborhood").val(address.bairro);
                $("#responsible_city").val(address.localidade);
                $("#responsible_state").val(address.uf);
            }
        })
    });
</script>
