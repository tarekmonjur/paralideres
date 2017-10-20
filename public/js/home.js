/**
 * Created by Tarek on 10/16/2017.
 */

new Vue({
    el: '#app',
    data:{
        base_url: window.base_url,
        api_url: window.api_url,
        resources: [],
        poll:[],
    },

    created(){
        this.getResources();
        this.getLastPoll();
    },

    filters: {
        truncate: function (string, value) {
            return string.substring(0, value) + '...';
        }
    },

    methods: {

        getResources(search=null, value=null){
            if(search !=null){
                var action_url = '/'+search+'?search='+value;
            }else{
                var action_url = '';
            }
            axios.get(this.api_url+'resources'+action_url)
            .then(response => {
                this.resources = response.data.data;
                // console.log(response);
                // console.log(this.resources);
            });
        },

        getNextResources(next_page_url){
            axios.get(next_page_url)
            .then(response => {
                this.resources = response.data.data;
                // console.log(response);
                // console.log(this.resources);
            });
        },

        getCategoryResources(slug){
            axios.get(this.api_url+'categories/'+slug+'/resources')
            .then(response => {
                this.resources = response.data.data;
                // console.log(response);
                // console.log(this.resources);
            });
        },

        resourceDownload(resource){

        },

        givenResourceLike(resource){
            axios.post(this.api_url+'resources/'+resource.id+'/like')
            .then(response => {
                if(response.data.status == 'like'){
                    if(resource.likes_count.length > 0){
                        resource.likes_count[0].total +=1;
                    }else{
                        resource.likes_count = [{'resource_id': resource.id,'total':1}];
                    }

                }else if(response.data.status == 'unlike'){
                    if(resource.likes_count.length > 0){
                        resource.likes_count[0].total -=1;
                    }else{
                        resource.likes_count = [{'resource_id': resource.id,'total':0}];
                    }
                }
            });
        },

        getLastPoll(){
            axios.get(this.api_url+'polls/last')
            .then(response => {
                this.poll = response.data.data;
                // console.log(response);
                // console.log(this.poll);
            });
        },

        votePoll(){
            let formID = document.querySelector('#votePoll');
            let formData = new FormData(formID);

            axios.post(this.api_url+'polls/'+this.poll.id+'/vote', {
                'option': formData.get('poll_option')
            })
            .then(response => {
                this.poll = response.data.data;
                // console.log(response);
                // console.log(this.poll);
            })
            .catch(error => {

            });
        },

    }

});