
document.addEventListener(
'DOMContentLoaded',
()=>{

const modal =
document.getElementById(
'ajaxModal'
);

const modalContent =
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

if(!modal || !modalContent)
return;

/* ==========================
   INIT FORM PENDAFTARAN
========================== */

function initPendaftaran()
{

const selectPemilik =
document.getElementById(
'id_pemilik'
);

const listHewan =
document.getElementById(
'list_hewan'
);

const dataHewan =
document.getElementById(
'hewan_json'
);

if(
!selectPemilik ||
!listHewan ||
!dataHewan
)
{
return;
}

const hewan =
JSON.parse(
dataHewan.value
);

selectPemilik.addEventListener(
'change',
function(){

const id =
parseInt(this.value);

let html = '';

hewan.forEach(function(item){

if(
parseInt(item.id_pemilik)
===
id
)
{

html +=

`
<label
style="
display:block;
margin-bottom:8px;
cursor:pointer;
">

<input
type="checkbox"
name="id_hewan[]"
value="${item.id_hewan}">

🐾 ${item.nama_hewan}

</label>
`;

}

});

if(html=='')
{

html =
'Tidak ada hewan milik pemilik ini.';

}

listHewan.innerHTML =
html;

});

}

/* ==========================
   OPEN MODAL
========================== */

async function openModal(url)
{

try{

modalContent.innerHTML =

`
<div class="modal-loading">

<div class="loader"></div>

<p>
Memuat data...
</p>

</div>
`;

modal.classList.add(
'show'
);

const response =
await fetch(url);

if(!response.ok)
{

throw new Error(
'Gagal mengambil data'
);

}

const html =
await response.text();

modalContent.innerHTML =
html;

/* jalankan kembali JS
   pada form yang baru dimuat */

initPendaftaran();

}
catch(error)
{

modalContent.innerHTML =

`
<div class="error-box">

<h3>
⚠️ Terjadi Kesalahan
</h3>

<p>

${error.message}

</p>

</div>
`;

}

}

/* ==========================
   ADD BUTTON
========================== */

if(addBtn)
{

addBtn.addEventListener(
'click',
()=>{

openModal(
'tambah_appointment.php'
);

});

}

/* ==========================
   DETAIL BUTTON
========================== */

document
.querySelectorAll(
'.btn-detail'
)
.forEach(btn=>{

btn.addEventListener(
'click',
()=>{

openModal(
`detail_appointment.php?id=${btn.dataset.id}`
);

});

});

/* ==========================
   EDIT BUTTON
========================== */

document
.querySelectorAll(
'.btn-edit'
)
.forEach(btn=>{

btn.addEventListener(
'click',
()=>{

openModal(
`edit_appointment.php?id=${btn.dataset.id}`
);

});

});

/* ==========================
   CLOSE MODAL
========================== */

function closeModal()
{

modal.classList.remove(
'show'
);

setTimeout(()=>{

modalContent.innerHTML='';

},200);

}

if(closeBtn)
{

closeBtn.addEventListener(
'click',
closeModal
);

}

/* backdrop */

modal.addEventListener(
'click',
(e)=>{

if(e.target===modal)
{

closeModal();

}

});

/* ESC */

document.addEventListener(
'keydown',
(e)=>{

if(
e.key==='Escape'
&&
modal.classList.contains(
'show'
)
)
{

closeModal();

}

});

});

