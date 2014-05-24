<?php
/**
 * 软件管理控制器类
 * 
 * @author        zhao jinhan <326196998@qq.com>
 * @copyright     Copyright (c) 2014-2015. All rights reserved.
 */

class SoftController extends Backend
{
	protected $_catalog;
		
	public function init(){
		parent::init();
		//栏目
		$this->_catalog = Catalog::model()->findAll('status_is=:status_is AND type=:type',array(':status_is'=>'Y',':type'=>'soft'));
		
	}
	
	/**
	 * !CodeTemplates.overridecomment.nonjd!
	 * @see CController::beforeAction()
	 */
	public function beforeAction($action){
		$controller = Yii::app()->getController()->id;
		$action = $action->id;
		if(!$this->checkAcl($controller.'/'.$action)){
			$this->message('error',Yii::t('common','Access Deny'),$this->createUrl('index'),'',true);
			return false;
		}
		return true;
	}
	
    /**
     * 首页
     *
     */
	
    public function actionIndex() {    	
        $model = new Soft();
        $criteria = new CDbCriteria();
        $condition = "type = 'soft'";
        $title = trim( $this->_request->getParam( 'title' ) );      
        $catalogId = intval( $this->_request->getParam( 'catalogId' ) );
        $title && $condition .= ' AND title LIKE \'%' . $title . '%\'';        
        $catalogId && $condition .= ' AND catalog_id= ' . $catalogId;
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $criteria->with = array ( 'catalog' );
        $count = $model->count( $criteria );
        $pages = new CPagination( $count );
        $pages->pageSize = 10;
        //根据title,catelogId,titleAlias查询
        $pageParams = $this->buildCondition( $_GET, array ( 'title' , 'catalogId','titleAlias' ) );
        $pages->params = is_array( $pageParams ) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll( $criteria );    
        //推荐位
        $recom_list = RecommendPosition::model()->findAll('type=:type', array(':type'=>'soft'));
        $this->render( 'index', array ( 'datalist' => $result , 'pagebar' => $pages ,'recom_list'=>$recom_list) );
    }

    /**
     * 新增数据
     *
     */
    public function actionCreate() {
        
        $model = new Soft();       
    	if(isset($_POST['Soft']))
    	{    		
    		$model->attributes=$_POST['Soft'];  
    		$model->os = implode(',',$model->os);
    		//软件文件
    		$fileids = is_array($_POST['fileid'])?implode(',',$_POST['fileid']):'';
    		$model->fileid = $fileids;
    		if($_FILES['attach']['error'] == UPLOAD_ERR_OK){
	    		//封面图片
	    		$upload = new XUpload;	    		
	    		$upload->uploadFile($_FILES['attach']);
	    		if($upload->_error){
	    			$upload->deleteFile($upload->_file_name);	    		
	    			$this->message('error', Yii::t('admin',$upload->_error));
	    			return;
	    		}    		
	    		$model->cover_image = $upload->_file_name;	    		
    		}  
    		$model->create_time = time();
    		if($model->save())
    			$this->message('success',Yii::t('admin','Add Success'),$this->createUrl('index'));
    	}
    	//判断有无软件栏目
    	$soft_cat = Catalog::model()->find('type=:type', array(':type'=>'soft'));
    	if(!$soft_cat){
    		$this->message('error',Yii::t('admin','No Catalog'),$this->createUrl('index'));
    	}
    	
    	$this->render('update',array(
    			'model'=>$model,
    	));       
    }   

    /**
     * 更新
     *
     * @param  $id
     */
    public function actionUpdate( $id ) {
    	$model = Soft::model()->findByPk($id);  
    	$model->os = explode(',',$model->os);
    	if(isset($_POST['Soft']))
    	{
    		$model->attributes=$_POST['Soft'];  
    		$model->os = implode(',',$model->os);
    		//软件文件    		
    		$fileids = is_array($_POST['fileid'])?implode(',',$_POST['fileid']):'';
    		$model->fileid = $fileids;
    		if($_FILES['attach']['error'] == UPLOAD_ERR_OK){
	    		//封面图片
	    		$upload = new XUpload;
	    		$upload->_thumb_width = 100;
	    		$upload->_thumb_height = 100;    		
	    		$upload->uploadFile($_FILES['attach'], true);
	    		if($upload->_error){
	    			$upload->deleteFile($upload->_file_name);	    			
	    			$this->message('error', Yii::t('admin',$upload->_error));
	    			return;
	    		}    		
	    		$model->cover_image = $upload->_file_name;	    		
    		}
    		$model->update_time = time();
    		if($model->save())
    			$this->message('success',Yii::t('admin','Update Success'),$this->createUrl('index'));
    	}	
    	    	
    	$this->render('update',array(
    			'model'=>$model    			
    	));    	
        
    }
    
    /**
     * 批量操作
     *
     */
    public function actionBatch() {
        if ( $this->method() == 'GET' ) {
            $command = trim( $_GET['command'] );
            $ids = intval( $_GET['id'] );
        } elseif ( $this->method() == 'POST' ) {
            $command = trim( $_POST['command'] );
            $ids = $_POST['id'];
        } else {
            $this->message( 'errorBack', Yii::t('admin','Only POST Or GET') );
        }
        empty( $ids ) && $this->message( 'error', Yii::t('admin','No Select') );

        switch ( $command ) {
        case 'delete':      
        	//删除软件     
        	foreach((array)$ids as $id){
        		$postModel = Soft::model()->findByPk($id);
        		if($postModel){        			
        			XUpload::deleteFile($postModel->cover_image);        			       			
        			$postModel->delete();
        		}
        	}
            break;        
        case 'show':     
        	//软件显示      
        	foreach((array)$ids as $id){
        		$postModel = Soft::model()->findByPk($id);        		
        		if($postModel){
        			$postModel->status = 'Y';
        			$postModel->save();
        		}
            }
            break;
        case 'hidden':     
        	//软件隐藏      
        	foreach((array)$ids as $id){
        		$postModel = Soft::model()->findByPk($id);        		
        		if($postModel){
        			$postModel->status = 'N';
        			$postModel->save();
        		}
            }
            break;              
         default:
            throw new CHttpException(404, Yii::t('admin','Error Operation'));
            break;
        }
        $this->message('success', Yii::t('admin','Batch Operate Success'));
    }
}