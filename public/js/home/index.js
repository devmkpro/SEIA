const lightTheme = document.getElementById("light-theme");
const darkTheme = document.getElementById("dark-theme");
const moonIcon = document.getElementById("moon-icon");
const sunIcon = document.getElementById("sun-icon");
const imgPerfil = document.querySelectorAll(".img-perfil");
const logoSeia = document.querySelectorAll(".logo-seia");
const aName = document.querySelectorAll(".a-name");
const center = document.querySelectorAll(".center");
const iconsM = document.querySelectorAll(".icons-menu");

const caretLeft = document.getElementById('caret-left');
const caretRight = document.getElementById('caret-right');

const contentWrapper = document.getElementById('content-wrapper');
const blockScrollMobile = document.getElementById('blockScrollMobile');

var vw = Math.max(
    document.documentElement.clientWidth || 0,
    window.innerWidth || 0
);

window.addEventListener("load", function () {


    if (vw < 768) {
        
        localStorage.setItem('sidebar-toggled', 'sidebar-toggled')

        contentWrapper.style.overflowY = "auto";
        sidebar.classList.add("toggled");
        document.body.classList.add("sidebar-toggled");

 }

});
(function (){
    "use strict"; // Start of use strict

    var sidebar = document.querySelector(".sidebar");
    const aName = document.querySelectorAll(".a-name");
    const iconsM = document.querySelectorAll(".icons-menu");
    const center = document.querySelectorAll(".center");
    const logoSeia = document.querySelectorAll(".logo-seia");
    const imgPerfil = document.querySelectorAll(".img-perfil");
    const menutitle = document.querySelectorAll(".menu-title");
    const btnSidebarToggle = document.getElementById('btnSidebarToggle');
    var sidebarToggles = document.querySelectorAll(
        "#sidebarToggle, #sidebarToggleTop, .sidebarToggleTopMobile, #blockScrollMobile",
    );



    if (sidebar) {
        var collapseEl = sidebar.querySelector(".collapse");
        var collapseElementList = [].slice.call(
            document.querySelectorAll(".sidebar .collapse")
        );
        var sidebarCollapseList = collapseElementList.map(function (collapseEl) {
            return new bootstrap.Collapse(collapseEl, { toggle: false });
        });

        for (var toggle of sidebarToggles) {
            // Toggle the side navigation
            toggle.addEventListener("click", function (e) {
                document.body.classList.toggle("sidebar-toggled");
                sidebar.classList.toggle("toggled");



                if (vw < 768) {
                    if (sidebar.classList.contains("toggled")) {
                        contentWrapper.style.overflowY = "auto";
                        blockScrollMobile.classList.add("d-none");
                    } else {
                        contentWrapper.style.overflowY = "hidden";
                        blockScrollMobile.classList.remove("d-none");
                    }
                }


                //remover o if se der merda
                if (vw > 768) {
                     //troca ph-caret-left-bold por ph-caret-right-bold de btnSidebarToggle

                    if (sidebar.classList.contains("toggled")) {
                        btnSidebarToggle.classList.remove("ph-caret-left-bold");
                        btnSidebarToggle.classList.add("ph-caret-right-bold");
                        btnSidebarToggle.classList.add("ps-1");
                    } else {
                        btnSidebarToggle.classList.remove("ph-caret-right-bold");
                        btnSidebarToggle.classList.remove("ps-1");
                        btnSidebarToggle.classList.add("ph-caret-left-bold");
                    }

                    //adiciona center ao menu-title se modo retraido ativo
                    menutitle.forEach((m) => {
                        m.classList.toggle("align-self-start")
                        m.classList.toggle("center");
                    });

                    //Arruma imagem perfil se modo retraido ativo
                    imgPerfil.forEach((i) => {
                        i.classList.toggle("img-perfil-retraido");
                    });

                    //Esconde nomes se modo retraido ativo
                    aName.forEach((a) => {
                        a.classList.toggle("d-none");
                    });

                    //verificar se toggled remover w-50 e colocar logo-seia-retraido
                    if (sidebar.classList.contains("toggled")) {
                        logoSeia.forEach((l) => {
                            l.classList.remove("w-50");
                            l.classList.add("logo-seia-retraido");
                        });

                        localStorage.setItem('sidebar-toggled', 'sidebar-toggled')
                    } else {
                        logoSeia.forEach((l) => {
                            l.classList.add("w-50");
                            l.classList.remove("logo-seia-retraido");
                        });

                        localStorage.removeItem('sidebar-toggled')
                    }
                    //Centraliza itens se modo retraido ativo
                    center.forEach((c) => {
                        c.classList.toggle("center-retraido");
                    });

                    //Centraliza icones se modo retraido ativo
                    iconsM.forEach((i) => {
                        i.classList.toggle("icons-menu-retraido");
                    });

                    if (sidebar.classList.contains("toggled")) {
                        for (var bsCollapse of sidebarCollapseList) {
                            bsCollapse.hide();
                        }
                    }
                }

            

               
            });
        }

        // Close any open menu accordions when window is resized below 768px
        window.addEventListener("resize", function () {
            var vw = Math.max(
                document.documentElement.clientWidth || 0,
                window.innerWidth || 0
            );

            if (vw < 768) {
                for (var bsCollapse of sidebarCollapseList) {
                    bsCollapse.hide();
                }
            }
        });
    }



    // Prevent the content wrapper from scrolling when the fixed side navigation hovered over

    var fixedNaigation = document.querySelector("body.fixed-nav .sidebar");

    if (fixedNaigation) {
        fixedNaigation.on("mousewheel DOMMouseScroll wheel", function (e) {

            if (vw > 768) {
                var e0 = e.originalEvent,
                    delta = e0.wheelDelta || -e0.detail;
                this.scrollTop += (delta < 0 ? 1 : -1) * 30;
                e.preventDefault();
            }
        });
    }

    var scrollToTop = document.querySelector(".scroll-to-top");

    if (scrollToTop) {
        // Scroll to top button appear
        window.addEventListener("scroll", function () {
            var scrollDistance = window.pageYOffset;

            //check if user is scrolling up
            if (scrollDistance > 100) {
                scrollToTop.style.display = "block";
            } else {
                scrollToTop.style.display = "none";
            }
        });
    }
})(); // End of use strict

