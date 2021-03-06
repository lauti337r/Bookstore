var Encore = require('@symfony/webpack-encore');


Encore
// directory where compiled assets will be stored
    .setOutputPath('public/build/')

    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')
    .cleanupOutputBeforeBuild()
    .autoProvidejQuery()
    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addStyleEntry('global', './assets/css/global.scss')
    .addEntry('jquery','./assets/js/jquery.js')
    .addStyleEntry('shop-hp','./assets/css/shop-homepage.css')
    //.addEntry('bootstrapbundle','./assets/js/bootstrap.bundle.js')
    .addEntry('jqmycart','./assets/js/jquery.mycart.js')
    .addEntry('starsjs','./assets/js/star-rating.min.js')
    .addEntry('starscss','./assets/css/star-rating.min.css')
    //.addStyleEntry('bootstrap','/assets/css/bootstrap.css')
    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')
    .cleanupOutputBeforeBuild()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning()

// uncomment if you use TypeScript
//.enableTypeScriptLoader()

// uncomment if you use Sass/SCSS files
.enableSassLoader()

// uncomment if you're having problems with a jQuery plugin
//.autoProvidejQuery()


module.exports = Encore.getWebpackConfig();