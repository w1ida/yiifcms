<?php
/**
 *  专题列表
 * 
 * @author        Sim Zhao <326196998@qq.com>
 * @copyright     Copyright (c) 2015. All rights reserved.
 */

class IndexAction extends CAction
{	
	public function run(){
        $model = new Special();
        //查询条件
        $criteria = new CDbCriteria();
        $condition = '1';
        $title = Yii::app()->request->getParam( 'title' );       
        $title && $condition .= ' AND title LIKE \'%' . $title . '%\'';        
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $count = $model->count( $criteria );
        //分页
        $pages = new CPagination( $count );
        $pages->pageSize = 10;       
        $pages->applyLimit($criteria);
        //结果
        $result = $model->findAll( $criteria );
        $this->controller->render( 'index', array ( 'model' => $model, 'datalist' => $result , 'pagebar' => $pages ) );
	}
}