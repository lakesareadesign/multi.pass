<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php echo $subject ?></title>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet" type="text/css">
	<style type="text/css">
		body, #bodyTable, #bodyCell {
			height: 100% !important;
			margin: 0;
			padding: 0;
			width: 100% !important;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
		}

		table {
			border-collapse: collapse;
		}

		img, a img {
			border: 0;
			outline: none;
			text-decoration: none;
		}

		h1, h2, h3, h4, h5, h6 {
			margin: 0px;
			padding: 0;
		}

		h4 {
			padding-bottom: 5px;
			line-height: 125%;
			font-size: 20px;
			color: #333333 !important;
		}

		#templateBody strong {
			font-weight: 400 !important;
			color: #333333 !important;
		}

		p {
			margin: 0 0 1em;
			padding: 0;
		}

		a {
			word-wrap: break-word;
		}

		.ReadMsgBody {
			width: 100%;
		}

		.ExternalClass {
			width: 100%;
		}

		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {
			line-height: 100%;
		}

		table, td {
			mso-table-lspace: 0pt;
			mso-table-rspace: 0pt;
		}

		#outlook a {
			padding: 0;
		}

		img {
			-ms-interpolation-mode: bicubic;
		}

		body, table, td, p, a, li, blockquote {
			-ms-text-size-adjust: 100%;
			-webkit-text-size-adjust: 100%;
		}

		.mcnImage {
			vertical-align: bottom;
		}

		.mcnImageCardBlockInner {
			width: 600px;
			max-width: 100%;
			overflow: hidden;
			white-space: nowrap;
		}

		.mcnImageCardBlockInner img {
			max-width: 100% !important;
		}

		.mcnTextContent img {
			height: auto !important;
		}

		.socialIconsWrapper {
			display: inline;
		}

		.footerContainer hr {
			width: 50px;
			margin-left: 0px;
			border: 1px solid #ddd;
		}

		#templateContainer {
			border: 0;
		}

		h1 {
			color: #15485F !important;
			display: block;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 32px;
			font-style: normal;
			font-weight: bold;
			line-height: 120%;
			letter-spacing: -0.04em;
			margin: 0 0 20px;
			text-transform: uppercase;
			text-align: center;
		}

		h2 {
			color: #15485F !important;
			display: block;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 20px;
			font-style: normal;
			font-weight: bold;
			line-height: 100%;
			letter-spacing: -0.04em;
			margin: 2em 0 1em;
			text-align: left;
		}

		h3 {
			color: #15485F !important;
			display: block;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 18px;
			font-style: normal;
			font-weight: normal;
			line-height: 125%;
			letter-spacing: -1px;
			margin: 2em 0 1em;
			text-align: right;
		}

		h4 {
			color: #555555 !important;
			display: block;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 20px;
			font-style: normal;
			font-weight: normal;
			line-height: 125%;
			letter-spacing: normal;
			margin: 0;
			text-align: left;
		}

		#templatePreheader {
			background-color: #EDEFED;
			border-top: 0;
			border-bottom: 0;
		}

		.preheaderContainer .mcnTextContent, .preheaderContainer .mcnTextContent p {
			color: #555555;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 16px;
			line-height: 125%;
			text-align: left;
		}

		.preheaderContainer .mcnTextContent a {
			color: #555555;
			font-weight: normal;
			text-decoration: none;
		}

		#templateHeader {
			background-color: #3d464d;
			border-top: 0;
			border-bottom: 0;
		}

		.headerContainer .mcnTextContent, .headerContainer .mcnTextContent p {
			color: #555555;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 16px;
			line-height: 100%;
			text-align: center;
		}

		.headerContainer .mcnTextContent a {
			color: #555555;
			font-weight: normal;
			text-decoration: none;
		}

		#templateBody {
			background-color: #FFFFFF;
			border-top: 0;
			border-bottom: 0;
		}

		.bodyContainer .mcnTextContent, .bodyContainer .mcnTextContent p {
			color: #555555;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 16px;
			line-height: 150%;
			text-align: left;
			font-weight: 300;
		}

		.bodyContainer .mcnTextContent a {
			color: #00AECC;
			font-weight: normal;
			text-decoration: underline;
		}

		#templateColumns {
			background-color: #FFFFFF;
			border-top: 0;
			border-bottom: 0;
		}

		.leftColumnContainer .mcnTextContent, .leftColumnContainer .mcnTextContent p {
			color: #606060;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 14px;
			line-height: 150%;
			text-align: left;
		}

		.leftColumnContainer .mcnTextContent a {
			color: #333333;
			font-weight: normal;
			text-decoration: none;
		}

		.rightColumnContainer .mcnTextContent, .rightColumnContainer .mcnTextContent p {
			color: #606060;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 14px;
			line-height: 150%;
			text-align: left;
		}

		.rightColumnContainer .mcnTextContent a {
			color: #333333;
			font-weight: normal;
			text-decoration: none;
		}

		#templateFooter {
			background-color: #EDEFED;
			border-top: 0;
			border-bottom: 0;
		}

		.footerContainer .mcnTextContent, .footerContainer .mcnTextContent p {
			color: #333333;
			font-family: 'Roboto', Arial, sans-serif;
			font-size: 18px;
			line-height: 150%;
			text-align: left;
		}

		.footerContainer .mcnTextContent a {
			color: #333333;
			font-weight: normal;
			text-decoration: none;
		}

		#offCanvas {
			background-color: #FFFFFF;
			padding-bottom: 100px;
		}

		.colophon p {
			margin-top: 1em;
		}

		.colophon p, .colophon a {
			text-transform: uppercase;
			color: #333333;
			font-weight: normal;
			font-size: 12px;
			font-family: 'Roboto', Arial, sans-serif;
		}

		@media only screen and (max-width: 480px) {
			body, table, td, p, a, li, blockquote {
				-webkit-text-size-adjust: none !important;
			}
		}

		@media only screen and (max-width: 480px) {
			body {
				width: 100% !important;
				min-width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[id=bodyCell] {
				padding: 10px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnTextContentContainer] {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnBoxedTextContentContainer] {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcpreview-image-uploader] {
				width: 100% !important;
				display: none !important;
			}
		}

		@media only screen and (max-width: 480px) {
			img[class=mcnImage] {
				width: 100% !important;
				max-width: 100% !important;
				position: relative !important;
				left: 0 !important;
				right: 0 !important;
				top: 0 !important;
				bottom: 0 !important;
			}
		}

		@media only screen and (max-width: 480px) {
			a[class=hasAbsoluteChild] {
				height: auto !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnImageGroupContentContainer] {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnImageGroupContent] {
				padding: 9px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnImageGroupBlockInner] {
				padding-bottom: 0 !important;
				padding-top: 0 !important;
			}
		}

		@media only screen and (max-width: 480px) {
			tbody[class=mcnImageGroupBlockOuter] {
				padding-bottom: 9px !important;
				padding-top: 9px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnCaptionTopContent], table[class=mcnCaptionBottomContent] {
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnCaptionLeftTextContentContainer], table[class=mcnCaptionRightTextContentContainer], table[class=mcnCaptionLeftImageContentContainer], table[class=mcnCaptionRightImageContentContainer], table[class=mcnImageCardLeftTextContentContainer], table[class=mcnImageCardRightTextContentContainer] {
				width: 50% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnImageCardLeftImageContent], td[class=mcnImageCardRightImageContent] {
				padding-right: 18px !important;
				padding-left: 18px !important;
				padding-bottom: 0 !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnImageCardBottomImageContent] {
				padding-bottom: 9px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnImageCardTopImageContent] {
				padding-top: 18px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnCaptionLeftContentOuter] td[class=mcnTextContent], table[class=mcnCaptionRightContentOuter] td[class=mcnTextContent] {
				padding-top: 9px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnCaptionBlockInner] table[class=mcnCaptionTopContent]:last-child td[class=mcnTextContent] {
				padding-top: 18px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnBoxedTextContentColumn] {
				padding-left: 18px !important;
				padding-right: 18px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=columnsContainer] {
				display: block !important;
				max-width: 600px !important;
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=mcnTextContent] {
				padding-right: 18px !important;
				padding-left: 18px !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[id=templateContainer], table[id=templatePreheader], table[id=templateHeader], table[id=templateColumns], table[class=templateColumn], table[id=templateBody], table[id=templateFooter] {
				max-width: 600px !important;
				width: 100% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			h1 {
				font-size: 22px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			h2 {
				font-size: 20px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			h3 {
				font-size: 18px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			h4 {
				font-size: 16px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[class=mcnBoxedTextContentContainer] td[class=mcnTextContent], td[class=mcnBoxedTextContentContainer] td[class=mcnTextContent] p {
				font-size: 18px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			table[id=templatePreheader] {
				display: block !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=preheaderContainer] td[class=mcnTextContent], td[class=preheaderContainer] td[class=mcnTextContent] p {
				font-size: 14px !important;
				line-height: 115% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=headerContainer] td[class=mcnTextContent], td[class=headerContainer] td[class=mcnTextContent] p {
				font-size: 18px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=bodyContainer] td[class=mcnTextContent], td[class=bodyContainer] td[class=mcnTextContent] p {
				font-size: 18px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=leftColumnContainer] td[class=mcnTextContent], td[class=leftColumnContainer] td[class=mcnTextContent] p {
				font-size: 18px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=rightColumnContainer] td[class=mcnTextContent], td[class=rightColumnContainer] td[class=mcnTextContent] p {
				font-size: 18px !important;
				line-height: 125% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=footerContainer] td[class=mcnTextContent], td[class=footerContainer] td[class=mcnTextContent] p {
				font-size: 14px !important;
				line-height: 115% !important;
			}
		}

		@media only screen and (max-width: 480px) {
			td[class=footerContainer] a[class=utilityLink] {
				display: block !important;
			}
		}

		@media only screen and (max-width: 480px) {
			#mainLogo {
				width: 100px !important;
				height: auto !important;
			}
		}

		@media only screen and (max-width: 480px) {
			.socialIconsWrapper {
				display: block !important;
			}
		}
	</style>
</head>
<body leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
<center>

	<table align="center" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable"
	       bgcolor="#FFFFFF">
		<tr>
			<td align="center" valign="top" id="bodyCell" bgcolor="#EDEFED"
			    style="padding:35px 20px 20px;border-top:0;">

				<!-- BEGIN TEMPLATE // -->
				<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
					<tr>
						<td align="center" valign="top">

							<!-- BEGIN PREHEADER // -->
							<table border="0" cellpadding="0" cellspacing="0" width="600" id="templatePreheader">
								<tr>
									<td valign="top" class="preheaderContainer" style="padding-top:0px;">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
										       class="mcnTextBlock">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner">

													<table align="left" border="0" cellpadding="0" cellspacing="0"
													       width="600" class="mcnTextContentContainer">
														<tbody>
														<tr>
															<td valign="top" class="mcnTextContent"
															    style="padding-top:0px; padding-right: 0px; padding-bottom: 0px; padding-left: 18px;">
																<!-- Not used -->
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>

										<table border="0" cellpadding="0" cellspacing="0" width="100%"
										       class="mcnCaptionBlock">
											<tbody class="mcnCaptionBlockOuter">
											<tr>
												<td class="mcnCaptionBlockInner" valign="top" style="padding:0 0 45px;">

													<table border="0" cellpadding="0" cellspacing="0"
													       class="mcnCaptionRightContentOuter" width="100%">
														<tbody>
														<tr>
															<td valign="top" class="mcnCaptionRightContentInner"
															    style="padding:0px 0px;">
																<table align="left" border="0" cellpadding="0"
																       cellspacing="0"
																       class="mcnCaptionRightImageContentContainer">
																	<tbody>
																	<tr>
																		<td class="mcnCaptionRightImageContent"
																		    valign="top">
																			<a href="https://premium.wpmudev.org/blog/"
																			   style="display:block;"><img alt="News"
																			                               src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/419f156a-1d24-40a0-b233-9d12fb9bd75a.png"
																			                               width="100%"
																			                               height="100%"
																			                               id="mainLogo"></a>
																		</td>
																	</tr>
																	</tbody>
																</table>

																<table class="mcnCaptionRightTextContentContainer"
																       align="right" border="0" cellpadding="0"
																       cellspacing="0" width="400">
																	<tbody>
																	<tr>
																		<td valign="top" class="mcnTextContent"
																		    style="padding:25px 0 0 0 ;">
																			<!-- Not used -->
																		</td>
																	</tr>
																	</tbody>
																</table>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
							<!-- // END PREHEADER -->

						</td>
					</tr>
					<tr>
						<td align="center" valign="top">

							<table width="100%"
							       style="table-layout: fixed;border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF !important;">
								<tr>
									<td style="width:100%;padding-top: 50px;padding-right: 50px;padding-bottom: 29px;padding-left: 50px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #555555;font-family: 'Roboto', Arial, sans-serif;font-size: 16px;line-height: 150%;text-align: left;font-weight: 300;">
										<?php echo $message ?>
									</td>
								</tr>
							</table>

						</td>
					</tr>
					<tr>
						<td align="center" valign="top">

							<!-- BEGIN FOOTER // -->
							<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateFooter">
								<tr>
									<td valign="top" class="footerContainer">
										<table border="0" cellpadding="0" cellspacing="0" width="100%"
										       class="mcnTextBlock">
											<tbody class="mcnTextBlockOuter">
											<tr>
												<td valign="top" class="mcnTextBlockInner">

													<table align="left" border="0" cellpadding="0" cellspacing="0"
													       width="600" class="mcnTextContentContainer">
														<tbody>
														<tr>

															<td valign="top" class="mcnTextContent"
															    style="padding-top:60px; padding-bottom: 30px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #555555;font-family: 'Roboto', Arial, sans-serif;font-size: 15px;line-height: 150%;text-align: left;font-weight: 300;">
																<div style="text-align: left;">
																	<hr>
																	<p class="null"
																	   style="display:inline;color:#00AECC;font-weight:normal;margin-right:20px;vertical-align:middle;letter-spacing:-1px">
																		Let’s get social!</p>

																	<div class="socialIconsWrapper">
																		<a href="https://twitter.com/wpmudev"
																		   style="line-height: 20.7999992370605px;display:inline-block;vertical-align:middle;"
																		   target="_blank">
																			<img align="none" height="30"
																			     src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/8325849f-33ea-4f55-ad1d-755b9a9c1213.png"
																			     style="opacity: 0.9; width: 30px; height: 30px; margin: 0px;"
																			     width="30">
																		</a>&nbsp;
																		<a href="https://www.youtube.com/user/wpmudev"
																		   target="_blank"
																		   style="display:inline-block;vertical-align:middle;">
																			<img align="none" height="30"
																			     src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/f76829b2-08f5-4fd6-ac4e-0426e8f81326.png"
																			     style="width: 30px; height: 30px; margin: 0px;"
																			     width="30">
																		</a>&nbsp;
																		<a href="https://www.facebook.com/wpmudev"
																		   style="line-height: 1.6em;display:inline-block;vertical-align:middle;"
																		   target="_blank">
																			<img align="none" height="30"
																			     src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/c1a1144c-3257-481f-8b60-ffbdc846f18d.png"
																			     style="width: 30px; height: 30px; margin: 0px;"
																			     width="30">
																		</a>&nbsp;
																		<a href="https://plus.google.com/+wpmuorg/"
																		   target="_blank"
																		   style="display:inline-block;vertical-align:middle;">
																			<img align="none" height="30"
																			     src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/afc08b31-056f-4c0f-89bc-68b5e9b35091.png"
																			     style="width: 30px; height: 30px; margin: 0px;"
																			     width="30">
																		</a>&nbsp;
																		<span
																			style="line-height:1.6em">&nbsp;&nbsp;</span>
																	</div>
																</div>
															</td>

															<td align="right" valign="top" style="padding-top:30px;">
																<a href="https://premium.wpmudev.org/blog/"
																   style="display:block;">
																	<img
																		src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/7d2039b2-a660-45db-b1d1-c211cb766441.gif"
																		alt="WPMU DEV Super Heroes" class="mcnImage">
																</a>
															</td>
														</tr>
														</tbody>
													</table>

												</td>
											</tr>
											</tbody>
										</table>
									</td>
								</tr>
							</table>
							<!-- // END FOOTER -->

						</td>
					</tr>
				</table>
				<!-- // END TEMPLATE -->

			</td>
		</tr>
		<tr>
			<td align="center" valign="top" id="offCanvas" style="padding:0 0 50px;">
				<table border="0" cellpadding="0" cellspacing="0" width="600" id="templateContainer">
					<tbody>
					<tr>
						<td align="center" valign="top">
							<a href="https://premium.wpmudev.org/blog/" style="display:block;">
								<img
									src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/12584994-1cac-4632-8af1-31b03d2ca22b.png"
									alt="" width="125" height="80"></a>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<a href="https://premium.wpmudev.org/&quot;><img alt=""
							src="https://gallery.mailchimp.com/53a1e972a043d1264ed082a5b/images/5b8432e0-9a06-45f5-a559-764897c6982f.png"
							width="100" height="23" style="max-width:100px;"></a>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top" class="colophon">
							<!-- Not used -->
						</td>
					</tr>
					</tbody>
				</table>

				<div style="display:none; white-space:nowrap; font:15px courier; line-height:0;">
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
				</div>

			</td>
		</tr>
	</table>

</center>
</body>
</html>