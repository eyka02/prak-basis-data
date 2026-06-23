
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

    content.innerHTML =
    '<div class="loading">Memuat...</div>';

    modal.classList.add('show');

    const response =
    await fetch(url);

    content.innerHTML =
    await response.text();

}

document
.getElementById('openModal')
?.addEventListener(
'click',
()=>{

openModal(
'tambah_obat.php'
);

});

document
.querySelectorAll('.btn-edit')
.forEach(btn=>{

btn.addEventListener(
'click',
()=>{

openModal(
`edit_obat.php?id=${btn.dataset.id}`
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

});
