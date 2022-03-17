<template>
    <div class="row">
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Create Group</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <group-component @refresh="refreshChatList"></group-component>
                    </div>
                </div>
            </div>
        </div>
         <listing-component @messages="msgList" @thread_id="getThreadId" :refresh="refresh"></listing-component>
        <message-component :message="message" :thread_id="thread_id" :Auth="Auth"></message-component>
    </div>
</template>

<script>
    export default {
        props:['Auth'],
        mounted() {
        },
        data() {
            return {
                message: [],
                thread_id: null,
                refresh: 0,
            };
        },
        methods:{
            msgList(e)
            {
                this.message = e;
            },
            refreshChatList(e)
            {
                this.refresh = e;
            },
            getThreadId(e)
            {
                this.thread_id = e;
            },
        }
    }
</script>
