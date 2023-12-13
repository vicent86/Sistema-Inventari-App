const VueLoaderPlugin = require('vue-loader');
const path = require('path');

module.exports = {
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: 'vue-loader',
            },
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: [['@babel/preset-env']],
                    },
                },
            },
        ],
    },
    plugins: [new VueLoaderPlugin()],

    resolve: {
        extensions: ['.wasm', '.mjs', '.js', '.jsx', '.json', '.vue'],
        alias: {
            'vue': '@vue/runtime-dom'
        }
    },
};
