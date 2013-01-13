<div id="editmast">
	<strong>EDIT ITEM</strong>
	<h2><?=$record->$rq?></h2>
</div>
<? $hidden = array('ID' => $record->$pk); ?>
<?=form_open($this->uri->segment(1).'/edit/'.$record->$pk, '', $hidden)?>
<fieldset>
	<ul>
		<?php foreach( $fields as $name=>$props ): ?>
		<li>
			<label><?=$props['label']?></label>
			<? if( isset($lookups[$name]) ): ?>
			<select name="<?=$name?>">
				<option value="0"></option>
				<?php foreach( $lookups[$name] as $lookup ): $lookup = array_values($lookup);?>
				<option value="<?=$lookup[0]?>" <?=($lookup[0]==$record->$name)?"selected":""?>><?=$lookup[1]?></option>
				<?php endforeach; ?>
			</select>
			<?else:?>
			<?=form_input($name, set_value($name, $record->$name))?>
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