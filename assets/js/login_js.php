<script>
    $(function(){

        $('#username').focus();
        $('#username,#pass').keypress(function(evt){
            if (evt.keyCode == 13)
                login();
        });
        $('#login').click(function(){
            login();
        });
        $(':input').keyup(function(e) {
            if(e.keyCode == 13){
                var tabindex = parseInt($(this).attr('tabindex')) + 1;
                $('[tabindex=' + tabindex + ']').focus();
            }
        });
        function login(){
            var username_val = $('#username').val();
            var password_val = $('#pass').val();
            toggleAlert(0);
            $.get("<?=base_url()?>login/check_username_control",
                {
                    username: username_val,
                    password: password_val
                },
                function(data) {
                    if (data == "error")
                        toggleAlert(1);
                    else {
                        toggleAlert(2);
                        window.location.replace('dashboard');
                    }
                },'JSON');
        }
        function toggleAlert(status){
            switch(status){
                case 0:
                    //prepare
                    $('#erroralert').hide();
                    $('#connectingalert').hide();
                    break;
                case 1:
                    //invalid
                    $('#erroralert').show();
                    $('#connectingalert').hide();
                    break;
                case 2:
                    //successful
                    $('#erroralert').hide();
                    $('#connectingalert').show();
                    break;
            }
        }
    });
</script>