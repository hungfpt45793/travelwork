<?php

namespace App\Http\Controllers\Site;

use App\Entity\JobGroup;
use App\Entity\MailConfig;
use App\Mail\TestEmail;
use Illuminate\Http\Request;
use Yangqi\Htmldom\Htmldom;
use Mail;

class HomeController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

//        if (!empty($this->domainUser)) {
//            if ( strtotime($this->domainUser->end_at) < time() && ($this->emailUser != 'vn3ctran@gmail.com')) {
//                return redirect(route('admin_dateline'));
//            }
//        }
        return view('site.default_site.index_new');
    }
    public function home_new(Request $request)
    {
        return view('site.default_site.index_new');
    }

    public function home_test_site(Request $request)
    {
            return view('site.layout_site.site_test_login');
    }

    public function embed_banner(Request $request)
    {
        return view('site.default_site.embed_banner');
    }
    function get_client_ip() {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function mail( Request $request)
    {
        $content = '<p>MockVault Newsletter</p>
<div style="background-color:#6e7178; background-image:url(http://www.mockvault.com/edms/images/bg.jpg); background-repeat:repeat; margin-bottom:0px; margin-left:0px; margin-right:0px; margin-top:0px; padding:0px">
<table border="0" cellpadding="20" cellspacing="0" style="width:100%">
	<tbody>
		<tr>
			<td>
			<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate; border-spacing:0; width:666px">
				<tbody>
					<tr>
						<td style="background-color:#000000"><img alt="" src="http://www.mockvault.com/edms/images/tbar.png" style="border:0px; height:6px; width:41px" /></td>
					</tr>
					<tr>
						<td style="background-color:#ffffff; vertical-align:top">
						<table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate; border-spacing:0; margin-bottom:16px; width:666px">
							<tbody>
								<tr><!-- Logo Bar -->
									<td><img alt="MockVault" src="http://www.mockvault.com/edms/images/logo.gif" style="border:0px" /></td>
									<td>
									<table border="0" cellpadding="3" cellspacing="0" style="width:200px">
										<tbody>
											<tr>
												<td>Email not looking pretty?<br />
												View the web version.</td>
												<td rowspan="2">&nbsp;</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
							</tbody>
						</table>

						<table border="0" cellpadding="0" cellspacing="0" style="border-collapse:separate; border-spacing:0; width:666px">
							<tbody>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/bar.gif" style="border:0px; height:11px; width:666px" /></td>
								</tr>
								<tr>
									<td><!-- Main Image --><a href="http://www.mockvault.com"><img alt="New Updates" class="responsive" src="http://www.mockvault.com/edms/03/hero.gif" style="border:0px; height:230px; width:665px" /></a></td>
								</tr>
								<tr>
									<td style="vertical-align:top"><!-- Main Copy -->
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td>
												<h1 style="margin-left:0px; margin-right:0px">Some updates we&#39;d like to share!</h1>

												<p>Hello! We launched <a href="http://www.mockvault.com" style="color:#96B60E;" title="MockVault">MockVault</a> not too long ago, though we made sure it&#39;s awesome before we shipped, there were still some pesky bugs. But we managed to fix them all, at least those that we know of. Thanks to your feedback and bug reports!</p>

												<p>On top of that, we also added new features and various improvements.</p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						<!-- Sections -->

						<table border="0" cellpadding="0" cellspacing="0" style="width:610px"><!-- ROW -->
							<tbody>
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td><img alt="" src="http://www.mockvault.com/edms/03/thumb1.jpg" style="border:1px solid #e9e9e9; height:171px; width:170px" /></td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>New keyboard shortcuts</td>
														</tr>
													</tbody>
												</table>

												<p>Keyboard shortcuts are such huge time savers. Just hit a key and perform a task. For instance, hit the number keypad 2 and you&#39;re in the &quot;Designs&quot; section in no time. Or hit &quot;c&quot; to open the comments drawer.<br />
												<a href="http://www.mockvault.com/2012/new-keyboard-shortcuts/"><img alt="" src="http://www.mockvault.com/edms/images/more.gif" style="border:0px; height:35px; padding-top:13px; width:86px" /></a></p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW --><!-- ROW -->
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td><img alt="" src="http://www.mockvault.com/edms/03/thumb2.jpg" style="border:1px solid #e9e9e9; height:171px; width:170px" /></td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>Get notified when client views your mockup</td>
														</tr>
													</tbody>
												</table>

												<p>This feature is one of the most requested. When you send a mockup to your client via MockVault&#39;s interface, a letter &#39;t&#39; is appended to the end of the mockup permalink. When your client clicks this specially formatted link, you get notified!<br />
												<a href="http://www.mockvault.com/2012/two-new-features/"><img alt="" src="http://www.mockvault.com/edms/images/more.gif" style="border:0px; height:35px; padding-top:13px; width:86px" /></a></p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW --><!-- ROW -->
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td><img alt="" src="http://www.mockvault.com/edms/03/thumb3.jpg" style="border:1px solid #e9e9e9; height:171px; width:170px" /></td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>Comments improvements</td>
														</tr>
													</tbody>
												</table>

												<p>In a nutshell, all members in your team will receive email notifications for every comment made by the client. Likewise, when you add comments, your clients who&#39;re currently in the comments thread will receive notifications too.<br />
												<a href="http://www.mockvault.com/2012/enhancements-to-comments-smtp-outgoing-emails-and-more/"><img alt="" src="http://www.mockvault.com/edms/images/more.gif" style="border:0px; height:35px; padding-top:13px; width:86px" /></a></p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW --><!-- ROW -->
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td><img alt="" src="http://www.mockvault.com/edms/03/thumb4.jpg" style="border:1px solid #e9e9e9; height:171px; width:170px" /></td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>Option to send email via SMTP</td>
														</tr>
													</tbody>
												</table>

												<p>To ensure 100% deliverability when you send mockups to your clients via MockVault, we added to option to send email via SMTP.<br />
												<a href="http://www.mockvault.com/2012/enhancements-to-comments-smtp-outgoing-emails-and-more/"><img alt="" src="http://www.mockvault.com/edms/images/more.gif" style="border:0px; height:35px; padding-top:13px; width:86px" /></a></p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW --><!-- ROW -->
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td><img alt="" src="http://www.mockvault.com/edms/03/thumb5.jpg" style="border:1px solid #e9e9e9; height:171px; width:170px" /></td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>Login problems? We squashed it!</td>
														</tr>
													</tbody>
												</table>

												<p>Quite a number of you informed us of having trouble logging in. Good news is, we fixed it! This should not happen again. If you previously tried logging in but can&#39;t, <a href="http://www.mockvault.com/2012/fixed-login-problem-numbering-bug/" style="color:#96B60E;" title="">try this fix</a>.<br />
												<a href="http://www.mockvault.com/2012/fixed-login-problem-numbering-bug/"><img alt="" src="http://www.mockvault.com/edms/images/more.gif" style="border:0px; height:35px; padding-top:13px; width:86px" /></a></p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW --><!-- ROW -->
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td><img alt="" src="http://www.mockvault.com/edms/03/thumb6.jpg" style="border:1px solid #e9e9e9; height:171px; width:170px" /></td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>Follow us on Twitter</td>
														</tr>
													</tbody>
												</table>

												<p>We scour the web for useful articles / resources and tweet them regularly. Don&#39;t miss this out, be sure to <a href="http://twitter.com/mockvault" style="color:#96B60E;" title="">follow us</a>!</p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW --><!-- ROW -->
								<tr>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
										<tbody>
											<tr>
												<td>&nbsp;</td>
												<td>
												<table border="0" cellpadding="0" cellspacing="0" style="width:420px">
													<tbody>
														<tr>
															<td>Blog &amp; support center is up!</td>
														</tr>
													</tbody>
												</table>

												<p>Last but not least, our <a href="http://www.mockvault.com/blog/" style="color:#96B60E;" title="">blog</a> and <a href="http://support.mockvault.com/" style="color:#96B60E;" title="">support center</a> is up!</p>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<tr>
									<td><img alt="" src="http://www.mockvault.com/edms/images/line.gif" style="border:0px; height:3px; width:608px" /></td>
								</tr>
								<tr>
									<td>&nbsp;</td>
								</tr>
								<!-- /ROW -->
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tbody>
						</table>
						<!-- /Sections --><!-- Footer Bar -->

						<table border="0" cellpadding="0" cellspacing="0" style="width:610px">
							<tbody>
								<tr>
									<td>Sent by <a href="http://www.mockvault.com" style="color:#000000; text-decoration: underline;">mockvault.com</a>. Questions? Email <a href="mailto:support@mockvault.com" style="color:#000000; text-decoration: underline;">support@mockvault.com</a></td>
									<td>
									<table border="0" cellpadding="0" cellspacing="0" style="width:70px">
										<tbody>
											<tr>
												<td><a href="http://twitter.com/mockvault"><img alt="Twitter" src="http://www.mockvault.com/edms/images/twitter.gif" style="border:0px; height:25px; width:31px" /></a></td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td colspan="2">&nbsp;</td>
								</tr>
							</tbody>
						</table>
						</td>
					</tr>
					<tr>
						<td><img alt="" src="http://www.mockvault.com/edms/images/bottomshadow.png" style="border:0px; height:25px; width:666px" /></td>
					</tr>
					<tr>
						<td style="vertical-align:top"><span style="color:#ffffff; font-family:Arial,Helvetica,sans-serif; font-size:12px">Don&#39;t want to receive our infrequent newsletters anymore? You can unsubscribe.</span></td>
					</tr>
					<tr>
						<td style="vertical-align:top">&nbsp;</td>
					</tr>
				</tbody>
			</table>
			</td>
		</tr>
	</tbody>
</table>
</div>';
    MailConfig::sendMail('tttthan1996@gmail.com', 'test mail', $content);die();
        require '../vendor/autoload.php'; // If you're using Composer (recommended)
// Comment out the above line if not using Composer
// require("<PATH TO>/sendgrid-php.php");
// If not using Composer, uncomment the above line and
// download sendgrid-php.zip from the latest release here,
// replacing <PATH TO> with the path to the sendgrid-php.php file,
// which is included in the download:
// https://github.com/sendgrid/sendgrid-php/releases
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom("tthang7211@gmail.com", "Example User");
        $email->setSubject("Sending with SendGrid is Fun");
        $email->addTo("thangit19966@gmail.com", "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid(env('SENDGRID_API_KEY'));
        try {
            $response = $sendgrid->send($email);
            print $response->statusCode() . "\n";
            print_r($response->headers());
            print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }

//        try{
//            $data = ['test_message' => 'test thu email'];
////            Mail::to('tttthang1996@gmail.com')->send(new TestEmail($data));
//
//            $testmail = new TestEmail($data);
//            Mail::to('tttthang1996@gmail.com')->send($testmail->sendEmail('longmt2207@gmail.com','Sanketoan.vn thông báo2','Sanketoan2'));
//
//
////            MailConfig::sendMail('tttthang1996@gmail.com', 'aaa', 'bb');
//
//        }catch (\Exception $e)
//        {
//            $e->getMessage();
//
//        }



    }

	public function testSaveCv()
	{
		$user_id = 26345;
        $employee = \App\Entity\Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id', 'my_facebook'
        )->where('user_id', $user_id)->first();
		$cv_template = \App\Entity\Cv_template::select('*')->first();
		$cv_employee = \App\Entity\Cv_employee::select('*')->where('employee_id', 19034)->first();
		return view('site.cv4', compact('cv_employee','cv_template','employee'));
	}
}
