const VueLoaderPlugin = require('vue-loader');
const path = require('path');
module.exports = {
    module:{
        rules: [
            {
                test:/\.vue$/,
                loader:'vue-loader',
            },
            {
                test:/\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                  loader: "babel-loader",
                  options:{
                      sourceType: "module",
                      presets: ['@babel/preset-env'],

                  },
                },
            },
        ],
    },
    plugins:[
        new VueLoaderPlugin(''),
        ["@babel/plugin-transform-runtime", {
            "corejs": 2,
        }],
    ],
    resolve: {
        alias: {
            '@': path.resolve(__dirname, 'src/'),
            extensions: [".wasm", ".mjs", ".js", ".jsx", ".json", ".vue"],

        }
    }
};
