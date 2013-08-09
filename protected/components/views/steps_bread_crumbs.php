<ul <?php echo($this->htmlOptions['class'] ? ' class="' . $this->htmlOptions['class'] . '"' : ''); ?><?php echo($this->htmlOptions['id'] ? ' id="' . $this->htmlOptions['id'] . '"' : ''); ?> >
	<?php

	$number = 1;

	foreach ($this->crumbs as $k => $crumb) {
		echo $crumb[2] . '. ';
		if ($number < $this->curStep) {
			echo '<li class="done">' . CHtml::link($crumb[0], $crumb[1]) . '</li>';
		} elseif ($number == $this->curStep) {
			echo '<li class="active">' . CHtml::link($crumb[0], $crumb[1]) . '</li>';
		} else {
			echo '<li><a href="">' . $crumb[0] . '</a></li>';
		}

		if (sizeof($this->crumbs) > ($number)) {
			echo '<span class="divider">' . $this->divider . '</span>';
		}

		$number++;
	}
	?>
</ul>
