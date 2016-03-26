jQuery(document).ready(function() {
	
	jQuery('.um-reviews-avg').raty({
		half: 		true,
		starType: 	'i',
		number: 	function() {return jQuery(this).attr('data-number');},
		score: 		function() {return jQuery(this).attr('data-score');},
		hints: ['1 Star','2 Star','3 Star','4 Star','5 Star'],
		space: false,
		readOnly: true
	});
	
	jQuery('.um-reviews-rate').raty({
		half: 		false,
		starType: 	'i',
		number: 	function() {return jQuery(this).attr('data-number');},
		score: 		function() {return jQuery(this).attr('data-score');},
		scoreName: 	function(){return jQuery(this).attr('data-key');},
		hints: ['1 Star','2 Star','3 Star','4 Star','5 Star'],
		space: false
	});
	
});