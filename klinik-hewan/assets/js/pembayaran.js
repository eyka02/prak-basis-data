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

const closeBtn =
document.getElementById(
'closeAjaxModal'
);

const addBtn =
document.getElementById(
'openAddModal'
);

async function openModal(url)
{

content.innerHTML =

`
<div class="modal-loading">
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

/* tambah */

if(addBtn)
{

addBtn.addEventListener(
'click',
()=>{

openModal(
'tambah_pembayaran.php'
);

});

}

/* detail */

document
.querySelectorAll('.btn-detail')
.forEach(btn=>{

btn.addEventListener(
'click',
()=>{

openModal(
`detail_pembayaran.php?id=${btn.dataset.id}`
);

});

});

/* close */

if(closeBtn)
{

closeBtn.addEventListener(
'click',
()=>{

modal.classList.remove(
'show'
);

});

}

modal.addEventListener(
'click',
e=>{

if(e.target===modal)
{

modal.classList.remove(
'show'
);

}

});

});