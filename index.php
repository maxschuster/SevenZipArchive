<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            error_reporting(E_ALL);
        
            //require_once 'eu/maxschuster/sevenzip/inc.sevenzip.php';
            require_once 'SevenZipArchive.phar';
            
            @unlink('test/create.7z');
            
            $zip = new \eu\maxschuster\sevenzip\SevenZipArchive('7z');  
            //$zip->open('test/empty_and_broken.7z');
            //$zip->open('test/working.7z');
            $zip->open('test/create.7z', 'passwd');
            
            $zip->addFile('test/test.txt');
            $zip->addFile('test/test.txt', 'test.txt');
            $zip->addFileFromString('fromStr.txt', 'Funzt :-D  #&;`|*?~<>^()[]{}$\, \\x0A and \\xFF. \'');
            $zip->addFileFromString('fromStr2.txt', 'Funzt :-D  #&;`|*?~<>^()[]{}$\, \\x0A and \\xFF. \'');
            $zip->addFileFromString('torename.txt', 'Funzt :-D  #&;`|*?~<>^()[]{}$\, \\x0A and \\xFF. \'');
            $zip->renameName('torename.txt', 'renamed.txt');
            var_dump($zip->getFromName('test/test.txt'));
            
            var_dump($zip->listArchive());
            
            $zip->extractTo('test/output', array('fromStr.txt', 'test/test.txt'));
        ?>
    </body>
</html>
