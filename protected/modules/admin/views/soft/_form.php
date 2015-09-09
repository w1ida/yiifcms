<?php if (CHtml::errorSummary($model)):?>
<table id="tips">
  <tr>
    <td><div class="erro_div"><span class="error_message"> <?php echo CHtml::errorSummary($model); ?> </span></div></td>
  </tr>
</table>
<?php endif?>
<script type="text/javascript" src="<?php echo $this->_static_public?>/js/jquery/jquery.ui.widget.js"></script>
<script type="text/javascript" src="<?php echo $this->_static_public?>/js/jquery/jquery.fileupload.js"></script>
<?php $form=$this->beginWidget('CActiveForm',array('id'=>'xform','htmlOptions'=>array('name'=>'xform','enctype'=>'multipart/form-data'))); ?>
<table class="form_table">
  <tr>
    <td class="tb_title" ><?php echo Yii::t('admin','Title');?>：</td>
  </tr>
  <tr >
    <td >
    	<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128, 'class'=>'validate[required]')); ?>
    </td>
  </tr>
 
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Belong Category');?>：</td>
  </tr>
  <tr >
    <td ><select name="Soft[catalog_id]" id="Soft_catalog_id">
        <?php foreach((array)Catalog::get(0, $this->_catalog) as $catalog):?>
        <option value="<?php echo $catalog['id']?>" <?php Helper::selected($catalog['id'], $model->catalog_id);?>><?php echo $catalog['str_repeat']?><?php echo $catalog['catalog_name']?></option>
        <?php endforeach;?>
      </select>
    </td>
  </tr>  
  
  <tr>
    <td class="tb_title"><?php echo Yii::t('model','SoftIcon');?>(120*120)：</td>
  </tr>
  <tr >
    <td colspan="2" >
    	<input name="soft_icon" id="soft_icon" type="hidden" value="<?php echo $model->soft_icon;?>"/>
        <input name="simple_file" id="fileupload_icon" onclick="fileUpload()" type="file" />
        <div id="icon_preview">
      	<?php if ($model->soft_icon):?>
      	<a href="<?php echo $model->soft_icon?>" target="_blank">
      		<img style="padding:5px; border:1px solid #cccccc;" src="<?php echo $model->soft_icon;?>" width="50" align="absmiddle" />
      	</a>
      	<?php endif;?>     
  	</td>
  </tr>
  
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Cover Image');?>：</td>
  </tr>
  <tr >
    <td colspan="2" >
    	<input name="cover_image" type="hidden" id="cover_image" value="<?php echo $model->cover_image;?>"/>
        <input name="simple_file" id="fileupload_cover" onclick="fileUpload()" type="file" />
        <div id="cover_preview">
      	<?php if ($model->cover_image):?>        
      	<a href="<?php echo $model->cover_image?>" target="_blank">
      		<img style="max-width:300px; max-height:300px; padding:5px; border:1px solid #cccccc;" src="<?php echo $model->cover_image;?>" align="absmiddle" />
      	</a>
      	<?php endif;?>
        </div>
  	</td>
  </tr>
  
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Soft Upload');?>：</td>
  </tr>
  <tr >
    <td colspan="2" >    	
      	<div>
            <?php $this->widget('application.widget.resumable.Resumable', array('options'=>array('upload_url'=>$this->createUrl('soft/uploadResumable'),'upload_file_name'=>'soft_file')));?>  				        
        </div>
        <!-- 显示已上传的文件-->            
        <ul class="resumable-files clear">
            <?php if($model->soft_file):?>           
            <li>
                <img src="<?php echo $model->soft_file;?>" width="100px" height="100px">
                <input type="hidden" value="<?php echo $model->soft_file;?>" name="soft_file">
                <div class="clear">
                    <a href="<?php echo $model->soft_file;?>" class="left" target="_blank">[查看]</a>
                    <a href="javascript:;" class="right" onclick="deleteFile(this)">[删除]</a>
                </div>
            </li>           
            <?php endif;?>
        </ul>
  	</td>
  </tr>
  
  <tr>
  	<td class="tb_title"><?php echo Yii::t('admin','Soft Language');?>：
    	<?php echo $form->dropDownList($model,'language',array('zh_cn'=>Yii::t('admin','zh_cn'),'zh_tw'=>Yii::t('admin','zh_tw'), 'en'=>Yii::t('admin','en'), 'i18n'=>Yii::t('admin','i18n'))); ?>
  		&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo Yii::t('admin','Soft Rank');?>：
     	<?php echo $form->dropDownList($model,'softrank',array('5'=>Yii::t('admin','5 Stars'),'4'=>Yii::t('admin','4 Stars'),'3'=>Yii::t('admin','3 Stars'),'2'=>Yii::t('admin','2 Stars'),'1'=>Yii::t('admin','1 Stars'))); ?>
    	&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo Yii::t('admin','Soft Type');?>
    	<?php echo $form->dropDownList($model,'softtype',array('domestic'=>Yii::t('admin','Domestic Soft'),'foreign'=>Yii::t('admin','Foreign Soft'))); ?>
    	&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo Yii::t('admin','Soft OS');?>
    	<?php echo $form->checkBoxList($model,'os',array('Linux'=>'Linux', 'Win2003'=>'Win2003','WinXP'=>'WinXP', 'Win7'=>'Win7', 'Win8'=>'Win8'), array('separator'=>'&nbsp;&nbsp;')); ?>
    </td>
  </tr>    
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Content');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textArea($model,'content'); ?>      
	  	<?php $this->widget('application.widget.kindeditor.KindEditor',array('id'=>'Soft_content'));?>
	  	</td>
  </tr>
  
  <tr>
		<td class="tb_title"><?php echo Yii::t('admin','Description');?>：</td>
	</tr>
	<tr>
		<td><?php echo CHtml::activeTextArea($model,'introduce',array('rows'=>5, 'cols'=>90)); ?></td>
	</tr>
  
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','Soft Link');?>：</td>
  </tr>
   <tr >
    <td  ><?php echo $form->textField($model,'softlink',array('size'=>60,'maxlength'=>128)); ?></td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','SEO Title');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'seo_title',array('size'=>50,'maxlength'=>80)); ?></td>
  </tr>
  <tr>
    <td  class="tb_title"><?php echo Yii::t('admin','SEO Keywords');?>：</td>
  </tr>
  <tr >
    <td ><?php echo $form->textField($model,'seo_keywords',array('size'=>50,'maxlength'=>80)); ?>
    	<input type="button" value="自动提取"	onclick="keywordGet('Soft_title', 'Soft_content', 'Soft_seo_keywords')" />
    </td>
  </tr>
  <tr>
    <td class="tb_title"><?php echo Yii::t('admin','SEO Description');?>：</td>
  </tr>
  <tr >
    <td ><?php echo CHtml::activeTextArea($model,'seo_description',array('rows'=>5, 'cols'=>80)); ?></td>
  </tr>  
  
  <tr >
    <td class="tb_title"><?php echo Yii::t('admin','Status');?>：</td>
  </tr>
  <tr >
    <td  ><?php echo $form->dropDownList($model,'status',array('Y'=>Yii::t('admin','Show'), 'N'=>Yii::t('admin','Hidden'))); ?></td>
  </tr>
  
  <tr class="submit">
  	<td colspan="2" >  		 	
      	<input type="submit" name="editsubmit" value="<?php echo Yii::t('common','Submit');?>" class="button" tabindex="3" />
     </td>
  </tr>
