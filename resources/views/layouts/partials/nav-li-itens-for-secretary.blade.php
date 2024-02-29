<span class="menu-title align-self-start">Secretaria</span>
<li class="nav-item">
    <a class="nav-link dropdown-toggle red center " href="#" id="navbarDropdownLocations" 
        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="pph ph-graduation-cap icons-menu"></i>
        <span class="a-name">Gestão</span>
    </a>
    <div class="dropdown-menu collapse navbar-collapse" aria-labelledby="navbarDropdownLocations">
        @schoolPermission('manage-curricula', optional($school_home)->uuid)
            <a class="dropdown-item red" href="{{route('manage.curriculum')}}">
                <i class="ph-list-checks-fill icons-menu"></i>
                <span class="">Matriz Curricular</span>
            </a>
        @endschoolPermission

        @schoolPermission('manage-classes', optional($school_home)->uuid)
            <a class="dropdown-item red" href="{{route('manage.classes')}}">
                <i class="ph ph-chalkboard-teacher icons-menu"></i>
                <span class="">Turmas</span>
            </a>
        @endschoolPermission

       
    </div>
</li>
<span class="menu-title align-self-start">Escola</span>

<li class="nav-item">
    <a class="nav-link dropdown-toggle red center " href="#" id="navbarDropdownLocations" 
        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="ph ph-chalkboard icons-menu"></i>
        <span class="a-name">Salas</span>
    </a>

    <div class="dropdown-menu collapse navbar-collapse" aria-labelledby="navbarDropdownLocations">
        @schoolPermission('manage-rooms', optional($school_home)->uuid)
            <a class="dropdown-item red" href="{{route('manage.rooms.index')}}">
                <i class="ph ph-list icons-menu"></i>
                <span class="">Listar</span>
            </a>
        @endschoolPermission

       
    </div>
</li>