// Trocar tema
function switchTheme() {
    if (lightTheme.disabled) {
        lightTheme.disabled = false;
        darkTheme.disabled = true;
        moonIcon.style.display = "block";
        sunIcon.style.display = "none";
        localStorage.setItem('light-theme', 'light-theme')
        localStorage.removeItem('dark-theme')
    }
    else {
        lightTheme.disabled = true;
        darkTheme.disabled = false;
        moonIcon.style.display = "none";
        sunIcon.style.display = "block";
        localStorage.setItem('dark-theme', 'dark-theme')
        localStorage.removeItem('light-theme')
    }
}

//checar localstorage e mudar tema

if (localStorage.getItem('light-theme') == 'light-theme') {
    lightTheme.disabled = false;
    darkTheme.disabled = true;
    moonIcon.style.display = "block";
    sunIcon.style.display = "none";
}
else {
    lightTheme.disabled = true;
    darkTheme.disabled = false;
    moonIcon.style.display = "none";
    sunIcon.style.display = "block";
}


//checar localstorage e mudar modo retraido



if(vw>768){
    if (localStorage.getItem('sidebar-toggled') == 'sidebar-toggled') {
        document.body.classList.toggle("sidebar-toggled");
        sidebar.classList.toggle("toggled");
    
        if (sidebar.classList.contains("toggled")) {
            btnSidebarToggle.classList.remove("ph-caret-left-bold");
            btnSidebarToggle.classList.add("ph-caret-right-bold");
            btnSidebarToggle.classList.add("ps-1");
        } else {
            btnSidebarToggle.classList.remove("ph-caret-right-bold");
            btnSidebarToggle.classList.remove("ps-1");
            btnSidebarToggle.classList.add("ph-caret-left-bold");
        }
    
        //Arruma imagem perfil se modo retraido ativo
        imgPerfil.forEach((i) => {
            i.classList.toggle("img-perfil-retraido");
        });
    
        //Esconde nomes se modo retraido ativo
        aName.forEach((a) => {
            a.classList.toggle("d-none");
        });
    
        //verificar se toggled remover w-50 e colocar logo-seia-retraido
        if (sidebar.classList.contains("toggled")) {
            logoSeia.forEach((l) => {
                l.classList.remove("w-50");
                l.classList.add("logo-seia-retraido");
            });
        } else {
            logoSeia.forEach((l) => {
                l.classList.add("w-50");
                l.classList.remove("logo-seia-retraido");
            });
        }
        //Centraliza itens se modo retraido ativo
        center.forEach((c) => {
            c.classList.toggle("center-retraido");
        });
    
        //Centraliza icones se modo retraido ativo
        iconsM.forEach((i) => {
            i.classList.toggle("icons-menu-retraido");
        });
    }
}






// seleciona todos os checkboxes ao tocar no botão "todos"
$('#todos').on('click', function () {
    $('input[type="checkbox"]').prop('checked', true);

    updateHeaderButtons();
});

// marca somente os checkboxes com a classe "lidos"
$('#read').on('click', function () {
    $('.lido input[type="checkbox"]').prop('checked', true);

    updateHeaderButtons();
});

// marca somente os checkboxes sem a  classe "lidos"
$('#unread').on('click', function () {
    $('.unread input[type="checkbox"]').prop('checked', true);

    updateHeaderButtons();
});

// desmarca tudo
$('#notSelect').on('click', function () {
    $('input[type="checkbox"]').prop('checked', false);

    updateHeaderButtons();
});

// atualiza os botões no cabeçalho
const checkboxes = document.querySelectorAll('.checkbox');
for (let i = 0; i < checkboxes.length; i++) {
    checkboxes[i].addEventListener('change', function () {
        updateHeaderButtons();
    });
}


// habilita/desabilita os botões no cabeçalho
function updateHeaderButtons() {
    const numChecked = $('.checkbox:checked').length;
    const deleteBtn = $('#deleteBtn');
    const markReadBtn = $('#markReadBtn');
    if (numChecked > 0) {
        deleteBtn.removeClass('d-none');
        markReadBtn.removeClass('d-none');
    } else {
        deleteBtn.addClass('d-none');
        markReadBtn.addClass('d-none');
    }
}

//remove disabled dos inputs do form com id modalDiario quando o btn com id disabledFalse é clicado, apos o btn DisabledFalse perde a classe d-none e oculta o disabledFalse usando js puro
function removeDisabled() {
    disTrue = document.getElementById("disabledTrue");
    disFalse = document.getElementById("disabledFalse");

    disFalse.classList.add("d-none");
    disTrue.classList.remove("d-none");

    //inputs
    var inputs = document.querySelectorAll('#modalDiario input');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].removeAttribute('disabled');
    }
}

function cancelDiarioAlterar() {
    disTrue = document.getElementById("disabledTrue");
    disFalse = document.getElementById("disabledFalse");

    disFalse.classList.remove("d-none");
    disTrue.classList.add("d-none");

    //inputs
    var inputs = document.querySelectorAll('#modalDiario input');
    for (var i = 0; i < inputs.length; i++) {
        inputs[i].setAttribute('disabled', 'disabled');
    }
}



