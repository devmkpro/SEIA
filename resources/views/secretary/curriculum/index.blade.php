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
                @schoolPermission('create-any-curriculum', optional($school_home)->uuid)
                    <div class="col-md-12">
                        <div class="d-flex justify-content-end mb-3">
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#addCurriculum">
                                Nova Matriz Curricular
                            </button>
                        </div>
                    </div>
                @endschoolPermission
                <x-grid-datatables identifier="schoolsTable" :columns="[
                    'Cód.',
                    'Série/Etapa',
                    'Modalidade',
                    'Horas semanais',
                    'Total de Horas',
                    'Hora início',
                    'Hora final',
                    'Ações',
                ]" />
            </div>
        </div>
    </div>

    @schoolPermission('create-any-curriculum', optional($school_home)->uuid)
        <x-modal titleModal="Nova Matriz Curricular: {{ optional($school_home)->name }}" identifier="addCurriculum"
            id="addCurriculum">
            <form action="{{ route('manage.curriculum.store') }}" method="POST" id="addCurriculumForm">
                @csrf
                @method('POST')
                <div class="row ms-2 me-2">
                    <div class="row mb-3">

                        <div class="col-md-12 mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" rows="3">{{ old('descricao') }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="serie" class="form-label">Série/Etapa</label>
                            <select class="form-select" name="serie" value="" required>
                                <option selected>Selecione uma série</option>
                                <option value="educ_infa_cc_0_3">Educacao Infantil - Creche (0 a 3 anos)</option>
                                <option value="educ_infa_cc_4_5">Educacao Infantil - Pre-escola (4 a 5 anos)</option>
                                <option value="educ_ini_1_5">Ensino Fundamental - Anos Iniciais (1 ao 5 ano)</option>
                                <option value="educ_ini_6_9">Ensino Fundamental - Anos Finais (6 ao 9 ano)</option>
                                <option value="educ_med_1">Ensino Medio - 1 serie</option>
                                <option value="educ_med_2">Ensino Medio - 2 serie</option>
                                <option value="educ_med_3">Ensino Medio - 3 serie</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="modalidade" class="form-label">Modalidade</label>
                            <select class="form-select" name="modalidade" value="" required>
                                <option selected>Selecione uma modalidade</option>
                                <option value="bercario">Berçário</option>
                                <option value="creche">Creche</option>
                                <option value="pre_escola">Pré-escola</option>
                                <option value="fundamental">Ensino Fundamental</option>
                                <option value="medio">Ensino Médio</option>
                                <option value="eja">EJA</option>
                                <option value="educacao_especial">Educação Especial</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="horas_semanais" class="form-label" required>Horas Semanais</label>
                            <input type="text" class="form-control" name="horas_semanais" placeholder="Ex. 40"
                                value="{{ old('horas_semanais') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="horas_totais" class="form-label" required>Horas Totais</label>
                            <input type="text" class="form-control" name="horas_totais" placeholder="Ex. 2000"
                                value="{{ old('horas_totais') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="hora_início" class="form-label" required>Hora de aula inicial</label>
                            <input type="time" class="form-control" name="hora_início" placeholder="Ex. 40"
                                value="{{ old('hora_início') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="hora_final" class="form-label" required>Hora de aula Final</label>
                            <input type="time" class="form-control" name="hora_final" placeholder="Ex. 2000"
                                value="{{ old('hora_final') }}" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="informacoes_complementares" class="form-label">Informações complementares</label>
                            <textarea class="form-control" name="informacoes_complementares" rows="3">{{ old('informacoes_complementares') }}</textarea>
                        </div>
                    </div>

                </div>


        </x-modal>
        </form>
    @endschoolPermission

    @schoolPermission('update-any-curriculum', optional($school_home)->uuid)
        <x-modal titleModal="Editar Matriz Curricular" identifier="editCurriculum" id="editCurriculum">
            <form action="" method="POST" id="editCurriculumForm">
                @csrf
                @method('PUT')
                <div class="row ms-2 me-2">
                    <div class="row mb-3">

                        <div class="col-md-12 mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" id="description" rows="3"></textarea>
                        </div>

                        <div class="col-md-6">
                            <label for="serie" class="form-label">Série/Etapa</label>
                            <select class="form-select" name="serie" id="series" required>
                                <option selected>Selecione uma série</option>
                                <option value="educ_infa_cc_0_3">Educacao Infantil - Creche (0 a 3 anos)</option>
                                <option value="educ_infa_cc_4_5">Educacao Infantil - Pre-escola (4 a 5 anos)</option>
                                <option value="educ_ini_1_5">Ensino Fundamental - Anos Iniciais (1 ao 5 ano)</option>
                                <option value="educ_ini_6_9">Ensino Fundamental - Anos Finais (6 ao 9 ano)</option>
                                <option value="educ_med_1">Ensino Medio - 1 serie</option>
                                <option value="educ_med_2">Ensino Medio - 2 serie</option>
                                <option value="educ_med_3">Ensino Medio - 3 serie</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="modalidade" class="form-label">Modalidade</label>
                            <select class="form-select" name="modalidade" id="modality" required>
                                <option selected>Selecione uma modalidade</option>
                                <option value="bercario">Berçário</option>
                                <option value="creche">Creche</option>
                                <option value="pre_escola">Pré-escola</option>
                                <option value="fundamental">Ensino Fundamental</option>
                                <option value="medio">Ensino Médio</option>
                                <option value="eja">EJA</option>
                                <option value="educacao_especial">Educação Especial</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="horas_semanais" class="form-label" required>Horas Semanais</label>
                                <input type="text" class="form-control" name="horas_semanais" id="weekly_hours"
                                    placeholder="Ex. 40" value="{{ old('horas_semanais') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="horas_totais" class="form-label" required>Horas Totais</label>
                                <input type="text" class="form-control" name="horas_totais" id="total_hours"
                                    placeholder="Ex. 2000" value="{{ old('horas_totais') }}" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="hora_início" class="form-label" required>Hora de aula inicial</label>
                                <input type="time" class="form-control" name="hora_início" id="start_time"
                                    placeholder="Ex. 40" value="{{ old('hora_início') }}" required>
                            </div>

                            <div class="col-md-6">
                                <label for="hora_final" class="form-label" required>Hora de aula Final</label>
                                <input type="time" class="form-control" name="hora_final" id="end_time"
                                    placeholder="Ex. 2000" value="{{ old('hora_final') }}" required>
                            </div>
                        </div>

                    </div>
                </div>
        </x-modal>
        </form>
    @endschoolPermission




    @section('scripts')
        <script>
            function showCurriculum(code) {
                $.ajax({
                    url: "{{ route('manage.curriculum.show') }}",
                    data: {
                        curriculum: code
                    },
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('#editCurriculumForm').attr('action', "{{ route('manage.curriculum.update') }}");
                        $('#editCurriculumForm').attr('method', "POST");
                        $('#editCurriculumForm input[name="curriculum"]').remove();
                        $('#editCurriculumForm').append('<input type="hidden" name="curriculum" value="' + code +
                            '">');
                        $('#editCurriculumForm #description').val(data.description);
                        $('#editCurriculumForm #series').val(data.series);
                        $('#editCurriculumForm #modality').val(data.modality);
                        $('#editCurriculumForm #weekly_hours').val(data.weekly_hours);
                        $('#editCurriculumForm #total_hours').val(data.total_hours);
                        $('#editCurriculumForm #start_time').val(data.start_time);
                        $('#editCurriculumForm #end_time').val(data.end_time);
                        $('#editCurriculumForm #complementary_information').val(data.complementary_information);

                    },
                    error: function(data) {
                        location.reload();
                    }
                });
            }
            $(document).ready(function() {
                $('#schoolsTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "ajax": {
                        "url": "{{ route('manage.curriculum.index') }}",
                        "type": "GET",
                        "dataSrc": ""
                    },
                    "columns": [{
                            "data": "code"
                        },
                        {
                            "data": "series"
                        },
                        {
                            "data": "modality"
                        },

                        {
                            "data": "weekly_hours"
                        },
                        {
                            "data": "total_hours"
                        },
                        {
                            "data": "start_time"
                        },
                        {
                            "data": "end_time"
                        },

                        {
                            "render": function(data, type, row, meta) {
                                return `
                                    <div class="row">
                                        <div class="btn-group" role="group" aria-label="Basic example">
                                            <button type="button" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editCurriculum" onclick="showCurriculum('${row.code}')">
                                                Editar
                                            </button>
                                            <a href="/gerenciar/matriz-curricular/${row.code}/disciplinas" class="btn btn-outline-secondary btn-sm">
                                                Disciplinas
                                            </a>
                                            @schoolPermission('delete-any-curriculum', optional($school_home)->uuid)
<form action="{{ route('manage.curriculum.destroy') }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="curriculum" value="${row.code}">
                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                        Excluir
                                                    </button>
                                                </form>
@endschoolPermission
                                        </div>
                                    </div>
                                `;
                            }
                        }
                    ]
                });
            });
        </script>
    @endsection
</x-app-layout>
