require('./vue-asset.js');
import { createApp, defineComponent} from "vue";
import informeFormulario from "./components/informe/InformeFormulario.vue";

const app = defineComponent({
    components: {
        'informe-formulario': informeFormulario,
    },
});

createApp(app).mount('#inventory');
