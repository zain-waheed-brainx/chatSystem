<template>

    <div class="col-md-12" style="margin-bottom: 2rem">
        <div class="card">
            <div class="card-header">Add new Group</div>

            <div class="card-body">
                <div class="row">
                    <div class="col-12" >
                        <form action="#" @submit.prevent="createGroup()">
                            <div class="form-group">
                                <input v-model="group.name" class="form-control" type="text" name="text">
                            </div>
                            <div class="form-group">
                                <select class="form-control" v-model="group.selectedValue" multiple>
                                    <option disabled value="">Select</option>
                                    <option v-for="item in list" :value="item.id">{{item.name}}</option>
                                </select>
                            </div>


                            <input type="submit" value="Create">
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {


        data() {
            return {
                list: [],
                group:{
                    name:'',
                    selectedValue: [],
                }


            };
        },
        created() {
            this.fetchList();
        },

        methods: {
            fetchList() {
                axios.get('/user-list').then((res) => {
                    this.list = res.data.data;
                    console.log(this.list)
                });
            },
            createGroup() {
                console.log(this.group)
                axios.post('/create-group', this.group)
                    .then((res) => {
                        console.log(res)
                    })
                    .catch((err) => console.error(err));
            },
        }
    }
</script>
