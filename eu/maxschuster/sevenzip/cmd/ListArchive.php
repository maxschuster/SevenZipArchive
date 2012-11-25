<?php

/*
 * Copyright 2012 Max Schuster 
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace eu\maxschuster\sevenzip\cmd;

use eu\maxschuster\sevenzip\exception\SevenZipException;
use \DateTime;
use eu\maxschuster\sevenzip\result\SevenZipFile;
use eu\maxschuster\sevenzip\result\SevenZipFolder;

/**
 * Command to list archive contents
 *
 * @author Max Schuster <dev@maxschuster.eu>
 * @copyright (c) 2012, Max Schuster
 * @package sevenziparchive
 */
class ListArchive extends PasswordProtectedCommand {

    /**
     * Gets the command
     * @return string
     */
    protected function getCommand() {
        $cmd = $this->getExecutable() . " " .
                self::CMD_LIST . " " .
                $this->getBaseArchiveFile() .
                $this->getPasswordSwitches();
        return $cmd;
    }

    /**
     * Gets the list
     * @return SevenZipItem[] Array containing SevenZipFiles and -Folders
     * @throws SevenZipException
     */
    public function getLastResult() {
        $lastOutput = $this->getLastOutput();
        if (count($lastOutput) > 0) {
            $fileRows = array_slice($lastOutput, 16, -2);
            $result = array();
            foreach ($fileRows as $row) {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', substr($row, 0, 19));
                $attr = substr($row, 20, 5);
                $size = intval(trim(substr($row, 26, 12)));
                $sizeCompressed = intval(trim(substr($row, 39, 12)));
                $name = substr($row, 53);

                if ($attr{0} == 'D') {
                    $result[] = new SevenZipFolder($date, $attr, $size, $sizeCompressed, $name);
                } else {
                    $result[] = new SevenZipFile($date, $attr, $size, $sizeCompressed, $name);
                }
            }
            return $result;
        }
        throw new SevenZipException('No parseble outout: ' . print_r($lastOutput, true));
    }

}

?>
