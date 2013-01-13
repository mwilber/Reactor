<h2>Add Item</h2>
<?=form_open($this->uri->segment(1).'/add/'.$format)?>
<fieldset>
	<ul>
		<li>
			<label>Email <span>(Required)</span></label>
			<?=form_input('userEmail', set_value('userEmail'))?>
			<?=form_error('userEmail')?>
		</li>
		<li>
			<input type="submit" value="Save" name="" class="button">
		</li>
	</ul>
	<ul>
		<li>
			<label>Password</label>
			<?=form_input('userPassword', set_value('userPassword'))?>
			<?=form_error('userPassword')?>
		</li>
		
	</ul>
</fieldset>
<?=form_close()?>