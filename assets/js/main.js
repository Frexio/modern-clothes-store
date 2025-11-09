//przesuwaniee zdjec
let position =0;
const slider = document.getElementById('slider');
const slidesToShow =3;
const slideGap =20;

function przesunzdj(direction) {
    const slide = slider.querySelector('.slide');
    const slideWidth=slide.offsetWidth + slideGap;
    const maxPosition = -(slider.children.length - slidesToShow) * slideWidth;

    position += direction * slideWidth;
    if (position > 0) position=0;
    if (position < maxPosition) position = maxPosition;
    slider.style.transform = 'translateX(${position}px)';

}

window.addEventListener('resize', () => {
    position=0;
    slider.style.transform = 'translateX(0px)';

});