<?php 
class Utils {
    
    public function searchHtml($filename){
        return file_get_contents('./templates/'. $filename . '.html');
    }
    
    public function searchInc($filename){
        return file_get_contents('./templates/inc/_'. $filename . '.html');
    }
    
}