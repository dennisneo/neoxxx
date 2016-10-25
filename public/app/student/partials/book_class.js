 var bcVue = new Vue({
     el:'#bcDiv',
     data:{
        teacher:{}
     },
     methods:{
         scheduleSession:function(){

             $('.btn').prop('disabled', true );
             $('#next').html( '<i class="fa fa-refresh fa-spin"></i>' );
             $.post( subdir+'/ajax/student/ss' , $('#sForm').serialize())
                 .done(function( data ){
                     if(data.success){
                         url = subdir+'/student/newsession?cid='+data.cid;
                         window.location.href  = url;
                         return;
                     }else{
                         if(data.error_code == 'NOT_ENOUGH_CREDIT' ){
                            $('#add_credit').removeClass('hide');
                         }else{
                             toastr.error( data.message );
                         }
                     }
                     $('.btn').prop('disabled', false );
                     $('#next').html( ' Next ' );
                 })
                 .error(function( data ){
                     $('.btn').prop('disabled', false );
                     $('#next').html( ' Next ' );
                 });
         },
         showCalendar:function()
         {
             $("#date").datepicker("show");
         }
     },
     ready:function(){
     
     }
 });

 $(document).ready(
     function(){
         var tomorrow = new Date( new Date() + 86400000);
         $( "#date" ).datepicker({
             defaultDate: tomorrow
         });
         $('#time').combodate({
             customClass: 'date-control',
             value:'08:00 am'
         });
     }
 );

