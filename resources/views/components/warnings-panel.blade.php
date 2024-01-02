<div class="avisos hstack gap-3">
    <div class="text d-flex justify-content-between align-items-start flex-column gap-3">
        <h3 class="title">
            {{
                $title ?? 'Bem vindo(a) ao SEIA! Seu ambiente de aprendizagem.'
            }}
        </h3>
        <p class="fs-6">
            {{
                $slot ?? 'Fique atento aos avisos e notificações para não perder nenhum prazo importante!'
            }}
        </p>
    </div>
    <img class="bookn ms-auto"
        src="https://res.cloudinary.com/dnjjcvwx5/image/upload/v1676052403/assets/seia/img/book_nuvem_euwnog.svg"
        alt="livro com capa vermelha e quadro, apenas demostrativo">
</div>
