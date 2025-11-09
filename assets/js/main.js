//przesuwaniee zdjec
let position =0;
const slider = document.getElementById('slider');
const slidesToShow =3;
const sliderWidth = slider.querySelector('.slide').offsetWidth +20;

function przesunzdj(direction) {
    const maxPosition = -(silder.children.lenght - slidesToShow) * sliderWidth;
    position += direction * slideWidth *3;
    if (position >0) position=0;
    if (position < maxPosition) position = maxPosition;
    slider.style.transform = 'translatex(${position}px)';

}

window.addEventListener('resize', () => {
    position=0;
    slider.style.transform = 'translateX(0px)';

});