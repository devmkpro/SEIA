<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    @endsection
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                @schoolPermission('create-any-class', optional($school_home)->uuid)
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-seia-oceanblue" data-bs-toggle="modal"
                                data-bs-target="#addClasses">
                                Adicionar Turma
                            </button>
                        </div>
                    </div>
                @endschoolPermission
                <x-grid-datatables identifier="addclassesTable" :columns="['Cód', 'Nome', 'Status', 'Ano Letivo', 'Turno', 'Máximo de alunos', 'Ações']" />
            </div>
        </div>
    </div>

    @schoolPermission('create-any-class', optional($school_home)->uuid)
        <x-modal titleModal="Adicionar nova Turma" identifier="addClasses" id="addclassesTable">
            <div class="me-3 ms-3 mt-2">
                <form action="{{ route('manage.classes.store') }}" method="POST" id="addclassesTableForm">
                    @csrf
                    @method('POST')


                    <h5 class="mt-3 h5">Dados da Turma</h5>
                    <small class="text-muted">Os campos marcados com
                        <span class="text-danger">*</span>
                        são obrigatórios</small>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nome
                                    <span class="text-danger">*</span>

                                </label>
                                <input type="text" class="form-control" id="name" name="nome"
                                    placeholder="Nome da Turma" value="{{ old('nome') }}" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="modalidade" class="form-label">Modalidade de ensino
                                </label>
                                <span class="text-danger">*</span>
                                <select class="form-select" aria-label="Default select example" id="modalidade"
                                    name="modalidade" required value="{{ old('modalidade') }}">
                                    <option value="regular">Regular</option>
                                    <option value="eja">EJA</option>
                                    <option value="eja_fundamental">EJA Fundamental</option>
                                    <option value="eja_medio">EJA Médio</option>
                                </select>
                            </div>
                        </div>
                    </div>



                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="turno" class="form-label">Turno
                                    <span class="text-danger">*</span>

                                </label>
                                <select class="form-select" aria-label="Default select example" id="turno"
                                    name="turno" required value="{{ old('turno') }}">
                                    <option value="morning">Manhã</option>
                                    <option value="afternoon">Tarde</option>
                                    <option value="night">Noite</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="max_estudantes" class="form-label">Máximo de alunos
                                    <span class="text-danger">*</span>

                                </label>
                                <input type="number" class="form-control" id="max_estudantes" name="max_estudantes"
                                    placeholder="Máximo de alunos" value="{{ old('max_estudantes') }}" required>
                            </div>
                        </div>
                    </div>

                    <h5 class="mt-3 h5">Dias letivos</h5>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="domingo" class="form-label">Domingo</label>
                                <select class="form-select" aria-label="Default select example" id="domingo"
                                    name="domingo" required value="{{ old('domingo') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="segunda" class="form-label">Segunda-feira</label>
                                <select class="form-select" aria-label="Default select example" id="segunda"
                                    name="segunda" required value="{{ old('segunda') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="terca" class="form-label">Terça-feira</label>
                                <select class="form-select" aria-label="Default select example" id="terca"
                                    name="terca" required value="{{ old('terca') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quarta" class="form-label">Quarta-feira</label>
                                <select class="form-select" aria-label="Default select example" id="quarta"
                                    name="quarta" required value="{{ old('quarta') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="quinta" class="form-label">Quinta-feira</label>
                                <select class="form-select" aria-label="Default select example" id="quinta"
                                    name="quinta" required value="{{ old('quinta') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sexta" class="form-label">Sexta-feira</label>
                                <select class="form-select" aria-label="Default select example" id="sexta"
                                    name="sexta" required value="{{ old('sexta') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sabado" class="form-label">Sábado</label>
                                <select class="form-select" aria-label="Default select example" id="sabado"
                                    name="sabado" required value="{{ old('sabado') }}">
                                    <option value="1">Sim</option>
                                    <option value="0">Não</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="sala" class="form-label">Sala
                                </label>
                                <input type="text" class="form-control" id="sala" name="sala"
                                    placeholder="Digite a sala da turma" value="{{ old('sala') }}">
                            </div>
                        </div>

                    </div>



            </div>
        </x-modal>
        </form>
    @endschoolPermission


    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#addclassesTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.classes.index') }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "code",
                        },
                        {
                            "data": "name",
                        },
                        {
                            "data": "status",
                        },
                        {
                            "data": "school_year",
                        },
                        {
                            "data": "turno",
                        },
                        {
                            "data": "max_students",
                        },
                        {
                            "render": function(data, type, row, meta) {
                                return `
                                    <a href="/gerenciar/turmas/${row.code}/editar" class="btn btn-sm btn-seia-oceanblue">Gerenciar</a>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endsection
</x-app-layout>
