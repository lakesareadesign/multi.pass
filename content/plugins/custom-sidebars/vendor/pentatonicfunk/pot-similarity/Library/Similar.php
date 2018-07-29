<?php

namespace PotSimilarity\Library;

use Gettext\Translation;

class Similar extends Translation
{
    /**
     * @var Translation[]
     */
    public $similarWith = array();

    public function __construct(
        $context,
        $original,
        $plural,
        $similarWith
        = array()
    ) {
        parent::__construct($context, $original, $plural);
        $this->similarWith = $similarWith;
    }
}