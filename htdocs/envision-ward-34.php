<?php

/**
 * The "Envision" page.
 *
 * PHP version 5
 *
 * @license		http://www.gnu.org/licenses/gpl.html GPL 3
 * @version		0.8
 * @link		http://www.statedecoded.com/
 * @since		0.8
 *
 */

/*
 * Fire up our templating engine.
 */
$content = new Content();

/*
 * Define some page elements.
 */
$content->set('browser_title', 'Envision Chicago');
$content->set('page_title', '');

$content->set('body',
<<<EOT
	<!-- UNCOMMENT TO DISPLAY AN INTRODUCTORY VIDEO HERE
	<div class="nest video">
		<div class="video-frame">
			<div class="video-container">
				<video width="" height="" controls="controls">
					<source src="" type="video/mp4">
					<source src="" type="video/webm">
				</video>
			</div>
		</div>
	</div>--> <!-- // .nest -->

	<section class="homepage" role="main">
		<div class="nest">
			<section class="feature-content">
				<hgroup>
					<h1>Envision Chicago</h1>
					<h2>Envision A Better Chicago</h2>
				</hgroup>
				<p>
				<strong>Hello Chicago Excel Academy of Roseland! Welcome to the Envision Chicago scholarship contest!</strong>
				</p>
				<p>
				Here’s how you can participate:
				</p>
				<p>
				Imagine a Better Chicago! Think about what you like best - and like least - about living in Chicago. What issues do you care about? What do you see in your neighborhood, in your ward and in your school that could be improved? Odds are, there's a law to match. How would you fix what you don't like or build on what you do?
				</p>
				<p>
				Find the Laws You Care About! Now that you have a vision for improving city life, visit ChicagoCode.org. Browse and search through the laws to find what you care about most.
				</p>
				<p>
				Rewrite the Rules! See how the law is written with ChicagoCode.org. Decide how you'd improve it. Tell us why this matters to you and your community. Share your ideas with the alderman who represents you on the Chicago City Council by April 15. There is NO LIMIT to how many ideas you can enter to win the $1,000 scholarship! Submit your idea by clicking the “Envision This Law” at the bottom of each law or by <a href="https://docs.google.com/a/opengovfoundation.org/forms/d/1IH1LUdPYB8lYCLTLS5YMNMd7Rg5EId0Xt_ZZ4sCixvg/viewform">filling out this form</a>.
				</p>
				<p>
				What Happens Next?
				</p>
				<p>
				After April 15, your ideas to Envision a Better Chicago will be reviewed by your Alderman, Chicago City Clerk Susana Mendoza and The OpenGov Foundation’s Executive Director Seamus Kraft. A winning idea will be selected from each ward, earning the winning student $1,000 for school and a shot at their idea becoming a legislative proposal before the Chicago City Council.
				</p>
			</section> <!-- // .feature -->

			<section class="secondary-content">

				<article style="width: 300px; margin-left: 30px;">

					<img src="http://placehold.it/300x300?text=Ward+Map" style="margin-bottom: 2rem;">

					<img src="http://placehold.it/300x400?text=Alderman Photo" style="">
					<span>Alderman Carrie Austin</span>

				</article>

			</section> <!-- // .secondary-content -->

		</div> <!-- // .nest -->

	</section>

EOT
);

/*
 * Put the shorthand $sidebar variable into its proper place.
 */
$content->set('sidebar', '');

/*
 * Add the custom classes to the body.
 */
$content->set('body_class', 'preload');

/*
 * Parse the template, which is a shortcut for a few steps that culminate in sending the content
 * to the browser.
 */
$template = Template::create();
$template->parse($content);
