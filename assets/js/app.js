/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

const button = document.querySelector('#button-list');
const list = document.querySelector('#list');

button.onclick = function () {
    list.classList.toggle('visible')
};

const inputNumber = document.querySelector('#numbers_inputNumber');

inputNumber.addEventListener("keyup",function () {
    if (inputNumber.value > 0 && inputNumber.value <= 99999) {
        inputNumber.setCustomValidity('');
    } else {
        inputNumber.setCustomValidity('Proszę podać numer z zakresu od 1 do 99999');
    }
});