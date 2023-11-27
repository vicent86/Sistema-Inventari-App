require('./vue-asset');
import { createApp, defineComponent} from "vue";
import crearProducto from "./components/producto/CrearProducto.vue";
import vistaProducto from "./components/producto/VistaProducto.vue";

const app = defineComponent({
    components: {
      'crear-producto': crearProducto,
      'vista-producto': vistaProducto
    },

});

createApp(app).mount('#inventory');
