
{{-- @php
$code=collect(str_split($mail_data[0]['code'], 4))->implode(' ');
$from=$mail_data[0]['from'];
$msg=$mail_data[0]['msg'];
$to=$mail_data[0]['to'];
$amount=$mail_data[0]['amount'];
$from_name=$mail_data[0]['from_name'];
$to_name=$mail_data[0]['to_name'];
if(isset($mail_data['html_code']))
{
$string=$mail_data['html_code'];
$search = array("['from']", "['msg']", "['to']","['amount']","['from_name']","['code']","['to_name']");
$replace = array("$from", "$msg", "$to","$amount","$from_name","$code","$to_name");
$newString = str_replace($search, $replace, $string);
}

@endphp





@if(isset($string))
{!! $newString !!}

@else --}}
<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation" style="table-layout:fixed">
	<tbody>
		<tr>
			<td align="center" valign="top">
				<table class="m_4043362051198468644pc-email-container" width="100%" align="center" border="0" cellpadding="0" cellspacing="0" role="presentation" style="margin:0 auto;max-width:620px">
					<tbody>
						<tr>
							<td align="left" valign="top" style="padding:0 10px">
								<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
									<tbody>
										<tr>
											<td height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
										</tr>
									</tbody>
								</table>
								<table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
									<tbody>
										<tr>
											<td valign="top">
												<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
													<tbody>
														<tr>
															<td class="m_4043362051198468644pc-sm-p-30-10 m_4043362051198468644pc-xs-p-25-0" bgcolor="#ffffff" style="padding:40px 20px;background:#ffffff;border-radius:8px" valign="top">
																<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																	<tbody>
																		<tr>
																			<td bgcolor="#ffffff" valign="middle" style="padding:0 20px;background-color:#ffffff;font-size:0">
																				<div class="m_4043362051198468644pc-sm-mw-100pc" style="width:100%;vertical-align:middle">
																					<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
																						<tbody>
																							<tr>
																								<td valign="top" style="padding:0" align="left">
																									<a style="text-decoration:none">
																										<img src="{{url('/images/gifts/logo.png')}}" width="150" height="" alt="Forever Medspa" style="max-width:100%;height:auto;border:0;line-height:100%;outline:0;font-size:14px;color:#1b1b1b" class="CToWUd a6T" data-bit="iit" tabindex="0" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
																										<div class="a6S" dir="ltr" style="opacity: 0.01; left: 344.984px; top: 178px;">
																											<span data-is-tooltip-wrapper="true" class="a5q" jsaction="JIbuQc:.CLIENT">
																												<button class="VYBDae-JX-I VYBDae-JX-I-ql-ay5-ays CgzRE" jscontroller="PIVayb" jsaction="click:h5M12e;clickmod:h5M12e; pointerdown:FEiYhc; pointerup:mF5Elf; pointerenter:EX0mI; pointerleave:vpvbp; pointercancel:xyn4sd; contextmenu:xexox;focus:h06R8; blur:zjh6rb;mlnRJb:fLiPzd;" data-idom-class="CgzRE" jsname="hRZeKc" aria-label="Download attachment " data-tooltip-enabled="true" data-tooltip-id="tt-c31" data-tooltip-classes="AZPksf" id="" jslog="91252; u014N:cOuCgd,Kr2w4b,xr6bB; 4:WyIjbXNnLWY6MTc5MTEyMTUwMTgwODg2ODQ5MSJd; 43:WyJpbWFnZS9qcGVnIl0.">
																													<span class="OiePBf-zPjgPe VYBDae-JX-UHGRz"></span><span class="bHC-Q" data-unbounded="false" jscontroller="LBaJxb" jsname="m9ZlFb" soy-skip="" ssk="6:RWVI5c"></span>
																													<span class="VYBDae-JX-ank-Rtc0Jf" jsname="S5tZuc" aria-hidden="true">
																														<span class="bzc-ank" aria-hidden="true">
																															<svg height="20" viewBox="0 -960 960 960" width="20" focusable="false" class=" aoH">
																																<path d="M480-336 288-528l51-51 105 105v-342h72v342l105-105 51 51-192 192ZM263.717-192Q234-192 213-213.15T192-264v-72h72v72h432v-72h72v72q0 29.7-21.162 50.85Q725.676-192 695.96-192H263.717Z"></path>
																															</svg>
																														</span>
																													</span>
																													<div class="VYBDae-JX-ano"></div>
																												</button>
																												<div class="ne2Ple-oshW8e-J9" id="tt-c31" role="tooltip" aria-hidden="true">Download</div>
																											</span>
																										</div>
																									</a>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td style="line-height:1px;font-size:1px" height="40">&nbsp;</td>
																		</tr>
																	</tbody>
																	<tbody>
																		<tr>
																			<td class="m_4043362051198468644pc-sm-fs-30" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:36px;font-weight:800;line-height:46px;letter-spacing:-0.6px;color:#151515;padding:0 20px;vertical-align:top" valign="top" id="m_4043362051198468644intro-title">Thank you for your order</td>
																		</tr>
																		<tr>
																			<td style="line-height:1px;font-size:1px" height="30">&nbsp;</td>
																		</tr>
																	</tbody>
																	<tbody>  
                                                      <tr>
																			<td class="m_4043362051198468644pc-sm-fs-18 m_4043362051198468644pc-xs-fs-16" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 20px" valign="top" id="m_4043362051198468644intro-text">
																				We really appreciate you buying this gift card and hope that the recipient loves our Giftcard!<br><br><img src="{{url('/images/gifts/logo.png')}}" width="100" height="50" class="CToWUd" data-bit="iit" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';"><br>From {{$mail_data->receipt_email}}<br>
																			</td>
																		</tr>

																	</tbody>
																	<tbody>
																		<tr>
																			<td style="font-size:0" valign="top">
																				<div class="m_4043362051198468644pc-sm-mw-100pc" style="display:inline-block;max-width:280px;width:100%;vertical-align:top;overflow:hidden">
																					<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																						<tbody>
																							<tr>
																								<td style="padding:10px 20px" valign="top">
																									<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																										<tbody>
																											<tr>
																												<td style="border-bottom:1px solid #e5e5e5;padding:0 0 10px;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515" valign="top">To</td>
																											</tr>
																											<tr>
																												<td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
																											</tr>
																										</tbody>
																										<tbody>
																											<tr>
																												<td style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word" valign="top">
                                                                                       {{ $mail_data ? ($mail_data->recipient_name ? $mail_data->recipient_name : $mail_data->your_name) : '' }}                                              <br>
																													<span style="color:#9b9b9b"><a href="mailto:{{$mail_data->receipt_email}}      " target="_blank">{{$mail_data->receipt_email}}      </a></span>
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																				<div class="m_4043362051198468644pc-sm-mw-100pc" style="display:inline-block;max-width:280px;width:100%;vertical-align:top;overflow:hidden">
																					<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																						<tbody>
																							<tr>
																								<td style="padding:10px 20px" valign="top">
																									<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																										<tbody>
																											<tr>
																												<td style="border-bottom:1px solid #e5e5e5;padding:0 0 10px;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;font-weight:bold;color:#151515" valign="top">Shipping</td>
																											</tr>
																											<tr>
																												<td height="10" style="font-size:1px;line-height:1px">&nbsp;</td>
																											</tr>
																										</tbody>
																										<tbody>
																											<tr>
																												<td style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#151515;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word" valign="top">
																													We'll email {{$mail_data->your_name}} at <a href="mailto:{{$mail_data->receipt_email}}" target="_blank">{{$mail_data->receipt_email}}</a> with their gift card                                                (<a href="" style="color:#333333" id="m_4043362051198468644primary-button" target="_blank" data-saferedirecturl="">download now</a>)
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																			</td>
																		</tr>
																	</tbody>
																	<tbody>
																		<tr>
																			<td height="20" style="line-height:1px;font-size:1px">&nbsp;</td>
																		</tr>
																		<tr>
																			<td style="padding:0 20px" valign="top">
																				<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																					<tbody>
																						<tr>
																							<th style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;padding:10px 10px 10px 0;border-bottom:1px solid #e5e5e5;width:400px;color:#151515" align="left">
																							</th>
																							<th style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;padding:10px 10px 10px 0;border-bottom:1px solid #e5e5e5;width:44px;color:#151515;text-align:right" align="right">
																							</th>
																							<th style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;border-bottom:1px solid #e5e5e5;padding:10px 0;width:56px;color:#151515;text-align:right" align="right">
																							</th>
																						</tr>
																					</tbody>
																					<tbody>
																						<tr>
																							<td style="padding:20px 10px 20px 0;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;border-bottom:1px solid #e5e5e5" valign="top">
																								<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																									<tbody>
																										<tr>
																											<td valign="top" style="font-size:0">
																												<div style="display:inline-block;max-width:120px;vertical-align:top" class="m_4043362051198468644hide-on-xs">
																													<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																														<tbody>
																															
																														</tbody>
																													</table>
																												</div>
																												<div style="display:inline-block;max-width:260px;vertical-align:top">
																													<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																														<tbody>
																															<tr>
																																<td style="padding:0 0 0" valign="top">
																																	<table border="0" cellpadding="0" cellspacing="0" role="presentation" width="100%">
																																		<tbody>
																																			<tr>
																																				<td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;letter-spacing:-0.3px;line-height:28px;font-weight:500;font-size:18px;color:#151515" valign="top">
																																					${{($mail_data->amount)/($mail_data->qty)}} gift card
																																				</td>
																																			</tr>
																																			<tr>
																																				<td height="4" style="font-size:1px;line-height:1px">&nbsp;</td>
																																			</tr>
																																		</tbody>
																																		<tbody>
																																			<tr>
																																				<td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;letter-spacing:-0.2px;line-height:30px;font-size:16px;color:#9b9b9b;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word;white-space:pre-wrap" valign="top">For use at Forever Medsap</td>
																																			</tr>

                                                                                                         <tr>
																																				<td height="4" style="font-size:1px;line-height:1px">&nbsp;</td>
																																			</tr>
                                                                                                         @php
                                                                                                         $cardnumber = App\Models\GiftcardsNumbers::where('transaction_id',$mail_data->transaction_id)->get();
                                                                                                         @endphp
                                                                                                      @foreach($cardnumber as $value)
                                                                                                         <tr>
                                                                                                            <td class="m_4043362051198468644pc-sm-fs-18 m_4043362051198468644pc-xs-fs-16" style="font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:18px;line-height:30px;letter-spacing:-0.2px;color:#9b9b9b;padding:0 0px" valign="top" id="m_4043362051198468644intro-text">
                                                                                                               <h2>{{$value->giftnumber }}</h2>
                                                                                                            </td>
                                                                                                         </tr>
                                                                                                      @endforeach
																																		</tbody>
                                                                                                      <tbody>
                                                                                                         <tr>
                                                                                                            <td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;letter-spacing:-0.3px;line-height:28px;font-weight:500;font-size:18px;color:#151515" valign="top">
                                                                                                               Message
                                                                                                            </td>
                                                                                                         </tr>
                                                                                                         <tr>
																																				<td height="4" style="font-size:1px;line-height:1px">&nbsp;</td>
																																			</tr>
                                                                                                         <tr>
																																				<td style="font-family:'Fira Sans',Roboto,Arial,sans-serif;letter-spacing:-0.2px;line-height:30px;font-size:16px;color:#9b9b9b;max-width:260px;overflow:hidden;text-overflow:ellipsis;word-wrap:break-word;white-space:pre-wrap" valign="top">{{$mail_data->message}}</td>
																																			</tr>

                                                                                                         <tr>
																																				<td height="4" style="font-size:1px;line-height:1px">&nbsp;</td>
																																			</tr>
                                                                                                      </tbody>
																																	</table>
																																</td>
																															</tr>
																														</tbody>
																													</table>
																												</div>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																							<td style="padding:20px 10px 20px 0;color:#9b9b9b;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;border-bottom:1px solid #e5e5e5" valign="top" align="right">
																								{{$mail_data->qty}}
																							</td>
																							<td style="padding:20px 0 20px;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;border-bottom:1px solid #e5e5e5;color:#151515" valign="top" align="right">${{$mail_data->amount}}</td>
																						</tr>
																					</tbody>
                                                               @if($mail_data->discount!='' && $mail_data->discount!=null)
																					<tbody>
																						<tr>
																							<td colspan="3" height="20" style="line-height:1px;font-size:1px">&nbsp;</td>
																						</tr>
																					</tbody>
																					<tbody>
																						<tr>
																							<td colspan="2" style="padding:0 10px 0 0;letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#40be65" valign="top" align="right">
																								Discount:
																							</td>
																							<td style="letter-spacing:-0.2px;line-height:26px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:16px;color:#40be65" valign="top" align="right">
																								-{{$mail_data->discount}}
																							</td>
																						</tr>
																					</tbody>
                                                               @endif
																					<tbody>
																						<tr>
																							<td colspan="3" height="20" style="line-height:1px;font-size:1px">&nbsp;</td>
																						</tr>
																					</tbody>
																					<tbody>
																						<tr>
																							<td class="m_4043362051198468644pc-sm-fs-20" colspan="3" style="padding:20px 0 0 0;font-family:'Fira Sans',Roboto,Arial,sans-serif;letter-spacing:-0.4px;line-height:34px;font-size:24px;border-top:2px solid #e5e5e5;font-weight:bold;color:#151515" valign="top" align="right" id="m_4043362051198468644total">
																								Total:
																								${{$mail_data->transaction_amount}}
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																	<tbody>
																		<tr>
																			<td style="line-height:1px;font-size:1px" height="50">&nbsp;</td>
																		</tr>
																		
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
												<table width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
													<tbody>
														<tr>
															<td height="8" style="font-size:1px;line-height:1px">&nbsp;</td>
														</tr>
													</tbody>
												</table>
												<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
													<tbody>
														<tr>
															<td class="m_4043362051198468644pc-sm-p-31-20-39 m_4043362051198468644pc-xs-p-15-10-25" style="padding:31px 30px;background-color:#ffffff;border-radius:8px" valign="top" bgcolor="#ffffff">
																<table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
																	<tbody>
																		<tr>
																			<td valign="top" style="font-size:0">
																				<div class="m_4043362051198468644pc-sm-mw-100pc" style="display:inline-block;width:100%;max-width:445px;vertical-align:top">
																					<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
																						<tbody>
																							<tr>
																								<td class="m_4043362051198468644pc-xs-p-15-10" style="line-height:20px;letter-spacing:-0.2px;font-family:'Fira Sans',Roboto,Arial,sans-serif;font-size:14px;color:#9b9b9b;padding:0 10px" valign="top">
																									© All rights reserved.<br>Sent by Forever Medsap on behalf of <a>Forever Medsap</a>.
																									<br>
																									<a href="https://forevermedspanj.com/" target="_blank" data-saferedirecturl="https://forevermedspanj.com/">https://www.<wbr>forevermedspanj.com/</a>                                                                        
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
																				<div class="m_4043362051198468644pc-sm-mw-100pc" style="display:inline-block;width:100%;max-width:65px;vertical-align:top">
																					<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
																						<tbody>
																							<tr>
																								<td valign="top" style="padding:0 0 10px">
																									<table border="0" cellpadding="0" cellspacing="0" role="presentation">
																										<tbody>
																											<tr>
																												<td valign="middle" style="padding:0 10px">
																													<img src="{{url('/images/gifts/logo.png')}}" width="80" height="40" alt="Gift Up!" style="border:0;line-height:100%;outline:0;font-size:14px;color:#151515" class="CToWUd" data-bit="iit" onerror="this.onerror=null; this.src='{{url('/No_Image_Available.jpg')}}';">
																												</td>
																											</tr>
																										</tbody>
																									</table>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</div>
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
								<table width="100%" border="0" cellpadding="0" cellspacing="0" role="presentation">
									<tbody>
										<tr>
											<td height="20" style="font-size:1px;line-height:1px">&nbsp;</td>
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
{{-- @endif --}}


