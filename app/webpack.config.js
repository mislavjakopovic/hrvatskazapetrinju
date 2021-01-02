var Encore = require('@symfony/webpack-encore');

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('public/assets/')
    .setPublicPath('/assets')
    .setManifestKeyPrefix('assets/')
    .cleanupOutputBeforeBuild()

    /* Theme CSS */
    .addStyleEntry('css/theme/style', './assets/css/theme/style.css')
    .addStyleEntry('css/theme/components', './assets/css/theme/components.css')

    /* SCSS compiles */
    .addEntry('css/custom', './assets/custom.js')

    /* Custom CSS */
    .addEntry('css/pages/home', './assets/css/pages/home.css')

    /* Custom JS */
    .addEntry('js/init/scripts', './assets/js/inits/scripts.init.js')
    .addEntry('js/init/stisla', './assets/js/inits/stisla.init.js')
    .addEntry('js/init/app', './assets/js/inits/app.init.js')
    .addEntry('js/pages/create', './assets/js/pages/create.page.js')
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
