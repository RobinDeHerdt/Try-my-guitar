
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/autocomplete.js';
import 'jquery-ui/ui/widgets/progressbar.js';
import 'jquery-ui/ui/widgets/slider.js';

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
        this.listenOnAuthUserChannel();

        if(document.getElementById('channel-id')) {
            var channel_id = document.getElementById('channel-id').value;
            this.listenOnCurrentChannel(channel_id);
            this.fetchMessages(channel_id);
            this.fetchChannel(channel_id);
        } else {
            this.listenOnUserChannels();
        }
    },

    methods: {
        listenOnAuthUserChannel() {
            axios.get('/user').then(response => {
                if(response.data) {
                    var user_id = response.data;

                    Echo.private(`user-channel.${user_id}`)
                        .listen('InviteSent', (e) => {
                            this.notifications.unshift({
                                message: " has invited you to chat!",
                                user: e.sender,
                                channel: e.channel,
                                type: 'invite',
                            });

                            this.checkMaxNotificationsReached(this.notifications, 8);
                            // this.removeNotificationAfterInterval(this.notifications);
                        });
                }
            });
        },

        fetchMessages(channel_id) {
            axios.get(`/channel/${channel_id}/messages`).then(response => {
                this.messages = response.data;
            });
        },

        fetchChannel(channel_id) {
            axios.get(`/channel/${channel_id}`).then(response => {
                this.channel = response.data[0];
                this.channelname = this.channel.name;
            });
        },

        addMessage(message) {
            this.messages.push(message);
            var channel_id = document.getElementById('channel-id').value;
            axios.post(`/channel/${channel_id}/messages/send`, message);
        },

        listenOnCurrentChannel(channel_id) {
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
        },

        listenOnUserChannels() {
            axios.get(`/channels`).then(response => {
                this.channels = response.data;
                if(response.data) {
                    this.channels.forEach(channel => {
                        Echo.private(`channel.${channel.id}`)
                            .listen('MessageSent', (e) => {
                                var limitedMessage = '';

                                if (e.message.message.lenght > 60) {
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
                                this.checkMaxNotificationsReached(this.notifications, 8);
                                // this.removeNotificationAfterInterval(this.notifications);
                            })
                            .listen('ChatJoined', (e) => {
                                this.notifications.unshift({
                                    message: " has joined the chat!",
                                    user: e.user,
                                    channel: channel,
                                });

                                this.checkMaxNotificationsReached(this.notifications, 8);
                                // this.removeNotificationAfterInterval(this.notifications);
                            })
                            .listen('ChatLeft', (e) => {
                                this.notifications.unshift({
                                    message: " has left the chat.",
                                    user: e.user,
                                    channel: channel,
                                });

                                this.checkMaxNotificationsReached(this.notifications, 8);
                                // this.removeNotificationAfterInterval(this.notifications);
                            });
                    });
                }
            });
        },

        checkMaxNotificationsReached(notifications, max) {
            if (notifications.length >= max) {
                notifications.pop();
                return notifications;
            }
        },

        removeNotificationAfterInterval(notifications) {
            setInterval(function(){
                notifications.pop();
                return notifications;
            },10000)
        },

        messageSeen(channel_id) {
            axios.post(`/channel/${channel_id}/messages/seen`);
        },
    }
});