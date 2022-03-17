<template>
    <div class="row">
        <group-component></group-component>
         <listing-component @messages="msgList" @thread_id="getThreadId"></listing-component>
        <message-component :message="message" :thread_id="thread_id" :Auth="Auth"></message-component>
    </div>
</template>

<script>
    export default {
        props:['Auth'],
        mounted() {
            console.log('Component mounted.')
            console.log(this.Auth);
        },
        data() {
            return {
                message: [],
                thread_id: null,
            };
        },
        methods:{
            msgList(e)
            {
                this.message = e;
            },
            getThreadId(e)
            {
                this.thread_id = e;
            },
        }
    }
</script>
