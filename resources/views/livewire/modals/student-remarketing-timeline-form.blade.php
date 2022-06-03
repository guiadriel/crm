<div>
    <hr>
    <div class="row">
        <div class="form-group col-5">
            <label for="modal_timeline_who_contacted">Quem entrou em contato</label>
            <input type="text"
                    name="modal_timeline_who_contacted"
                    wire:model="who_contacted"
                    class="@error('modal_timeline_who_contacted') is-invalid @enderror">

            @error('modal_timeline_who_contacted')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-4">
            <label for="modal_timeline_type">Tipo de contato</label>
            <input type="text"
                    name="modal_timeline_type"
                    wire:model="type"
                    class="@error('modal_timeline_type') is-invalid @enderror">

            @error('modal_timeline_type')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="form-group col-3">
            <label for="modal_timeline_date">Data</label>
            <input type="date"
                    name="modal_timeline_date"
                    wire:model="date"
                    class="@error('modal_timeline_date') is-invalid @enderror">

            @error('modal_timeline_date')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12">
            <button type="button"
                    wire:click="createRecord"
                    class="btn btn-primary">SALVAR</button>
        </div>
    </div>
</div>
