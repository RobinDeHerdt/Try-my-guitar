
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
window.VueChatScroll = require('vue-chat-scroll');
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#app',

    data: {
        messages: []
    },

    created() {
        // There should be a better way to do this. @todo later. maybe.
        if(document.getElementById('chat-page')) {
            this.fetchMessages();

            var args = window.location.pathname.split("/");
            Echo.private(`channel.${args[3]}`)
                .listen('MessageSent', (e) => {
                    this.messages.push({
                        message: e.message.message,
                        user: e.user
                    });
                });
        }
    },

    methods: {
        fetchMessages() {
            var uri = window.location.pathname;

            axios.get(`${uri}/messages`).then(response => {
                this.messages = response.data;
                console.log(this.messages);
            });
        },

        addMessage(message) {
            this.messages.push(message);

            var uri = window.location.pathname;

            axios.post(`${uri}/messages`, message);
        },
    }
});