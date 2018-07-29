<?php

namespace PotSimilarity\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\StreamOutput;

class AbstractCommandTest extends TestCase
{
    public static function runCommand($command)
    {
        $application = new \Symfony\Component\Console\Application();

        $fp = tmpfile();
        // ... register commands
        $application->add(new \PotSimilarity\Commands\FindSimilarity());
        try {
            // Set auto exit application to false
            $application->setAutoExit(false);
            // Command input
            $input = new StringInput($command);
            // Stream output to temporary file
            $output = new StreamOutput($fp);
            // Run command
            $application->run($input, $output);
            // Finds first byte in temporary file
            fseek($fp, 0);

            // Resets output
            $output = '';
            // Iterates through 'til end of temporary file
            while (! feof($fp)) {
                $output = fread($fp, 4096);
            }

            // Closes file stream
            fclose($fp);
        } catch (\Exception $e) {
            return '';
        }

        // Returns final output
        return $output;
    }
}