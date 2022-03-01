<ul class="<?=$ulClass?>">
    <?php foreach($menu as $menuItem):
        $path = $menuItem['path'];
        $title = $menuItem['title'];
        $id = $menuItem['id'];
        if (isCurrentUrl($path)) {
            $classTag = 'class="' . $itemClass . ' active"';
        } else {
        	$classTag = 'class="' . $itemClass . '"';
        }
    ?>
        <li><a id="<?=$id?>" <?=$classTag?> href="<?= $path?>"><?=$title?></a></li>
    <?php endforeach; ?>
</ul>
