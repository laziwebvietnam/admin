<?php 
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** 
 * @package   
 * @author laziweb@gmail.com
 * @copyright laziweb.com
 * @version 2016
 * @access public
 */
class article extends Public_controller{
    function __construct(){
        parent::__construct();
        $this->load->model('M_article');
        $this->load->model('M_category');
        $this->load->model('M_tags');
    }
    function index($alias='')
    {
        $detailCate = $this->M_category->getCategory($alias);
        if($detailCate==null){
            $this->load_message();
            return;
        }

        $data = array(
            'list'=>$this->getListData(null),
            'breadcrumb'=>$this->getBreadcrumb($detailCate,'category')
        );

        $this->set_seodata('category',$detailCate['id']);
        $this->load_view('article/demo/index',$data);
    }

    function getListData($idCate=null,$idTag=null,$searchText='',$whereTemp=array()){
        $where = array(
            'id_category'=>$idCate,
            'tb.'.$this->_lang.'title'=>$searchText,
            'tag'=>$idTag==null?array():array($idTag)
        );
        $where = array_merge($where,$whereTemp);
        $baseUrl = current_url();
        $limit = 5;
        $orderBy = 'tb.is_special desc, tb.id desc';
        $total_row = $this->M_article->frontend_getList($where,0,999,$orderBy,true);

        $data = array(
            'page'=>$this->create_pageList($total_row,$baseUrl,$limit,$start),
            'data'=>$this->M_article->frontend_getList($where,$start,$limit)
        );
        return $data;
    }

    function one($alias){
        $detailArt = $this->My_model->getArticleOneByField('tb.' . $this->_lang . 'alias', $alias, true);
        if($detailArt==null){
            $this->load_message();
            return;
        }

        $data = array(
            'detail' => $detailArt,
            'breadcrumbs' => $this->getBreadcrumb($detailArt, 'onepage')
        );
    
        $this->set_seodata('article_one', $detailArt['id']);
        $this->load_view('article/one', $data);
    }

    function getByCategory($alias=''){
        $this->index($alias);
    }

    function detail($alias=''){
        $detailArt = $this->M_article->getDetailByField('tb.'.$this->_lang.'alias',$alias,true);
        if($detailArt==null){
            $this->load_message();
            return;
        }
        $where = array(
            'tag'=>array('t.id_article'=>$detailArt['id'])
        );

        $data = array(
            'detail'=>$detailArt,
            'breadcrumb'=>$this->getBreadcrumb($detailArt,'detailArticle'),
            'tag'=>$this->M_tags->getListByType('article',$where['tag'])
        );

        $this->set_seodata('article',$detailArt['id']);
        $this->load_view('article/demo/detail',$data);
    }

    function byTag($alias=''){
        $detailTag = $this->M_tags->getDetailByField($this->_lang.'alias',$alias);
        if($detailTag==null){
            $this->load_message();
            return;
        }

        $data = array(
            'list'=>$this->getListData(null,$detailTag['id']),
            'breadcrumb'=>$this->getBreadcrumb($detailTag,'onepage','tag/arti-')
        );
        $dataSeo = array(
            'title'=>lang('tagArticle').$detailTag[$this->_lang.'title'],
            'desc'=>lang('tagArticle').$detailTag[$this->_lang.'title'],
            'keyword'=>$detailTag[$this->_lang.'title']
        );
        $this->set_seodata(null,null,$dataSeo);
        $this->load_view('article/demo/index',$data);
    }

    function search($searchString=''){
        if(isset($_GET['tu-khoa'])){
            $keyword = strip_tags($_GET['tu-khoa']);
            // $keyword = urlencode($keyword);

            $dataBreadcrumb[$this->_lang . 'title'] = $keyword;    
            $dataBreadcrumb[$this->_lang . 'alias'] = base_url().'search/arti?tu-khoa='.$keyword;

            $data = array(
                'list'=>$this->getListData(null,null,$keyword),
                'breadcrumb'=>$this->getBreadcrumb($dataBreadcrumb,'onepage')
            );
            $dataSeo = array(
                'title'=>lang('searchArticle').$keyword,
                'desc'=>lang('searchArticle').$keyword,
                'keyword'=>$keyword
            );
            $this->set_seodata(null,null,$dataSeo);
            $this->load_view('article/demo/index',$data);
        }else{
            $this->load_message();
            return;
        }
    }
}
?>