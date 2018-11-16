import api from '../../api/db';


// initial state
const state = {
    all: []
};

// getters
const getters = {
    getAll(){
        return state.all;
    }
};

// actions
const actions = {
    getAll ({ commit }) {
        api.getAllConsumers( consumers => {
            commit('setConsumers', consumers)
        })
    },
    remove({commit} , consumer ){

        return api.deleteConsumers(consumer).then(data=>{
            commit('deleteConsumers', consumer);
            return data
        }).catch( error =>{
            return error.response;
        });


    },
    add({commit} , consumer ){

        return api.addConsumer( consumer).then(data=>{
            consumer.id = data.data.id;
            commit('addConsumer',consumer);
            return data;
        }).catch(error=>{
            return error.response;
        });
    },
    update({commit} , consumer ){

        return api.updateConsumer(consumer).then(data=>{
            commit('updateConsumer',consumer);
            return data;
        }).catch(error=>{
            return error.response;
        });

    }
};

// mutations
const mutations = {
    setConsumers (state, consumers) {
        state.all = consumers
    },
    deleteConsumers(state, consumer){

        let index = state.all.indexOf(consumer);
        state.all.splice(index, 1);

    },
    addConsumer(state , consumer){
        state.all.push(consumer);
    },
    updateConsumer(state, consumer){
        state.all.find(function (element) {
            if(element.id === consumer.id){
                element = consumer;
            }
        })
    }

};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
}