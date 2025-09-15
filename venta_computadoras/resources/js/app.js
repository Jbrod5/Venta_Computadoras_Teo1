import './bootstrap';
import { createApp, h } from 'vue';



import Login from './components/Login.vue'
import Register from './components/RegisterClients.vue'

const components = {
    'login': Login,
    'register-clients' : Register,
}


const el = document.getElementById('app');
const componentname = el.dataset.component;

createApp({
    render:() => h(components[componentname])
}).mount('#app');

