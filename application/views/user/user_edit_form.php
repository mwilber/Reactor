<h2>Edit Item</h2>
<? $hidden = array('ID' => $record->$pk); ?>
<?=form_open($this->uri->segment(1).'/edit/'.$record->$pk, '', $hidden)?>
<fieldset>
	<ul>
		<li>
			<label>Email <span>(Required)</span></label>
			<?=form_input('userEmail', set_value('userEmail', $record->userEmail))?>
			<?=form_error('userEmail')?>
		</li>
		<li>
			<input type="submit" value="Save" name="" class="button">
		</li>
	</ul>
	<ul>
		<li>

		</li>
		
	</ul>
</fieldset>
<?=form_close()?>