document.addEventListener(
'DOMContentLoaded',
()=>{

const modal =
document.getElementById(
'ajaxModal'
);

const content =
document.getElementById(
'modalContent'
);

async function openModal(url){

    content.innerHTML = `
    <div class="loading">
        Memuat data...
    </div>
    `;

    modal.classList.add(
    'show'
    );

    const response =
    await fetch(url);

    content.innerHTML =
    await response.text();

}

document
.getElementById(
'openModal'
)
?.addEventListener(
'click',
()=>{

openModal(
'tambah_kunjungan.php'
);

});

document
.querySelectorAll(
'.btn-detail'
)
.forEach(btn=>{

btn.addEventListener(
'click',
()=>{

openModal(
`detail_kunjungan.php?id=${btn.dataset.id}`
);

});

});

document
.getElementById(
'closeAjaxModal'
)
?.addEventListener(
'click',
()=>{

modal.classList.remove(
'show'
);

});

modal?.addEventListener(
'click',
e=>{

if(e.target===modal){

modal.classList.remove(
'show'
);

}

});

});