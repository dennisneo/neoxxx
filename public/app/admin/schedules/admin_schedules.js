
var tVue = new Vue({
    el:'#tDiv',
    data:{
        sessions:[],
        session:{},
        student:{},
        teachers_autocomplete:[],
        search_teacher_id : 0,
        students_autocomplete:[],
        search_student_id : 0,
        learning_info:[],
        total: 0,
        page_count: [1],
        current_page : 1
    },
    methods:{
        showAudioDiv:function( src )
        {
            if( src == false ){
                $('#hasNoAudio').removeClass( 'hide' );
                $('#hasAudio').addClass( 'hide' );
                $('#audio_control').attr('src' , '' );
            }else{
                $('#hasAudio').removeClass( 'hide' );
                $('#hasNoAudio').addClass( 'hide' );
                $('#audio_control').attr('src' , src );
            }
        },
        openClassRecord:function( cid ){
            $.get(subdir+'/ajax/teacher/gcr' , { cid:cid } )
            .done(function( data ){
                if(data.success){
                    tVue.$data.session = data.session;
                    $('#class_id').val( data.session.class_id );
                    $('#performance_notes').val( data.session.performance_notes );
                    $('#comments').val( data.session.comments );
                    $('#actual_duration').val( data.session.actual_duration );
                    $('#class_status').val( data.session.class_status );

                    if( data.session.audio_file ){
                        tVue.showAudioDiv( data.session.audio_file  );
                    }else{
                        $('#hasNoAudio').removeClass( 'hide' );
                        $('#hasAudio').addClass( 'hide' );
                    }
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                    toastr.error( 'Something went wrong!' );
            });
            $('#classRecordModal').modal();
        },
        saveClassRecord:function(){
            $.post( subdir+'/ajax/teacher/ucr', $('#sForm').serialize() )
            .done(function( data ){
                if(data.success){
                    r = tVue.$data.sessions;
                    for( i=0; i < r.length; i++ ){
                        d = r[i];
                        if(d.class_id == data.sessions.class_id){
                            tVue.$data.sessions.$set( i, data.sessions );
                        }
                    }
                   toastr.success( 'Class record successfully updated' );
                   $('#classRecordModal').modal( 'toggle' );
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },
        deleteAudio:function()
        {
            ccid = $('#ccid').val();

            if( ! confirm( 'Are you sure you want to delete audio file? ')){
                return;
            }
            $.post(subdir+'/ajax/teacher/daf' , { ccid:ccid , _token : $('input[name=_token]').val()})
            .done(function( data ){
                if(data.success){
                    tVue.showAudioDiv( false );
                   toastr.success('Audio file successfully deleted');
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },
        openNotificationModal:function(){
            $('#notificationModal').modal();
        },
        openStudentInfoModal:function( sid ){
            $('#studentInfoModal').modal();
            $.get( subdir+'/ajax/admin/sinfo' , { sid:sid })
            .done( function( data ){
                if(data.success){
                    tVue.$data.student = data.student;
                    tVue.$data.learning_info = data.learning_info;
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){
                toastr.error('Something went wrong');
            });
        },
        sendNotification:function()
        {

        },
        sendForm:function()
        {

        },
        search:function(){
            let vm  = this;
            if( this.search_teacher_id != 0 ){
                var t = $.grep( this.teachers_autocomplete , function( t ){
                    return t.id == vm.search_teacher_id;
                })[0];
                if( t.value != $('#teacher').val() ){
                    vm.search_teacher_id = 0;
                }
            }

            if( this.search_student_id != 0 ){
                var s = $.grep( this.students_autocomplete , function( t ){
                    return t.id == vm.search_student_id;
                })[0];
                if( t.value != $('#student').val() ){
                    vm.search_student_id = 0;
                }
            }

            this.getClasses();
        },
        goToPage:function( e )
        {
            this.$data.current_page =  $(e.target).attr('data-page');
            $('#page').val( this.$data.current_page );
            this.getClasses();
        },
        goToNext:function()
        {
            this.$data.current_page =  parseInt( this.$data.current_page ) + 1;
            $('#page').val( this.$data.current_page );
            this.getClasses();
        },
        goToPrev:function()
        {
            this.$data.current_page =  parseInt( this.$data.current_page ) - 1;
            $('#page').val( this.$data.current_page );
            this.getClasses();
        },
        getClasses:function()
        {
            this.sessions =  [];
            $('.loading').html( '<i class="fa fa-refresh fa-spin"></i>' );

            $.get( subdir+'/ajax/admin/gsched' , $('#searchForm').serialize())
                .done(function( data ){
                    if(data.success){
                        tVue.$data.sessions =  data.sessions;
                        tVue.$data.total =  data.total;
                        tVue.$data.page_count =  data.page_count;
                        $('.loading').html( 'No record found' );
                    }else{
                        toastr.error( data.message );
                    }
                }).error(function( data ){
                    toastr.error( ' Something went wrong ! ')
                });
        }

    },
    ready:function(){
        this.getClasses();
    }
});

$( document ).ready(
    function(){
        var cache = {};
        var teachers_name = [];
        let vm  = tVue;
        $( "#teacher" ).autocomplete({
            minLength: 2,
            source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                    vm.teachers_autocomplete = cache[ term ];
                    response( vm.teachers_autocomplete );
                    return;
                }

                $.getJSON( subdir+'/ajax/teacher/autocomplete', request, function( data, status, xhr ) {
                    cache[ term ] = data.teachers;
                    vm.teachers_autocomplete = cache[ term ];
                    response( vm.teachers_autocomplete  );
                });

            },
            select: function( event, ui ) {
                vm.search_teacher_id = ui.item.id;
            }
        });

        $( "#student" ).autocomplete({
            minLength: 2,
            source: function( request, response ) {
                var term = request.term;
                if ( term in cache ) {
                    vm.students_autocomplete = cache[ term ];
                    response( vm.students_autocomplete );
                    return;
                }

                $.getJSON( subdir+'/ajax/student/autocomplete', request, function( data, status, xhr ) {
                    cache[ term ] = data.students;
                    vm.students_autocomplete = cache[ term ];
                    response( vm.students_autocomplete  );
                });

            },
            select: function( event, ui ) {
                vm.search_student_id = ui.item.id;
            }
        });

        $( '#fileupload' ).fileupload({
            dataType: 'json',
            progress: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('.bar').css('width', progress + '%');
            },
            done: function (e, data) {
                $('.bar').css('width', '0%');
                if( data.result.success){
                    toastr.success('Audio file successfully uploaded');
                    tVue.showAudioDiv( data.result.session.audio_file );
                }else{
                    toastr.error( data.result.message )
                }
            }
        });

        $('#date_from').datepicker();
        $('#date_to').datepicker();
    });
