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

        formData: null,
        submitDisable: false,
        errors:[]
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

        signup(form_id,signup){
            this.formData = $('#'+form_id).serialize();
            // let formID = document.querySelector('#'+form_id);
            // let formData = new FormData(formID);
            // console.log(this.formData, form_id, formData);
            if(signup){
                this.$common.loadingShow(0);
                this.submitDisable = true;
                this.formData += '&signup=home_signup';
            }

            axios.post(this.api_url+'users',this.formData).then(response => {
                this.$common.loadingHide(0);
                this.errors = [];
                this.submitDisable = false;
                if(response.data){
                    this.$common.showMessage(response.data);
                    setTimeout(function(){window.location.href = '/ingreser';},500)
                }
            }).catch(error => {
                this.$common.loadingHide(0);
                this.errors = [];
                this.submitDisable = true;
                if(error.response.status == 500 && error.response.data.code == 500){
                    var error = error.response.data;
                    this.$common.showMessage(error);
                }else if(error.response.status == 422){
                    this.errors = error.response.data.errors;
                }
            });
        },

        login(form_id,login){
            this.formData = $('#'+form_id).serialize();
            if(login){
                this.$common.loadingShow(0);
                this.submitDisable = true;
                this.formData += '&login=login';
            }

            axios.post('/login',this.formData).then(response => {
                this.$common.loadingHide(0);
                this.errors = [];
                this.submitDisable = false;
                if(response.data){
                    this.$common.showMessage(response.data);
                    setTimeout(function(){window.location.href = '/';},1000)
                }
            }).catch(error => {
                this.$common.loadingHide(0);
                this.errors = [];
                this.submitDisable = true;
                if(error.response.status == 500 && error.response.data.code == 500){
                    var error = error.response.data;
                    this.$common.showMessage(error);
                }else if(error.response.status == 422){
                    this.errors = error.response.data.errors;
                }
            });
        },





    }

});