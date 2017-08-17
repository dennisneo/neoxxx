
var sVue = new Vue({
    el:'#sDiv',
    data:{
        students:[],
        student:{},
        classes: [],
        notes:[],
        exams: [],
        can_retake_pe:false
    },
    methods:{
        openStudentContactInfo( student_id ){
            this.student = $.grep( this.students , function( s){
                return s.id == student_id;
            })[0];
            $('#editContactModal').modal();
        },
        openResetPasswordModal( student_id ){
            this.student = $.grep( this.students , function( s){
                return s.id == student_id;
            })[0];
            $('#resetPasswordModal').modal();
        },
        openPlacementModal:function( sid ){
            $.get(subdir+'/ajax/student/per', {sid:sid} )
            .done(function( data ){
                if(data.success){
                    if( data.exam_sessions.length ){
                        sVue.$data.exams = data.exam_sessions;
                        sVue.$data.can_retake_pe = data.can_retake;
                    }
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });

            $('#placementModal').modal();

        },
        openStudentView:function( sid ){
            $.get(subdir+'/ajax/student/gs' , { sid:sid })
            .done(function( data ){
                if(data.success){
                    sVue.$data.student = data.student;
                    sVue.$data.classes = data.classes;
                    sVue.$data.notes = data.notes;
                    sVue.$data.exams = data.exams;
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
            $('#studentViewModal').modal()
        },
        saveNote:function(){
            $('#note-btn').html( '<i class="fa fa-refresh fa-spin"></i>' );

            $.post( subdir+'/ajax/admin/sn', $('#nForm').serialize() )
            .done(function( data ){

                if(data.success){
                    toastr.success('Note successfully saved');
                    $('#note').val('')
                }else{
                   toastr.error( data.message );
                }

                $('#note-btn').html( 'Save Note' );
            }).error(function( data ){
                toastr.error( 'Something went wrong');
                $('#note-btn').html( 'Save Note' );
            });
        },
        resetPassword( e ){
            let vm = this;

            let btn = $(e.target);
            let h   = btn.html();

            $('.btn').prop('disabled', true );
            btn.html( '<i class="fa fa-spin fa-refresh"></i>' );

            $.post( subdir+'/ajax/admin/rsp'  , { _token:$('input[name=_token]').val() , sid : this.student.id } )
            .done(function( data ){
                if( data.success){
                    $('#rdiv').html( '<h4> New Password : '+data.password+' </h4>');
                    toastr.success( 'Password reset successful' );
                }else{
                    toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
                btn.html( h );
            })
            .error(function( data ){
                toastr.error('Something went wrong');
                $('.btn').prop('disabled', false );
                btn.html( h );
            });
        },
        saveContactForm(){
            let vm  = this;
            $('.btn').prop('disabled', true );
            $('#spButton').html('<i class="fa fa-spin fa-refresh"></i>');

            $.post(subdir+'/ajax/student/sp' , $('#contactForm').serialize())
            .done(function( data ){
                if(data.success){
                    toastr.success( 'Profile successfully saved' );
                    for( i=0; i < vm.students.length; i++ ){
                        d = vm.students[i];
                        if( vm.student.id == d.id ){
                            vm.students.$set( i , data.student );
                            break;
                        }
                    }
                    $( '#editContactModal' ).modal( 'toggle' );

                }else{
                    toastr.error( data.message );
                }
                $('.btn').prop('disabled', false );
                $('#spButton').html('Save');
            })
            .error(function( data ){
                toastr.error( 'Something went wrong' );
                $('.btn').prop('disabled', false );
                $('#spButton').html('Save');
            });
        }
    },
    ready:function(){
        $.get(  subdir+'/ajax/students/getall')
        .done(function( data ){
            if(data.success){
                sVue.$data.students = data.students;
            }else{
               toastr.error( data.message );
            }
        })
        .error(function( data ){

        });
    }
});

$('.li-tab').click(
    function(){
        d = $(this).attr('data-tab');

        $('.li-tab').removeClass('active');
        $('li[data-tab="'+d+'"]').addClass('active');
        $('.tab-content').addClass('hide');
        $('#'+d).removeClass('hide');

        //$('#'+d+'-tab').addClass('active');
    }
);