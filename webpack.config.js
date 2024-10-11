const path = require('path');
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const CssMinimizerPlugin = require("css-minimizer-webpack-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');
const { VueLoaderPlugin } = require('vue-loader');

const yargs = require('yargs');

const webpack = require('webpack');

const argv = yargs.argv;
const isDev = argv.mode === 'development';

module.exports = {
  devtool:  'source-map',
  entry: {
    core : ['./assets/js/src/main.js', '/assets/css/src/style.scss'], 
    quiz : ['./assets/js/src/quiz.js', '/assets/css/src/style.scss'],
    curriculum : ['/assets/js/src/curriculum.js', '/assets/css/src/style.scss'],
    admin: ['/assets/js/src/admin.js','/assets/css/src/admin.scss' ],
    exit: ['./assets/js/src/exitQuiz.js'],
  },
  output: {
    filename: './assets/js/build/bundle.[name].min.js',
    path: path.resolve(__dirname)
  },
  module: {
    rules: [
      {
        test: /\.(sass|scss)$/,
        use: [ 
          MiniCssExtractPlugin.loader, 
          'css-loader', 
          'sass-loader'
        ]
      },
      {
        test: [
          /\.bmp$/,
          /\.gif$/,
          /\.jpe?g$/,
          /\.png$/,
          /\.tiff$/,
          /\.ico$/,
          /\.avif$/,
          /\.webp$/,
          /\.eot$/,
          /\.otf$/,
          /\.ttf$/,
          /\.woff$/,
          /\.woff2$/,
          /\.svg$/
        ],
        exclude: [/\.(js|mjs|jsx|ts|tsx)$/],
        type: 'asset/resource',
        generator: {
          filename: 'static/img/[name][ext]'
        }
      },
      {
        test: /\.vue$/,
        loader: 'vue-loader'
      },
    ]
  },
  plugins: [

    new webpack.ProvidePlugin({
        $: "jquery",
        jQuery: "jquery"
    }),

    new MiniCssExtractPlugin({
      filename: './assets/css/build/[name].min.css'
    }),  

    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: ['./assets/js/build/*','./assets/css/build/*']
    }),

    new VueLoaderPlugin(),
  ],
  // optimization: {
  //   minimize: true,
  //   minimizer: [
  //     new TerserPlugin(),
  //     new CssMinimizerPlugin()
  //   ]
  // }
};