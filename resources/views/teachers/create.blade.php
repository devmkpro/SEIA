<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                  <form action="{{route('manage.classes.teachers.store', $class->code)}}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="name">Nome
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="nome" id="name" class="form-control"
                                placeholder="Nome do professor" value="{{ old('nome') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="email">E-mail
                                <span class="text-danger">*</span>
                            </label>
                            <input type="email" name="email" id="email" class="form-control"
                                placeholder="E-mail do professor" value="{{ old('email') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="phone">Celular
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="celular" id="phone" class="form-control"
                                placeholder="Celular do professor" value="{{ old('celular') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="telefone_fixo">Telefone Fixo

                            </label>
                            <input type="text" name="telefone_fixo" id="landline" class="form-control"
                                placeholder="Telefone do professor" value="{{ old('telefone_fixo') }}" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="cpf">CPF
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="cpf" id="cpf" class="form-control"
                                placeholder="CPF do professor" value="{{ old('cpf') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="rg">RG
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="rg" id="rg" class="form-control"
                                placeholder="RG do professor" value="{{ old('rg') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="inep">INEP do professor
                            </label>
                            <input type="text" name="inep" id="inep" class="form-control"
                                placeholder="INEP do professor" value="{{ old('inep') }}" >
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="data_nascimento">Data de nascimento
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date" name="data_nascimento" id="birth_date" class="form-control"
                                placeholder="Data de nascimento do professor" value="{{ old('data_nascimento') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="genero">Gênero
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="genero" id="gender">
                                <option value="M">Masculino</option>
                                <option value="F">Feminino</option>
                                <option value="NB">Não binário</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="naturalidade">País de nascimento
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="naturalidade" id="country" class="form-control"
                                placeholder="Ex: Brasil" value="{{ old('naturalidade') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="logradouro">Logradouro
                                
                            </label>
                            <input type="text" name="logradouro" id="street" class="form-control"
                                placeholder="Ex: Rua, Avenida, Travessa" value="{{ old('logradouro') }}" >
                        </div>

                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="bairro">Bairro
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="bairro" id="district" class="form-control"
                                placeholder="Ex: Rua, Avenida, Travessa" value="{{ old('bairro') }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="estado">Estado de moradia
                                <span class="text-danger">*</span>

                            </label>
                            <select name="estado" id="state" class="form-select"
                                aria-label="Default select example">
                                <option selected value="0">Selecione o estado</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->ibge_code }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="cidade">Cidade de moradia
                                <span class="text-danger">*</span>

                            </label>
                            <select name="cidade" id="city" class="form-select" value="{{ old('cidade') }}">
                                <option selected value="0">Selecione um estado</option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-4 mb-2">
                            <label for="cep">CEP
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text" name="cep" id="zip_code" class="form-control"
                                placeholder="Ex: 00000-000" value="{{ old('cep') }}" required>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="estado">Estado de nascimento
                                <span class="text-danger">*</span>

                            </label>
                            <select name="estado_nascimento" id="state_birth" class="form-select"
                                aria-label="Default select example" value="{{ old('estado_nascimento') }}">
                                <option selected value="0">Selecione o estado</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->ibge_code }}">{{ $state->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-2">
                            <label for="cidade">Cidade de nascimento
                                <span class="text-danger">*</span>

                            </label>
                            <select name="cidade_nascimento" id="city_birth" class="form-select"
                                value="{{ old('cidade_nascimento') }}">
                                <option selected value="0">Selecione um estado</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-2 mb-2">
                                <label for="numero">Número da moradia
                                </label>
                                <input type="text" name="numero" id="number" class="form-control"
                                    placeholder="Ex: 123" value="{{ old('numero') }}" >
                            </div>

                            <div class="col-sm-12 col-md-4 mb-2">
                                <label for="zona">Zona
                                    <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" name="zona" id="zone"
                                    value="{{ old('zona') }}">
                                    <option value="U">Urbana</option>
                                    <option value="R">Rural</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-6 mb-2">
                                <label for="nome_mae">Nome da mãe
                                </label>
                                <input type="text" name="nome_mae" id="mother_name" class="form-control"
                                    placeholder="Nome da mãe" value="{{ old('nome_mae') }}" >
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-4 mb-2">
                                <label for="nome_pai">Nome do pai

                                </label>
                                <input type="text" name="nome_pai" id="father_name" class="form-control"
                                    placeholder="Nome do pai" value="{{ old('nome_pai') }}" >
                            </div>
                            <div class="col-sm-12 col-md-4 mb-2">
                                <label for="tipo_sanguineo">Tipo sanguíneo

                                </label>
                                <select class="form-select" name="tipo_sanguineo" id="blood_type"
                                    value="{{ old('tipo_sanguineo') }}">
                                    <option value="" selected>Selecione um tipo sanguíneo</option>
                                    <option value="A+">A</option>
                                    <option value="B">B</option>
                                    <option value="AB">AB</option>
                                    <option value="O">O</option>
                                    <option value="Não sei">Não sei</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-4 mb-2">
                                <label for="deficiencia">Possui algum tipo de deficiência?
                                </label>
                                <select class="form-select" name="deficiencia" id="deficiency"
                                    value="{{ old('deficiencia') }}">
                                    <option value="0" selected>Não</option>
                                    <option value="1">Sim</option>
                                </select>
                            </div>
                        </div>
                        <div class="row ms-2 me-2">
                            <div class="col-12 d-flex justify-content-end mt-3 mb-2">
                                <button type="submit" class="btn btn btn-seia-oceanblue">Cadastrar</button>
                                <button type="button" class="btn btn-seia-red ms-2" data-bs-dismiss="modal"
                                    aria-label="Close">Cancelar</button>
                            </div>
                        </div>
                      </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @section('scripts')
        <script>
            $('#phone').mask('(00) 0000-0000');
            $('#landline').mask('(00) 0000-0000');
            $('#inep').mask('00000000');
            $('#cpf').mask('000.000.000-00');
            $('#rg').mask('00.000.000-0');
            $('#number').mask('0000');
            $('#zip_code').mask('00000-000');
            
            

            function populateCities(element, state_code) {
                var url = "{{ route('manage.states.cities') }}";
                var token = "{{ csrf_token() }}";
                if (state_code == 0) {
                    $(element).empty();
                    $(element).append('<option value="" selected>Selecione um estado</option>');
                    return;
                }
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        code: state_code,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(response) {
                        $(element).empty();
                        $(element).append('<option value="" selected>Selecione uma cidade</option>');
                        $.each(response, function(index, value) {
                            $(element).append('<option value="' + value.ibge_code + '">' + value.name +
                                '</option>');
                        });
                    },
                });
            }

            $('#state_birth').change(function() {
                var state_code = $(this).val();
                populateCities('#city_birth', state_code);
            });

            $('#state').change(function() {
                var state_code = $(this).val();
                populateCities('#city', state_code);
            });
        </script>
    @endsection
</x-app-layout>
