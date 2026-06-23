
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

    modal.classList.add('show');

    const response =
    await fetch(url);

    content.innerHTML =
    await response.text();
}

/* TAMBAH */

document
.getElementById('openModal')
?.addEventListener(
'click',
()=>{

openModal(
'tambah_vaksin.php'
);

});

/* EDIT */

document
.querySelectorAll('.btn-edit')
.forEach(btn=>{

btn.addEventListener(
'click',
()=>{

openModal(
`edit_vaksin.php?id=${btn.dataset.id}`
);

});

});

/* CLOSE */

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

document.addEventListener(
'keydown',
e=>{

if(e.key==='Escape'){

modal.classList.remove(
'show'
);

}

});

});

