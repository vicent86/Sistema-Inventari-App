require('./vue-asset');
import { createApp, defineComponent } from "vue";
import CrearCategoria from "./components/categoria/CrearCategoria.vue";
import VistaCategoria from "./components/categoria/VistaCategoria.vue";

const app = defineComponent({
    components: {
        'crear-categoria': CrearCategoria,
        'vista-categoria' : VistaCategoria
    },
})

createApp(app).mount('#inventory');
