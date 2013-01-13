<div id="addedit" class="dialog">
</div>

<a href="<?=base_url()?><?=$this->uri->segment(1);?>/add" class="button" style="float:left; margin-right:5px;">Add Item</a>
<a href="<?=base_url()?><?=$this->uri->segment(1);?>/csv" class="button" style="float:left; margin-right:5px;">Export CSV</a>

<?if($this->session->flashdata('flashError')):?>
<div class='flashError'>
	Error! <?=$this->session->flashdata('flashError')?>
</div>
<?endif?>

<?if($this->session->flashdata('flashConfirm')):?>
<div class='flashConfirm'>
	Success! <?=$this->session->flashdata('flashConfirm')?>
</div>
<?endif?>

<strong  style="float:left; clear:both;">Total Records: <?=$total_rows?></strong>

<table border="1" cellpadding="4" style="float:left; clear:both;">
	<tr>
		<th width="100"></th>
		<?php foreach( $fields as $field ): ?>
		<th width="100"><?=$field['label']?></th>
		<?php endforeach; ?>
		<th width="100"></th>
		<th width="100"></th>
	</tr>
	<?if(isset($records) && is_array($records) && count($records)>0):?>
		<?foreach($records as $record):?>
		<tr>
			<td><?=$record->$pk?></td>
			<?php foreach( $fields as $name=>$props ): ?>
			<?php if(substr_compare($name, 'Id', -2, 2) === 0): ?>
				<td class="join" ref="<?=base_url()?><?=substr($name, 0, -2);?>/detail/<?=$record->$name?>"><a href='<?=base_url()?><?=substr($name, 0, -2);?>/edit/<?=$record->$name?>' ><?=$record->$name?></a></td>
			<?php else: ?>
				<td><?=$record->$name?></td>
			<?php endif; ?>
			<?php endforeach; ?>
			<td><a href='<?=base_url()?><?=$this->uri->segment(1);?>/edit/<?=$record->$pk?>'>Edit</a></td>
			<td><a href='<?=base_url()?><?=$this->uri->segment(1);?>/delete/<?=$record->$pk?>'>Delete</a></td>
		</tr>
		<?endforeach?>
	<?else:?>
		<tr>
			<td colspan="3">There are currently no records.</td>
		</tr>
	<?endif?>
</table>
