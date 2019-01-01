/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
//JQuery and JS modules
const $ = require('jquery');
require('select2');

// CSS Modules
require('../css/app.css');
require('select2/dist/css/select2.css');

// App JS
$('select').select2();