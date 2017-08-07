<?php
$data = $this->_template['seo_data'];
$data['url']= 'http://'.$_SERVER["HTTP_HOST"].$_SERVER['REQUEST_URI'];
$data['url']=$data['url'];
$robots = isset($this->_template['seo_data']['noindex'])?'noindex,nofollow':'index,follow';
?>
<meta http-equiv="Content-Language" content="en"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title><?=$data['title_seo']?></title>
<link rel="canonical" href="<?=$data['url'];?>" />
<link rel="shortcut icon" type="image/png" href="<?=valueByKey($this->_template['config_website'],'logo_icon');?>"/>
<meta property="og:url" content="<?=$data['url'];?>" />
<meta property="og:title" content="<?=$data['title_seo_facebook']; ?>" />
<meta property="og:description" content="<?=$data['desc_seo_facebook']; ?>" />
<meta property="og:type" content="website" />
<meta property="og:site_name" content="<?=$data['site_name']?>" />
<meta property="og:image" content="<?=$data['image'];?>" />
<meta property="og:image:width" content="470" />
<meta property="og:image:height" content="246" />
<meta name="keywords" content="<?=$data['keyword_seo']?>"/>
<meta name="description" content="<?=$data['desc_seo']?>"/>
<meta name="author" content="<?=$data['author']?>"/>
<meta name="robots" content="<?=$robots?>"/>



<?=valueByKey($this->_template['config_website'],'code_ga')?>
<?=valueByKey($this->_template['config_website'],'code_chatonline')?>