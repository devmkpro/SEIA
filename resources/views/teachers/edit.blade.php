<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')
    @section('styles')
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.js"></script>
    @endsection
    <x-global-manage-layout>
        @section('title-header-page', 'do professor')
        @section('title-description-page')
            Cod.: <span class="fw-bolder text-dark-seia">{{ $user->username }}</span>
            Nome: <span class="fw-bolder text-dark-seia">{{ $user->name }}</span>
            Email: <span class="fw-bolder text-dark-seia">
                <a href="mailto:{{ $user->email }}">
                    {{ $user->email }}
                </a></span>
            Celular: <span class="fw-bolder text-dark-seia">
                <a href="tel:{{ $user->phone }}">
                    {{ $user->phone }}
                </a>
            </span>
            CH Semanal: <span class="fw-bolder text-dark-seia">{{ $teacherSchool->weekly_workload }}</span>

            <p class="mb-4">
                Qtd. Disciplinas Lecionadas: <span
                    class="fw-bolder text-dark-seia">{{ $teacherSchool->teacherSubjects ? $teacherSchool->teacherSubjects->subjects->count() : 0 }}</span>

            </p>

        @endsection
        @section('btns-header-page')

        @endsection
        @section('alerts')
            @isset($alerts)
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
                @schoolPermission('manage-subjects', optional($school_home)->uuid)
                    <a data-bs-toggle="modal" data-bs-target="#changeSubjectsModal"
                        class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-green">
                        Disciplinas
                    </a>
                @endschoolPermission

                @schoolPermission('update-any-teacher', optional($school_home)->uuid)
                    <a data-bs-toggle="modal"
                        class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-yellow">
                        CH Semanal
                    </a>
                @endschoolPermission

                @schoolPermission('update-any-teacher', optional($school_home)->uuid)
                    <a data-bs-toggle="modal" data-bs-target="#manageScheduleModal"
                        class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-darkblue">
                        horários
                    </a>
                @endschoolPermission
            </div>

        @endsection
        @section('modals')
            @schoolPermission('manage-subjects', optional($school_home)->uuid)
                <x-modal titleModal="Gerenciar disciplinas" idModal="changeSubjectsModal" identifier="changeSubjectsModal"
                    id="changeSubjectsModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="#" method="POST" id="changeCurriculumForm">
                            <x-grid-datatables identifier="teachersSubjectsTable" :columns="['Cód.', 'Nome', 'Ch Semanal', 'Ações']">

                            </x-grid-datatables>
                    </div>
                </x-modal>
                </form>
            @endschoolPermission
            @schoolPermission('update-any-teacher', optional($school_home)->uuid)
                <x-modal titleModal="Modificar carga horária semanal" idModal="modifySubjectModal"
                    identifier="modifySubjectModal" id="modifySubjectModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="#" method="POST" id="modifySubjectForm">
                            @csrf
                            <input type="hidden" name="teacher" value="{{ $user->username }}">
                            <input type="hidden" name="subject" value="">
                            <input type="hidden" name="class" value="{{ $class->code }}">

                            <div class="row mb-3">
                                <div class="col-12">
                                    Modificar carga horária semanal do(a) professor(a) <span
                                        class="fw-bolder">{{ $user->name }}</span> que atualmente é de <span
                                        class="fw-bolder">{{ $teacherSchool->weekly_workload }}</span> horas.
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="weeklyHours" class="form-label">Nova carga horária semanal:</label>
                                    <input type="number" name="weeklyHours" id="weeklyHours" class="form-control rounded-md"
                                        required>
                                </div>
                            </div>
                        </form>
                    </div>
                </x-modal>
            @endschoolPermission
            @schoolPermission('update-any-teacher', optional($school_home)->uuid)
                <x-modal titleModal="Modificar horários de aula" idModal="manageScheduleModal" identifier="manageScheduleModal"
                    id="manageScheduleModal">
                    <div class="me-3 ms-3 mt-2">
                        <form action="#" method="POST" id="modifySubjectForm">
                            @csrf
                            <input type="hidden" name="teacher" value="{{ $user->username }}">
                            <input type="hidden" name="subject" value="">
                            <div class="d-flex">
                                <div class="weekDays">

                                </div>
                                <div class="manageSchedule">

                                </div>
                            </div>
                        </form>
                    </div>
                </x-modal>
            @endschoolPermission
        @endsection
    </x-global-manage-layout>


    @section('scripts')
        @schoolPermission('manage-subjects', optional($school_home)->uuid)
            <script>
                $(document).ready(function() {
                    $('#teachersSubjectsTable').DataTable({
                        responsive: true,
                        "language": {
                            "url": "//cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json"
                        },

                        "data": [
                            @foreach ($subjects as $subject)
                                [
                                    `{{$subject['code']}}`,
                                    `{{$subject['name']}}`,
                                    `{{$subject['ch_week']}}`,
                                    `
                                    @if($subject['isTeacher'])
                                        <a href='#' class='btn btn-sm btn-seia-red'>Remover</a>
                                    @else
                                        <a href='#' class='btn btn-sm btn-seia-green'>Adicionar</a>
                                    @endif
                                    `
                                ],
                            @endforeach
                        ],

                    });
                });
            </script>
        @endschoolPermission
    @endsection
</x-app-layout>
