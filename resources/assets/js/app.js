
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

Vue.component('chat-notifications', require('./components/ChatNotifications.vue'));
Vue.component('chat-participants', require('./components/ChatParticipants.vue'));
Vue.component('chat-messages', require('./components/ChatMessages.vue'));
Vue.component('chat-name', require('./components/ChatName.vue'));
Vue.component('chat-form', require('./components/ChatForm.vue'));

const app = new Vue({
    el: '#app',

    data: {
        notifications: [],
        channels: [],
        messages: [],
        channel: [],
        channelname: ''
    },

    created() {
        if(document.getElementById('channel-id')) {
            var channel_id = document.getElementById('channel-id').value;

            this.fetchMessages(channel_id);
            this.fetchChannel(channel_id);

            /**
             * @todo Api call to get all of the authenticated users channels.
             * Loop over all channels and apply listeners
             * Do this in the conditional 'channel-id' else section. That way events don't get shown double on chat pages.
             *
             * Create a vue template in the layout file. This template will loop over an array of all received events.
             * Show the template absolute positioned in the right bottom of the screen.
             * When clicked on 'close' section of the container, the event gets removed from the array.
             *
             * Optional: remove event after 10 seconds. (fade out)
             */

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
                    for (var i = 0; i < this.channel.users.length; i++) {
                        if (this.channel.users[i].id === e.user.id) {
                            this.channel.users.splice(i, 1);
                        }
                    }
                })
                .listen('ChatNameChanged', (e) => {
                    this.channelname = e.channel.name;
                });
        } else {
            /**
             * @todo Api call to get all of the authenticated users channels.
             * Loop over all channels and apply listeners
             * Do this in the conditional 'channel-id' else section. That way events don't get shown double on chat pages.
             *
             * Create a vue template in the layout file. This template will loop over an array of all received events.
             * Show the template absolute positioned in the right bottom of the screen.
             * When clicked on 'close' section of the container, the event gets removed from the array.
             *
             * Optional: remove event after 10 seconds. (fade out)
             */
            this.fetchUserChannels();
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
                this.channelname = this.channel.name;
            });
        },

        addMessage(message) {
            this.messages.push(message);
            var channel_id = document.getElementById('channel-id').value;
            axios.post(`/api/chat/channel/${channel_id}/messages/send`, message);
        },

        fetchUserChannels() {
            axios.get(`/api/chat/channels`).then(response => {
                this.channels = response.data;

                this.channels.forEach(channel => {
                    Echo.private(`channel.${channel.id}`)
                        .listen('MessageSent', (e) => {
                            var limitedMessage = '';

                            if(e.message.message.lenght > 60) {
                                limitedMessage = e.message.message.substring(0, 60) + '...';
                            } else {
                                limitedMessage = e.message.message;
                            }

                            this.notifications.unshift({
                                message: limitedMessage,
                                user: e.user,
                                channel: channel,
                            });

                            this.messageSeen(channel.id);
                        })
                        .listen('ChatJoined', (e) => {
                            this.notifications.unshift({
                                message: " has joined the chat!",
                                user: e.user,
                                channel: channel,
                            });
                        })
                        .listen('ChatLeft', (e) => {
                            this.notifications.unshift({
                                message: " has left the chat.",
                                user: e.user,
                                channel: channel,
                            });
                        });
                });

            });
        },

        messageSeen(channel_id) {
            axios.post(`/api/chat/channel/${channel_id}/messages/seen`);
        },
    }
});