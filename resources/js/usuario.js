require('./vue-asset.js');
import { createApp, defineComponent } from "vue";
import crearUsuario from "./components/usuario/CrearUsuario.vue";
import vistaUsuario from "./components/usuario/VistaUsuario.vue";

const app = defineComponent({
    components: {
        'crear-usuario': crearUsuario,
        'vista-usuario': vistaUsuario
    },
});
createApp(app).mount('#inventory');
