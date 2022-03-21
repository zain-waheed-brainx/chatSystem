<template>

    <div class="col-md-8" style="padding-left: 0px;">
        <div class="card h-100">
            <div class="card-header" :class="{headerHeight:!chat_open}">
                <div v-if="chat_open"><img :src="'/images/user.png'" style="height: 50px"><i style="margin-left: 10px">{{name}}</i>
                </div>
                <p v-else style="margin-top: 10px;margin-left: 10px">Messages</p></div>

            <div class="d-flex flex-column card-body chat">
                        <div class="p-2 scrollable h-100">
                            <div v-if="message.length === 0" style="text-align: center">
                                No MSGS Found
                            </div>
                                <ul v-else>

                                    <li :class="{him:Auth!=row.from,me:Auth==row.from}" v-for="row in message"
                                        :key="row.id">
                                        <b v-if="Auth!=row.from" style="color: black">{{row.sender.name}}</b> <br v-if="Auth!=row.from">
                                        {{row.text}}
                                        <br>
                                        <i style="float: right;color: black"> {{row.time}}</i>
                                    </li>
                                </ul>
                        </div>
                        <div class="p-1">
                            <form class="form-inline w-100" action="#" @submit.prevent="sendMsg()" v-if="send_msg">
                                <div class="form-group" style="width: calc(100% - 60px)">
                                    <input v-model="thread_id" type="hidden" name="thread_id">
                                    <input v-model="msg.text" class="form-control w-100" type="text" name="text">
                                </div>
                                <button type="submit" class="btn btn-success">Send</button>
                            </form>

                        </div>

            </div>

        </div>
    </div>

</template>
<style>
    .headerHeight {
        height: 74px
    }

    .scrollable {
        width: 100%;
        overflow-y: auto;
    }

    .fixed {
        height: 100%;
        max-height: 345px;
        position: fixed;
    }

    .chat {
        height: 85vh;
        background-image: url('/images/chat_bg.jpg');
        padding-block-start:0;
        padding-block-end:2.2rem;
        padding-inline : 0;
    }

    .chat ul {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .chat ul li {
        display: inline-block;
        clear: both;
        padding: 20px;
        border-radius: 30px;
        margin-bottom: 2px;
        font-family: Helvetica, Arial, sans-serif;
    }

    .chat .him {
        background: #eee;
        float: left;
    }

    .chat .me {
        float: right;
        background: #0084ff;
        color: #fff;
    }

    .chat .him + .me {
        border-bottom-right-radius: 5px;
    }

    .chat .me + .me {
        border-top-right-radius: 5px;
        border-bottom-right-radius: 5px;
    }

    .chat .me:last-of-type {
        border-bottom-right-radius: 30px;
    }
</style>
<script>
    export default {
        props: {
            message: Array,
            Auth: Number,
            name: String,
            thread_id: Number,
        },
        data() {
            return {
                send_msg: false,
                chat_open: false,
                msg: {
                    thread_id: this.thread_id,
                    text: ''
                }
            };
        },
        updated() {
            this.send_msg = true;
            $(".scrollable").scrollTop($(".scrollable")[0].scrollHeight);
        },
        watch: {
            send_msg: function (val, oldVal) {
                this.chat_open = true;
            },
        },
        methods: {
            sendMsg() {
                this.msg.thread_id = this.thread_id;
                axios.post('/send-message', this.msg)
                    .then((res) => {
                        this.msg.text = '';
                        this.message.push(res.data.data)
                    })
                    .catch((err) => console.error(err));
            }
        }
    }
</script>
