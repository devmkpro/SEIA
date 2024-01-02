<div class="row">

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-sm border-left-primary shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Nº de alunos</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $school_home->students->count() }}</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-sm border-left-success shadow  py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Nº de professores</div>

                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $school_home->teachers->count() }}</div>

                    </div>
                    <div class="col-auto">
                        <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card card-sm border-left-warning shadow py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Alunos com Deficiência
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ $school_home->students->filter(function ($student) {
                                    return $student->datauser->deficiency != null;
                                })->count() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-auto">
                <i class="fas fa-comments fa-2x text-gray-300"></i>
            </div>
        </div>
    </div>
</div>