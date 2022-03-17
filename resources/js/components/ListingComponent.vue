<template>

    <div class="col-md-4" style="padding-right: 0px;">
        <div class="card " >
            <div class="card-header">Listing
                <i class="fa fa-ellipsis-v" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuButton" aria-hidden="true" style="float: right"></i>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a href="javascript:void(0)" class="dropdown-item" data-toggle="modal" data-target="#exampleModal">Create Group</a>
                </div>
            </div>

            <div class="card-body" style="overflow-y: scroll;height: 84vh">
                <div class="row">
                    <div class="col-12" v-if="list.length === 0">
                        No Conversations Found
                    </div>
                    <div class="col-12" v-for="row in list" :key="row.thread_id">
                        <a href="javascript:void(0)" @click="messageList(row.thread_id)">
                            {{row.name}}
                            <hr>
                        </a>

                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            refresh:Number,
        },
        mounted() {
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
        watch: {
            refresh: function (val, oldVal) {
                this.fetchList();
            },
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
