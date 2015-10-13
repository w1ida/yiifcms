<div id="contentHeader">
    <h3><?php echo Yii::t('admin', 'Article Manage'); ?></h3>
    <div class="searchArea">
        <ul class="action left">
            <li><a href="<?php echo $this->createUrl('create') ?>" class="actionBtn"><span><?php echo Yii::t('admin', 'add'); ?></span></a></li>
        </ul>
        <div class="search right">
            <?php $this->beginWidget('CActiveForm', array('id' => 'searchForm', 'method' => 'get', 'action' => array('index'), 'htmlOptions' => array('name' => 'xform', 'class' => 'right '))); ?>
            <select name="catalogId" id="catalogId">
                <option value="">=<?php echo Yii::t('admin', 'All Content'); ?>=</option>
                <?php foreach ((array) Catalog::get(0, $this->_catalog) as $catalog): ?>
                    <option value="<?php echo $catalog['id'] ?>"><?php echo $catalog['str_repeat'] ?><?php echo $catalog['catalog_name'] ?></option>
                <?php endforeach; ?>
            </select>
            <?php echo Yii::t('admin', 'Title'); ?>
            <input type="text" name="title" value="<?php echo Yii::app()->request->getParam('title') ?>" class="txt" size="15"/>  
            <input name="searchsubmit" type="submit"  value="<?php echo Yii::t('admin', 'Query'); ?>" class="button "/>
            <input name="searchsubmit" type="reset"  value="<?php echo Yii::t('admin', 'Reset'); ?>" class="button "/>     
            <?php $this->endWidget();?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {        
        $("#catalogId").val('<?php echo Yii::app()->request->getParam('catalogId') ?>');
    });
</script>
<?php $form = $this->beginWidget('CActiveForm', array('action' => $this->createUrl('batch'))); ?>
    <table border="0" cellpadding="0" cellspacing="0" class="content_list"> 
        <thead>
            <tr class="tb_header">
                <th width="10%"><?php echo $form->label($model, 'id'); ?></th>
                <th><?php echo $form->label($model, 'title'); ?></th>
                <th width="12%"><?php echo $form->label($model, 'catalog_id'); ?></th>
                <th width="8%"><?php echo $form->label($model, 'status'); ?></th>
                <th width="8%"><?php echo $form->label($model, 'commend'); ?></th>
                <th width="8%"><?php echo $form->label($model, 'top_line'); ?></th>
                <th width="8%"><?php echo $form->label($model, 'view_count'); ?></th>
                <th width="15%"><?php echo $form->label($model, 'create_time'); ?></th>
                <th><?php echo Yii::t('admin', 'Operate'); ?></th>
            </tr>
        </thead>
        <?php foreach ($datalist as $row): ?>
            <tr class="tb_list" <?php if ($row->status == 'N'): ?>style=" background:#F0F7FC"<?php endif ?>>
                <td ><input type="checkbox" name="id[]" value="<?php echo $row->id ?>">
                    <?php echo $row->id ?></td>
                <td >
                    <a href="<?php echo $this->createUrl('/post/view', array('id' => $row['id'])); ?>" title="<?php echo $row->title; ?>" target="_blank" style="<?php echo $this->formatStyle($row->title_style); ?>"><?php echo Helper::truncate_utf8_string($row->title, 15); ?></a><br />
                </td>
                <td ><?php echo $row->catalog->catalog_name ?></td>
                <td><?php if ($row->status == 'Y') {
                    echo Yii::t('admin', 'Show');
                } else {
                    echo "<span class='red'>" . Yii::t('admin', 'Hidden') . "</span>";
                } ?></td>
                <td><?php if ($row->commend == 'Y') {
                    echo Yii::t('admin', 'Yes');
                } else {
                    echo Yii::t('admin', 'No');
                } ?></td>
                <td><?php if ($row->top_line == 'Y') {
                    echo Yii::t('admin', 'Yes');
                } else {
                    echo Yii::t('admin', 'No');
                } ?></td>
                <td><span ><?php echo $row->view_count ?></span></td>
                <td ><?php echo date('Y-m-d H:i', $row->create_time) ?></td>
                <td >
                    <a href="<?php echo $this->createUrl('update', array('id' => $row->id)) ?>"><img src="<?php echo $this->module->assetsUrl; ?>/images/update.png" align="absmiddle" /></a>&nbsp;&nbsp;
                    <a href="<?php echo $this->createUrl('batch', array('command' => 'delete', 'id' => $row->id)) ?>" class="confirmSubmit"><img src="<?php echo $this->module->assetsUrl; ?>/images/delete.png" align="absmiddle" /></a>&nbsp;&nbsp;
                    <a href="<?php echo $this->createUrl('/post/view', array('id' => $row['id'])) ?>" target="_blank"><img src="<?php echo $this->module->assetsUrl; ?>/images/view.png" align="absmiddle" /></a>
                </td>
            </tr>
            <?php endforeach; ?>
        <tr class="operate">
            <td colspan="6">
                <div class="cuspages right">
                <?php $this->widget('CLinkPager', array('pages' => $pagebar)); ?>
                </div>
                <div class="fixsel">
                    <input type="checkbox" name="chkall" id="chkall" onClick="checkAll(this.form, 'id')" />
                    <label for="chkall"><?php echo Yii::t('admin', 'Check All'); ?></label>
                    <select name="command">
                        <option><?php echo Yii::t('admin', 'Select Operate'); ?></option>
                        <option value="delete"><?php echo Yii::t('admin', 'Delete'); ?></option>
                        <option value="show"><?php echo Yii::t('admin', 'Show'); ?></option>
                        <option value="hidden"><?php echo Yii::t('admin', 'Hidden'); ?></option>
                        <option value="stick"><?php echo Yii::t('common', 'Stick'); ?></option>
                        <option value="cancelStick"><?php echo Yii::t('common', 'Cancel Stick'); ?></option>
                        <option value="commend" id="recom"><?php echo Yii::t('admin', 'Recommend'); ?></option>            
                    </select>
                    <input id="submit_maskall" class="button confirmSubmit" type="submit" value="<?php echo Yii::t('common', 'Submit'); ?>" name="maskall" />
                </div></td>
        </tr>        
    </table>
<?php $this->endWidget();
