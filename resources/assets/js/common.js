/**
 * Created by Tarek on 8/16/2017.
 */

export default function (Vue) {

    Vue.component('select2', {
        props: ['value'],
        template: '<select><slot></slot></select>',
        mounted: function() {
            var vm = this;
            $(this.$el)
                .val(this.value).select2()
                .on('change', function() {
                    vm.$emit('input', this.value)
                })
        },
        watch: {
            value: function(value) {
                $(this.$el).select2('val', value)
            }
        },
        destroyed: function() {
            $(this.$el).off().select2('destroy')
        }
    });



    Vue.component('select2Multiple', {
        props: ['options', 'value'],
        template: '<select multiple><slot></slot></select>',
        mounted: function () {
            var vm = this
            $(this.$el)
            // init select2
                .select2({ data: this.options })
                .val(this.value)
                .trigger('change')
                // emit event on change.
                .on('change', function () {
                    vm.$emit('input', $(this).val())
                })
        },
        watch: {
            value: function (value) {
                if ([...value].sort().join(",") !== [...$(this.$el).val()].sort().join(","))
                    $(this.$el).val(value).trigger('change');
            },
            options: function (options) {
                // update options
                $(this.$el).select2({ data: options })
            }
        },
        destroyed: function () {
            $(this.$el).off().select2('destroy')
        }
    });

    Vue.common = {
        showMessage(data,delayTime=2000){
            new PNotify({
                title: data.title,
                text: data.message,
                shadow: true,
                addclass: 'stack_top_right',
                type: data.status,
                width: '290px',
                delay: delayTime
            });
        },

        openModal(form_id) {
            this.errors = [];

            $.magnificPopup.open({
                removalDelay: 300,
                items: {
                    src: form_id
                },
                callbacks: {
                    beforeOpen: function (e) {
                        var Animation = "mfp-zoomIn";
                        this.st.mainClass = Animation;
                    }
                },
                midClick: true
            });
        },


        loadingShow(id=0){
            if(id !=0){
                $(id).LoadingOverlay("show",{color:"rgba(0, 0, 0, 0)"});
            }else{
                $.LoadingOverlay("show",{color:"rgba(0, 0, 0, 0)"});
            }

        },


        loadingHide(id=0){
            if(id !=0){
                $(id).LoadingOverlay("hide",{color:"rgba(0, 0, 0, 0)"});
            }else{
                $.LoadingOverlay("hide",{color:"rgba(0, 0, 0, 0)"});
            }
        },


        dataTableCall(table_selector){
            $(table_selector).dataTable({
                "destroy": true,
                "paging":   true,
                "searching": true,
                "info": true,
                // "sDom": '<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
                "sDom": '<"col-sm-12 pb10"<"pull-left"l><"pull-right"f><"clearfix">>t<"col-sm-6"i><"col-sm-6 pt5"p><"clearfix">'
            });
        },


        dataTableDestroy(table_selector){
            $(table_selector).dataTable().fnDestroy();
        },


        dataTableGenerate(table_selector){
            var vueThis = this;
            if(this.dataTable){
                setTimeout(function(){vueThis.dataTableCall(table_selector);}, 1);
                this.dataTable = false;
            }else{
                this.dataTableDestroy(table_selector);
                setTimeout(function(){vueThis.dataTableCall(table_selector);}, 1);
            }
        },

        datePickerYear(){
            $('.datePickerYear').datetimepicker({
                format: 'YYYY',
                viewMode: 'years',
                minViewMode: "years",
                pickTime: false
            });
        },


        myDatePicker(){
            $('.myDatePicker').datetimepicker({
                format: 'YYYY-MM-DD',
                pickTime: false
            });
        },

    }

    Object.defineProperties(Vue.prototype, {
        $common:{
            get(){
                return Vue.common;
            }
        }
    });
}
