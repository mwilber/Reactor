<h2>Add Item</h2>
<?=form_open_multipart($this->uri->segment(1).'/add/'.$format)?>
<fieldset>
	<ul>
		<?php foreach( $fields as $name=>$props ): ?>
		<li>
			<label><?=$props['label']?></label>
			<? if( isset($lookups[$name]) ): ?>
			<select name="<?=$name?>">
				<option value="0"></option>
				<?php foreach( $lookups[$name] as $lookup ): $lookup = array_values($lookup);?>
				<option value="<?=$lookup[0]?>"><?=$lookup[1]?></option>
				<?php endforeach; ?>
			</select>
			<?else:?>
			<?=form_input($name, set_value($name))?>
			<?=form_error($name)?>
			<?endif;?>
		</li>
		<?php endforeach; ?>
		<li>
			<input type="submit" value="Save" name="" class="button">
		</li>
	</ul>
</fieldset>
<?=form_close()?>