import './bootstrap';
require('./bootstrap');
window.Vue = require('vue').default;
import HelloWorld from './components/HelloWorld.vue';
const app = new Vue({
  el: '#app',
  components: {
    HelloWorld
  }
});
