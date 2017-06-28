<template>
    <div class="notification">
        <div v-for="notification in notifications">
            <div class="chat-notification" v-if="notification.type != 'invite'">
                <a v-bind:href="'/chat/channel/' + notification.channel.id">
                    <div class="notification-user">
                        <div class="profile-picture" v-bind:style="{ backgroundImage: 'url(/storage/' + notification.user.image_uri + ')' }"></div>
                    </div>
                    <div class="notification-content">
                        <span class="notification-channel-name">{{ notification.channel.name }}</span><br/>
                        <span><strong>{{ notification.user.first_name }} </strong>{{ notification.message }}</span>
                    </div>
                </a>
                <div class="notification-close" v-on:click="removeNotification(notifications.indexOf(notification))">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
            <div class="chat-notification" v-if="notification.type == 'invite'">
                <a v-bind:href="'/dashboard#invites'">
                    <div class="notification-user">
                        <div class="profile-picture" v-bind:style="{ backgroundImage: 'url(/storage/' + notification.user.image_uri + ')' }"></div>
                    </div>
                    <div class="notification-content">
                        <span class="notification-channel-name">{{ notification.channel.name }}</span><br/>
                        <span><strong>{{ notification.user.first_name }} </strong>{{ notification.message }}</span>
                    </div>
                </a>
                <div class="notification-close" v-on:click="removeNotification(notifications.indexOf(notification))">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['notifications'],
        methods: {
            removeNotification(array_index) {
                this.notifications.splice(array_index, 1);
            }
        }
    };
</script>