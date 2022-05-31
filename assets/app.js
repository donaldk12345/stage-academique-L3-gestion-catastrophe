/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import $ from 'jquery';
global.$ = $;

// start the Stimulus application
import './bootstrap';
import './js/bootstrap.bundle.min.js';
import './js/popper.min.js';
import './js/jquery.js';
import './js/script.js';
import './js/scroll.js';
import './js/jquery-2.2.4.min.js';
import './js/jquery-3.1.0.min.js';
require('@fortawesome/fontawesome-free/js/all');
import 'animate.css';


var myInput = document.getElementById('myInput')
myModal.addEventListener('shown.bs.modal', function() {
    myInput.focus()
})