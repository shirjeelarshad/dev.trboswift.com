
<div class="border-bottom">
<h1>File structure</h1>
<p class="lead text-dark">In this section we explain the role of each folder.</p>
</div>

<?php 
/*
function listFolderFiles($dir){
    $ffs = scandir($dir);

    unset($ffs[array_search('.', $ffs, true)]);
    unset($ffs[array_search('..', $ffs, true)]);

    // prevent empty ordered elements
    if (count($ffs) < 1)
        return;

    echo '<ol>';
    foreach($ffs as $ff){
        echo '<li>'.$ff;
        if(is_dir($dir.'/'.$ff)) listFolderFiles($dir.'/'.$ff);
        echo '</li>';
    }
    echo '</ol>';
}

listFolderFiles(get_template_directory());
 */
?>
 
 