</table>
<script type="text/javascript">
    //ajax上传图片
    function fileUpload() {        
        $('#fileupload_icon').fileupload({
            url: "<?php echo $this->createUrl('soft/uploadSimple');?>",
            dataType: 'json',
            done: function(e, JsonData) {                
                var data = JsonData.result;
                if (200 === data.code) {                    
                    var atta_file = '';
                    if(data.data.file_path) {
                        $('#soft_icon').val(data.data.file_path);
                        atta_file = '<a href="'+data.data.file_path+'" target="_blank"><img  style="max-width:300px; max-height:300px; padding: 5px; border: 1px solid #cccccc;"  src="'+data.data.file_path+'"  align="absmiddle" /></a>';
                    }                    
                    $('#icon_preview').html(atta_file);                    
                }else{
                    alert(data.message);
                }
                return false;
            }
        });
        $('#fileupload_cover').fileupload({
            url: "<?php echo $this->createUrl('soft/uploadSimple');?>",
            dataType: 'json',
            done: function(e, JsonData) {
                console.log('aa');
                var data = JsonData.result;
                if (200 === data.code) {                    
                    var atta_file = '';
                    if(data.data.file_path) {
                        $('#cover_image').val(data.data.file_path);
                        atta_file = '<a href="'+data.data.file_path+'" target="_blank"><img  style="max-width:300px; max-height:300px; padding: 5px; border: 1px solid #cccccc;"  src="'+data.data.file_path+'"  align="absmiddle" /></a>';
                    }                    
                    $('#cover_preview').html(atta_file);                    
                }else{
                    alert(data.message);
                }
                return false;
            }
        });
    }
    $(function(){
        $("#xform").validationEngine();
    });
</script>
<?php $this->endWidget();
