document.addEventListener(
'DOMContentLoaded',
()=>{

const cards =
document.querySelectorAll(
'.stock-card'
);

cards.forEach((card,index)=>{

card.style.opacity='0';
card.style.transform='translateY(25px)';

setTimeout(()=>{

card.style.transition='.5s';

card.style.opacity='1';

card.style.transform=
'translateY(0)';

},index*100);

});

/* TABLE ROW */

document
.querySelectorAll('.table tr')
.forEach((row,index)=>{

row.style.opacity='0';

setTimeout(()=>{

row.style.transition='.4s';

row.style.opacity='1';

},index*40);

});

/* CARD HOVER GLOW */

cards.forEach(card=>{

card.addEventListener(
'mousemove',
()=>{

card.style.boxShadow=
'0 25px 60px rgba(79,70,229,.15)';

});

card.addEventListener(
'mouseleave',
()=>{

card.style.boxShadow=
'0 15px 35px rgba(15,23,42,.06)';

});

});

});