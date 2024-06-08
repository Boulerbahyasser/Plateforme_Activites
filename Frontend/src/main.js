

// Importez `createApp` de Vue
import { createApp } from 'vue';
import App from './App.vue';
import router from './router';

// import '../node_modules/flowbite-vue/dist/index.css' ;

// Créez l'instance de l'application
const app = createApp(App);

// Utilisez le router avec `app.use()`
app.use(router);

// Montez l'application
app.mount('#app');
