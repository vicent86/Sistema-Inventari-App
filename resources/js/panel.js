require('./vue-asset');
import { createApp, defineComponent} from "vue";
import infoBox from './components/panel/InfoBox.vue';

const app = defineComponent({
    components: {
        'info-box': infoBox,
    },
});

createApp(app).mount('#inventory');
