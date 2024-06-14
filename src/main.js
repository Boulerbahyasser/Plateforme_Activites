

// Importez `createApp` de Vue
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import '@fortawesome/fontawesome-free/css/all.css';
import '@fortawesome/fontawesome-free/js/all.js';


// Créez l'instance de l'application
const app = createApp(App);

// Utilisez le router avec `app.use()`
app.use(router);

// Montez l'application
app.mount('#app');
