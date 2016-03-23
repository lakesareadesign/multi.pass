<?php
/* START_REGION_OUTPUT */
$pre_footer_gap = upfront_create_region(
			array (
  'name' => 'pre-footer-gap',
  'title' => 'Pre Footer Gap',
  'type' => 'wide',
  'scope' => 'global',
  'container' => 'pre-footer-gap',
  'position' => 1,
  'allow_sidebar' => true,
),
			array (
  'row' => 20,
  'breakpoint' =>
  (array)(array(
     'tablet' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
     'mobile' =>
    (array)(array(
       'edited' => false,
       'col' => 24,
    )),
  )),
  'version' => '1.0.0',
)
			);

$regions->add($pre_footer_gap);

/* END_REGION_OUTPUT */