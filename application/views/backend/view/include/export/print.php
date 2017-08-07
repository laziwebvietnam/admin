<html>

<head>
    <title><?=$data['title']?></title>
    <base href="<?=$this->_base_url?>" />
    <meta charset="utf-8" />
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/uniform/css/uniform.default.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/layouts/layout/css/layout.min.css" rel="stylesheet" type="text/css">
    <link href="<?=$this->_base_url_template_admin?>/assets/layouts/layout/css/themes/darkblue.min.css" rel="stylesheet" type="text/css" id="style_color">
    <link href="<?=$this->_base_url_template_admin?>/assets/layouts/layout/css/custom.min.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="<?=$this->_base_url_template_admin?>/admin1/favicon.ico">
</head>

<body>
    <h1><?=lang($data['title'])?></h1>
    <table class="table table-striped table-bordered table-hover order-column dataTable no-footer">
        <thead>
            <tr>
                <?
                    if($data['field'] != null){
                        foreach($data['field'] as $row){
                            ?>
                            <th><?=lang($row)?></th>
                            <?
                        }
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            
            <?
                if($data['list'] != null){
                    foreach($data['list'] as $row){          
                        echo "<tr>";
                        
                        foreach($row as $key=>$item){
                            $temp = array_find_value_by_key($data['type_field'],'name',$data['field'][$key]);
                            
                            $type = isset($temp['type'])?$temp['type']:'';
                            $html = $item;
                            if($type=='image'){
                                $html = "<img src=\"$html\" width=\"70\"/>";
                            }
                            
                            echo "<td>$html</td>";
                        }
                        
                        echo "</tr>";
                    }
                }
                
                
            ?>
            
        </tbody>
</body>


<style>
    .label {
            border: none;
            background:none;
            color:black
    }
</style>

</html>