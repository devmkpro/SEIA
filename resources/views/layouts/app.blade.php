<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="SEIA - Sistema Escola de Integração Acadêmica oferece soluções completas para a gestão escolar.">
    <meta name="keywords" content="SEIA, educação, gestão escolar, soluções">
    <meta name="author" content="Equipe SEIA">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{ asset('css/home/index.css') }}?v=1.6">
    <link rel="stylesheet" href="{{ asset('css/home/dark-theme.css') }}?v=1.2" id="dark-theme" disabled>
    <link rel="stylesheet" href="{{ asset('css/home/light-theme.css') }}?v=1.2" id="light-theme">

    <title>{{ config('app.name', 'SEIA') }}</title>

    <!-- Fonts -->
    <link rel="apple-touch-icon" sizes="180x180"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="icon" type="image/png" sizes="32x32"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="icon" type="image/png" sizes="16x16"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="manifest"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="mask-icon"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg" color="#5bbad5">
    <link rel="shortcut icon"
        href="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg">
    <link rel="stylesheet"
        href="https://res.cloudinary.com/dnjjcvwx5/raw/upload/v1675776364/assets/seia/css/Bootstrap%205.2.x/bootstrap522.min_fag1ma.css">

    <!-- Scripts -->
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js">
    </script>


    @yield('styles')

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/phosphor-icons"></script>
</head>


