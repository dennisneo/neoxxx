var ftVuew = new Vue({
    el:'#ftDiv',
    data:{
        teachers: [],
        teacher:{}
    },
    methods:{
        search:function(){

            $.get( subdir+'/ajax/student/teacher/search' , { q:$('#q').val() })
            .done(function( data ){
                if(data.success){
                   ftVuew.$data.teachers = data.teachers
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });

        },
        openAvailability:function( tid ){
            $('#availabilityModal').modal();
            $.get( subdir+'/ajax/student/teacher/sessions' , { tid:tid })
            .done(function( data ){

            })
            .error(function( data ){

            });
        },
        openProfile:function( tid ){

            var d = ftVuew.$data;
            var dt;

            for( var i = 0 ; i < d.teachers.length ; i++ ){
                dt = d.teachers[i]
                if( dt.cid == tid  ){
                    d.teacher = dt
                }
            }
            $('#profileModal').modal()
        },
        bookTeacher:function( tid ) {
            $('#profileModal').modal('toggle');
            $('#bookClassModal').modal();
            bcVue.$data.teacher = this.teacher
        },
        r:function( n ){
            return parseInt( Math.round(n) );
        }
    },
    ready:function(){
        $.get( subdir+'/ajax/teachers/getall' )
        .done(function( data ){
            d  = ftVuew.$data.teachers;
            if(data.success){
                ftVuew.$data.teachers = data.teachers
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});
