<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class product extends Public_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_product');
        $this->load->model('M_category');
        $this->load->model('M_tags');
        $this->load->model('M_product_buy_together');
    }
    function index($alias='')
    {
        $detailCate = $this->M_category->getCategory($alias);
        if($detailCate==null){
            $this->load_message();
            return;
        }

        $data = array(
            'list'=>$this->getListData($detailCate['id']),
            'breadcrumb'=>$this->getBreadcrumb($detailCate,'category')
        );

        $this->set_seodata('category',$detailCate['id']);
        $this->load_view('product/demo/index',$data);
    }

    function getListData($idCate=null,$idTag=null,$searchText='',$whereTemp=array()){
        $where = array(
            'id_category'=>$idCate,
            'tb.'.$this->_lang.'title'=>$searchText,
            'tag'=>$idTag==null?array():array($idTag)
        );
        $where = array_merge($where,$whereTemp);
        $baseUrl = current_url();
        $limit = 99;
        $orderBy = 'tb.is_special desc, tb.is_new desc, tb.id desc';
        $total_row = $this->M_product->frontend_getList($where,0,999,$orderBy,true);

        $data = array(
            'page'=>$this->create_pageList($total_row,$baseUrl,$limit,$start),
            'data'=>$this->M_product->frontend_getList($where,$start,$limit)
        );
        return $data;
    }

    function getByCategory($alias=''){
        $this->index($alias);
    }

    function detail($alias=''){
        $detailPro = $this->M_product->getDetailByField($this->_lang.'alias',$alias,true);
        if($detailPro==null){
            $this->load_message();
            return;
        }
        $where = array(
            'tag'=>array('t.id_product'=>$detailPro['id'])
        );

        $data = array(
            'detail'=>$detailPro,
            'breadcrumb'=>$this->getBreadcrumb($detailPro,'detailProduct'),
            'tag'=>$this->M_tags->getListByType('product',$where['tag']),
            'buyTogether'=>$this->M_product_buy_together->frontend_getListByIdpro($detailPro['id'])
        );

        $this->set_seodata('product',$detailPro['id']);
        $this->load_view('product/demo/detail',$data);
    }

    function byTag($alias=''){
        $detailTag = $this->M_tags->getDetailByField($this->_lang.'alias',$alias);
        if($detailTag==null){
            $this->load_message();
            return;
        }

        $data = array(
            'list'=>$this->getListData(null,$detailTag['id']),
            'breadcrumb'=>$this->getBreadcrumb($detailTag,'onepage','tag/prod-')
        );
        $dataSeo = array(
            'title'=>lang('tagProduct').$detailTag[$this->_lang.'title'],
            'desc'=>lang('tagProduct').$detailTag[$this->_lang.'title'],
            'keyword'=>$detailTag[$this->_lang.'title']
        );
        $this->set_seodata(null,null,$dataSeo);
        $this->load_view('product/index',$data);
    }

    function search($searchString=''){
        if(isset($_GET['tu-khoa'])){
            $keyword = strip_tags($_GET['tu-khoa']);
            $keyword = urlencode($keyword);

            $dataBreadcrumb['title'] = $keyword;    
            $dataBreadcrumb['alias'] = base_url().'search/prod?tu-khoa='.$keyword;

            $data = array(
                'list'=>$this->getListData(null,null,$keyword),
                'breadcrumb'=>$this->getBreadcrumb($dataBreadcrumb,'onepage')
            );
            $dataSeo = array(
                'title'=>lang('searchProduct').$keyword,
                'desc'=>lang('searchProduct').$keyword,
                'keyword'=>$keyword
            );
            $this->set_seodata(null,null,$dataSeo);
            $this->load_view('product/demo/index',$data);
        }else{
            $this->load_message();
            return;
        }
    }
}
?>