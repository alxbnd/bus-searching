<H1>Results</H1>

<div id="result">
	<h2><?=$result['route']['depart'].' - '.$result['route']['arrive']?></h2>
	<h3>from <?=$result['period']['start']. ' to '. $result['period']['end']?></h3>
	<div id="min">
		<div class="price">
			Minimal price: <?=$result['min']['min']?> 
		</div>
		
		<ul class="dates">
			<p> Available dates with this price:</p>
			<?php
				foreach ($result['min']['date'] as $date) {
					echo '<li class="datesLi">'.$date.'</li>';
				}
			?>
		</ul>
		
		<ul class="details">
			<p>Available dates:</p>
			<?php
				foreach ($result['min']['details'] as $k=>$v) {
					echo '<li class="datesDetailsLi">'.$k.'<ul class="detailsUl">';
					echo '<li class="detailsLi">Departure<ul class="departures">';
					foreach ($v['departure'] as $departure) {
						echo '<li class="time">'.$departure.'</li>';
					}
					echo '</ul></li><li class="detailsLi">Arrive<ul class="arrives">';
					foreach ($v['arrive'] as $arrive) {
						echo '<li class="time">'.$arrive.'</li>';
					}
					echo '</ul></li><li class="links"><a href="'.$v['url'].'" target="_blank">Click to order</a></li></ul></li>';
				}
			?>
		</ul>
		<pre><? print_r($result)?></pre>
		<script type="text/javascript">
			let data = <?=json_encode($result)?>;
			console.log(data);
		</script>
	</div>
</div>
