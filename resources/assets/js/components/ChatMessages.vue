<template>
    <ul class="chat" v-chat-scroll>
        <li class="left clearfix" v-for="message in messages">
            <div class="chat-body clearfix">
                <div class="header">
                    <strong class="primary-font" v-if="message.user.last_name">{{ message.user.first_name + ' ' + message.user.last_name }}</strong>
                    <strong class="primary-font" v-if="!message.user.last_name">{{ message.user.first_name }}</strong>
                    <strong> | {{ message.created_at }}</strong>
                </div>
                <p>{{ message.message }}</p>
            </div>
        </li>
    </ul>
</template>

<script>
  export default {
    props: ['messages']
  };
</script>