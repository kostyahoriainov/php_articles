const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
    entry: './assets/app/main.js',
    output: {
        path: path.join(__dirname, '/public/dist/'),
        filename: 'bundle.js'
    },
    mode: "development",
    resolve: {
        extensions: [ '.js', '.vue'],
        alias: {
            '@': path.join(__dirname, '/assets/'),
        }
    },
    module: {
        rules: [
            {
                test: /\.vue$/,
                exclude: /node_modules/,
                loader: "vue-loader"
            },
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader',
            }
        ]
    },
    plugins: [
        new VueLoaderPlugin()
    ]
};