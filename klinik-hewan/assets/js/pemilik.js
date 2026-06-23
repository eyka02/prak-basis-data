
document.addEventListener('DOMContentLoaded', () => {

    /* =========================
       TABLE FADE
    ========================= */

    document
    .querySelectorAll('.table tr')
    .forEach((row,index)=>{

        row.classList.add('fade-item');

        setTimeout(()=>{

            row.classList.add('show');

        },index * 70);

    });

    /* =========================
       RIPPLE BUTTON
    ========================= */

    document
    .querySelectorAll('.btn')
    .forEach(btn=>{

        btn.addEventListener(
        'click',
        function(e){

            const ripple =
            document.createElement('span');

            ripple.classList.add('ripple');

            const rect =
            this.getBoundingClientRect();

            ripple.style.left =
            (e.clientX - rect.left) + 'px';

            ripple.style.top =
            (e.clientY - rect.top) + 'px';

            this.appendChild(ripple);

            setTimeout(()=>{

                ripple.remove();

            },600);

        });

    });

    /* =========================
       MODAL TAMBAH
    ========================= */

    const modalTambah =
    document.getElementById('modalPemilik');

    const openBtn =
    document.getElementById('openModal');

    const closeBtn =
    document.getElementById('closeModal');

    const cancelBtn =
    document.getElementById('cancelModal');

    if(openBtn && modalTambah){

        openBtn.addEventListener(
        'click',
        ()=>{

            modalTambah.classList.add(
            'show'
            );

        });

    }

    if(closeBtn){

        closeBtn.addEventListener(
        'click',
        ()=>{

            modalTambah.classList.remove(
            'show'
            );

        });

    }

    if(cancelBtn){

        cancelBtn.addEventListener(
        'click',
        ()=>{

            modalTambah.classList.remove(
            'show'
            );

        });

    }

    if(modalTambah){

        modalTambah.addEventListener(
        'click',
        (e)=>{

            if(e.target===modalTambah){

                modalTambah.classList.remove(
                'show'
                );

            }

        });

    }

    /* =========================
       INPUT EFFECT
    ========================= */

    document
    .querySelectorAll(
    '.input-group input, .input-group textarea'
    )
    .forEach(input=>{

        input.addEventListener(
        'focus',
        ()=>{

            input.parentElement.style.transform =
            'translateY(-2px)';

        });

        input.addEventListener(
        'blur',
        ()=>{

            input.parentElement.style.transform =
            'translateY(0)';

        });

    });

    /* =========================
       AJAX DETAIL / EDIT
    ========================= */

    const ajaxModal =
    document.getElementById(
    'ajaxModal'
    );

    const modalContent =
    document.getElementById(
    'modalContent'
    );

    const closeAjaxModal =
    document.getElementById(
    'closeAjaxModal'
    );

    if(ajaxModal){

        document
        .querySelectorAll('.btn-detail')
        .forEach(btn=>{

            btn.addEventListener(
            'click',
            async ()=>{

                const id =
                btn.dataset.id;

                const response =
                await fetch(
                `detail_pemilik.php?id=${id}`
                );

                const html =
                await response.text();

                modalContent.innerHTML =
                html;

                ajaxModal.classList.add(
                'show'
                );

            });

        });

        document
.querySelectorAll('.btn-edit')
.forEach(btn => {

    btn.addEventListener(
        'click',
        async () => {

            const id = btn.dataset.id;

            const response = await fetch(
                `edit_pemilik.php?id=${id}`
            );

            const html = await response.text();

            modalContent.innerHTML = html;

            ajaxModal.classList.add('show');

            // =========================
            // HANDLE FORM UPDATE
            // =========================

            const form =
            modalContent.querySelector("form");

            if(form){

                form.addEventListener(
                    "submit",
                    function(){

                        console.log("FORM UPDATE DIKIRIM");
                    }
                );

            }

        }

    );

});

        if(closeAjaxModal){

            closeAjaxModal.addEventListener(
            'click',
            ()=>{

                ajaxModal.classList.remove(
                'show'
                );

            });

        }

        ajaxModal.addEventListener(
        'click',
        (e)=>{

            if(e.target===ajaxModal){

                ajaxModal.classList.remove(
                'show'
                );

            }

        });

    }

});

