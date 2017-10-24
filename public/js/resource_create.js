/**
 * Created by Tarek on 10/21/2017.
 */

new Vue({
    el: '#app',
    data: {
        errors:[]
    },

    methods: {
        createResource(e){
            this.$common.loadingShow(0);
            var formData = new FormData(e.target);
            axios.post(window.base_url+window.api_url+'resources', formData)
            .then(response => {
                this.$common.loadingHide(0);
                this.errors = [];
                this.$common.showMessage(response.data);
                this.resources = response.data.data;
                e.target.reset();
            }).catch(error => {
                this.$common.loadingHide(0);
                this.errors = [];
                if (error.response.status == 500 && error.response.data.code == 500) {
                    var error = error.response.data;
                    this.$common.showMessage(error);
                } else if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
});