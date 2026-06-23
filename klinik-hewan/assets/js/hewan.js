
document.addEventListener('DOMContentLoaded', () => {

    const modal = document.getElementById('ajaxModal');
    const modalContent = document.getElementById('modalContent');
    const closeBtn = document.getElementById('closeAjaxModal');

    if (!modal || !modalContent) return;

    async function loadModal(url) {

        modalContent.innerHTML = `
            <div class="modal-loading">
                <div class="spinner"></div>
                <p>Memuat data...</p>
            </div>
        `;

        modal.classList.add('show');

        try {

            const response = await fetch(url);
            const html = await response.text();

            modalContent.innerHTML = html;

        } catch (error) {

            modalContent.innerHTML = `
                <div class="modal-error">
                    Gagal memuat data.
                </div>
            `;

        }

    }

    document.querySelectorAll('.btn-detail').forEach(btn => {

        btn.addEventListener('click', () => {

            loadModal(
                `detail_hewan.php?id=${btn.dataset.id}`
            );

        });

    });

    document.querySelectorAll('.btn-edit').forEach(btn => {

        btn.addEventListener('click', () => {

            loadModal(
                `edit_hewan.php?id=${btn.dataset.id}`
            );

        });

    });

    const tambahBtn =
    document.getElementById('openModal');

    if(tambahBtn){

        tambahBtn.addEventListener('click', () => {

            loadModal('tambah_hewan.php');

        });

    }

    function closeModal(){

        modal.classList.remove('show');

        setTimeout(() => {

            modalContent.innerHTML = '';

        },300);

    }

    if(closeBtn){

        closeBtn.addEventListener(
            'click',
            closeModal
        );

    }

    modal.addEventListener(
        'click',
        (e)=>{

            if(e.target === modal){

                closeModal();

            }

        }
    );

    document.addEventListener(
        'keydown',
        (e)=>{

            if(e.key === 'Escape'){

                closeModal();

            }

        }
    );

});

