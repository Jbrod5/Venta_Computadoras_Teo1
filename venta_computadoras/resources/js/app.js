import './bootstrap';
import { createApp, h } from 'vue';



import Login from './components/Login.vue'
import Register from './components/RegisterClients.vue'
import AdminDashboard from './components/admin/Dashboard.vue';




const components = {
    'login': Login,
    'register-clients' : Register,
    'admin-dashboard' : AdminDashboard,
}


const el = document.getElementById('app');
const componentname = el.dataset.component;

const username = el.dataset.user;

createApp({
    render:() => h(components[componentname], {username})
}).mount('#app');

