<template>
    <div class="notification">
        <div v-for="notification in notifications">
            <a v-bind:href="'/chat/channel/' + notification.channel.id">
                <div class="chat-notification">
                    <div class="notification-user">
                        <div class="profile-picture" v-bind:style="{ backgroundImage: 'url(/storage/' + notification.user.image_uri + ')' }"></div>
                    </div>
                    <div class="notification-content">
                        <strong>{{ notification.channel.name }}</strong><br/>
                        <span><strong>{{ notification.user.first_name }}: </strong>{{ notification.message }}</span>
                    </div>
                </div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['notifications']
    };
</script>