/**
 * Created by Tarek on 10/16/2017.
 */

$(document).ready(function(){
new Vue({
    el: '#app',
    data:{
        base_url: window.base_url,
        api_url: window.api_url,
        resources: [],
        poll:[],
        pollResult:false
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
            this.$common.loadingShow(0);
            if(search !=null){
                var action_url = '/'+search+'?search='+value;
            }else{
                var action_url = '';
            }
            axios.get(this.api_url+'resources'+action_url)
            .then(response => {
                this.resources = response.data.data;
                this.$common.loadingHide(0);
                // console.log(response);
                // console.log(this.resources);
            });
        },

        getNextResources(next_page_url){
            this.$common.loadingShow(0);
            axios.get(next_page_url)
            .then(response => {
                this.resources = response.data.data;
                this.$common.loadingHide(0);
                // console.log(response);
                // console.log(this.resources);
            });
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        },

        getCategoryResources(slug){
            this.$common.loadingShow(0);
            axios.get(this.api_url+'categories/'+slug+'/resources')
            .then(response => {
                this.resources = response.data.data;
                this.$common.loadingHide(0);
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
            this.$common.loadingShow(0);
            axios.post(this.base_url+this.api_url+'polls/'+this.poll.id+'/vote', {
                'option': formData.get('poll_option')
            })
            .then(response => {
                this.$common.loadingHide(0);
                this.pollResult = true;
                this.poll = response.data.data;
                this.$common.showMessage(response.data);
                console.log(this.pollResult, response.data.data);
            })
            .catch(error => {
                this.$common.loadingHide(0);
                if (error.response.status == 500 && error.response.data.code == 500) {
                    this.$common.showMessage(error);
                }
            });
        },

    }

});

});