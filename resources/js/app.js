import { createApp } from "vue"
import router from './router'
import { createPinia } from 'pinia'
import App from './components/App.vue'
import { BootstrapIconsPlugin } from 'bootstrap-icons-vue';

const pinia = createPinia();
const originalWarn = console.warn;
console.warn = function () { };

const noop = () => { }
const warnHandler = (msg, vm, trace) => {
  // do nothing
}

createApp(App)
  .use(pinia)
  .use(router)
  //   .use(VueSweetalert2)
  .use(BootstrapIconsPlugin)
  .mount('#vueapp')
  .config.warnHandler = warnHandler
console.warn = originalWarn;