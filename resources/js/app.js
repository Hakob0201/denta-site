// require('./bootstrap');
const jquery          = require("jquery");

jquery.event.special.touchstart = {
    setup: function( _, ns, handle ){
        this.addEventListener("touchstart", handle, { passive: true });
    }
};

window.$              = jquery;
window.jQuery         = jquery;

const owlCarousel     = require('owl.carousel');
const magnificPopup   = require('magnific-popup');
const moment          = require('moment');

const datepicker      = require('air-datepicker');
require('./plugin/datepicker/datepicker.hy');
require('./plugin/datepicker/datepicker.en');

window.owlCarousel    = owlCarousel;
window.magnificPopup  = magnificPopup;
window.moment         = moment;
window.datepicker     = datepicker;

require('./custom');
