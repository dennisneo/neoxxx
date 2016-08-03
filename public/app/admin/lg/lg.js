
var lgVue = new Vue({
    el:'#lgDiv',
    data:{
        goals:[],
        lg:{}
    },
    ready:function(){
        $( '.btn' ).prop('disabled', false);
        $.get( subdir+'/ajax/admin/lg/get' )
            .done(function( data ){
                if(data.success){
                    lgVue.$data.goals = data.goals
                }
            })
            .error(function( data ){

            });
    },
    methods:{
        resetForm:function(){
            lgVue.$set( 'lg' , {goal: '' , goal_id: 0 , summary : ''} );
            $('.lg-field').val('')
        },
        add:function(){
            this.resetForm();
            $('#lgdiv').modal()
        },
        saveGoal:function(){
            $( '.btn' ).prop('disabled', true );
            $.post( subdir+'/ajax/admin/savelg' , $('#lForm').serialize() )
            .done(function( data ){
                if(data.success){
                   lgVue.resetForm();
                   var isNew = true;
                   for( i=0; i < lgVue.$data.goals.length; i++ ){
                        d = lgVue.$data.goals[i];
                        if(d.goal_id == data.goal.goal_id ){
                            lgVue.$data.goals.$set ( i, data.goal );
                            isNew = false;
                        }
                   }

                    if( isNew ){
                        lgVue.$data.goals.push( data.goal );
                    }

                   toastr.success( ' Learning goal successsfully saved' )
                }else{
                   toastr.error( data.message );
                }

                $( '#lgdiv').modal( 'toggle' );
                $( '.btn' ).prop('disabled', false );
            })
            .error(function( data ){
                toastr.error( 'Something went wrong' );
                $( '.btn' ).prop('disabled', false );
                lgVue.resetForm();
            });
        },
        edit:function( gid ){

            $('#lgdiv').modal( 'show');

            for( i=0; i < lgVue.$data.goals.length; i++ ){
                d = lgVue.$data.goals[i];
                if(d.goal_id == gid ){
                    lgVue.$set( 'lg', d );
                    // explicit assignments.. modal values will stick once saved
                    $('#goal').val(d.goal);
                    $('#goal_id').val(d.goal_id);
                    $('#summary').val(d.summary);
                }
            }

        },

        remove:function( gid ){

            if( ! confirm( 'Are you sure you want to delete a learning goal entry ?') ){
                return ;
            }

            token = $('input[name="_token"]').val();

            $.post( subdir+'/ajax/admin/lg/d' , { gid:gid, _token: token  } )
            .done(function( data ){
                if(data.success){
                   for( i=0; i < lgVue.$data.goals.length; i++ ){
                       d = lgVue.$data.goals[i];
                       if( d.goal_id == gid ){
                           lgVue.$data.goals.$remove( d )
                       }
                   }

                   toastr.success('Deletion successful');
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        }
    }
});