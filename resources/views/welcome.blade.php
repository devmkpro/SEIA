<x-app-layout>
    @include('components.messages-erros')
    @include('components.warnings-panel')

    <div class="row">
        @if ($school_home == null && !Auth::user()->hasRole('admin'))
            @include('layouts.partials.select-school-welcome')
        @elseif($school_home != null)
            @role('admin')
                @include('layouts.partials.index-card-for-secretary')
            @endrole

            @schoolRole('secretary', optional($school_home)->uuid)
                @include('layouts.partials.index-card-for-secretary')
            @endschoolRole

            @schoolRole('student', optional($school_home)->uuid)
                @include('layouts.partials.index-card-for-student')
            @endschoolRole
        @endif

    </div>
</x-app-layout>
