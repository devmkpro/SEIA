<span class="menu-title align-self-start">Secretaria</span>
<li class="nav-item">
    <a class="nav-link dropdown-toggle red center " href="#" id="navbarDropdownLocations"
        role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="pph ph-graduation-cap icons-menu"></i>
        <span class="">Gestão</span>
    </a>
    <div class="dropdown-menu collapse navbar-collapse" aria-labelledby="navbarDropdownLocations">
        @schoolPermission('manage-curricula', optional($school_home)->uuid)
            <a class="dropdown-item red" href="{{route('manage.curriculum')}}">
                <i class="ph-list-checks-fill icons-menu"></i>
                <span class="">Matriz Curricular</span>
            </a>
        @endschoolPermission
    </div>
</li>

