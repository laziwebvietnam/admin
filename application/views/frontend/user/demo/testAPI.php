<script type="text/javascript" src="<?= base_url(); ?>template/frontend/lazi/jquery-1.12.2.min.js"></script>

<?php
if ($this->data['customer']) {
    echo '<pre>';
    print_r($this->data['customer']);
    exit;
} else {
    ?>
    <a href="javascript:void(0);" onclick="loginAPI('Facebook');">
        Login Facebook!
    </a>
    <br>
    <a href="javascript:void(0);" onclick="loginAPI('Google');">
        Login Google!
    </a>
    <script type="text/javascript">
        function loginAPI(api) {
            var ajax = $.post('user/login' + api);
            
            ajax.success(function (data_return) {
                data_return = $.parseJSON(data_return);

                if (data_return.is_auth) {
                    location.reload();
                } else {
                    window.location.href = data_return.link;
                }
            });
        }
    </script>
    <?php
}
?>