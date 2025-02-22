<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')

    @php
        $totalChSubject = $curriculum->subjects->sum('ch');
        $limitChSubject = $curriculum->total_hours;
        $percentChSubject = ($totalChSubject * 100) / $limitChSubject;
    @endphp

    @if ($percentChSubject > 100)
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Atenção!</h4>
            <p>A carga horária das disciplinas cadastradas ultrapassa a carga horária total da matriz curricular.</p>
            <hr>
            <p class="mb-0">Carga horária total da matriz curricular: {{ $limitChSubject }} horas.</p>
            <p class="mb-0">Carga horária total das disciplinas cadastradas: {{ $totalChSubject }} horas.</p>
        </div>
    @endif

    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    @endsection

    <div class="row">
        <div class="col-sm-12">
            <div class="card">

                <div class="row">
                    <div class="col-md-6">
                        <a href="{{ route('manage.curriculum') }}" class="btn btn btn-seia-jeans">Voltar para matrizes </a>
                    </div>
                    @schoolPermission('create-any-subject', optional($school_home)->uuid)
                        <div class="col-md-6">
                            <div class="d-flex justify-content-end mb-3">
                                <button type="button" class="btn btn-seia-oceanblue" data-bs-toggle="modal"
                                    data-bs-target="#createSubjectModal">
                                    Cadastrar Disciplina
                                </button>
                            </div>
                        </div>
                    @endschoolPermission
                </div>
            

                <x-grid-datatables identifier="subjectsTable" :columns="['Nome', 'Carga Horária', 'Carga Horária Semanal', 'Modalidade', 'Descrição', 'Ações']" />

            </div>
        </div>
    </div>

    @schoolPermission('create-any-subject', optional($school_home)->uuid)
        <x-modal titleModal="Cadastro de Disciplinas" identifier="createSubjectModal" id="createSubjectModal">
            <form action="{{ route('manage.subjects.store') }}" method="POST" id="addSubjectForm">
                @csrf
                @method('POST')
                <div class="row ms-2 me-2">

                    <input type="hidden" name="curriculum" value="{{ $curriculum->code }}">

                    <div class="col-md-12 mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <select class="form-select" name="nome" value="{{ old('nome') }}" required>
                            <option selected>Selecione uma disciplina</option>
                            <option value="artes">Artes</option>
                            <option value="biologia">Biologia</option>
                            <option value="ciencias">Ciências</option>
                            <option value="educacao-fisica">Educação Física</option>
                            <option value="filosofia">Filosofia</option>
                            <option value="fisica">Física</option>
                            <option value="geografia">Geografia</option>
                            <option value="historia">História</option>
                            <option value="ingles">Inglês</option>
                            <option value="literatura">Literatura</option>
                            <option value="matematica">Matemática</option>
                            <option value="portugues">Língua Portuguesa</option>
                            <option value="quimica">Química</option>
                            <option value="sociologia">Sociologia</option>
                            <option value="ensino-religioso">Ensino Religioso</option>
                            <option value="other">Outra</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="carga_horaria" class="form-label">Carga Horária</label>
                            <input type="number" class="form-control" name="carga_horaria" value="{{ old('carga_horaria') }}"
                                placeholder="Ex: 200" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="carga_horaria_semanal" class="form-label">Carga Horária Semanal</label>
                            <input type="number" class="form-control" name="carga_horaria_semanal" value="{{ old('carga_horaria_semanal') }}"
                                placeholder="Ex: 15" required>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" rows="3" placeholder="Ex: Disciplina de Matemática" required>{{ old('descricao') }}</textarea>
                        <small class="text-muted">* Por favor, adicione uma descrição caso tenha escolhido a opção
                            "Outra" no campo "Nome".</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="modalidade" class="form-label">Modalidade</label>
                        <select class="form-select" name="modalidade" value="{{ old('modalidade') }}" required>
                            <option selected>Selecione uma modalidade</option>
                            <option value="linguagens-e-suas-tecnologias">Linguagens e suas tecnologias</option>
                            <option value="ciencias-da-natureza-e-suas-tecnologias">Ciências da Natureza e suas
                                tecnologias</option>
                            <option value="ciencias-humanas-e-suas-tecnologias">Ciências Humanas e suas tecnologias
                            </option>
                            <option value="estudos-literarios">Estudos Literários</option>
                            <option value="ensino-religioso">Ensino Religioso</option>
                            <option value="parte-diversificada">Parte Diversificada</option>
                        </select>
                    </div>
                </div>


        </x-modal>
        </form>
    @endschoolPermission

    @schoolPermission('update-any-subject', optional($school_home)->uuid)
        <x-modal titleModal="Editar Disciplina" identifier="editSchoolYear" id="editSchoolYear">
            <form action="{{ route('manage.subjects.update') }}" method="POST" id="editSubjectForm">
                @csrf
                @method('PUT')

                <input type="hidden" name="curriculum" value="{{ $curriculum->code }}">

                <div class="row ms-2 me-2">
                    <div class="col-md-12 mb-3">
                        <label for="nome" class="form-label">Nome</label>
                        <select class="form-select" name="nome" id="name" value="#" required>
                            <option selected>Selecione uma disciplina</option>
                            <option value="artes">Artes</option>
                            <option value="biologia">Biologia</option>
                            <option value="ciencias">Ciências</option>
                            <option value="educacao-fisica">Educação Física</option>
                            <option value="filosofia">Filosofia</option>
                            <option value="fisica">Física</option>
                            <option value="geografia">Geografia</option>
                            <option value="historia">História</option>
                            <option value="ingles">Inglês</option>
                            <option value="literatura">Literatura</option>
                            <option value="matematica">Matemática</option>
                            <option value="portugues">Língua Portuguesa</option>
                            <option value="quimica">Química</option>
                            <option value="sociologia">Sociologia</option>
                            <option value="ensino-religioso">Ensino Religioso</option>
                            <option value="other">Outra</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="carga_horaria" class="form-label">Carga Horária</label>
                            <input type="number" class="form-control" name="carga_horaria" id="ch" value=""
                                placeholder="Ex: 200" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="carga_horaria_semanal" class="form-label">Carga Horária Semanal</label>
                            <input type="number" class="form-control" name="carga_horaria_semanal" id="ch_week" value=""
                                placeholder="Ex: 15" required>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" name="descricao" id="description" rows="3"
                            placeholder="Ex: Disciplina de Matemática" required></textarea>
                        <small class="text-muted">* Por favor, adicione uma descrição caso tenha escolhido a opção
                            "Outra" no campo "Nome".</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="modalidade" class="form-label">Modalidade</label>
                        <select class="form-select" name="modalidade" id="modality" value="" required>
                            <option selected>Selecione uma modalidade</option>
                            <option value="linguagens-e-suas-tecnologias">Linguagens e suas tecnologias</option>
                            <option value="ciencias-da-natureza-e-suas-tecnologias">Ciências da Natureza e suas
                                tecnologias</option>
                            <option value="ciencias-humanas-e-suas-tecnologias">Ciências Humanas e suas tecnologias
                            </option>
                            <option value="estudos-literarios">Estudos Literários</option>
                            <option value="ensino-religioso">Ensino Religioso</option>
                            <option value="parte-diversificada">Parte Diversificada</option>
                        </select>
                    </div>
                </div>


        </x-modal>
        </form>


        <script>
            function editSubjectCurriculum(uuid) {
                $.ajax({
                    url: '{{route("manage.subjects.show")}}',
                    data: {
                        'subject': uuid
                    },
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#name').val(data.name);
                        $('#ch').val(data.ch);
                        $('#ch_week').val(data.ch_week);
                        $('#description').val(data.description);
                        $('#modality').val(data.modality);
                        $('#editSubjectForm').find('input[name="subject"]').remove();
                        $('#editSubjectForm').append('<input type="hidden" name="subject" value="' + data.uuid +
                            '">');
                        $('#editSubjectForm').attr('action', '{{ route("manage.subjects.update") }}');
                    } , error: function(data) {
                        location.reload();
                    }
                });
            }
        </script>
    @endschoolPermission


    @section('scripts')
        <script>
            $('#subjectsTable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                },
                "ajax": {
                    "url": "{{ route('manage.subjects.index') }}",
                    "data": {
                        "curriculum": "{{ $curriculum->code }}"
                    },
                    "type": "GET",
                    "dataSrc": ""
                },
                "columns": [{
                        "data": "name"
                    },
                    {
                        "data": "ch"
                    },
                    {
                        "data": "ch_week"
                    },
                    {
                        "data": "modality"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "id",
                        "render": function(data, type, row, meta) {
                            return `
                    <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editSchoolYear" onclick="editSubjectCurriculum('${row.uuid}')">Editar</button>
                    @schoolPermission('delete-any-subject', optional($school_home)->uuid)
                    <form action="{{ route('manage.subjects.destroy') }}" method="POST" class="d-inline-block">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="subject" value="${row.uuid}">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Excluir</button>
                    </form>
                    @endschoolPermission
                `;
                        }
                    }
                ]
            });
        </script>
    @endsection
</x-app-layout>
