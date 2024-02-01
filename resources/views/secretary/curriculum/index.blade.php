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
                <x-grid-datatables identifier="schoolsTable" :columns="['Cód.', 'Série/Etapa', 'Modalidade', 'Horas semanais', 'Total de Horas', 'Ações']">
                    <x-slot:btns>
                        @schoolPermission('create-any-curriculum', optional($school_home)->uuid)
                            <div class="col-md-12">
                                <div class="d-flex justify-content-end mb-3">
                                    <button type="button" class="btn  btn-seia-oceanblue" data-bs-toggle="modal"
                                        data-bs-target="#addCurriculum">
                                        Nova Matriz Curricular
                                    </button>
                                </div>
                            </div>
                        @endschoolPermission
                    </x-slot:btns>
                </x-grid-datatables>
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
                                <option value="courses">Cursos</option>
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
                                <option value="tecnico">Ensino Técnico</option>
                                <option value="eja">EJA</option>
                                <option value="educacao_especial">Educação Especial</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>
                    </div>


                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="horas_semanais" class="form-label" required>Horas Semanais</label>
                            <input type="text" class="form-control" name="horas_semanais" placeholder="Ex. 40"
                                value="{{ old('horas_semanais') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="horas_totais" class="form-label" required>Horas Totais</label>
                            <input type="text" class="form-control" name="horas_totais" placeholder="Ex. 2000"
                                value="{{ old('horas_totais') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="turno" class="form-label">Turno</label>
                            <select class="form-select" name="turno" id="turno" required>
                                <option selected>Selecione um turno</option>
                                <option value="morning">Matutino</option>
                                <option value="afternoon">Vespertino</option>
                                <option value="night">Noturno</option>
                                <option value="integral">Integral</option>
                                <option value="other">Outro</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="hora_início" class="form-label" required>Hora de aula inicial</label>
                            <input type="time" class="form-control" name="hora_início" placeholder="Ex. 40"
                                value="{{ old('hora_início') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="hora_final" class="form-label" required>Hora de aula Final</label>
                            <input type="time" class="form-control" name="hora_final" placeholder="Ex. 2000"
                                value="{{ old('hora_final') }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="default_time_class" class="form-label" required>Tempo de aula (minutos)</label>
                            <input type="number" class="form-control" name="tempo_padrao_de_aula" placeholder="Ex. 45"
                                value="{{ old('tempo_padrao_de_aula') }}" required>
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

    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#schoolsTable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                    },
                    "data": [
                        @foreach ($curriculums as $curriculum)
                            [
                                '{{ $curriculum["code"] }}',
                                '{{ $curriculum["series"] }}',
                                '{{ $curriculum["modality"] }}',
                                '{{ $curriculum["weekly_hours"] }}',
                                '{{ $curriculum["total_hours"] }}',
                                `<a href="{{route('manage.curriculum.edit', $curriculum['code'])}}" class="btn btn-seia-blue btn-sm" >
                                        Gerenciar
                                </a> `,	
                            ],
                        @endforeach
                    ],

                });
            });
        </script>
    @endsection
</x-app-layout>
