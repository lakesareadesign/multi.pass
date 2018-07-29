<?php

namespace PotSimilarity\Commands;

use PotSimilarity\Library\Parser;
use PotSimilarity\Library\Similar;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindSimilarity extends Command
{
    protected function configure()
    {
        $this
            ->setName('find:similar')
            ->setDescription('Find Similar strings on pot file ')
            // the "--help" option
            ->setHelp('Find Similar strings on pot file')
            ->addArgument(
                'pot_path',
                InputArgument::REQUIRED,
                'Path of the pot file'
            )->addArgument(
                'threshold_percentage',
                InputArgument::OPTIONAL,
                'Thresehold Percentage of similar text',
                70
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '1024M');
        $potPath             = $input->getArgument('pot_path');
        $thresholdPercentage = $input->getArgument('threshold_percentage');
        $thresholdPercentage = (float)$thresholdPercentage;
        try {
            if (! is_readable($potPath)) {
                throw new \Exception('Pot file is unreadable.');
            }

            $parser = new Parser($potPath, $thresholdPercentage);
            $parser->parse();
            $similars = $parser->getSimilars();
            if (! count($similars)) {
                $output->writeln(
                    '<info>Yeay all strings are unique.</info>'
                );

                return false;
            }

            foreach ($similars as $similar) {
                /** @var Similar $similar */
                $output->writeln(
                    '<comment>"'.$similar->getOriginal().'"</comment>'
                );
                $output->writeln(
                    '<error>Simlilar With</error>'
                );
                foreach ($similar->similarWith as $similarWith) {
                    $output->writeln(
                        "\t".'<comment>"'.$similarWith->getOriginal()
                        .'"</comment>'
                    );
                    $output->writeln(
                        "\t\t".'<question>"'.
                        self::flatten($similarWith->getReferences())
                        .'"</question>'
                    );
                }
                $output->writeln('');
            }

            $output->writeln(
                '<info>Brace your self you can reduce '
                .count($similars).' Similar Strings with '.$thresholdPercentage
                .'% threshold</info>'
            );
        } catch (\Exception $e) {
            $output->writeln('<error>'.$e->getMessage().'</error>');

            return false;
        }

        return true;
    }

    public static function flatten($array)
    {
        $string = '';
        if (is_array($array)) {
            foreach ($array as $arr) {
                $string .= ' '.self::flatten($arr);
            }
        } else {
            return $array;
        }

        return $string;
    }
}