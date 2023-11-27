require('./vue-asset');
import { createApp, defineComponent } from "vue";

import vistaCliente from "./components/cliente/VistaCliente.vue";
import crearCliente from "./components/cliente/CrearCliente.vue";

const app = defineComponent({
    components: {
        'crear-cliente': crearCliente,
        'vista-cliente': vistaCliente
    },
});

createApp(app).mount('#inventory');
