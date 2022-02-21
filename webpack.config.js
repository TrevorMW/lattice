const path = require('path');
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const webpack = require('webpack');

module.exports = {
  devtool: 'source-map',
  entry: {
    core : ['./assets/js/src/main.js', '/assets/css/src/style.scss'], 
    quiz : ['./assets/js/src/quiz.js', '/assets/css/src/style.scss'],
    curriculum : ['/assets/js/src/curriculum.js', '/assets/css/src/style.scss']
  },
  output: {
    filename: './assets/js/build/bundle.[name].min.js',
    path: path.resolve(__dirname)
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
          options: {
            presets: ['@babel/preset-env']
          }
        }
      },
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
      }
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
    })
  ],
  optimization: {
    minimize: false,
    minimizer: [
      new TerserPlugin()
    ]
  }
};