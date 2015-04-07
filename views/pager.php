<?php
// vim: ft=htmlphp

/* @var $this PaavPager */
/* @var $items Object */
/* @var $urls Object */
?>
<div class="paavPager">
  <?php echo $items->fromItem; ?> -- <?php echo $items->toItem; ?> из <?php echo $items->itemCount; ?>
  <a href="<?php echo $urls->prevPage; ?>">prev</a>
  <a href="<?php echo $urls->nextPage; ?>">next</a>
</div>

