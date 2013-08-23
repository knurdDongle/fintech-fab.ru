<?php

class BottomTabsWidget extends CWidget
{
	public $tabs;
	public $tabsArray;

	public function run()
	{
		$first = 0;
		if (!empty($this->tabs)) {
			foreach ($this->tabs as $t) {
				if ($first == 0) {
					$this->tabsArray[] = array('label' => $t->tab_title, 'content' => $t->tab_content, 'active' => true);
					$first = 1;
				} else {
					$this->tabsArray[] = array('label' => $t->tab_title, 'content' => $t->tab_content);
				}

			}
			$this->render('bottom_tabs');
		}
	}
}

?>
