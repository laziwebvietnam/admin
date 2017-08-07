

<?
    /** Breadcrumb */
    $this->load->view($this->_view_folder.'dashboard/include/breadcrumb');
    
    /** Quick info */
    $this->load->view($this->_view_folder.'dashboard/include/quickinfo');
?>
    
<div class="clearfix"></div>
<!-- END DASHBOARD STATS 1-->
<div class="row">
    <?
        /** Chart traffic */
        $this->load->view($this->_view_folder.'dashboard/include/chart_traffic');
        
        /** Chart order */
        $this->load->view($this->_view_folder.'dashboard/include/chart_order');
    ?>
</div>

<div class="row">
    <?
        /** History */
        $this->load->view($this->_view_folder.'dashboard/include/history');
        
        /** Contact */
        $this->load->view($this->_view_folder.'dashboard/include/contact');
    ?>
</div>


