
var sVue = new Vue({
    el:'#sDiv',
    data:{
        teachers:[],
        selected_teacher:{}
    },
    methods:{
        teacherSelected:function( e ){

            var tid =  $(e.target).attr( 'data-val');
            $(e.target).html( '<i class="fa fa-refresh fa-spin"></i>');

            $.post( subdir+'/ajax/student/ts' , { cid: $('#cid').val() , tid:tid ,_token:$('#_token').val() })
            .done(function( data ){
                if( data.success ){
                    sVue.$data.selected_teacher = data.teacher;
                    $('#teacher_id').val( data.teacher.id );
                    $('#teachersListDiv').addClass( 'hide' );
                    $('#teachers_name').ss( 'hide' );
                    toastr.success( 'Teacher selected' );
                }else{
                   toastr.error( data.message );
                }

                $('.btn-select').html('Select')
            })
            .error(function( data ){

            });
        },
        saveSession:function(){

            $('.btn').prop('disabled', true );
            $('.save').html('<i class="fa fa-refresh fa-spin"></i>' );

            if(  $('#teacher_id').val() == 0 ||  $('#teacher_id').val() == '' ){

                $('.btn').prop('disabled', false );
                $('.save').html( '<i class="fa fa-check"></i> Confirm' );
                toastr.error( 'You need to select a teacher before you can procceed' );
                return;

            }

            $.post(  subdir+'/ajax/student/sas' , $('#sForm').serialize() )
            .done(function( data ){
                   if(data.success){
                       url = subdir+'/student/sdetails?cid='+data.cid;
                       window.location.href  = url;
                   }else{
                       $('.btn').prop('disabled', false );
                       $('.save').html( '<i class="fa fa-check"></i> Confirm' );
                      toastr.error( data.message );
                   }
            })
            .error(function( data ){
                    $('.btn').prop('disabled', false );
                    $('.save').html( '<i class="fa fa-check"></i> Confirm' );
                    toastr.error( 'Something went wrong' );
            });
        },
        cancelSession:function()
        {
            if( confirm( 'Are you sure you want to cancel this class session?') ){
                $.post( subdir+'/ajax/student/scancel' , $('#sForm').serialize() )
                .done(function( data ){
                    if(data.success){
                       toastr.success( 'Class session successfully canceled' );
                        url = subdir+'/student/dashboard';
                    }else{
                       toastr.error( data.message );
                    }
                })
                .error(function( data ){

                });
            }
        }
    },
    ready:function(){

        if( $('#teacher_id').val() > 0  ){
            return;
        }

        // load available teachers
        $.get( subdir+'/ajax/student/at' , { cid: $('#cid').val() } )
        .done(function( data ){
            if( data.success ){
                if(data.success){
                    sVue.$data.teachers = data.teachers
                }else{
                   toastr.error( data.message );
                }
                $('.loading').addClass('hide')
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});


var ssVue = new Vue({
    el:'#ssDiv',
    data:{
        sessions:[],
        feedback:{}
    },
    methods:{
        evaluateTeacherModal:function( class_id , detail )
        {
            $('#class_id').val( class_id );
            $('#detail').html( detail );
            $.get( subdir+'/ajax/student/gf', { class_id: class_id })
            .done(function( data ){
                if(data.success){
                    if( data.feedback ){

                        ssVue.$data.feedback = data.feedback;

                        ssVue.highlighStar( data.feedback.satisfaction , 'st' );
                        ssVue.highlighStar( data.feedback.internet_quality , 'iq' );
                        ssVue.highlighStar( data.feedback.pronunciation , 'p' );
                        ssVue.highlighStar( data.feedback.teaching_skills , 'ts' );

                    }else{
                        ssVue.$data.feedback = {};
                    }
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
            $( '#evaluationModal' ).modal();
        },

        highlighStar:function( n , id ){
            $('#'+id).val( n );

            for( i = 1;i<= 5 ; i++ ){
                d = id+''+i;
                if( i <= n){
                    $('#'+d).removeClass( 'fa-star-o');
                    $('#'+d).addClass( 'fa-star');
                }else{
                    $('#'+d).addClass( 'fa-star-o');
                    $('#'+d).removeClass( 'fa-star');
                }
            }
        },

        checkStar:function( n , id )
        {
            if( this.feedback.feedback_id ){
                return;
            }

            this.highlighStar( n , id );
        },

        submitFeedback:function()
        {
            $.post( subdir+'/ajax/student/sf' , $('#ratingForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success('');
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                    toastr.error( 'Something went wrong' );
            });
        }
    },
    ready:function(){
        $.get( subdir+'/ajax/student/gss' , {sid:$('#student_id').val()} )
        .done(function( data ){

            if(data.success){
                if( data.sessions.length ){
                    ssVue.$data.sessions = data.sessions
                }else{
                    $('.loading').html( 'No entry found')
                }


            }else{

            }
        })
        .error(function( data ){

        });
    }
});

