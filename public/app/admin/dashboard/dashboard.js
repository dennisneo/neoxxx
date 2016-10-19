var dVue = new Vue({
    el:'#dDiv',
    data:{
        applicants:[],
        students:[]
    },
    methods:{

    },
    ready:function(){
        $.get(subdir+'/ajax/admin/dashboard/latest_applicants')
        .done(function( data ){
            if(data.success){
                dVue.$data.applicants = data.applicants
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });

        $.get(subdir+'/ajax/admin/dashboard/latest_students')
        .done(function( data ){
                dVue.$data.students = data.students
        })
        .error(function( data ){

        });
    }
});
