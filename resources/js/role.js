require('./vue-asset.js');
import { createApp, defineComponent} from "vue";
import crearRole from "./components/role/CrearRole.vue";
import vistaRole from "./components/role/VistaRole.vue";

const app = defineComponent({
    components: {
        'crear-role': crearRole,
        'vista-role': vistaRole
    },
});

createApp(app).mount('#inventory');
