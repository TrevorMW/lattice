const path = require('path');
const TerserPlugin = require("terser-webpack-plugin");
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const { CleanWebpackPlugin } = require('clean-webpack-plugin');

const webpack = require('webpack');

module.exports = {
  entry: {
    core : ['./assets/js/src/main.js', '/assets/css/src/style.scss'], 
    homepage : ['./assets/js/src/frontpage.js', './assets/css/src/frontpage.scss']
  },
  output: {
    filename: './assets/js/build/bundle.[name].min.js',
    path: path.resolve(__dirname)
  },
  module: {
    rules: [
      {
        test: require.resolve('jquery'),
        use: [
          {
            loader: 'expose-loader',
            options: {
              exposes: [
                {
                  globalName: '$',
                  override: true,
                },
                {
                  globalName: 'jQuery',
                  override: true,
                },
              ],
            },
          },
        ],
      },
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
        use: [MiniCssExtractPlugin.loader, 'css-loader', 'sass-loader']
      }
    ]
  },
  plugins: [
    new MiniCssExtractPlugin({
      filename: './assets/css/build/[name].min.css'
    }),  

    new CleanWebpackPlugin({
      cleanOnceBeforeBuildPatterns: ['./assets/js/build/*','./assets/css/build/*']
    })
  ],
  optimization: {
    minimize: true,
    minimizer: [
      new TerserPlugin()
    ]
  }
};