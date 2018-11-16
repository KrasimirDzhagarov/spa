

const end_point = "api/";

export default  {

    getAllConsumers(cb){

        axios.get(end_point + "consumer").then( ({data})=> {
           cb(data);
        }).catch(({error}) => {

            console.log('error');

        })

    },

    deleteConsumers(consumer){

        return axios.delete(end_point + "consumer/" + consumer.id);

    },

    addConsumer(consumer){

        return axios.post(end_point + "consumer", {name: consumer.name , age: consumer.age , city: consumer.city});

    },

    updateConsumer(consumer){

        return axios.put(end_point + "consumer/" + consumer.id, {name: consumer.name , age: consumer.age , city: consumer.city});
    }

}