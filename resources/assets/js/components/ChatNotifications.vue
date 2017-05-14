<template>
    <div>
        <div class="chat-notification" v-for="notification in notifications">
            <span>Message: {{ notification.message }}</span><br>
            <span>from: {{ notification.user.first_name }}</span><br>
            <span>in: {{ notification.channel.name }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['notifications']
    };
</script>