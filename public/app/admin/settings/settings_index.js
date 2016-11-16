
var sVue = new Vue({
    el:'#sDiv',
    data:{
        credits_cost:[]
    },
    methods:{
        save:function()
        {
            $('.btn').prop('disabled', true );
            $('.save').html('<i class="fa fa-refresh fa-spin"></i>');
            $.post( subdir+'/ajax/admin/settings/s' , $('#sForm').serialize() )
            .done(function( data ){
                if(data.success){
                   toastr.success('Settings successfully saved');
                }else{
                   toastr.error( data.message );
                }
                    $('.btn').prop('disabled', false );
                    $('.save').html('Save');
            })
            .error(function( data ){
                toastr.error( 'Something went wrong' );
                $('.btn').prop('disabled', false );
                $('.save').html('Save');
            });
        },

        openCreditCost:function( e )
        {
            e.preventDefault();
            $('.fc').val('');
            $('#cost_id').val( 0 );
            $('#ccModal').modal();
        },

        saveCreditCost:function()
        {
            $('.btn').prop('disabled', true );
            $('.save').html('<i class="fa fa-refresh fa-spin"></i>');

            $.post(subdir+'/ajax/admin/credits_cost/save' , $('#ccForm').serialize())
            .done(function( data ){
                $('.btn').prop('disabled', false );
                $('.save').html('Save');

                if(data.success){
                    $('.fc').val('');
                    $('#ccModal').modal( 'toggle' );
                    n = sVue.$data.credits_cost;
                    for( i=0; i < n.length; i++ ){
                        d = n[i];
                        if( d.cost_id == data.credits_cost.cost_id ){
                            sVue.$data.credits_cost.$set(  i, data.credits_cost );
                            return;
                        }
                    }

                    sVue.$data.credits_cost.push(  data.credits_cost );

                }else{
                   toastr.error( data.message );
                }

            })
            .error(function( data ){
                toastr.error('Something went wrong');
                $('.btn').prop('disabled', false );
                $('.save').html('Save');
            });
        },

        editCreditCost:function( ccid )
        {
            $('#ccModal').modal();

            $.get( subdir+'/ajax/admin/credits_cost/get' , {ccid:ccid } )
            .done(function( data ){
                if(data.success){
                    $('#credits').val( data.cc.credits );
                    $('#cost').val( data.cc.cost );
                    $('#desc').val( data.cc.desc );
                    $('#cost_id').val( data.cc.cost_id );
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },

        deleteCreditCost:function( ccid )
        {
            if( !confirm('Are you sure you want to delete this credit/cost ? ') ){
                return;
            }

            $.post(subdir+'/ajax/admin/credits_cost/delete' , {ccid:ccid, _token:$('input[name="_token"]').val() })
                .done(function( data ){
                    if(data.success){
                        n = sVue.$data.credits_cost;
                        for( i=0; i < n.length; i++ ){
                            d = n[i];
                            if( d.cost_id == data.ccid ){
                                n.$remove( d );
                            }
                        }
                    }else{

                    }

                })
                .error(function( data ){
                    toastr.error('Something went wrong');

                });
        }
    },
    ready:function(){
        $('.btn').prop('disabled', false );
        $('.save').html('Save');
        $.get(subdir+'/ajax/admin/settings/credits_cost')
        .done(function( data ){
            if( data.success ){
                sVue.$data.credits_cost = data.credits_cost;
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){
            toastr.error('Something went wrong');
        });
    }
});

$(document).ready(function(){

});