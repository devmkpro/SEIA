<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')
    <x-global-manage-layout>
        @section('title-header-page', 'da matriz curricular')
        @section('title-description-page')
            Cod.: <span class="fw-bolder text-dark-seia">{{ $curriculum->code }}</span>
            Série/Etapa: <span class="fw-bolder text-dark-seia">{{ $seriesFormated }}</span>
            Modalidade: <span class="fw-bolder text-dark-seia">{{ $modalityFormated }}</span>
            Horas Semanais: <span class="fw-bolder text-dark-seia">{{ $curriculum->weekly_hours }}h</span>
            Carga Horária: <span class="fw-bolder text-dark-seia">{{ $curriculum->total_hours }}h</span>
            <p class="mb-4">
                Hora inicial de aula: <span class="fw-bolder text-dark-seia">{{ $curriculum->start_time }}</span>
                Hora final de aula: <span class="fw-bolder text-dark-seia">{{ $curriculum->end_time }}</span>
            </p>
            <p>
                @if ($curriculum->description != null)
                    Descrição:
                    <span class="fw-bolder text-dark-seia">{{ $curriculum->description }}
                    </span>
                @endif

                </span><br>

                @if ($curriculum->complementary_information != null)
                    Observação:
                    <span class="fw-bolder text-dark-seia">{{ $curriculum->complementary_information }}
                    </span>
                @endif
            </p>
        @endsection
        @section('btns-header-page')
        @endsection
        @section('alerts')
        @endsection
        @section('actions')
            <div class="row row-cols-md-3 row-cols-sm-1 justify-content-center gap-3 gap-y-2">
                <a data-bs-toggle="modal" data-bs-target="#editCurriculum"
                    class="inline-flex items-center justify-content-center rounded text-white text-dark-seia btn btn-group-sm btn-seia-oceanblue">
                    Editar informações
                </a href="#">
                <a href="{{ route('manage.subjects', $curriculum) }}"
                    class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-greenligth">
                    Gerenciar Disciplinas
                </a>

                @schoolPermission('delete-any-curriculum', optional($school_home)->uuid)
                    <button type="button"
                        class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-red"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                        Excluir Matriz Curricular
                    </button>
                @endschoolPermission
            </div>

        @endsection
        @section('modals')
            @schoolPermission('update-any-curriculum', optional($school_home)->uuid)
                <x-modal titleModal="Editar Matriz Curricular" identifier="editCurriculum" id="editCurriculum">
                    <form action="{{route('manage.curriculum.update')}}" method="POST" id="editCurriculumForm">
                        @csrf
                        @method('PUT')
                        <div class="row ms-2 me-2">
                            <div class="row mb-3">
                                <div class="col-md-12 mb-3">
                                    <label for="descricao" class="form-label">Descrição</label>
                                    <textarea class="form-control" name="descricao" id="description" rows="3">{{ $curriculum->description }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label for="serie" class="form-label">Série/Etapa</label>
                                    <select class="form-select" name="serie" id="series" required>
                                        <option selected>Selecione uma série</option>
                                        <option value="educ_infa_cc_0_3" @if ($curriculum->series == 'educ_infa_cc_0_3') selected @endif>
                                            Educacao Infantil - Creche (0 a 3 anos)</option>
                                        <option value="educ_infa_cc_4_5"
                                            {{ $curriculum->series == 'educ_infa_cc_4_5' ? 'selected' : '' }}>
                                            Educacao Infantil - Pre-escola (4 a 5 anos)</option>
                                        <option value="educ_ini_1_5"
                                            {{ $curriculum->series == 'educ_ini_1_5' ? 'selected' : '' }}>
                                            Ensino Fundamental - Anos Iniciais (1 ao 5 ano)</option>
                                        <option value="educ_ini_6_9"
                                            {{ $curriculum->series == 'educ_ini_6_9' ? 'selected' : '' }}>
                                            Ensino Fundamental - Anos Finais (6 ao 9 ano)</option>
                                        <option value="educ_med_1" {{ $curriculum->series == 'educ_med_1' ? 'selected' : '' }}>
                                            Ensino Medio - 1 serie</option>
                                        <option value="educ_med_2" {{ $curriculum->series == 'educ_med_2' ? 'selected' : '' }}>
                                            Ensino Medio - 2 serie</option>
                                        <option value="educ_med_3" {{ $curriculum->series == 'educ_med_3' ? 'selected' : '' }}>
                                            Ensino Medio - 3 serie</option>
                                        <option value="courses" {{ $curriculum->series == 'courses' ? 'selected' : '' }}>
                                            Cursos</option>
                                        <option value="other" {{ $curriculum->series == 'other' ? 'selected' : '' }}>
                                            Outro</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="modalidade" class="form-label">Modalidade</label>
                                    <select class="form-select" name="modalidade" id="modality" required>
                                        <option selected>Selecione uma modalidade</option>
                                        <option value="bercario"
                                            {{ $curriculum->modality == 'bercario' ? 'selected' : '' }}>Berçário</option>
                                        >Berçário</option>
                                        <option value="creche"
                                            {{ $curriculum->modality == 'creche' ? 'selected' : '' }}>Creche</option>
                                        >Creche</option>
                                        <option value="pre_escola"
                                            {{ $curriculum->modality == 'pre_escola' ? 'selected' : '' }}>Pré-escola</option>
                                        >Pré-escola</option>
                                        <option value="fundamental"
                                            {{ $curriculum->modality == 'fundamental' ? 'selected' : '' }}>Ensino
                                        >Ensino Fundamental</option>
                                        <option value="medio"
                                            {{ $curriculum->modality == 'medio' ? 'selected' : '' }}>Ensino Médio</option>
                                        >Ensino Médio</option>
                                        <option value="tecnico"
                                            {{ $curriculum->modality == 'tecnico' ? 'selected' : '' }}>Ensino Técnico</option>
                                        >Ensino Técnico</option>
                                        <option value="eja"
                                            {{ $curriculum->modality == 'eja' ? 'selected' : '' }}>EJA</option>
                                        >EJA</option>
                                        <option value="educacao_especial"
                                            {{ $curriculum->modality == 'educacao_especial' ? 'selected' : '' }}>Educação
                                        >Educação Especial</option>
                                        <option value="other"
                                            {{ $curriculum->modality == 'other' ? 'selected' : '' }}>Outro</option>
                                        >Outro</option>
                                    </select>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="horas_semanais" class="form-label" required>Horas Semanais</label>
                                        <input type="text" class="form-control" name="horas_semanais" id="weekly_hours"
                                            placeholder="Ex. 40" value="{{ $curriculum->weekly_hours }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="horas_totais" class="form-label" required>Horas Totais</label>
                                        <input type="text" class="form-control" name="horas_totais" id="total_hours"
                                            placeholder="Ex. 2000" value="{{ $curriculum->total_hours }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="turno" class="form-label">Turno</label>
                                        <select class="form-select" name="turno" id="turno" required>
                                            <option selected>Selecione um turno</option>
                                            <option value="morning" {{ $curriculum->turn == 'morning' ? 'selected' : '' }}>
                                                Matutino</option>
                                            <option value="afternoon"
                                                {{ $curriculum->turn == 'afternoon' ? 'selected' : '' }}>Vespertino</option>
                                            <option value="night" {{ $curriculum->turn == 'night' ? 'selected' : '' }}>
                                                Noturno</option>
                                            <option value="integral"
                                                {{ $curriculum->turn == 'integral' ? 'selected' : '' }}>Integral</option>
                                            <option value="other" {{ $curriculum->turn == 'other' ? 'selected' : '' }}>
                                                Outro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label for="hora_início" class="form-label" required>Hora de aula inicial</label>
                                        <input type="time" class="form-control" name="hora_início" id="start_time"
                                            placeholder="Ex. 40" value="{{ $curriculum->start_time }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="hora_final" class="form-label" required>Hora de aula Final</label>
                                        <input type="time" class="form-control" name="hora_final" id="end_time"
                                            placeholder="Ex. 2000" value="{{ $curriculum->end_time }}" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label for="default_time_class" class="form-label" required>Tempo de aula
                                            (minutos)</label>
                                        <input type="text" class="form-control" name="tempo_padrao_de_aula"
                                            id="default_time_class" placeholder="Ex. 45"
                                            value="{{ $curriculum->default_time_class }}" required>
                                    </div>
                                </div>
                                <input type="hidden" name="curriculum" value="{{ $curriculum->code }}">
                            </div>
                        </div>
                </x-modal>
                </form>
            @endschoolPermission
            @schoolPermission('delete-any-curriculum', optional($school_home)->uuid)
                <x-modal titleModal="Deletar Matriz Curricular" identifier="deleteModal" id="deleteModal">
                    <form action="{{ route('manage.curriculum.destroy') }}" method="POST" id="formDelete">
                        @csrf
                        @method('DELETE')
                        <div class="row ">
                            <input type="hidden" name="curriculum" value="{{ $curriculum->code }}">
                            <h1 class="text-center">
                                Você tem certeza que deseja excluir essa matriz curricular?
                            </h1>
                        </div>
                </x-modal>
                </form>
            @endschoolPermission
        @endsection
    </x-global-manage-layout>
</x-app-layout>
