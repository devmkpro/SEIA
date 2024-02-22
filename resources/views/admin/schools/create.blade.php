<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('manage.schools.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <label for="name">Nome
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Nome da escola" value="{{ old('name') }}" required>

                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="cnpj">CNPJ</label>
                                <input type="text" name="cnpj" id="cnpj" class="form-control"
                                    placeholder="CNPJ da escola" value="{{ old('cnpj') }}">
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <label for="email_responsible">E-mail do responsável
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email_responsible" id="email_responsible"
                                    class="form-control" placeholder="E-mail do responsável"
                                    value="{{ old('email_responsible') }}" required>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-6">
                                <label for="email">E-mail da escola
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="E-mail da escola" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-sm-12 col-md-3">
                                <label for="phone">Celular da escola
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="phone" id="phone" class="form-control"
                                    placeholder="Celular da escola" value="{{ old('phone') }}" required>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <label for="landline">Telefone fixo</label>
                                <input type="text" name="landline" id="landline" class="form-control"
                                    placeholder="Telefone da escola" value="{{ old('landline') }}">
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-4">
                                <label for="zip_code">CEP
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="zip_code" id="zip_code" class="form-control"
                                    placeholder="CEP da escola" value="{{ old('zip_code') }}" required>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="district">Bairro
                                    <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="district" id="district" class="form-control"
                                    placeholder="Bairro da escola" value="{{ old('district') }}" required>
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="street">Rua
                                </label>
                                <input type="text" name="street" id="street" class="form-control"
                                    placeholder="Rua da escola" value="{{ old('street') }}">
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-4">
                                <label for="inep">INEP

                                </label>
                                <input type="text" name="inep" id="inep" class="form-control"
                                    placeholder="INEP da escola" value="{{ old('inep') }}">
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="number">Número

                                </label>
                                <input type="text" name="number" id="number" class="form-control"
                                    placeholder="Número da escola" value="{{ old('number') }}" maxlength="10">
                            </div>

                            <div class="col-sm-12 col-md-4">
                                <label for="complement">Complemento
                                </label>
                                <input type="text" name="complement" id="complement" class="form-control"
                                    placeholder="Complemento da escola" value="{{ old('complement') }}">
                            </div>
                        </div>


                        <div class="row mt-2">
                            <div class="col-sm-12 col-md-3">
                                <label for="has_education_infant">Educação Infantil
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="has_education_infant" id="has_education_infant" class="form-control"
                                    value="{{ old('has_education_infant') }}" required>
                                    <option value="1" selected>Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <label for="has_education_fundamental">Ensino Fundamental
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="has_education_fundamental" id="has_education_fundamental"
                                    class="form-control" value="{{ old('has_education_fundamental') }}" required>
                                    <option value="1" selected>Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <label for="has_education_medium">Ensino Médio
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="has_education_medium" id="has_education_medium" class="form-control"
                                    value="{{ old('has_education_medium') }}" required>
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>
                            </div>

                            <div class="col-sm-12 col-md-3">
                                <label for="has_education_professional">Ensino Profissional
                                    <span class="text-danger">*</span>
                                </label>
                                <select name="has_education_professional" id="has_education_professional"
                                    class="form-control" value="{{ old('has_education_professional') }}" required>
                                    <option value="1">Sim</option>
                                    <option value="0" selected>Não</option>
                                </select>

                            </div>

                            <div class="row mt-2">
                                <div class="col-sm-12 col-md-4">
                                    <label for="public">Escola Pública
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="public" id="public" class="form-control"
                                        value="{{ old('public') }}" required>
                                        <option value="1" selected>Sim</option>
                                        <option value="0">Não</option>
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label for="state_code">Estado
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="state_code" id="state_code" class="form-control"
                                        value="{{ old('state_code') }}" required>
                                        <option value="0" selected>Selecione</option>
                                        @foreach ($states as $state)
                                            <option value="{{ $state->ibge_code }}">{{ $state->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-sm-12 col-md-4">
                                    <label for="city_code">Cidade
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="city_code" id="city_code" class="form-control"
                                        value="{{ old('city_code') }}" required>
                                        <option value="0" selected>Selecione um estado</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row ms-2 me-2 mt-2">
                            <div class="col-12 d-flex justify-content-end mt-3 mb-2">
                                <button type="submit" class="btn btn-outline-primary">Cadastrar</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script>
            $(document).ready(function() {

                $('#zip_code').mask('00000-000');
                $('#cnpj').mask('00.000.000/0000-00');
                $('#phone').mask('(00) 00000-0000');
                $('#landline').mask('0000-0000');
                $('#inep').mask('00000000');

                $('#state_code').change(function() {
                    var state_code = $(this).val();
                    var url = "{{ route('manage.location.states.cities') }}";
                    var token = "{{ csrf_token() }}";
                    if (state_code == 0) {
                        $('#city_code').empty();
                        $('#city_code').append('<option value="" selected>Selecione um estado</option>');
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
                            $('#city_code').empty();
                            $('#city_code').append(
                                '<option value="" selected>Selecione uma cidade</option>');
                            $.each(response, function(index, value) {
                                $('#city_code').append('<option value="' + value.ibge_code +
                                    '">' + value
                                    .name + '</option>');
                            });
                        }
                    });
                });
            });
        </script>
    @endsection


</x-app-layout>
