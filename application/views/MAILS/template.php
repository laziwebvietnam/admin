<?php
if(!isset($form) || !$form)
{
    exit('Form mail not defined!');
}
$contents['ediable']='';
if(isset($this->_config['is_mail_editor'])&&$this->_config['is_mail_editor'])
{
    $contents['ediable']='contenteditable="true"';
}
?>
<meta charset="utf8" />
<div style="border: 1px solid rgb(222,222,200);padding: 20px;background: rgb(248,248,248);border-radius: 25px 0;">
    <h1 <?=$contents['ediable']?> style="color: #FF0080;"><?=$subject?></h1><br />
    <div>
        <?
            $this->load->view('MAILS/forms/'.$form,$contents);
        ?>      
    </div>
    <br /><br />
    <div>
        <?=isset($this->_template['config']['mail_footer'])?$this->_template['config']['mail_footer']:'Thân chào!'?>
    </div>
</div>