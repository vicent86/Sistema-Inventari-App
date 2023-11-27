require('./vue-asset');
import { createApp, defineComponent} from "vue";
import crearFactura from "./components/factura/CrearFactura.vue";
import vistaFactura from "./components/factura/VistaFactura.vue";

const app = defineComponent({
    components: {
      'crear-factura': crearFactura,
      'vista-factura': vistaFactura,
    },
});

createApp(app).mount('#inventory');
