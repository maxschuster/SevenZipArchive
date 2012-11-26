# SevenZipArchive

## License
Apache License, Version 2.0

## REQUIREMENTS
* PHP >= 5.3
* 7-Zip commandline tool (version > 9.25 alpha suggested)

## Tested on
* Windows 7

# Example
```php
$zip = new \eu\maxschuster\sevenzip\SevenZipArchive('7z');
$zip->open('test/create.7z', 'passwd');
$zip->addFileFromString('fromStr.txt', 'Some text #&;`|*?~<>^()[]{}$\, \\x0A and \\xFF. \'');
var_dump($zip->listArchive());
```