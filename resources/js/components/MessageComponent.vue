<template>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Messages</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12" v-if="message.length === 0" style="margin-bottom: 30px;text-align: center">
                        No MSGS Found
                    </div>
                    <div class="col-12" v-for="row in message" :key="row.id">
                        <p :key="row.id" :style="{textAlign:(Auth==row.from?'right':'left')}">
                            {{row.text}}
                        </p>

                    </div>
                    <div class="col-12" v-if="send_msg">
                        <form action="#" @submit.prevent="sendMsg()">
                            <input v-model="msg.text" class="form-control" type="text" name="text">
                            <input v-model="thread_id" type="hidden"  name="thread_id">
                            <input type="submit" style="float: right;margin-top: 10px" value="Send">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        props: {
            message:Array,
            Auth:Number,
            thread_id:Number,
        },
        data() {
            return {
                // message : [],
                send_msg : false,
                msg: {
                    thread_id: this.thread_id,
                    text: ''
                }
            };
        },
        updated()
        {
            console.log('updated');
            console.log(this.thread_id);
            this.send_msg = true;
        },
        methods:{
            sendMsg(){
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
