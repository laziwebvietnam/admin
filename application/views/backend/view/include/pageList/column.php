<?
    if(isset($this->data_view['tableField'])){
    
        if($this->data_view['tableField']){
            echo "<div class=\"dt-button-collection hidden\">";
            foreach($this->data_view['tableField'] as $key=>$row){
                $key = "Field_".$row['name'];
                $title = $row['title'];
                $status = isset($row['hidden'])?'':'active';
                echo "<a class=\"dt-button buttons-columnVisibility $status\" 
                                data-field=\"$key\"><span>$title</span></a>";            
            }
            echo "</div>";
        }
    }
?>    