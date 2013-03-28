<?php
if ($dir = opendir("uploads/")) {
    while (($file = readdir($dir)) !== false) {
		echo "<ul>";
        if ($file != "." && $file != "..") {
            echo "<li><a href='uploads/$file'>$file</a> <input value='[Alt Text](uploads/$file)' onclick='this.select(0,this.value.length)' style='width: 300px;'/></li>";
        }
		echo "</ul>";
    } 
    closedir($dir);
}
?>