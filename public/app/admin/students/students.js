
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
        openPlacementModal:function( sid )
        {
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
        openStudentView:function( sid )
        {
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
        saveNote:function()
        {
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