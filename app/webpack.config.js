var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')
    .setManifestKeyPrefix('assets/')
    .cleanupOutputBeforeBuild()

    /* SCSS compiles */
    .addEntry('css/style', './assets/style.js')
    .addEntry('css/components', './assets/components.js')
    .addEntry('css/reverse', './assets/reverse.js')

    /* Custom CSS */
    .addEntry('css/pages/home', './assets/css/pages/home.css')

    /* Custom JS */
    .addEntry('js/init/scripts', './assets/js/inits/scripts.init.js')
    .addEntry('js/init/stisla', './assets/js/inits/stisla.init.js')
    .addEntry('js/pages/home', './assets/js/pages/home.page.js')

    .enableSassLoader()
    .enableSingleRuntimeChunk()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableIntegrityHashes(Encore.isProduction())

    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[ext]',
    })

    .copyFiles({
        from: './assets/js/vendor',
        to: 'js/vendor/[path][name].[ext]',
    })

    .copyFiles({
        from: './assets/css/vendor',
        to: 'css/vendor/[path][name].[ext]',
    })
;

module.exports = Encore.getWebpackConfig();
