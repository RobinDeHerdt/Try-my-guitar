<template>
    <ul class="chat" v-chat-scroll>
        <li class="left clearfix" v-for="(message, index) in messages">
            <div class="chat-body clearfix">
                <div class="header" v-if="index === 0 || messages[index-1].user.id !== message.user.id">
                    <strong class="primary-font" v-if="message.user.last_name">{{ message.user.first_name + ' ' + message.user.last_name }} </strong>
                    <strong class="primary-font" v-if="!message.user.last_name">{{ message.user.first_name }} </strong>
                    <span> &middot; {{ message.created_at | date }}</span>
                </div>
                <p>{{ message.message }}</p>
            </div>
        </li>
    </ul>
</template>

<script>
   import moment from 'moment';

    const formatDate = function(value) {

      if (value) {
        if(moment(value).isSame(moment(), 'day')) {
          return moment(String(value)).format('[Today at] h:mm a');
        }

        return moment(String(value)).format('dddd h:mm a');
      }
    }

  export default {
    filters: {
      date: formatDate
    },

    props: ['messages']
  };
</script>
