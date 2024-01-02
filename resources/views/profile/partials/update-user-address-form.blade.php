<div class="col-12 row">
    <div class="col-sm-12 col-md-8 d-flex justify-content-center align-items-baseline gap-1">
        <label for="logradouro">Logradouro: </label>
        <input type="text" name="logradouro" id="logradouro" value="{{$user->datauser->street}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="numero">Número: </label>
        <input type="text" name="numero" id="numero" value="{{$user->datauser->number ?? 'Sem número'}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="complemento">Complemento: </label>
        <input type="text" name="complemento" id="complemento" value="{{$user->datauser->complement ?? 'Sem complemento'}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="zona">Zona: </label>
        <input type="text" name="zona" id="zona" value="{{$user->datauser->zone}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6  col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="bairro">Bairro: </label>
        <input type="text" name="bairro" id="bairro" value="{{$user->datauser->district}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="cep">CEP: </label>
        <input type="text" name="cep" id="cep" value="{{$user->datauser->zip_code}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="cidade">Cidade: </label>
        <input type="text" name="cidade" id="cidade" value="{{$user->datauser->city}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="estado">Estado: </label>
        <input type="text" name="estado" id="estado" value="{{$user->datauser->state}}" class="w-100" disabled>
    </div>
</div>
