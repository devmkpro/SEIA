<div class="col-sm-12 col-md-6 col-lg-8 d-flex justify-content-start align-items-center">
    <label for="nome_responsavel">Nome do responsável: </label>
    <input type="text" name="nome_responsavel" id="nome_responsavel" value="{{$user->datauser->name_responsible ?? 'Não informado'}}" class="w-100" disabled>
</div>
<div class="col-sm-12 col-md-6 col-lg-4 d-flex justify-content-start align-items-center">
    <label for="cpf_responsavel">CPF do responsável: </label>
    <input type="text" name="cpf_responsavel" id="cpf_responsavel" value="{{$user->datauser->cpf_responsible}}" class="w-100" disabled>
</div>
