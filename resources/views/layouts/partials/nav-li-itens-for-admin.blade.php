<span class="menu-title align-self-start">Admin</span>
@can('manage-location')
    <li class="nav-item">
        <a class="nav-link dropdown-toggle red center" href="#" id="navbarDropdownLocations"
            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ph-map-pin-fill icons-menu"></i>
            <span class="a-name ">Localizações</span>
        </a>
        <div class="dropdown-menu collapse navbar-collapse" aria-labelledby="navbarDropdownLocations">

            <a class="dropdown-item red" href="{{ route('manage.cities') }}">
                <i class="ph-map-pin-fill icons-menu"></i>
                <span >Cidades</span>
            </a>

            <a class="dropdown-item red" href="{{ route('manage.states') }}">
                <i class="ph-map-pin-fill icons-menu"></i>
                <span >Estados</span>
            </a>
        </div>
    </li>
@endcan

@can('manage-schools')
    <li class="nav-item">
        <a class="nav-link dropdown-toggle blue center" href="#" id="navbarDropdownSchools"
            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ph-bank-fill icons-menu"></i>
            <span class="a-name ">Escolas</span>
        </a>
        <div class="dropdown-menu collapse navbar-collapse" aria-labelledby="navbarDropdownSchools">

            @can('update-any-school')
                <a class="dropdown-item blue" href="{{route('manage.schools')}}">
                    <i class="ph-bank-fill icons-menu"></i>
                    <span >Gerenciar</span>
                </a>
            @endcan

            @can('create-any-school')
                <a class="dropdown-item blue" href="{{route('manage.schools.create')}}">
                    <i class="ph-bank-fill icons-menu"></i>
                    <span >Cadastrar</span>
                </a>
            @endcan
        </div>
    </li>
@endcan

@can('manage-school-years')
    <li class="nav-item">
        <a class="nav-link dropdown-toggle green center" href="#" id="navbarDropdownSchoolYears"
            role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="ph-calendar-fill icons-menu"></i>
            <span class="a-name ">Anos Letivos</span>
        </a>
        <div class="dropdown-menu collapse navbar-collapse" aria-labelledby="navbarDropdownSchoolYears">

            @can('update-any-school-year')
                <a class="dropdown-item green" href="{{route('manage.school-years')}}">
                    <i class="ph-calendar-fill icons-menu"></i>
                    <span >Gerenciar</span>
                </a>
            @endcan

        </div>
    </li>
@endcan