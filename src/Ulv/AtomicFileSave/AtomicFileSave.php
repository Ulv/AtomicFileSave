<?php
/**
 * Class to save files in php atomically
 *
 * PHP version 5.4
 *
 * @category
 * @package
 * @author    Vladimir Chmil <vladimir.chmil@gmail.com>
 * @license
 * @link
 */

namespace Ulv\AtomicFileSave;

class AtomicFileSave {
    /**
     * @param      $filename
     * @param      $content
     * @param null $tmpDir
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    public function save($filename, $content, $tmpDir = null) {
        if (!$tmpDir) {
            $tmpDir = sys_get_temp_dir();
        }

        $temp = tempnam($tmpDir, 'temp');
        if (!($f = @fopen($temp, 'wb'))) {
            $temp = $tmpDir . DIRECTORY_SEPARATOR . uniqid('temp');
            if (!($f = @fopen($temp, 'wb'))) {
                throw new \RuntimeException(__METHOD__ . ": error writing temporary file '$temp'");
            }
        }

        fwrite($f, $content);
        fclose($f);

        if (!@rename($temp, $filename)) {
            @unlink($filename);
            @rename($temp, $filename);
        }

        @chmod($filename, 0666 & ~umask());

        return $filename;
    }
}