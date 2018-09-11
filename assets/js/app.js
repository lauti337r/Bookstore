// assets/js/app.js

//require('https://sdk.accountkit.com/en_US/sdk.js');

require('../css/app.css');

require('../css/global.scss');

require('../css/bootstrap.css');

//console.log('Hello Webpack Encore');


const imagesContext = require.context('../images', true, /\.(png|jpg|jpeg|gif|ico|svg|webp)$/);
imagesContext.keys().forEach(imagesContext);

const $ = require('jquery');

require('bootstrap');

$(document).ready(function() {
    $('[data-toggle="popover"]').popover();
});