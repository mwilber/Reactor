<h2>Builder</h2>
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
<?=form_open('admin/builder')?>
<fieldset>
	<ul>
		<li>
			<label>Select a Model</label>
			<?=form_dropdown('model', $loneModels);?>
		</li>
		<li>
			<?=form_submit('submit', 'Generate Scaffold');?>
		</li>
	</ul>
</fieldset>    
<?=form_close()?>