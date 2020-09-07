const Encore = require('@symfony/webpack-encore');

Encore
    .setOutputPath('./src/Resources/public/')
    .setPublicPath('/bundles/magicwizard')
    .setManifestKeyPrefix('bundles/magicwizard')
    .cleanupOutputBeforeBuild()
    .enableSassLoader()
    .enableVueLoader()
    .enableSourceMaps(false)
    .enableVersioning(false)
    .disableSingleRuntimeChunk()
    .autoProvidejQuery()

    .addEntry('app', './assets/js/app.js')
;

module.exports = Encore.getWebpackConfig();
