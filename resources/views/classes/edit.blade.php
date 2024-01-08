<x-app-layout>
    @include('components.warnings-panel')
    @include('components.messages-erros')
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="mb-4 container">
                    <section aria-labelledby="class-info-heading" class="seia-bg p-4 rounded seia-shadow my-3">
                        <h2 id="class-info-heading" class="fs-6 fw-bold text-dark-seia mb-4">
                            Informações da turma
                        </h2>
                        <p class="mb-2 space-y-1">
                            Cod.: <span class="fw-bolder text-dark-seia">B503</span> Período: <span
                                class="fw-bolder text-dark-seia">Matutino</span> Nível:{" "}
                            <span class="fw-bolder text-dark-seia">Fundamental II</span> Turma AEE: <span
                                class="fw-bolder text-dark-seia">Não se aplica</span> Nº
                            de alunos: <span class="fw-bolder text-dark-seia">31</span> Professor: <span
                                class="fw-bolder text-dark-seia">Não informado</span>
                        </p>
                        <p class="mb-4">
                            Professor auxiliar: <span class="fw-bolder text-dark-seia">Não capacitado</span>
                        </p>
                        <div class="flex space-x-4">
                            <a href="#"
                                class="inline-flex items-center justify-content-center rounded text-white text-dark-seia btn btn-group-sm btn-seia-red">
                                Matriz curricular
                            </a href="#">
                            <a href="#"
                                class="inline-flex items-center justify-content-center rounded text-white text-dark-seia btn btn-group-sm btn-seia-oceanblue">
                                Editar informações
                            </a href="#">
                        </div>
                    </section>
                    <section aria-labelledby="alerts-heading" class="seia-bg  p-4 rounded seia-shadow my-3">
                        <h2 id="alerts-heading" class="fs-6 fw-bold text-dark-seia mb-4">
                            Avisos
                        </h2>
                        <div class="d-flex align-items-center mb-2 text-dark-seia">
                            <i class="ph ph-warning text-seia-red me-2" style="font-size: 1.3rem"></i>
                            <span>Matriz curricular não informada!</span>
                        </div>
                        <div class="d-flex align-items-center text-dark-seia">
                            <i class="ph ph-warning-circle text-seia-ambar me-2" style="font-size: 1.3rem"></i>
                            <span>Turma sem professor!</span>
                        </div>
                    </section>
                    <section aria-labelledby="actions-heading" class="seia-bg  p-4 rounded seia-shadow my-3">
                        <h2 id="actions-heading" class="fs-6 fw-bold text-dark-seia mb-4">
                            Ações
                        </h2>
                        <div class="row row-cols-md-3 row-cols-sm-1 justify-content-center gap-3 gap-y-2">
                            <a href="#"
                                class="btn btn-group btn-group-sm align-items-center d-flex justify-content-center btn-seia-greenligth">
                                Gerenciar professor
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
                    </section>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
