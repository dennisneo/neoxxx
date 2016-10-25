var peVue = new Vue({
    el:'#peDiv',
    data:{
        question:{},
        session:{},
        choices:[],
        results:[]
    },
    methods:{
        openPEModal:function()
        {
            $('#questionaireModal').modal();
            $.get( subdir+'/ajax/student/pe/gpeq', { student_id:$('#student_id').val() })
            .done(function( data ){
                if(data.success){
                   peVue.$data.question = data.question;
                   peVue.$data.choices = data.question.choices;
                   peVue.$data.session = data.session;
                }else{
                   toastr.error( data.message );
                }
            })
            .error(function( data ){

            });
        },

        submit:function(){
            $('.btn').prop('disabled', true );
            $('#sbtn').html('<i class="fa fa-spin fa-refresh"></i>');
            $.post( subdir+'/ajax/student/pe/sa' , $('#peForm').serialize() )
            .done(function( data ){
                if( data.success ){
                    if( data.is_done ){
                        $('.v').addClass( 'hide' );
                        $('.btnDiv').addClass( 'hide' );
                        $('#resultDiv').removeClass( 'hide' );
                        $('#nButton').removeClass( 'hide' );
                        peVue.$data.results = data.results;
                    }else{
                        peVue.$data.question = data.question;
                        peVue.$data.choices = data.question.choices;
                        peVue.$data.session = data.session;
                    }
                    $('.btn').prop('disabled', false );
                    $('#sbtn').html('Submit');

                }else{
                    toastr.error( data.message );
                    $('.btn').prop('disabled', false );
                    $('#sbtn').html('Submit');
                }
            }).error(function( data ){
                toastr.error( 'Something went wrong' );
            });
        },

        bookClass:function(){
            $('#questionaireModal').modal( 'toggle' );
            $('#bookClassModal').modal();
        },

        convertToPercent:function( rating ){
            v = parseFloat( rating * 100 ).toFixed( 0 );
            return v+'%';
        }

    },
    computed:{
        total_correct:function(){
            d = this.results;
            var total = 0;

            for( i  = 0 ; i < d.length; i++ ){
                r = d[i];
                total += r.correct;
            }

            return total;
        },
        total_wrong:function(){
           d = this.results;
           var total = 0;
           for( i  = 0 ; i < d.length; i++ ){
                r = d[i];
                total +=  r.wrong;
            }

            return total;
        },
        total_items:function() {
            d = this.results;
            var total = 0;
            for( i  = 0 ; i < d.length; i++ ){
                r = d[i];
                total += ( r.correct + r.wrong );
            }
            return total;
        },
        total_rating:function(){
            d = this.results;
            var total = 0;
            var correct = 0;
            for( i  = 0 ; i < d.length; i++ ){
                r = d[i];
                total += ( r.correct + r.wrong );
                correct += r.correct;
            }

            if( total == 0 ){
                return '  ';
            }

            rating = correct / total ;
            v = parseFloat( rating * 100 ).toFixed( 0 );
            return v+'%';
        }
    },
    ready:function(){

    }
})