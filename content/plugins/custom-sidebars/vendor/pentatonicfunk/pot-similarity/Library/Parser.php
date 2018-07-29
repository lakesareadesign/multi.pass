<?php

namespace PotSimilarity\Library;

use Gettext\Translation;
use Gettext\Translations;

class Parser
{
    private $pot_file = '';

    /**
     * @var Similars|null
     */
    private $similars = null;

    private $percentage_threshold = 70;

    /**
     * Parser constructor.
     *
     * @param $pot_file
     * @param $percentage_threshold
     */
    public function __construct($pot_file, $percentage_threshold)
    {
        $this->pot_file             = $pot_file;
        $this->percentage_threshold = $percentage_threshold;
    }

    public function parse()
    {
        //import from a .po file:
        $translations = Translations::fromPoFile($this->pot_file);

        /** @var Translation[] $items */
        $items = array();
        foreach ($translations->getIterator() as $item) {
            /**@var Translation $item */
            $items[] = $item;
        }

        $this->similars = new Similars();
        $this->findSimilar($items);
    }

    /**
     *
     * @param Translation[] $items
     *
     * @return bool
     */
    public function findSimilar($items)
    {
        if (empty($items)) {
            return false;
        }

        $compare = array_shift($items);

        $similar = new Similar(
            $compare->getContext(),
            $compare->getOriginal(),
            $compare->getPlural(),
            array()
        );

        foreach ($items as $key => $item) {
            $a = trim(strtolower($similar->getOriginal()));
            $b = trim(strtolower($item->getOriginal()));
            similar_text(
                $a,
                $b,
                $percent
            );

            if ($percent >= $this->percentage_threshold) {
                $similar->similarWith[] = $item;
                unset($items[$key]);
            }
        }

        if (! empty($similar->similarWith)) {
            $this->similars[] = $similar;
        }

        $items = array_values($items);


        return $this->findSimilar($items);
    }

    public function getSimilars(): Similars
    {
        return $this->similars;
    }
}