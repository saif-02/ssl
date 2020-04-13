<?php

include('include/common_functions.php');
$common = new commonFunctions();
$connect = $common->connect();

$fetch_site_details = mysqli_query($connect, "SELECT * FROM `site_details` WHERE parameter = 'site_url' ");
			$res_site_details = mysqli_fetch_array($fetch_site_details);
			$site_url = $res_site_details['value'];

			//var_dump($connect); exit();

		// $fetch_admins = mysqli_query($connect, "SELECT * FROM `all_users` WHERE `roleid` = 1 and `user_id` = '2' and email= 'anweshan.p@iverbinden.com' ");

			$fetch_admins = mysqli_query($connect, "SELECT * FROM `all_users` WHERE `roleid` = 1 and `user_id` = '31' and email= 'anweshan.p@iverbinden.com' ");

			// var_dump(mysqli_num_rows($fetch_admins)); exit();
		if(mysqli_num_rows($fetch_admins) > 0){

			while($res_ad = mysqli_fetch_array($fetch_admins)) {

				$user_id = $res_ad['user_id'];
				$admin_email = $res_ad['email'];
				$user_name = $res_ad['first_name'];


		$fetch_admin_details = mysqli_query($connect, "SELECT event_id FROM `all_users` WHERE `roleid` = 1 AND user_id = '".$user_id."' ");
		if(mysqli_num_rows($fetch_admin_details) > 0){

			while($res_admin = mysqli_fetch_array($fetch_admin_details)) {

				$events_array = explode(",",$res_admin['event_id']);
				if(count($events_array) > 0){
							//$arka = 0; 	 
				foreach ($events_array as $event) {
					$event_id = $event;	
					/*echo $arka;
					$arka++;*/		

	
			//*****************fetch all counts
		$fetch_event_data = mysqli_query($connect, "SELECT * FROM `all_events` WHERE `id` = '".$event_id."' AND date(event_end_date) >= date(now())");

			if(mysqli_num_rows($fetch_event_data) > 0)
			{
				$res_event = mysqli_fetch_array($fetch_event_data);
				$event_name = $res_event['event_name'];
			

		  $today_date = date("d-M-Y");

		  // ****************  NEW Functions   **************************//
		  $total_campaign = $common->get_daily_email_campaign_daily_notification($event_id);
		  //var_dump($total_campaign); exit();

		  //************* Resource addded today
		   $total_resource_today = $common->get_all_resource_added_today_daily_notification($event_id);

		  // **************** End of NEW Functions   **************************//

		   $total_speaker = $common->get_count_all_total_speakers_daily_notification($event_id);
		   $newly_added_speaker  = $common->get_newly_added_speakers_daily_notification($event_id);
		  // $newly_deleted_speaker = $common->get_newly_deleted_speakers_daily_notification($event_id);


		  $total_sponsor = $common->get_count_all_total_sponsors_daily_notification($event_id);
		   $newly_added_sponsors = $common->get_newly_added_sponsors_daily_notification($event_id); 
		  // $newly_deleted_sponsors = $common->get_newly_deleted_sponsors_daily_notification($event_id); 

		  
		  $total_master = $common->get_count_all_total_masters_daily_notification($event_id);
		   $newly_added_master = $common->get_newly_added_masters_daily_notification($event_id); 
		  //  $newly_deleted_master = $common->get_newly_deleted_masters_daily_notification($event_id); 
		  // $total_mail_sent = $common->get_count_all_total_mail_sent($event_id);
		  // $today_mail_sent = $common->get_count_today_mail_sent($event_id);

		  //******** Action section

		  //$fetch_today_action = $common->get_action_of_the_day($event_id); 


		  

		    $resource_html = '';
		  if(count($total_resource_today) > 0){

		    foreach ($total_resource_today as $resource_today) {

		       $resource_html .= '<tr>
					     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					      '.$resource_today['resource'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
					         '.$resource_today['category_name'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;"><a href="'.$resource_today['url'].'">'.$resource_today['url'].'</a>
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					          '.$resource_today['created_by_name'].'
					      </td>
					     
					</tr>';    
		    }
		  }else{
		  	$resource_html ='<tr align="left" ><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">No Resources has been added today!</td></tr>';
		  }



		  //**********  daily email template data binding **********//
		  $daily_campaign_html = '';
		  if(count($total_campaign) > 0){
		  	foreach ($total_campaign as $campaign) {
		  		$daily_campaign_html .= '<tr>
					<td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					          '.$campaign['template_name'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
					           '.$campaign['audience'].'
					      </td>
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
					        '.$campaign['template_used'].'
					      </td>    
					      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
					           '.$campaign['email_read'].'
					      </td>
					      
					</tr>';

		  	}

		  }else{
		  	$daily_campaign_html ='<tr align="left" ><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">No campaign has been sent today!</td></tr>';
		  }
		

		 $email_body = '<table cellspacing="0" cellpadding="0" width="700" align="center" style="border: 1px solid #f1f1f1;">
<tr>
<td>
<table cellpadding="5" cellspacing="0" width="100%" bgcolor="#007DB7" style="background: url('.$site_url.'/images/Banner_ab-01.jpg) center center no-repeat;background-size: cover;padding-top:10px; ">

<tr>
	<td align="center">
		<table cellpadding="5" cellspacing="0" width="100%";>
			<tr>
				<td style="width:20%;"><img src="'.$site_url.'/images/main-logo.png" width="180" alt="Speaker Engage" style="margin-top: 5px;margin-bottom:0px;"/>
				</td>
				<td style="width:70%;">
				   <h2 style="text-align: left;color: #fff;font-size: 36px;font-weight: 600;margin-top: 25px;margin-bottom: 0px;padding-left:45px;">
				     Hi '.$user_name.'!
				   </h2>
				</td>  
			</tr>   
		</table>   
	   <h3 style="text-align: center;color: #fff !important;font-size: 16px;font-weight: 400;margin-top: 10px;">Here is a quick summary of activities on your Speaker Engage for the last 24 hours!</h3>
	   <hr style="width: 200px;height: 1px;border: 0px;background:rgba(255, 255, 255, 0.7098039215686275);margin-top: 15px;opacity: 0.4;margin-bottom: 30px;" />
	</td>
<tr>
	<td style="padding:0px;">
		<table cellpadding="0" cellspacing="0" width="100%" bgcolor="" style="background: rgba(0, 0, 0, 0.43);color: #fff;padding: 5px 0px;">
			<tr>
			<td align="left" style="padding: 10px;">
			          '.strtoupper($event_name).'</b>
			      </td>
			      <td align="right" style="padding: 10px;">
			          '.$today_date.'
			      </td>
			</tr>
		</table>
	</td>
</tr> 
</tr>
</table>

<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
 <tr>
<td align="left" colspan="6" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;">

<table>
<tr>
<td valign="center" style="height: 40px;"><img src="'.$site_url.'/images/mail1.png" width="40" alt="Speaker Engage" style="margin-top: 5px;"/></td>
<td valign="center" style="height: 40px;">
<span style="font-weight: 600;padding-left: 10px;color: #db0566;font-size:24px;">Email Campaigns</span>
</td>
</tr>
</table>
         
     </td>
</tr>
 <tr>
   <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;">Email Subject</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;">Audience</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;"># Sent</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;"># Opened </th>
   
 </tr>
'.$daily_campaign_html.'

</table>


<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
<tr>
<td align="left" colspan="6" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;padding-top: 10px;">

<table>
<tr>
<td valign="center" style="height: 40px;"><img src="'.$site_url.'/images/Asset2.png" width="30" alt="Speaker Engage" style="margin-top: 5px;"/></td>
<td valign="center" style="height: 40px;">
<span style="font-weight: 600;padding-left: 10px;color: #db0566;font-size:24px;">Contact Summary</span>
</td>
</tr>
</table>
         
     </td>
</tr>
<tr>
   <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;width: 33.33%;">Contact Type</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 33.33%;">Current Total</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;width: 33.33%;">New</th>
 </tr>


<tr>
     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
          Speakers
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
          '.$total_speaker.'
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #222;">
           '.$newly_added_speaker.'
      </td>
     
</tr>

<tr>
     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
      Sponsors
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
         '.$total_sponsor.'
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #222;">
         '.$newly_added_sponsors.'
      </td>
     
</tr>

<tr>
     <td align="left" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;">
      Masters
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #f5f5f5;">
        '.$total_master.'
      </td>
      <td align="center" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color: #222;">
         '.$newly_added_master.'
      </td>
     
</tr>


</table>


<table cellpadding="0" cellspacing="0" width="100%" bgcolor="">
 <tr>
<td align="left" colspan="6" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ffff;font-size: 22px;color: #b51d55;padding-top: 10px;">

<table>
<tr>
<td valign="center" style="height: 40px;"><img src="'.$site_url.'/images/Asset3.png" width="35" alt="Speaker Engage" style="margin-top: 5px;"/></td>
<td valign="center" style="height: 40px;">
<span style="font-weight: 600;padding-left: 10px;color: #db0566;font-size:24px;">Resources Added</span>
</td>
</tr>
</table>
         
     </td>
</tr>
 <tr>
   <th align="left" style="padding: 10px;background: #0281a2;color: #fff;text-align: left;">Resource Name</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;"> Resource Category</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;">URL</th>
   <th align="center" style="padding: 10px;background: #0281a2;color: #fff;text-align: center;">Added By </th>
 </tr>

'.$resource_html.'

<tr>
	<td>
		<tr align="left">
			<td colspan="4" style="padding-top: 50px;padding-bottom: 45px;border-bottom: 1px solid #d7d8da;background: #fff;color:rgba(0, 0, 0, 0.66);text-align:center;">
				<a href="'.$site_url.'/login.php" style="background-color:#0281a2;padding:10px;color:#fff;text-decoration:none;border-radius:6px;font-size:14px;">Login to Speaker Engage</a>
			</td>
		</tr>
	</td>				
</tr>

<tr>
	<td>
		<tr align="left"><td colspan="4" style="padding: 10px;border-bottom: 1px solid #d7d8da;background: #ededed;color:rgba(0, 0, 0, 0.66);">Powered by SpeakerEngage.com</td>
		</tr>
	</td>						
</tr>
</table>
		';

			$email_header = "Speaker Engage : Activity notification for ".$event_name;

		     mysqli_query($connect, "INSERT INTO all_crud_logs(event_id,operation,created_at) VALUES ('".$event_id."','daily update notification',now())");
		     //$admin_email = "anweshan.developer@gmail.com"; 

		    $send_email = $common->sendEmail($admin_email , 'noreply@speakerengage.com', $email_header,$email_body,'Speaker Engage Team');

			} // fetch_event_data

		} //end of foreach

	} // end of if(count($events_array) > 0)



	} //end of while
		} //end of if(mysqli_num_rows($fetch_admin_details) > 0)


	} // first while
} //first if



?>