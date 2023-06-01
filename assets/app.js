const $ = require('jquery');

//Custom CSS
require('./styles/navbar.css');

//Bootstrap JS
require('bootstrap');

//Bootstrap CSS
require('./styles/app.scss');

// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});
