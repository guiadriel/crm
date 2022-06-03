<div class="form-group row">
    <div class="col-2">
        <label class="my-1 mr-2" for="gender">Gênero</label>
        <select name="gender"
                id="gender"
                class='w-100'>
            <option value="M" @if( isset($student->gender) && $student->gender === 'M') selected @endif>Masculino</option>
            <option value="F" @if( isset($student->gender) && $student->gender === 'F') selected @endif>Feminino</option>
        </select>
    </div>

    <div class="col-3">
        <label for="rg">RG</label>
        <input type="rg"
                name="rg"
                id="rg"
                value="{{ $student->rg ?? old('rg') }}"
                class="@error('rg') is-invalid @enderror">

        @error('rg')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-3">
        <label for="cpf">CPF</label>
        <input type="cpf"
                name="cpf"
                id="cpf"
                value="{{ $student->cpf ?? old('cpf') }}"
                class="@error('cpf') is-invalid @enderror">

        @error('cpf')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-2">
        <label for="phone_message">Telefone (Recado)</label>
        <input type="text"
                name="phone_message"
                id="phone_message"
                value="{{ $student->phone_message ?? old('phone_message') }}"
                class="@error('phone_message') is-invalid @enderror mask-phone">

        @error('phone_message')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="col-2">
        <label for="birthday_date">Dt. Nascimento</label>
        <input type="text"
                name="birthday_date"
                id="birthday_date"
                value="{{ $student->birthday_date ?? old('birthday_date') }}"
                class="@error('birthday_date') is-invalid @enderror mask-date-only">

        @error('birthday_date')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="form-group row">
    <div class="col-12">
        <label for="email">Email</label>
        <input type="email"
                name="email"
                id="email"
                value="{{ $student->email ?? old('email') }}"
                class="@error('email') is-invalid @enderror">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="row mb-2">
    <div class="col-2">
        <label for="zip_code">Cep</label>
        <input type="zip_code"
                name="zip_code"
                id="zip_code"
                value="{{ $student->zip_code ?? old('zip_code') }}"
                class="@error('zip_code') is-invalid @enderror">

        @error('zip_code')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-8">
        <label for="address">Endereço</label>
        <input type="text"
                name="address"
                id="address"
                value="{{ $student->address ?? old('address') }}"
                class="@error('address') is-invalid @enderror">

        @error('address')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-2">
        <label for="number">Número</label>
        <input type="text"
                name="number"
                id="number"
                value="{{ $student->number ?? old('number') }}"
                class="@error('number') is-invalid @enderror">

        @error('number')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="row mb-2">
    <div class="col-5">
        <label for="neighborhood">Bairro</label>
        <input type="text"
                name="neighborhood"
                id="neighborhood"
                value="{{ $student->neighborhood ?? old('neighborhood') }}"
                class="@error('neighborhood') is-invalid @enderror">

        @error('neighborhood')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-5">
        <label for="city">Cidade</label>
        <input type="text"
                name="city"
                id="city"
                value="{{ $student->city ?? old('city') }}"
                class="@error('city') is-invalid @enderror">

        @error('city')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-2">
        <label for="state">Estado</label>
        <input type="text"
                name="state"
                id="state"
                value="{{ $student->state ?? old('state') }}"
                class="@error('state') is-invalid @enderror">

        @error('state')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="form-group row">
    <div class="col-6">
        <label for="instagram">Instagram</label>
        <input type="text"
                name="instagram"
                id="instagram"
                value="{{ $student->instagram ?? old('instagram') }}"
                class="@error('instagram') is-invalid @enderror">

        @error('instagram')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="col-6">
        <label for="facebook">Facebook</label>
        <input type="text"
                name="facebook"
                id="facebook"
                value="{{ $student->facebook ?? old('facebook') }}"
                class="@error('facebook') is-invalid @enderror">

        @error('facebook')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<script>
    $(function () {
        $("#zip_code").blur( async function(){
            if($(this).val() != ""){
                const formattedZipCode = $(this).val().replace(/[^0-9]/g, '');

                $("body").LoadingOverlay('show');
                const address = await  window.axios.get(`https://viacep.com.br/ws/${formattedZipCode}/json/`).then(res => res.data);
                $("body").LoadingOverlay('hide');

                $("#address").val(address.logradouro);
                $("#neighborhood").val(address.bairro);
                $("#city").val(address.localidade);
                $("#state").val(address.uf);
            }
        })
    });
</script>
