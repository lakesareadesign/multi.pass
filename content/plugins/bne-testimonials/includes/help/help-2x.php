<?php
/*
 *	Help Admin Page - Shortcode v2.x
 *
 * 	@author		Kerry Kline
 * 	@copyright	Copyright (c) 2017, Kerry Kline
 * 	@link		http://www.bnecreative.com
 *	@package	BNE Testimonials
 *
*/

// Exit if accessed directly
if ( !defined('ABSPATH')) exit;


?>


<div class="widget" style="margin-top:15px;">
	<h3 class="widget-title">Testimonial Shortcode Display</h3>
	<p><strong>List Shortcode:</strong> [bne_testimonials layout="list"]</p>
	<p><strong>Slider Shortcode:</strong> [bne_testimonials layout="slider"]</p>
	<p>To change the default behavior of this shortcode, include any of the available arguments below. You only need to include them if changing the default behavior.</p>
	<hr>
	
	<div class="table-responsive">
		<h4>Query</h4>
		<p>These options alter the query that is used to gather and order the testimonials.</p>
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th style="width: 100px;">Argument</th>
					<th style="width: 80px;">Default</th>
					<th style="width: 120px;">Options</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>limit</td>
					<td>-1</td>
					<td>Any numerical value</td>
					<td>The number of testimonials to display. Use <code>-1</code> to display all testimonials.</td>
				</tr>
				<tr>
					<td>id</td>
					<td></td>
					<td>Any numerical value</td>
					<td>Only display this testimonial.</td>
				</tr>
				<tr>
					<td>category</td>
					<td></td>
					<td>the category slug</td>
					<td>Will only display testimonials from this category. You can display multiple categories by separating each category name with a comma (,).<br>Example: <code>category="marketing, management, support"</code></td>
				</tr>
				<tr>
					<td>order</td>
					<td>asc</td>
					<td>asc or desc</td>
					<td>The display direction in ascending or descending order based on the <code>orderby</code> query below.</td>
				</tr>
				<tr>
					<td>orderby</td>
					<td>name</td>
					<td>name, date, rand, menu_order, etc.</td>
					<td>The query order of testimonials. Name refers to the "post title" given to the testimonial.</td>
				</tr>
			</tbody>
		</table>




		<hr>
		<h4>Layout and Design</h4>
		<p>These options allow changing the default layout, theme and overall display.</p>
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th style="width: 100px;">Argument</th>
					<th style="width: 80px;">Default</th>
					<th style="width: 120px;">Options</th>
					<th>Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>layout</td>
					<td>list</td>
					<td>list or slider</td>
					<td>The layout display of the testimonials.
						<ul>
							<li><code>list</code> will show the testimonials like a traditional archive.</li>
							<li><code>slider</code> will show the testimonials in a rotation.</li>
						</ul>
					</td>
				</tr>
				<tr>
					<td>theme</td>
					<td>default</td>
					<td>default or  simple</td>
					<td>Display testimonials with different pre-defined styles. <code>simple</code> will include the minimal amount of styling specifically for the slider.</td>
				</tr>
				<tr>
					<td>image_style</td>
					<td>square</td>
					<td>square, circle, flat-square, or flat-circle</td>
					<td>Styles the testimonial image using one of the four built in styles. Square and Circle will give the image a border, frame and shadow. flat-square and flat-circle will add no border, no frame, and no shadow.</td>												
				</tr>
				<tr>
					<td>image_size</td>
					<td>thumbnail</td>
					<td>Any crop size</td>
					<td>The registered crop name provided from your theme or another plugin.</td>												
				</tr>
			</tbody>
		</table>



		<hr>
		<h4>Testimonial Details</h4>
		<p>These options allow adjusting how the testimonial details are used.</p>
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th>Argument</th>
					<th>Default</th>
					<th>Options</th>
					<th style="width: 60%;">Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>name</td>
					<td>true</td>
					<td>true or false</td>
					<td>Show or hide the testimonial name.</td>
				</tr>
				<tr>
					<td>image</td>
					<td>true</td>
					<td>true or false</td>
					<td>Show or hide the testimonial image.</td>
				</tr>
				<tr>
					<td>tagline</td>
					<td>true</td>
					<td>true or false</td>
					<td>Show or hide the testimonial tagline.</td>
				</tr>
				<tr>
					<td>website</td>
					<td>true</td>
					<td>true or false</td>
					<td>Show or hide the testimonial website.</td>
				</tr>
			</tbody>
		</table>



		<hr>
		<h4>Slider Layout Only</h4>
		<p>These options allow adjusting how the slider layout is configured.</p>
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th>Argument</th>
					<th>Default</th>
					<th>Options</th>
					<th style="width: 60%;">Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>nav</td>
					<td>true</td>
					<td>true or false</td>
					<td>(Slider layout only) Display the pagination buttons. Not available with the Thumbnail Slider layout.</td>
				</tr>
				<tr>
					<td>arrows</td>
					<td>true</td>
					<td>true or false</td>
					<td>(Slider layout only) Display the directional arrows. Not available with the Thumbnail Slider layout.</td>
				</tr>
				<tr>
					<td>pause</td>
					<td>true</td>
					<td>true or false</td>
					<td>If mouse cursor hovers over slider, slideshow will pause.</td>
				</tr>
				<tr>
					<td>animation</td>
					<td>slide</td>
					<td>slide or fade</td>
					<td>The transition of each testimonial.</td>
				</tr>
				<tr>
					<td>animation_speed</td>
					<td>700</td>
					<td>Any numerical value</td>
					<td>This determines the speed of the transition, in milliseconds. "1000" would equal to 1 second.</td>
				</tr>
				<tr>
					<td>smooth</td>
					<td>true</td>
					<td>true or false</td>
					<td>Height will adjust with a smooth animation based on the amount of content.</td>
				</tr>
				<tr>
					<td>speed</td>
					<td>7000</td>
					<td>Any numerical value</td>
					<td>This determines the speed of the slideshow cycling, in milliseconds. "7000" would equal to 7 seconds.</td>
				</tr>
			</tbody>
		</table>

		<hr>
		<h4>Other</h4>
		<table class="table table-bordered table-responsive">
			<thead>
				<tr>
					<th>Argument</th>
					<th>Default</th>
					<th>Options</th>
					<th style="width: 60%;">Description</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>class</td>
					<td></td>
					<td></td>
					<td>Add a custom classname or classes to the main wrapper div to further customize the appearance of the testimonials.</td>
				</tr>
			</tbody>
		</table>

	</div><!-- .table-responsive (end) -->

	<hr>
	<p><strong>Example Use #1:</strong> <code>[bne_testimonials limit="3" image_style="circle"]</code><br>
	<span style="font-style:italic;">The above will display only 3 testimonials using the circle featured image style.</span></p>

	<p><strong>Example Use #2:</strong> <code>[bne_testimonials layout="slider"]</code><br>
	<span style="font-style:italic;">The above, will display the testimonials using the slider layout.</span></p>

</div><!-- .widget (end) -->