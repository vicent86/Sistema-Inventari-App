// En un archivo llamado config.js
export const base_url = "http://localhost/login";

// En tu componente Vue
import { base_url } from './config.js';

export default {
    // ...
    methods: {
        getData() {
            axios.get(base_url + "info-box").then((response) => {
                this.info = response.data;
                this.isLoading = false;
            });
        },
    },
    // ...
};
