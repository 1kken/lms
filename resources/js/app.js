require('./bootstrap');

var Turbolinks = require("turbolinks")
require('axios')
require('quagga').default;
if (Turbolinks.supported) {
    Turbolinks.start();
}
