<?php

class PaavPager extends CBasePager
{
    public $cssFile;

    public function init()
    {
        if ($this->cssFile === null) {
            $file = dirname(__FILE__) . '/assets/' . 'main.css';
            $this->cssFile = Yii::app()->getAssetManager()->publish($file);
        }
    }

    public function run()
    {
        Yii::app()->getClientScript()->registerCssFile($this->cssFile);

        $pages = $this->pages;

        $offset = $pages->offset;
        $itemCount = $pages->ItemCount;

        $toItem = $pages->currentPage != $pages->pageCount - 1
                ? $offset + $pages->limit
                : $itemCount;

        $items = (object) array(
            'fromItem' => $offset +1,
            'toItem' => $toItem,
            'itemCount' => $itemCount,
        );

        $pageCount = $this->getPageCount(); 
        $currentPage = $this->getCurrentPage();

		if(($prevPage = $currentPage - 1) < 0)
			$prevPage = 0;

		if(($nextPage = $currentPage + 1) >= $pageCount - 1)
			$nextPage = $pageCount - 1;

        $urls = (object) array(
            'prevPage' => $this->createPageUrl($prevPage),
            'nextPage' => $this->createPageUrl($nextPage),
        );

        $this->render('pager', array(
            'items' => $items,
            'urls' => $urls,
        ));
    }

}
