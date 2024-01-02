<x-app-layout>
    @include('components.messages-erros')
    <div class="avisos d-flex">
        <div class="text d-flex justify-content-center align-items-start flex-column">
            <h3 class="title">Seja bem vindo!</h3>
            <p class="fs-6">Seja bem vindo ao SEIA, o sistema de ensino integrado ao ambiente. Aqui você pode encontrar
                tudo o que precisa para o seu aprendizado.</p>
        </div>
        <img src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675960159/assets/seia/img/Teacher-student_rkk4o5.svg"
            alt="Alunos e professor">
    </div>

    <div class="row">
        @if ($school_home == null && !Auth::user()->hasRole('admin'))
            @include('layouts.partials.select-school-welcome')
        @elseif($school_home != null)
            @role('admin')
                @include('layouts.partials.index-card-for-secretary')
            @endrole

            @schoolRole('director', optional($school_home)->uuid)
                @include('layouts.partials.index-card-for-secretary')
            @endschoolRole

            @schoolRole('secretary', optional($school_home)->uuid)
                @include('layouts.partials.index-card-for-secretary')
            @endschoolRole

            @schoolRole('student', optional($school_home)->uuid)
                @include('layouts.partials.index-card-for-student')
            @endschoolRole
        @endif

    </div>
   
</x-app-layout>
