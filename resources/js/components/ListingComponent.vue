<template>

    <div class="col-md-4" style="padding-right: 0px;">
        <div class="card " >
            <div class="card-header"><img :src="'/images/user.png'" style="height: 50px">
                <i class="fa fa-ellipsis-v" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="dropdownMenuButton" aria-hidden="true" style="float: right;margin-top: 10px;font-size: 20px"></i>
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
                        <a href="javascript:void(0)" @click="messageList(row.thread_id,row.name)">
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
                    if (this.list.length>0)
                    {
                        console.log('here');
                        this.messageList(this.list[0].thread_id,this.list[0].name)
                    }

                });
            },
            messageList(id,name) {

                axios.get('/message-list/'+id).then((res) => {
                    this.$emit('messages', res.data.data)
                    this.$emit('thread_id', id)
                    this.$emit('name', name)
                });
            },
        }
    }
</script>
