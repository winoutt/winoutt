<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title>Oceanpace</title>

		<style>
			@media only screen and (max-width: 480px) {
				.body-wrap {
					width: 100% !important;
				}

				.container {
					width: 95% !important;
				}
			}
		</style>
	</head>

	<body
		style="
			font-family: BlinkMacSystemFont, -apple-system, Segoe UI, Roboto, Oxygen, Ubuntu,
				Helvetica Neue, Helvetica, Arial, sans-serif, Apple Color Emoji, Segoe UI Emoji,
				Segoe UI Symbol;
			font-size: 1rem;
			line-height: 1.5;
			color: #2d3339;
		"
	>
		<center>
			<table
				class="body-wrap"
				style="
					width: 75%;
					border: 4px solid rgba(126, 122, 122, 0.08);
					border-spacing: 4px 20px;
					margin-top: 10px;
				"
			>
				<tr>
					<td>
						<center>
							<table class="container" bgcolor="#ffffff" width="80%" border="0">
								<tbody>
									<tr>
										<a href="{{ config('app.url') }}">
											<img
												src="https://oceanpace-prod.s3.us-east-2.amazonaws.com/assets/logo.png"
												style="
													width: 130px;
													margin-bottom: 32px;
													display: block;
													margin-left: auto;
													margin-right: auto;
												"
											/>
										</a>
									</tr>
									<tr style="text-align: left;">
										<td>
											@yield('content')
										</td>
									</tr>
									<tr style="text-align: left;">
										<td>
											<p style="margin-top: 1px; margin-bottom: 38px;">
												Cheers,<br />
												The Oceanpace Team<br />
												<a href="{{ config('app.url') }}"
													>{{ config('app.url') }}</a
												>
											</p>
											<hr
												style="border: none; border-top: 2px solid #f5f5f5;"
											/>

											<table align="center" width="110px">
												<tr>
													<td>
														<a
															href="https://www.linkedin.com/company/oceanpace/"
														>
															<img
																src="https://oceanpace-prod.s3.us-east-2.amazonaws.com/assets/linkedin-with-circle.png"
																style="
																	width: 40px;
																	margin-bottom: 5px;
																	margin-top: 20px;
																	display: flex;
																	align-items: center;
																	margin-left: auto;
																	margin-right: auto;
																"
															/>
														</a>
													</td>

													<td>
														<a
															href="https://www.youtube.com/channel/UCjFiXdyB_SfTGjsZ-J2WSLw"
														>
															<img
																src="https://oceanpace-prod.s3.us-east-2.amazonaws.com/assets/youtube-with-circle.png"
																style="
																	width: 40px;
																	margin-bottom: 5px;
																	margin-top: 20px;
																	display: block;
																	margin-left: auto;
																	margin-right: auto;
																"
															/>
														</a>
													</td>
												</tr>
											</table>

											<p
												style="
													margin-bottom: 10px;
													margin-top: 10px;
													color: #a2a2a2;
													font-size: 0.813rem;
													text-align: center;
												"
											>
												Oceanpace LLC, 201 East 5th St. STE 1200, Sheridan, WY
												82801, U.S.A.
											</p>
										</td>
									</tr>
								</tbody>
							</table>
						</center>
					</td>
				</tr>
			</table>
		</center>
	</body>
</html>
