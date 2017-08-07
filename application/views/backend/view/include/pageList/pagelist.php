<div class="row">
    <div class="col-md-5 col-sm-5">
        <div class="dataTables_info">Hiển thị dữ liệu từ dòng <?=$data['list']['start']?> đến <?=$data['list']['limit']?></div>
    </div>
    <div class="col-md-7 col-sm-7">
        <?
            if(isset($data['list']['pageList'])){
                echo $data['list']['pageList'];
            }
        ?>
    </div>
</div>