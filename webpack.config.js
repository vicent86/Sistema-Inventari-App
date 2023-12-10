const VueLoaderPlugin = require("vue-loader/lib/plugin");

module.exports = {
    module: {
        rules: [
            {
                test: /\.vue$/,
                loader: "vue-loader/lib/plugin",
            },
            {
                test: /\.m?js$/,
                exclude: /(node_modules|bower_components)/,
                use: {
                    loader: "babel-loader",
                    options: {
                        presets: [["@babel/preset-env"]],
                    },
                },
            },
        ],
    },
    plugins: [new VueLoaderPlugin()],

    resolve: {
        extensions: ["*", ".wasm", ".mjs", ".js", ".jsx", ".json", ".vue"],
    },
};







