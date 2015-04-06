<?php

class PaavPager extends CLinkPager
{
    public $infoCssClass;
    public $buttonsCssClass;
	public $previousPageCssClass='paavpager-prev';
	public $nextPageCssClass='paavpager-next';

	/**
	 * Initializes the pager by setting some default property values.
	 */
	public function init()
	{
		if($this->nextPageLabel===null)
			$this->nextPageLabel=Yii::t('yii','Next &gt;');
		if($this->prevPageLabel===null)
			$this->prevPageLabel=Yii::t('yii','&lt; Previous');
		if($this->firstPageLabel===null)
			$this->firstPageLabel=Yii::t('yii','&lt;&lt; First');
		if($this->lastPageLabel===null)
			$this->lastPageLabel=Yii::t('yii','Last &gt;&gt;');
        if($this->header===null)
            $this->header = $this->_getHeader();
		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='paavpager';
        if ($this->cssFile === null) {
            $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'pager.css';
            $this->cssFile=Yii::app()->getAssetManager()->publish($file);
        }

        $this->maxButtonCount = 0;

		if($this->infoCssClass === null)
            $this->infoCssClass = 'paavpager-info';

		if($this->buttonsCssClass === null)
            $this->buttonsCssClass = 'paavpager-buttons';
	}

	/**
	 * Executes the widget.
	 * This overrides the parent implementation by displaying the generated page buttons.
	 */
	public function run()
	{
		$this->registerClientScript();
		$buttons=$this->createPageButtons();
		if(empty($buttons))
			return;

        $headerHtml = CHtml::tag('span',
                                 array('class' => $this->infoCssClass),
                                 $this->header);
        $buttonsHtml = CHtml::tag('div',
                                  array('class' => $this->buttonsCssClass),
                                  implode("\n",$buttons));
        echo CHtml::tag('div', $this->htmlOptions, $headerHtml . $buttonsHtml);
	}

	/**
	 * Creates the page buttons.
	 * @return array a list of page buttons (in HTML code).
	 */
	protected function createPageButtons()
	{
		if(($pageCount=$this->getPageCount())<=1)
			return array();

		list($beginPage,$endPage)=$this->getPageRange();
		$currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
		$buttons=array();

		// first page
		//$buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);

		// prev page
		if(($page=$currentPage-1)<0)
			$page=0;
		$buttons[]=$this->createPageButton($this->prevPageLabel,$page,$this->previousPageCssClass,$currentPage<=0,false);

		// internal pages
		for($i=$beginPage;$i<=$endPage;++$i)
			$buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);

		// next page
		if(($page=$currentPage+1)>=$pageCount-1)
			$page=$pageCount-1;
		$buttons[]=$this->createPageButton($this->nextPageLabel,$page,$this->nextPageCssClass,$currentPage>=$pageCount-1,false);

		// last page
		//$buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);

		return $buttons;
	}

	/**
	 * Creates a page button.
	 * You may override this method to customize the page buttons.
	 * @param string $label the text label for the button
	 * @param integer $page the page number
	 * @param string $class the CSS class for the page button.
	 * @param boolean $hidden whether this page button is visible
	 * @param boolean $selected whether this page button is selected
	 * @return string the generated button
	 */
	protected function createPageButton($label,$page,$class,$hidden,$selected)
	{
		if($hidden || $selected)
			$class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        return CHtml::link($label,$this->createPageUrl($page),array('class'=>$class));
	}



    private function _getHeader()
    {
        $pages = $this->pages;
        $offset = $pages->offset;
        $itemCount = $pages->ItemCount;

        $toItem = $pages->currentPage != $pages->pageCount - 1
                ? $offset + $pages->limit
                : $itemCount;

        return $offset + 1 . ' – ' . $toItem . ' из ' . $itemCount;
    }
}
