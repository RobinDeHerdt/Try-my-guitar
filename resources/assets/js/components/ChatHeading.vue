<template>
    <div>
        <div class="profile-teaser" v-for="user in channel.users">
            <a v-bind:href="'/profile/' + user.id">
                <div class="profile-picture" v-bind:style="{ backgroundImage: 'url(/storage/' + user.image_uri + ')' }"></div>
            </a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['channel']
    };
</script>