<template>
    <div class="container">


        <div class="row mt-3">
            <div class="col-md-4">
                <input class="search form-control" placeholder="Search"  v-model="search"/>
            </div>
            <div class="col-md-2 offset-md-6">
                <select class="form-control" v-model="selectOrder" >
                    <option value="id asc">ID Asc</option>
                    <option value="id desc">ID Desc</option>
                    <option value="name asc">Name Asc</option>
                    <option value="name desc">Name Desc</option>
                </select>
            </div>
        </div>

        <div class="row mt-3">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">City</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody class="list">
                <tr v-for="consumer in consumers " :key="consumer.id">

                    <td >{{consumer.id}}
                    <span style="display: none;">{{consumer.updated_at}}</span>
                    </td>
                    <td  @dblclick="enableEdit('name' , consumer)" v-bind:class="{ 'text-danger': consumer.age < 18 , 'text-success' : consumer.age > 60  }">
                        <div v-if="consumer.edit.name">
                            <div  class="input-group">
                                <input type="text" class="form-control"  v-model="consumer.name" v-validate="'required|min:4|max:40'" name="edit.name">

                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" @click="updateConsumer(consumer , 'name')">ok </button>
                                    <button class="btn btn-outline-secondary" type="button" @click="cancelEdit('name' , consumer)">x </button>
                                </div>
                            </div>
                            <span class="text-danger">{{ errors.first('edit.name') }}</span>
                        </div>
                        <label v-else >{{consumer.name}}</label>
                    </td>
                    <td @dblclick="enableEdit('age' , consumer)">
                        <div v-if="consumer.edit.age">
                            <div class="input-group">
                                <input type="text" class="form-control"  v-model="consumer.age" v-validate="'required|between:14,99'" name="edit.age">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" @click="updateConsumer(consumer , 'age')">ok </button>
                                    <button class="btn btn-outline-secondary" type="button" @click="cancelEdit('age' , consumer)">x </button>
                                </div>
                            </div>
                            <span class="text-danger">{{ errors.first('edit.age') }}</span>
                        </div>
                        <label v-else > {{consumer.age}}</label>
                    </td>
                    <td @dblclick="enableEdit('city' , consumer)">
                        <div v-if="consumer.edit.city">
                            <div class="input-group">
                                <input type="text" class="form-control"  v-model="consumer.city" v-validate="'required|included:Sofia,Varna,Plovdiv'" name="edit.city">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" @click="updateConsumer(consumer , 'city')">ok </button>
                                    <button class="btn btn-outline-secondary" type="button" @click="cancelEdit('city' , consumer)">x </button>
                                </div>
                            </div>
                            <span class="text-danger">{{ errors.first('edit.city') }}</span>
                        </div>
                        <label v-else > {{consumer.city}}</label>
                    </td>
                    <td>
                        <button class="btn btn-danger"  @click="removeConsumer(consumer)" :disabled=isDisabled >DELETE</button>
                    </td>
                </tr>
                </tbody>
                <tfoot>

                <tr>
                    <td></td>
                    <td>
                        <input class="form-control" v-model="form.name" v-validate="'required|min:4|max:40'" name="name" type="text"  placeholder="NAME" :disabled=isDisabled />
                        <p class="text-danger">{{ errors.first('name') }}</p>
                    </td>
                    <td>
                        <input class="form-control" v-model="form.age" v-validate="'required|between:14,99'" name="age" type="text" placeholder="AGE" :disabled=isDisabled />
                        <p class="text-danger">{{ errors.first('age') }}</p>
                    </td>
                    <td>
                        <input class="form-control" v-model="form.city" v-validate="'required|included:Sofia,Varna,Plovdiv'" name="city"  type="text" placeholder="CITY" :disabled=isDisabled />
                        <p class="text-danger">{{ errors.first('city') }}</p>
                    </td>
                    <td><button  class="btn btn-success" @click="addConsumer()" :disabled=isDisabled >ADD USER</button></td>
                </tr>
                </tfoot>

            </table>
        </div>
    </div>
</template>

<script>
   import { mapActions , mapGetters} from 'vuex';

    export default {
        data() {
            return {

                selectOrder: 'id asc',
                prevOrder: 'id asc',
                search: '',
                prevSearch: '',
                isDisabled: false,
                isEdit: false,
                editValue: '',
                form: {
                    name: "",
                    age: "",
                    city: "",
                },
            }
        },
        computed: {
         ...mapGetters( 'consumers' , {
            list: 'getAll'
        }),
            consumers: function(){

                let global = this;
                let temp   =  this.list;


                for (let index = 0; index < temp.length; ++index) {
                    temp[index].edit = {};
                    for(let key in  temp[index]){
                        temp[index].edit[key] = false;
                    }

                }


                if(this.search !== this.prevSearch || this.selectOrder !== this.prevOrder)
                {

                    this.prevSearch = this.search;

                    temp = temp.filter((consumer) => {

                        return    consumer.name.toLowerCase().indexOf(global.search.toLowerCase()) >= 0
                            || consumer.age.toString().toLowerCase().indexOf(global.search.toLowerCase()) >= 0
                            || consumer.city.toLowerCase().indexOf(global.search.toLowerCase()) >= 0
                    });
                }

                if(this.selectOrder !== this.prevOrder || this.search !== this.prevSearch)
                {
                    this.prevOrder = this.selectOrder;
                    let by = this.selectOrder.split(" ");
                    if(by.length === 2){
                        temp = _.orderBy(temp, by[0], by[1]);
                    }
                }

                return temp;
          }
        },
        methods:{
            ...mapActions('consumers', [
                'remove' , 'add' , 'update'
            ])
            ,
            removeConsumer(consumer){
              this.isDisabled = true;

              this.remove(consumer).then( ({data}) => {
                  let type = data.errors ? 'error' : 'success';

                  swal(
                      '',
                      data.message,
                      type
                  );
                  this.isDisabled = false;
              }).catch( error => {

              });
            },
            addConsumer(){

               this.$validator.validateAll().then(result=>{

                   if(result){
                       this.isDisabled = true;

                       this.add({name: this.form.name , city : this.form.city , age: this.form.age }).then( ({data}) => {

                           let type = 'error';

                           if(!data.errors){
                               type='success';

                               for(let key in this.form){
                                   this.form[key] = null;
                               }

                           }
                           swal(
                               '',
                               data.message,
                               type
                           );
                           this.isDisabled = false;

                           this.$validator.reset();

                       }).catch( error => {

                       });

                   }


               }).catch(error=>{});


            },
            updateConsumer(consumer , field){

                this.$validator.validate('edit.' + field).then(result=>{

                    if(result && consumer[field] !== this.oldValue){
                        this.isDisabled = true;

                        this.update(consumer).then(({data})=>{

                            let type = data.errors ? 'error' : 'success';

                            swal(
                                '',
                                data.message,
                                type
                            );
                            consumer.edit[field] =false;
                            consumer.updated_at = new Date();
                            this.isEdit     = false;
                            this.isDisabled = false;
                        }).catch(error=>{})
                    }
                }).catch(error=>{});

            },
            enableEdit(field,consumer)
            {
                if(!this.isEdit){
                    consumer.edit[field] = true;
                    this.oldValue = consumer[field];
                    consumer.updated_at = new Date();
                    this.isEdit = true;
                }

            },
            cancelEdit(field, consumer)
            {
                consumer.edit[field] = false;
                consumer[field] = this.oldValue;
                consumer.updated_at = new Date();
                this.isEdit = false;
                this.$validator.reset();

            }
        },

        beforeCreate() {
            this.$store.dispatch('consumers/getAll');
        }
    }
</script>
