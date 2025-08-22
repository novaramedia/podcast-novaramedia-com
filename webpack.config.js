const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');
const postcssPresetEnv = require('postcss-preset-env');

module.exports = (env, argv) => {
  const isProduction = argv.mode === 'production';

  return {
    entry: './src/styl/main.styl',

    output: {
      path: path.resolve(__dirname, 'dist'),
      filename: 'bundle.js', // We need this but won't use it for CSS-only builds
    },

    module: {
      rules: [
        {
          test: /\.styl$/,
          use: [
            {
              loader: MiniCssExtractPlugin.loader,
            },
            {
              loader: 'css-loader',
              options: {
                url: false,
              },
            },
            {
              loader: 'postcss-loader',
              options: {
                postcssOptions: {
                  plugins: [postcssPresetEnv()],
                },
              },
            },
            {
              loader: 'stylus-native-loader',
            },
          ],
        },
      ],
    },

    plugins: [
      new MiniCssExtractPlugin({
        filename: 'style.css',
      }),
    ],

    optimization: {
      minimizer: isProduction ? [new CssMinimizerPlugin()] : [],
    },

    devtool: isProduction ? false : 'source-map',
    watch: !isProduction,
  };
};