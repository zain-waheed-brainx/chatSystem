<template>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Listing</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12" v-if="list.length === 0">
                        No Conversations Found
                    </div>
                    <div class="col-12" v-for="row in list" :key="row.thread_id">
                        <div @click="messageList(row.thread_id)">
                            {{row.name}}
                            <hr>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
                list: [],
                message: [],
            };
        },
        created() {
            this.fetchList();
        },

        methods: {
            fetchList() {
                axios.get('/chat-list').then((res) => {
                    this.list = res.data.data;
                    console.log(this.list)
                });
            },
            messageList(id) {

                axios.get('/message-list/'+id).then((res) => {
                    this.$emit('messages', res.data.data)
                    this.$emit('thread_id', id)
                    console.log('emit')
                });
            },
        }
    }
</script>
