require('./vue-asset.js');
import { createApp, defineComponent} from "vue";
import crearProveedor from "./components/proveedor/CrearProveedor.vue";
import vistaProveedor from "./components/proveedor/VistaProveedor.vue";

const app = defineComponent({
    components: {
        'crear-proveedor': crearProveedor,
        'vista-proveedor': vistaProveedor
    },
});
createApp(app).mount('#inventory');
