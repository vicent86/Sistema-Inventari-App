require('./vue-asset.js');
import { createApp, defineComponent } from "vue";
import crearStock from "./components/stock/CrearStock.vue";
import vistaStock from "./components/stock/VistaStock.vue";

const app =defineComponent({
    components: {
      'crear-stock': crearStock,
      'vista-stock': vistaStock
    },
});
createApp(app).mount('#inventory');
