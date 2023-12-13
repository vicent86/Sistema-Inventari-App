// En el componente Vue
const axios = require('axios');
const config = require('./config.js');

module.exports =  {
    base_url: "http://localhost/login",
    data() {
        return {
            // Aquí van tus otras propiedades de data...
        };
    },
    methods: {
        getData() {
            axios.get(config.base_url + "info-box").then((response) => {
                this.info = response.data;
                this.isLoading = false;
            });
        },
    },
    // ...
};