<body id="page-top">
    <div id="wrapper">
        <div id="blockScrollMobile" class="d-none"></div>
        <nav class="navbar navbar-light align-items-start sidebar sidebar-dark accordion p-0" id="sidebar">
            <div class="container-fluid d-flex flex-column p-0 scroll-active">
                <div class="top">
                    <span>
                        <button class="btn btn-link d-md-none me-3 px-2 d-none sidebarToggleTopMobile"
                            id="sidebarToggleTopMobile" type="button" aria-label="Fechar/Abrir sidebar">
                            <i class="ph-fill ph-x fs-3"></i>
                        </button>
                    </span>
                    <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
                        href="#">
                        <div class="sidebar-brand-icon mx-3 center">
                            <img src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg"
                                alt="Logo" class="w-50 logo-seia animated--fade-in">
                        </div>
                    </a>

                    <div class="d-flex info_perfil_nav gap-2 mt-3 mb-4 align-items-center p-0 center ">
                        <img class="sidebar-brand-icon img-perfil animated--grow-in "
                            src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640049/samples/people/boy-snow-hoodie.jpg"
                            alt="imagem de perfil"
                            srcset="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675701885/assets/seia/img/profiles/default/undraw_profile_zc6h9i.svg">
                        <div class="d-flex flex-column   a-name ">
                            <div class="name text-black a-name ">
                                {{ auth()->user()->name }}
                            </div>
                            @schoolRole('student', optional($school_home)->uuid)
                                <span class="info  text-dark text-capitalize a-name">
                                    Curso / turma
                                </span>
                            @endschoolRole
                        </div>
                        <span>
                            <button id="sidebarToggle" type="button" aria-label="Sidebar abrir/fechar">
                                <i class="ph-caret-left-bold icons-menu" id="btnSidebarToggle"></i>

                            </button>
                        </span>
                    </div>


                    <hr class="sidebar-divider my-3 shadow-sm">

                </div>

                <ul class="navbar-nav center animated--fade-in" id="accordionSidebar">
                    <span class="menu-title align-self-start">Menu</span>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-title="Início"><a class="nav-link blue center"
                            href="{{ route('panel') }}"><i class="ph-house-fill icons-menu"></i></i><span
                                class="a-name">Início</span></a></li>


                    @schoolRole('director', optional($school_home)->uuid)
                        @if ($school_home)
                            @include('layouts.partials.nav-li-itens-for-secretary')
                        @endif
                    @endschoolRole

                    @schoolRole('secretary', optional($school_home)->uuid)
                        @if ($school_home)
                            @include('layouts.partials.nav-li-itens-for-secretary')
                        @endif
                    @endschoolRole

                    @schoolRole('student', optional($school_home)->uuid)
                    @include('layouts.partials.nav-li-itens-for-students')
                @endrole

                @role('admin')
                    @if ($school_home)
                        @include('layouts.partials.nav-li-itens-for-secretary')
                    @endif
                    @include('layouts.partials.nav-li-itens-for-admin')
                @endrole



                <hr class="sidebar-divider my-3 shadow-sm">
                <span class="menu-title align-self-start">Pessoal</span>
                <li class="nav-item" data-bs-toggle="tooltip" data-bs-title="Perfil">
                    <a class="nav-link green center" href="{{ route('profile.edit') }}">
                        <i class="ph-user-circle-fill icons-menu"></i>
                        <span class="a-name">Minhas Informações</span>
                    </a>
                </li>

                <li class="nav-item" data-bs-toggle="tooltip" data-bs-title="Notificações">
                    <a class="nav-link yellow center" href="#">
                        <i class="ph-bell-fill icons-menu"></i>
                        <span class="a-name">Notificações</span>
                    </a>
                </li>

                <li class="nav-item" data-bs-toggle="tooltip" data-bs-title="Configurações"><a
                        class="nav-link blue center" href="#"><i class="ph-gear icons-menu"></i>
                        <span class="a-name">Configurações</span></a>
                </li>



                <hr class="sidebar-divider my-3 shadow-sm">
            </ul>

            <div class="exit">
                <div class="d-flex flex-column align-items-center justify-content-center">
                    <ul class="navbar-nav center animated--fade-in">
                        <li class="nav-item" data-bs-toggle="tooltip" data-bs-title="Sair do sistema">
                            <a class="nav-link d-flex justify-content-center align-items-center center red"
                                href="{{ route('logout') }}">
                                <i class="ph-sign-out icons-menu"></i>
                                <span class="a-name">Sair</span>
                            </a>
                        </li>
                    </ul>

                    <span class="copyright text-dark-seia">SEIA {{ date('Y') }} </span>
                </div>
            </div>


        </div>
    </nav>
    <div class="d-flex flex-column" id="content-wrapper">
        <div id="content">
            <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top"
                id="nav-content">
                <div class="container-fluid">
                    <button class="btn btn-link d-md-none me-3 px-2" id="sidebarToggleTop" type="button"
                        aria-label="Fechar/Abrir sidebar">
                        <i class="ph-fill ph-list fs-3"></i>
                    </button>
                    @if ($school_home)
                        <div class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group">
                                <form action="{{ route('delete-school-home') }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="d-flex flex-column align-items-start">
                                        <img src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg"
                                            alt="LogoDaEscola" class="img-fluid" style="height: 12px">
                                        <span class="">
                                            {{ $school_home ? $school_home->name : null }}
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <ul class="navbar-nav flex-nowrap ms-auto">
                        @if ($school_home)
                            <li class="nav-item dropdown d-sm-none no-arrow">
                                <a class="dropdown-toggle nav-link lime" aria-expanded="false"
                                    data-bs-toggle="dropdown" href="#" aria-label="Escola">
                                    <i class="ph-bank"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in"
                                    aria-labelledby="searchDropdown">
                                    <div class="me-auto navbar-search w-100">

                                        <form action="{{ route('delete-school-home') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="d-flex flex-column align-items-start">
                                                <img src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640779/logos/seia_logo_etwo84.svg"
                                                    alt="LogoDaEscola" height="12px">
                                                <span class="">
                                                    {{ $school_home ? $school_home->name : null }}
                                                </span>
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endif

                        <li class="nav-item dropdown mx-1 no-arrow">
                            <a class="dropdown-toggle nav-link green" aria-expanded="false"
                                data-bs-toggle="dropdown" href="#" aria-label="Periodo letivo">
                                <i class="ph-calendar fs-5"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <div class="me-auto navbar-search w-100">
                                    <div class="d-flex flex-column align-items-start">
                                        <span class="text-dark-seia">
                                            {{ $school_year ? $school_year->name : 'Sem periodo letivo' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item no-arrow mx-1">
                            <div class="nav-item no-arrow">
                                <button class="nav-link border-0 red" href="" onclick="switchTheme()"
                                    aria-label="Trocar tema">
                                    <i id="sun-icon" class="ph-sun-fill darkMode "></i>
                                    <i id="moon-icon" class="ph-moon-fill darkMode "></i>
                                </button>
                            </div>
                        </li>

                        @php
                            $notifications = \App\Models\Notifications::where('user_uuid', auth()->user()->uuid)->get();
                        @endphp

                        <li class="nav-item mx-1">
                            <div class="dropdown no-arrow">
                                <a id="notifications-container" class="dropdown-toggle nav-link yellow"
                                    aria-expanded="false" data-bs-toggle="dropdown" data-bs-auto-close="outside"
                                    href="#">
                                    <span class="badge bg-danger badge-counter">
                                        {{ $notifications->where('read', false)->count() }}
                                    </span><i class="ph-bell fs-5"></i>
                                </a>
                                <div
                                    class="notification dropdown-menu dropdown-menu-end dropdown-list animated--grow-in seia-shadow">
                                    <div class="dropdown-header">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="d-flex gap-1 align-items-center fs-6 ">
                                                <i class="ph ph-info fs-5 "></i> Notificações
                                            </span>
                                            <div class="relative markAllCheck">
                                                <a class="dots" onclick="openMarkAll()">
                                                    <i class="ph ph-dots-three"></i>
                                                </a>
                                                <div class="drop invisible" id="button-check-all">
                                                    <a class="text-dark-seia button-check-all d-flex justify-content-center align-items-center gap-2"
                                                        href="#">
                                                        <i class="ph ph-list-checks fs-5"></i>
                                                        Marcar todas como lidas
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="notificationNotRead-tab"
                                                data-bs-toggle="tab" data-bs-target="#notificationNotRead"
                                                type="button" role="tab" aria-controls="notificationNotRead"
                                                aria-selected="true">Não lidas</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="notificationsRead-tab"
                                                data-bs-toggle="tab" data-bs-target="#notificationsRead"
                                                type="button" role="tab" aria-controls="notificationsRead"
                                                aria-selected="false">Lidas</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="notificationNotRead"
                                            role="tabpanel" aria-labelledby="notificationNotRead-tab">

                                            @if ($notifications->where('read', false)->count() > 0)
                                                @foreach ($notifications->where('read', false)->take(4) as $notification)
                                                    @php
                                                        $modalId = uniqid('modal_');
                                                    @endphp
                                                    <div class="accordion accordion-flush"
                                                        id="accordionFlushExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="flush-headingOne">
                                                                <button
                                                                    class="accordion-button collapsed "
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#{{ $modalId }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="flush-collapseOne">
                                                                    <div
                                                                        class="d-flex flex-column align-items-start text-dark-seia">
                                                                        <div class="d-flex justify-content-center align-items-center gap-1 notification">
                                                                            <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                                                                            </i> {{ $notification->title }}
                                                                        </div>
                                                                        <div class="text-muted "
                                                                            style="font-size: 12px; margin-left: 3em">
                                                                            {{ $notification->created_at->format('d/m/Y - H:i') }}
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="{{ $modalId }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="flush-headingOne"
                                                                data-bs-parent="#accordionFlushExample">
                                                                <div class="accordion-body text-dark-seia">
                                                                    {{ $notification->body }}

                                                                    @if ($notification->type == 'request')
                                                                        <div class="d-flex mt-2">
                                                                            <form
                                                                                action="{{ route('manage.invite.acceptOrReject') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('POST')
                                                                                <input type="hidden"
                                                                                    name="school_request"
                                                                                    value="{{ $notification->request_uuid }}">
                                                                                <input type="hidden"
                                                                                    name="notification"
                                                                                    value="{{ $notification->uuid }}">
                                                                                <input type="hidden"
                                                                                    name="status"
                                                                                    value="accepted">
                                                                                <button type="submit"
                                                                                    class="btn btn-seia-greenligth btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold me-2">
                                                                                    <i class="ph-check"></i>
                                                                                    Aceitar
                                                                                </button>
                                                                            </form>
                                                                            <form
                                                                                action="{{ route('manage.invite.acceptOrReject') }}"
                                                                                method="POST">
                                                                                @csrf
                                                                                @method('POST')
                                                                                <input type="hidden"
                                                                                    name="notification"
                                                                                    value="{{ $notification->uuid }}">
                                                                                <input type="hidden"
                                                                                    name="school_request"
                                                                                    value="{{ $notification->request_uuid }}">
                                                                                <input type="hidden"
                                                                                    name="status"
                                                                                    value="rejected">
                                                                                <button type="submit"
                                                                                    class="btn btn-seia-red btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                                                    <i class="ph-x"></i> Recusar
                                                                                </button>
                                                                            </form>
                                                                        </div>
                                                                    @else
                                                                        <div class="d-flex mt-2">
                                                                            <button type="submit"
                                                                                class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                                                <i class="ph ph-eye-slash"></i>
                                                                                Marcar como não lida
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="accordion-item"></div>
                                                @endforeach
                                            @else
                                                <div class="d-flex justify-content-center py-5">
                                                    <span class="text-center text-dark-seia">
                                                        Nenhuma notificação
                                                    </span>
                                                </div>
                                            @endif

                                        </div>
                                        <div class="tab-pane fade" id="notificationsRead" role="tabpanel"
                                            aria-labelledby="notificationsRead-tab">

                                            @if ($notifications->where('read', true)->count() > 0)
                                                @php
                                                    $recentNotifications = $notifications
                                                        ->where('read', true)
                                                        ->sortByDesc('created_at')
                                                        ->take(4);
                                                @endphp
                                                @foreach ($recentNotifications as $notification)
                                                    @php
                                                        $modalId = uniqid('modal_');
                                                    @endphp
                                                    <div class="accordion accordion-flush"
                                                        id="accordionFlushExample">
                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="flush-headingOne">
                                                                <button
                                                                    class="accordion-button collapsed "
                                                                    type="button" data-bs-toggle="collapse"
                                                                    data-bs-target="#{{ $modalId }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="flush-collapseOne">
                                                                    <div
                                                                        class="d-flex flex-column align-items-start text-dark-seia">
                                                                        <div class="d-flex justify-content-center align-items-center gap-1 notification">
                                                                            <i class="{{ $notification->icon }} {{ $notification->type }} p-2 text-white rounded-circle">
                                                                            </i> {{ $notification->title }}
                                                                        </div>
                                                                        <div class="text-muted "
                                                                            style="font-size: 12px; margin-left: 3em">
                                                                            {{ $notification->created_at->format('d/m/Y - H:i') }}
                                                                        </div>
                                                                    </div>
                                                                </button>
                                                            </h2>
                                                            <div id="{{ $modalId }}"
                                                                class="accordion-collapse collapse"
                                                                aria-labelledby="flush-headingOne"
                                                                data-bs-parent="#accordionFlushExample">
                                                                <div class="accordion-body text-dark-seia">
                                                                    {{ $notification->body }}

                                                                    @if ($notification->type == 'request')
                                                                        @if ($notification->request->status == 'accepted')
                                                                            <div class="d-flex mt-2">
                                                                                <span
                                                                                    class="text-seia-green fw-semibold mt-1">
                                                                                    Você já aceitou este convite
                                                                                </span>
                                                                            </div>
                                                                        @elseif ($notification->request->status == 'rejected')
                                                                            <div class="d-flex mt-2">
                                                                                <span
                                                                                    class="text-seia-red fw-semibold mt-1">
                                                                                    Você recusou este convite
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                    @else
                                                                        <div class="d-flex mt-2">
                                                                            <button type="submit"
                                                                                class="btn btn-seia-blue btn-sm d-flex justify-content-center align-items-center gap-1 fw-semibold">
                                                                                <i class="ph ph-eye-slash"></i>
                                                                                Marcar como não lida
                                                                            </button>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="accordion-item"></div>
                                                @endforeach
                                            @else
                                                <div class="d-flex justify-content-center py-5">
                                                    <span class="text-center text-dark-seia">
                                                        Nenhuma notificação já lida
                                                    </span>
                                                </div>
                                            @endif


                                        </div>
                                    </div>





                                    <div class="dropdown-footer">
                                        <a class="dropdown-item text-center small" href="{{route('profile.notifications')}}">
                                            Ver todas as notificações
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </li>

                        <li class="nav-item dropdown no-arrow mx-1">
                            <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link lime"
                                    aria-expanded="false" data-bs-toggle="dropdown" href="#"><span
                                        class="badge bg-danger badge-counter">7</span><i
                                        class="ph-envelope fs-5"></i></a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-list animated--grow-in">
                                    <h6 class="dropdown-header text-center">Mensagens</h6><a
                                        class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640049/samples/people/boy-snow-hoodie.jpg"
                                                alt="foto1">
                                            <div class="bg-success status-indicator"></div>
                                        </div>
                                        <div class="fw-bold">
                                            <div class="text-truncate"><span>Hi there! I am wondering if you can
                                                    help me with a problem I've been having.</span></div>
                                            <p class="small text-dark-seia mb-0">Emily Fowler - 58m</p>
                                        </div>
                                    </a><a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640049/samples/people/boy-snow-hoodie.jpg"
                                                alt="foto2">
                                            <div class="status-indicator"></div>
                                        </div>
                                        <div class="fw-bold">
                                            <div class="text-truncate"><span>I have the photos that you ordered
                                                    last
                                                    month!</span></div>
                                            <p class="small text-dark-seia mb-0">Jae Chun - 1d</p>
                                        </div>
                                    </a><a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image me-3"><img class="rounded-circle"
                                                src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640049/samples/people/boy-snow-hoodie.jpg"
                                                alt="foto3">
                                            <div class="bg-warning status-indicator"></div>
                                        </div>
                                        <div class="fw-bold">
                                            <div class="text-truncate"><span>Last month's report looks great, I am
                                                    very happy with the progress so far, keep up the good
                                                    work!</span></div>
                                            <p class="small text-dark-seia mb-0">Morgan Alvarez - 2d</p>
                                        </div>
                                    </a><a class="dropdown-item d-flex align-items-center" href="#">
                                        <div class="dropdown-list-image me-3">
                                            <img class="rounded-circle"
                                                src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1675640049/samples/people/boy-snow-hoodie.jpg"
                                                alt="foto4">
                                            <div class="bg-success status-indicator"></div>
                                        </div>
                                        <div class="fw-bold">
                                            <div class="text-truncate"><span>Am I a good boy? The reason I ask is
                                                    because someone told me that people say this to all dogs, even
                                                    if they aren't good...</span></div>
                                            <p class="small text-dark-seia mb-0">Chicken the Dog · 2w</p>
                                        </div>
                                    </a><a class="dropdown-item text-center small text-dark-seia"
                                        href="#">Ver todas
                                        as mensagens </a>
                                </div>
                            </div>
                            <div class="shadow dropdown-list dropdown-menu dropdown-menu-end"
                                aria-labelledby="alertsDropdown"></div>
                        </li>

                    </ul>
                </div>
            </nav>

            <main class="container">

                {{ $slot }}

            </main>
        </div>

    </div>
    <a class="border rounded d-inline scroll-to-top text-decoration-none" href="#page-top"><i
            class="ph-caret-up"></i></a>
</div>

<!-- Modal -->
<div class="modal fade modalDiario1" id="bimestre2" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="bimestre2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bimestre2Label">2º Bimestre - 5ª ano B - Língua portuguesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="modalDiario">
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table ">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Faltas</th>
                                    <th scope="col">Nota 1</th>
                                    <th scope="col">Nota 2</th>
                                    <th scope="col">Nota 3</th>
                                    <th scope="col">Nota 4</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>João Pedro da silva</td>
                                    <td><span>0</span></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <tr>
                                    <th scope="row">2</th>
                                    <td>Carmen lucien da silva</td>
                                    <td><span>5</span></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                    <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Carmen lucien da silva</td>
                                <td><span>5</span></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Carmen lucien da silva</td>
                                <td><span>5</span></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Carmen lucien da silva</td>
                                <td><span>5</span></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Carmen lucien da silva</td>
                                <td><span>5</span></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Carmen lucien da silva</td>
                                <td><span>5</span></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                                <th scope="row">2</th>
                                <td>Carmen lucien da silva</td>
                                <td><span>5</span></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                <td><input type="number" class="form-control" placeholder="0" disabled></td>
                                </tr>
                            </tbody>
                        </table>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn btn-primary" id="disabledFalse"
                        onclick="removeDisabled()">Editar</button>
                    <button type="button" class="btn btn-danger d-none" id="disabledTrue"
                        onclick="cancelDiarioAlterar()">Cancelar</button>
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/home/index.js') }}?v=1.5"></script>
@yield('scripts')


</body>

</html>
