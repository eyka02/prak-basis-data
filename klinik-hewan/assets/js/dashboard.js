
/*
=========================
CARD ANIMATION
=========================
*/

const cards =
document.querySelectorAll('.card');

cards.forEach(card => {

    card.addEventListener('mousemove', e => {

        const rect =
        card.getBoundingClientRect();

        const x =
        e.clientX - rect.left;

        const y =
        e.clientY - rect.top;

        card.style.background =
        `
        radial-gradient(
            circle at ${x}px ${y}px,
            rgba(99,102,241,.15),
            rgba(255,255,255,.85)
        )
        `;

    });

    card.addEventListener('mouseleave',()=>{

        card.style.background =
        'rgba(255,255,255,.75)';

    });

});



/*
=========================
COUNTER ANIMATION
=========================
*/

const numbers =
document.querySelectorAll('.card h1');

numbers.forEach(number => {

    const value =
    parseInt(
        number.innerText.replace(/\D/g,'')
    );

    if(isNaN(value)) return;

    let start = 0;

    const speed = value / 50;

    const update = () => {

        start += speed;

        if(start < value){

            number.innerText =
            Math.floor(start)
            .toLocaleString();

            requestAnimationFrame(update);

        }else{

            number.innerText =
            value.toLocaleString();
        }
    };

    update();

});

/*
=========================
FADE IN
=========================
*/

const observer =
new IntersectionObserver(entries=>{

entries.forEach(entry=>{

if(entry.isIntersecting){

entry.target.style.opacity='1';

entry.target.style.transform=
'translateY(0px)';

}

});

});

document
.querySelectorAll('.detail-card')
.forEach(item=>{

item.style.opacity='0';

item.style.transform=
'translateY(40px)';

item.style.transition=
'.7s ease';

observer.observe(item);

});

