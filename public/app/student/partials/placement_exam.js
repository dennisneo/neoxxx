var peVue = new Vue({
    el:'#peDiv',
    data:{
        learning_goals:[]
    },
    methods:{

        openLearningGoalModal:function(){

            $( '.lg_cb' ).prop( 'checked', false );

            $.get(subdir+'/ajax/student/glg', {sid:$('#student_id').val() })
            .done(function( data ){
                if(data.success){
                    if( data.lg.length ){
                        for( i = 0 ; i < data.lg.length; i++ ){
                            d = data.lg[i];
                            $('.lg_cb[value='+ d.learning_goal_id+']').prop('checked' , true);
                        }
                    }
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
            $('#learningGoalModal').modal()
        },
        saveLearningGoals:function(){
            $('.btn').prop('disabled', false );
            $('#savelg').html('<i class="fa fa-refresh fa-spin"></i>');
            $.post( subdir+'/ajax/student/slg', $('#peForm').serialize() )
            .done(function( data ){
                if(data.success){
                    toastr.success( 'Learning goals successfully saved. You may now take your placement exam ' );
                    $('#learningGoalModal').modal( 'toggle' );
                }else{
                   toastr.error( data.message );
                }

                $('.btn').prop( 'disabled', false );
                $('#savelg').html('Save');
            })
            .error(function( data ){
                toastr.error( 'Something went wrong' );
                $('#savelg').html('Save');
            });
        }
    },
    ready:function(){
        $.get( subdir+'/ajax/student/glg' , {sid:$('#student_id').val()} )
        .done(function( data ){
            if(data.success){
               peVue.$data.learning_goals = data.lg
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});
