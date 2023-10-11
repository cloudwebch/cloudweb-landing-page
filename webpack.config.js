// Import the original config from the @wordpress/scripts package.
const defaultConfig = require('@wordpress/scripts/config/webpack.config')
// Plugins.
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts')
const CompressionPlugin = require('compression-webpack-plugin')

// Utilities.
const path = require('path')
const {resolve} = require('path')
const themePlugins = [
  new RemoveEmptyScriptsPlugin({
    stage: RemoveEmptyScriptsPlugin.STAGE_AFTER_PROCESS_PLUGINS,
  }),
  new CompressionPlugin({
    algorithm: 'gzip',
  }),
]

// Add any a new entry point by extending the webpack config.
module.exports = {
  ...defaultConfig,
  output:        {
    filename: '[name].js',
    path:     resolve(process.cwd(), 'assets/build'),
    clean:    true,
  },
  entry:         {
    'js/variations': [
      path.resolve(process.cwd(), 'src/blocks/variations', 'index.js'),
    ],
  },
  plugins:       [...defaultConfig.plugins, ...themePlugins],
  externalsType: 'global',
  externals:     {
    jquery: 'jQuery',
  },
}
