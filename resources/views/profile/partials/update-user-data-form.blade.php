
<div class="col-sm-12 col-md-10 row">
    <div class="col-sm-12 col-md-7 d-flex justify-content-center align-items-baseline gap-1">
        <label for="name">Nome: </label>
        <input type="text" name="name" id="name" value="{{$user->name}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="phone">Celular: </label>
        <input type="text" name="phone" id="phone" value="{{$user->phone}}" class="w-100" disabled>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email" value="{{$user->email}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="cpf">CPF: </label>
        <input type="text" name="cpf" id="cpf" value="{{$user->datauser->cpf}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="rg">RG: </label>
        <input type="text" name="rg" id="rg" value="{{$user->datauser->rg}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="nascimento">Data de nascimento: </label>
        <input type="text" name="nascimento" id="nascimento" value="{{$user->datauser->birth_date->format('m/d/Y')}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="cor">Etnia: </label>
        <input type="text" name="cor" id="cor" value="{{$user->datauser->gender}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="sangue">Tipo sanguineo: </label>
        <input type="text" name="sangue" id="sangue" value="{{$user->datauser->blood_type ?? 'Não informado'}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="deficiencia">Deficiencia: </label>
        <input type="text" name="deficiencia" id="deficiencia" value="{{$user->datauser->deficiency ? 'Sim' : 'Não'}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="cidade_nascimento">Cidade de nascimento: </label>
        <input type="text" name="cidade_nascimento" id="cidade_nascimento" value="{{$user->datauser->city_birth}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-4 d-flex justify-content-center align-items-baseline gap-1">
        <label for="estado_nascimento">Estado de nascimento: </label>
        <input type="text" name="estado_nascimento" id="estado_nascimento" value="{{$user->datauser->state_birth}}" class="w-100" disabled>
    </div>

    <div class="col-sm-6 col-md-6 col-lg-6 d-flex justify-content-center align-items-baseline gap-1">
        <label for="matricula">Matricula: </label>
        <input type="text" name="matricula" id="matricula" value="{{$user->username}}" class="w-100" disabled>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 d-flex justify-content-center align-items-baseline gap-1">
        <label for="inep" class="w-25">Cod. INEP: </label>
        <input type="text" name="inep" id="inep" value="{{$user->datauser->inep}}" class="w-100" disabled>
    </div>
</div>
