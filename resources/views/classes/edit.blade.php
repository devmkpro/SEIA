<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')
    <x-global-manage-layout>
        @section('title-header-page', 'da turma')
        @section('title-description-page')
            Cod.: <span class="fw-bolder text-dark-seia">{{ $class->code }}</span>
            Período: <span class="fw-bolder text-dark-seia">
                @if ($class->turn == 'morning')
                    Manhã
                @elseif ($class->turn == 'afternoon')
                    Tarde
                @elseif ($class->turn == 'night')
                    Noite
                @endif
            </span> Nível da matriz curricular: <span class="fw-bolder text-dark-seia">
                {{ $curriculum_modality ?? 'Não informado' }}</span>

            <p class="mb-4">
                Modalidade de ensino:
                <span class="fw-bolder text-dark-seia">
                    @if ($class->modality == 'regular')
                        Regular
                    @elseif ($class->modality == 'eja')
                        EJA
                    @elseif ($class->modality == 'eja_fundamental')
                        EJA Fundamental
                    @elseif ($class->modality == 'eja_medio')
                        EJA Médio
                    @endif
                </span>

                Nº máximo de alunos: <span class="fw-bolder text-dark-seia">{{ $class->max_students }}</span>


                Professor responsável: <span class="fw-bolder text-dark-seia">
                    {{ $class->teacher_responsible_uuid ? $class->teacher_responsible->name : 'Não se aplica' }}</span>
                </span>
            @endsection
            @section('btns-header-page')
            <div class="flex space-x-4">
                @schoolPermission('update-any-class', optional($school_home)->uuid)
                    <a data-bs-toggle="modal" data-bs-target="#changeCurriculumModal"
                        class="inline-flex items-center justify-content-center rounded text-white text-dark-seia btn btn-group-sm btn-seia-red me-3">
                        Matriz curricular
                    </a href="#">
                    <a data-bs-toggle="modal" data-bs-target="#updateClassModal"
                        class="inline-flex items-center justify-content-center rounded text-white text-dark-seia btn btn-group-sm btn-seia-oceanblue">
                        Editar informações
                    </a href="#">
                @endschoolPermission

            </div>
        @endsection
        @section('alerts')
            @isset ($alerts)
                @foreach ($alerts as $alert)
                    <div class="d-flex align-items-center mb-2 text-dark-seia">
                        @if ($alert['type'] == 'warning')
                            <i class="ph ph-warning-circle text-seia-ambar me-2" style="font-size: 1.3rem"></i>
                        @elseif ($alert['type'] == 'danger')
                            <i class="ph ph-warning text-seia-red me-2" style="font-size: 1.3rem"></i>
                        @endif
                        <span class="fw-bolder">{{ $alert['message'] }}</span>
                    </div>
                @endforeach
            @else
                Nenhum aviso para exibir.
            @endisset
        @endsection
        @section('actions')
            <div class="row row-cols-md-3 row-cols-sm-1 justify-content-center gap-3 gap-y-2">
                <a href="{{ route('manage.classes.teachers', $class->code) }} "
                    class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-greenligth">
                    Gerenciar professores
                </a>
                <a href="#"
                    class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-oceanblue">
                    Gerenciar alunos
                </a>
                <a href="#"
                    class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-ambar">
                    Horários e salas
                </a>
                <a href="#"
                    class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-red">
                    Monitor de presença
                </a>
                <a href="#"
                    class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-green">
                    Matricular novo aluno
                </a>
            </div>
        @endsection
        @section('modals')
            @schoolPermission('update-any-class', optional($school_home)->uuid)
                <x-modal titleModal="Alterar Matriz Curricular" idModal="changeCurriculumModal"
                    identifier="changeCurriculumModal" id="changeCurriculumModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="{{ route('manage.classes.change.curriculum') }}" method="POST"
                            id="changeCurriculumForm">
                            @csrf
                            @method('PUT')
                            <select name="curriculum" id="curriculum" class="form-select">
                                @if ($curriculums->count() == 0)
                                    <option value="">Não há matrizes na escola</option>
                                @else
                                    <option value="">Selecione uma matriz curricular</option>
                                    @foreach ($curriculums as $curriculum)
                                        <option value="{{ $curriculum['code'] }}"
                                            @if (decrypt($curriculum['uuid']) == $class->curriculum_uuid) selected @endif>
                                            {{ $curriculum['series'] }} - {{ $curriculum['modality'] }} -
                                            {{ $curriculum['turn'] }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                            <input type="hidden" name="class" value="{{ $class->code }}">
                    </div>
                </x-modal>
                </form>

                <x-modal titleModal="Atualizar Turma" identifier="updateClassModal" id="updateClassModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="{{ route('manage.classes.update', $class->code) }}" method="POST" id="updateClassForm">
                            @csrf
                            @method('PUT')
                            
                            <input type="hidden" name="class" value="{{ $class->code }}">

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
                                            placeholder="Nome da Turma" value="{{ $class->name }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modalidade" class="form-label">Modalidade de ensino
                                        </label>
                                        <span class="text-danger">*</span>
                                        <select class="form-select" aria-label="Default select example" id="modalidade"
                                            name="modalidade" required">
                                            <option value="regular" @if ($class->modality == 'regular') selected @endif>Regular
                                            </option>
                                            <option value="eja" @if ($class->modality == 'eja') selected @endif>EJA
                                            </option>
                                            <option value="eja_fundamental" @if ($class->modality == 'eja_fundamental') selected @endif>
                                                EJA Fundamental</option>
                                            <option value="eja_medio" @if ($class->modality == 'eja_medio') selected @endif>EJA
                                                Médio</option>
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
                                            name="turno" required value="{{ $class->turn }}">
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
                                            placeholder="Máximo de alunos" required value="{{ $class->max_students }}">
                                    </div>
                                </div>

                            </div>


                            <h5 class="mt-3 h5">Dias letivos</h5>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="domingo" class="form-label">Domingo</label>
                                        <select class="form-select" aria-label="Default select example" id="domingo"
                                            name="domingo" required">
                                            @if ($class->sunday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="segunda" class="form-label">Segunda-feira</label>
                                        <select class="form-select" aria-label="Default select example" id="segunda"
                                            name="segunda" required>
                                            @if ($class->monday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="terca" class="form-label">Terça-feira</label>
                                        <select class="form-select" aria-label="Default select example" id="terca"
                                            name="terca" required>
                                            @if ($class->tuesday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quarta" class="form-label">Quarta-feira</label>
                                        <select class="form-select" aria-label="Default select example" id="quarta"
                                            name="quarta" required>
                                            @if ($class->wednesday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quinta" class="form-label">Quinta-feira</label>
                                        <select class="form-select" aria-label="Default select example" id="quinta"
                                            name="quinta" required>
                                            @if ($class->thursday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sexta" class="form-label">Sexta-feira</label>
                                        <select class="form-select" aria-label="Default select example" id="sexta"
                                            name="sexta" required value="{{ old('sexta') }}">
                                            @if ($class->friday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sabado" class="form-label">Sábado</label>
                                        <select class="form-select" aria-label="Default select example" id="sabado"
                                            name="sabado" required>
                                            @if ($class->saturday == 1)
                                                <option value="1" selected>Sim</option>
                                                <option value="0">Não</option>
                                            @else
                                                <option value="1">Sim</option>
                                                <option value="0" selected>Não</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="sala" class="form-label">Sala Principal
                                        </label>
                                        <select class="form-select" aria-label="Default select example" id="sala"
                                            name="sala" >
                                            @if ($class->rooms->count() == 0)
                                                <option value="">Não há salas cadastradas</option>
                                            @else
                                            <option value="">Selecione uma sala</option>
                                                @foreach ($class->rooms as $classroom)
                                                    <option value="{{ $classroom->uuid }}"
                                                        @if ($classroom->uuid == $class->classroom_uuid) selected @endif>
                                                        {{ $classroom->name }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>



                    </div>
                </x-modal>
                </form>
            @endschoolPermission
        @endsection
    </x-global-manage-layout>
</x-app-layout>
