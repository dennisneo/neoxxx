var pVue = new Vue({
    el:'#pDiv',
    data:{
        me: {  },
        saving:false,
        changing_pass:false,
        spinner: '<i class="fa fa-spin fa-refresh"></i>'
    },
    methods:{
        init(){
            let vm = this;
            $.get( subdir+'/ajax/admin/profile' )
            .done(function( data ){
                if( data.success){
                    vm.me = data.me;
                }else{
                    toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        openEditModal(){
            $('#profileModal').modal();
        },
        saveProfile(){
            let vm = this;
            vm.saving = true;
            $.post( subdir+'/ajax/admin/profile' , $('#pForm').serialize() )
            .done(function( data ){
                if( data.success){
                    vm.me = data.me;
                    toastr.success( 'Profile successfully updated' );
                    $('#profileModal').modal( 'toggle' );
                }else{
                    toastr.error( data.message );
                }
                    vm.saving = false;
            }).error(function( data ){
                toastr.error('Something went wrong');
                vm.saving = false;
            });
        },
        changePassword( ){
            let vm = this;
            vm.changing_pass = true;
            $.post( subdir+'/ajax/admin/profile/changepass' , $('#cForm').serialize() )
            .done( function( data ){
                if( data.success){
                    toastr.success( 'Password successfully updated' );
                    $('.pass').val('');
                }else{
                    toastr.error( data.message );
                }
                vm.changing_pass = false;
            }).error(function( data ){
                toastr.error('Something went wrong');
                vm.changing_pass = false;
            });
        }
    },
    ready:function(){
        this.init();
    }
});

$(document).ready(function(){

    $('.btn').prop('disabled',  false );

    $( '#fileupload' ).fileupload({
        dataType: 'json',
        progress: function (e, data) {
            var progress = parseInt( data.loaded / data.total * 100, 10);
            $('.bar').css('width', progress + '%');
        },
        done: function (e, data) {
            $('.bar').css('width', '0%');
            if( data.result.success){
                pVue.$data.me = data.result.profile;
                $('.profile_img').attr( 'src' , data.result.profile.profile_photo_url );
                toastr.success('Profile photo successfully uploaded');
            }else{
                toastr.error( data.result.message )
            }
        },
        error: function(){
            $('.bar').css('width', '0%');
            toastr.error('Something went wrong!')
        }
    });
});