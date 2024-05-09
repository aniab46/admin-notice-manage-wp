(function($){

    $(document).ready(function(){
        $(".custom-notice .notice-dismiss").on('click',function(){
            $.post(admin_ajax.admin_url,{
                action: 'dissable',
                _ajax_nonce: admin_ajax.nonce,
            },
            function(response){
                console.log(response);
            })
        })
    })
})(jQuery)
    
