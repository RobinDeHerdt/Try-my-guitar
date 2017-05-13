
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
Vue.component('chat-heading', require('./components/ChatHeading.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#app',

    data: {
        messages: [],
        channel: []
    },

    created() {
        if(document.getElementById('chat-page') && document.getElementById('channel-id')) {
            var channel_id = document.getElementById('channel-id').value;

            this.fetchMessages(channel_id);
            this.fetchChannel(channel_id);

            Echo.private(`channel.${channel_id}`)
                .listen('MessageSent', (e) => {
                    this.messages.push({
                        message: e.message.message,
                        user: e.user
                    });
                    this.messageSeen(channel_id);
                })
                .listen('ChatJoined', (e) => {
                    this.channel.users.push(e.user);
                })
                .listen('ChatLeft', (e) => {
                    this.channel.users.splice(e.user);
                });
        }
    },

    methods: {
        fetchMessages(channel_id) {
            axios.get(`/api/chat/channel/${channel_id}/messages`).then(response => {
                this.messages = response.data;
            });
        },

        fetchChannel(channel_id) {
            axios.get(`/api/chat/channel/${channel_id}`).then(response => {
                this.channel = response.data[0];
            });
        },

        addMessage(message) {
            this.messages.push(message);

            var channel_id = document.getElementById('channel-id').value;

            axios.post(`/api/chat/channel/${channel_id}/messages/send`, message);
        },

        messageSeen(channel_id) {
            axios.post(`/api/chat/channel/${channel_id}/messages/seen`);
        },
    }
});