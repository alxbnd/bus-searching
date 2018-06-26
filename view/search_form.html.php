<H1>Choose dates and cities:</H1>
<form action="" method="post">
    <FIELDSET>
	<ul class="searchForm">
		<li>
			<input type="text" name="dateStart" class="tcal" value="" placeholder="choose start date" required>
			<input type="text" name="dateEnd" class="tcal" value="" placeholder="choose end date" required>
		</li>
		<li>
			
			<select name="cityDepart" required>
					<option selected disabled value="">from</option>
				<? foreach ($cities as $k=>$v) { ?>
					<option value="<?=$v?>"><?=$v?></option>
				<?}?>			
			</select>
			<select name="cityArrive" required>
					<option selected value="">to</option>
				<? foreach ($cities as $k=>$v) { ?>
					<option value="<?=$v?>"><?=$v?></option>
				<?}?>
			</select>
		</li>
		<li><input type="submit" value="search"></li>
	</ul>
    </FIELDSET>
</form>
<?php if ($error) {
	print_r($error);
}?>
<script type="text/javascript" src="<?=ROOT?>script/tcal_en.js"></script>
