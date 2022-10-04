<?php
ob_start();
//token ro inja vared konid
define('API_KEY','5610525783:AAEo7pQgatXAtdCy2gJ-3xHP2Cp2QWMH8fs');
$admin = "336414094";
$admin2 = "336414094";
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
$boolean = file_get_contents('booleans.txt');
$booleans= explode("\n",$boolean);
$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$editm = $update->edited_message;
$message_id = $message->message_id;
$chat_id = $message->chat->id;
$fname = $message->chat->first_name;
$uname = $message->chat->username;
$text1 = $message->text;
$fadmin = $message->from->id;
$chatid = $update->callback_query->message->chat->id;
$data = $update->callback_query->data;
$reply = $update->message->reply_to_message->forward_from->id;
$forward = $update->message->forward_from;
$query=$update->callback_query;
$inline=$update->inline_query;
$channel_forward = $update->channel_post->forward_from;
$channel_text = $update->channel_post->text;
$messageid = $update->callback_query->message->message_id;
$reply = $update->message->reply_to_message;
$time=date("h:i:s");
$dat=json_decode(file_get_contents("http://api.gpmod.ir/time"),true);
$date=$dat['FAdate'];
$step=file_get_contents("type2.txt");
mkdir("matn");
$bolen=file_get_contents("bolen.txt");
$keyboard=json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[
['text'=>"تغییر پیام استارت"],['text'=>"تغییر پیام اشتباه"],
],
[
['text'=>"ارسال به همه"],['text'=>"تعداد کاربران"],
],
[
['text'=>"برگشت"],
]
]
]);
mkdir("matn");
if($text1=="/start"){
if($chat_id==$admin){
	$text=file_get_contents("matn/start.txt");
			$q=str_replace("FIRSTNAME","$fname",$text);
		$w=str_replace("USERNAME","$uname",$q);
		$e=str_replace("USERID","$fadmin",$w);
		$r=str_replace("TEXT","$text1",$e);
		$t=str_replace("DATE","$date",$r);
		$y=str_replace("TIME","$time",$t);
bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>$y,
	'parse_mode'=>"html",
]);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"بابایی جونم همین الان از بخش مدیریت ربات رو تنظیم کن😊",
'reply_markup'=>json_encode([
'resize_keyboard'=>true,
'keyboard'=>[
[
['text'=>"مدیریت ربات"],
],
]])
]);
	}else{
		$text=file_get_contents("matn/start.txt");
			$q=str_replace("FIRSTNAME","$fname",$text);
		$w=str_replace("USERNAME","$uname",$q);
		$e=str_replace("USERID","$fadmin",$w);
		$r=str_replace("TEXT","$text1",$e);
		$t=str_replace("DATE","$date",$r);
		$y=str_replace("TIME","$time",$t);
bot('sendmessage',[
	'chat_id'=>$chat_id,
	'text'=>$y,
	'parse_mode'=>"html",
]);


}
}elseif($text1=="مدیریت ربات" && $chat_id==$admin){
				bot('sendmessage',[
				'chat_id'=>$chat_id,
				'text'=>"به بخش مدیریت ربات خوش آمدید لطفا یک گزینه را بفرستید",
				'reply_markup'=>$keyboard,
				]);
				}elseif($text1=="تغییر پیام استارت" && $chat_id==$admin){
					file_put_contents("type2.txt","start");
					bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"لطفا متن جدید استارت رو بفرستید",
					]);
					
					
					}elseif($step=="start"){
						file_put_contents("type2.txt","qwer");
					 file_put_contents("matn/start.txt",$text1);
						bot('sendmessage',[
						'chat_id'=>$chat_id,
						'text'=>"متن با موفقیت تغییر کرد✅",
						'reply_markup'=>$keyboard,
						]);
						
						
						
						}elseif($text1=="تغییر پیام اشتباه" && $chat_id==$admin){
					file_put_contents("type2.txt","nocommand");
					
					bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"لطفا متنی که در صورت اشتباه بودن لینک فرستاده میشه رو بفرستید",
					]);
					
					
					}elseif($text1=="برگشت" && $chat_id==$admin){
					bot('sendmessage',[
					'chat_id'=>$chat_id,
					'text'=>"برگشتید به منوی اول",
					'reply_markup'=>json_encode([
					'resize_keyboard'=>true,
					'keyboard'=>[
					[
					['text'=>"مدیریت ربات"]
					]
					]
					
					])
					]);
						}elseif($step=="nocommand"){
						file_put_contents("type2.txt","qwer");
						file_put_contents("matn/nocommand.txt","$text1");
						bot('sendmessage',[
						'chat_id'=>$chat_id,
						'text'=>"متن با موفقیت تغییر کرد✅",
						'reply_markup'=>$keyboard,
						]);
							
						
				}elseif ($text1 =="ارسال به همه"  && $chat_id == $admin | $bolen="false") {
  {
      bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"لطفا متن خود را بنویسید تا به همه ی کاربرا ارسال کنم\n\nمیتونید از فرمت html هم استفاده کنید"
]);
  }
      $boolean = file_get_contents('bolen.txt');
      $booleans= explode("\n",$boolean);
      $addd = file_get_contents('banlist.txt');
      $addd = "true";
      file_put_contents('bolen.txt',$addd);
      
    }
      elseif($chat_id == $admin  && $bolen=="true") {
    $ttxtt = file_get_contents('membertest.txt');
    $membersidd= explode("\n",$ttxtt);
    for($y=0;$y<count($membersidd);$y++){
      bot('sendmessage',[
'chat_id'=>$membersidd[$y],
'text'=>$text1,
'parse_mode'=>"html",
]);
      
    }
    $memcout = count($membersidd)-1;
     {
     bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"پیام شما به همه ی مخاطبین ارسال شد✅"
]);
    }
         $addd = "false";
      file_put_contents('bolen.txt',$addd);

	}elseif( $text1 == 'تعداد کاربران'){
    $txtt = file_get_contents('membertest.txt');
    $member_id = explode("\n",$txtt);
    $mmemcount = count($member_id) -1;
    $user=file_get_contents("memberuser.txt");
  bot('sendMessage',[
      'chat_id'=>$chat_id,
      'text'=>"تعداد کاربران تا این لحظه : <b>$mmemcount </b>\n\nکاربران جدید\n\n ",
 'parse_mode'=>"html",
   ]);
	}else{
		$shorta=file_get_contents("http://yeo.ir/api.php?url=$text1");
	$short2="http://plink.ir/api?api=K91i5fDwoQ4p&url=$text1";
	$short1=json_decode(file_get_contents($short2),true);
	$shor2=$short1['short'];
	$short="https://api-ssl.bitly.com/v3/shorten?access_token=f2d0b4eabb524aaaf22fbc51ca620ae0fa16753d&longUrl=$text1";
	$shor=json_decode(file_get_contents($short),true);
	$ok=$shor['status_txt'];
	$link=$shor['data']['url'];
	if($ok=="OK"){
		bot('sendmessage',[
 'chat_id'=>$chat_id,
 'text'=>"لینک شما ساخته شد\nلینک اول \n".$link."\nلینک دوم\n".$shor2."\nلینک سوم\n".$shorta,
 'parse_mode'=>"html",
]);
		}
		else{
			$text=file_get_contents("matn/nocommand.txt","a+");
		$q=str_replace("FIRSTNAME","$fname",$text);
		$w=str_replace("USERNAME","$uname",$q);
		$e=str_replace("USERID","$fadmin",$w);
		$r=str_replace("TEXT","$text1",$e);
		$t=str_replace("DATE","$date",$r);
		$y=str_replace("TIME","$time",$t);
 bot('sendmessage',[
 'chat_id'=>$chat_id,
 'text'=>$y,
 'parse_mode'=>"html",
 ]);
 }}
		$txxt = file_get_contents("membertest.txt","a+");
    $pmembersid= explode("\n",$txxt);
    if (!in_array($chat_id,$pmembersid)){
      $aaddd = file_get_contents("membertest.txt");
      $aaddd .= $chat_id."\n";
      file_put_contents("membertest.txt",$aaddd);
}

?>