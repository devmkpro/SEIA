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

                @schoolPermission('create-any-subject', optional($school_home)->uuid)
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#createSubjectModal">
                                Cadastrar Disciplina
                            </button>
                        </div>
                    </div>
                @endschoolPermission

                <x-grid-datatables identifier="subjectsTable" :columns="['Nome', 'Carga Horária', 'Carga Horária Semanal', 'Modalidade', 'Descrição', 'Ações']" />

                <div class="card-footer">
                    <a href="{{ route('manage.curriculum') }}" class="btn btn-primary">Voltar para o Gerenciamento de
                        Matriz</a>
                </div>
            </div>
        </div>
    </div>

    @schoolPermission('create-any-subject', optional($school_home)->uuid)
        <x-modal titleModal="Cadastro de Disciplinas" identifier="createSubjectModal" id="createSubjectModal">
            <form action="{{ route('manage.subjects.store', $curriculum->code) }}" method="POST" id="addSubjectForm">
                @csrf
                @method('POST')

                <div class="row ms-2 me-2">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <select class="form-select" name="name" value="{{ old('name') }}" required>
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
                            <label for="ch" class="form-label">Carga Horária</label>
                            <input type="number" class="form-control" name="ch" value="{{ old('ch') }}"
                                placeholder="Ex: 200" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ch_week" class="form-label">Carga Horária Semanal</label>
                            <input type="number" class="form-control" name="ch_week" value="{{ old('ch_week') }}"
                                placeholder="Ex: 15" required>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Ex: Disciplina de Matemática" required>{{ old('description') }}</textarea>
                        <small class="text-muted">* Por favor, adicione uma descrição caso tenha escolhido a opção
                            "Outra" no campo "Nome".</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="modality" class="form-label">Modalidade</label>
                        <select class="form-select" name="modality" value="{{ old('modality') }}" required>
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
            <form action="{{ route('manage.subjects.update', $curriculum->code) }}" method="POST" id="editSubjectForm">
                @csrf
                @method('PUT')

                <div class="row ms-2 me-2">
                    <div class="col-md-12 mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <select class="form-select" name="name" id="name" value="#" required>
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
                            <label for="ch" class="form-label">Carga Horária</label>
                            <input type="number" class="form-control" name="ch" id="ch" value=""
                                placeholder="Ex: 200" required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="ch_week" class="form-label">Carga Horária Semanal</label>
                            <input type="number" class="form-control" name="ch_week" id="ch_week" value=""
                                placeholder="Ex: 15" required>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Descrição</label>
                        <textarea class="form-control" name="description" id="description" rows="3"
                            placeholder="Ex: Disciplina de Matemática" required></textarea>
                        <small class="text-muted">* Por favor, adicione uma descrição caso tenha escolhido a opção
                            "Outra" no campo "Nome".</small>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label for="modality" class="form-label">Modalidade</label>
                        <select class="form-select" name="modality" id="modality" value="" required>
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
                    url: '/api/verify/subjects/'.concat(uuid),
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
                        $('#editSubjectForm').attr('action', '{{ route('manage.subjects.update') }}');
                    },
                });
            }
        </script>
    @endschoolPermission



    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#subjectsTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "/api/verify/subjects/curriculum/".concat({{ $curriculum->code }}),
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
                                    <button  type="button" class="btn btn-outline-primary btn-sm " data-bs-toggle="modal" data-bs-target="#editSchoolYear" onclick="editSubjectCurriculum('${row.uuid}')">Editar</button>
                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-danger">Excluir</button>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endsection
</x-app-layout>
