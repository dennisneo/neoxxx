
var tVue  =  new Vue({
    el:'#tDiv',
    data:{
        classes: [],
        notifications: [],
        wh:[] // work hours
    },
    methods:{
        editProfile:function()
        {
            $('#profileModal').modal();
        },
        openClassRecord:function( class_id )
        {
            location.href=subdir+'/teacher/class/'+class_id;
        },
        init(){
            let vm  = this;
            $.get( subdir+'/ajax/teacher/init' , { tid: $('#tid').val() } )
            .done(function( data ){
                if(data.success){
                    tVue.$data.classes = data.classes;
                    tVue.$data.wh = data.wh;
                    vm.notifications = data.notifications;
                }else{
                    toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        openRequest(){
           $('#requestModal').modal();
        }
    },
    ready:function()
    {
        this.init();
    }
});

