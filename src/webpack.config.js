const path = require('path');
const { VueLoaderPlugin } = require('vue-loader');

module.exports = {
    entry: './src/app/main.js',
    output: {
        path: path.join(__dirname, `/public/dist/`),
        filename: `bundle.js`
    },
    mode: "development",
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