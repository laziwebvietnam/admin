<!--div class="row">
    <div class="col-md-12"-->
        <div class="dt-buttons">
            <a class="dt-button btn dark btn-outline fullscreen" href="javascript:;">Xem full</a>
            <?
                if(isset($this->data_view['dataTable']['export']['print'])){
                    echo "<a class=\"dt-button btn dark btn-outline\" onclick=\"print(this);\"><span>In</span></a>";
                }
                
                if(isset($this->data_view['dataTable']['export']['pdf'])){
                    //echo "<a class=\"dt-button btn green btn-outline\" onclick=\"pdf(this);\"><span>Xuất file PDF</span></a>";
                }
                
                if(isset($this->data_view['dataTable']['export']['csv'])){
                    echo "<a class=\"dt-button btn purple btn-outline\" onclick=\"csv(this);\"><span>Xuất file CSV</span></a>";
                }                                   
                
            ?>
            <a class="dt-button buttons-collection buttons-colvis btn dark btn-outline"><span>Ẩn/Hiện cột</span></a>
        </div>
    <!--/div>
</div-->