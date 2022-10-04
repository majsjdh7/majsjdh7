<?php
/*
ارائه شده در چنل  تلگرام زکس وب هرگونه کپی برداری بدون ذکر منبع غیر مجاز
@ZxWeb
❗️به قوانین کپی رایت احترام بزارید❗️
*/

error_reporting(0);
date_default_timezone_set('Asia/Tehran');
define('API_KEY','0629363:AAHAzNxgLnERzv8-4pMWjvTOnz3o'); //توکنتون اینجا بزارید

$Update = json_decode(file_get_contents('php://input'));
if(isset($Update)){
    $telegram_ip_ranges = [['lower' => '149.154.160.0', 'upper' => '149.154.175.255'],['lower' => '91.108.4.0','upper' => '91.108.7.255']];
    $ip_dec = (float) sprintf('%u', ip2long($_SERVER['REMOTE_ADDR']));$ok=false;
    foreach ($telegram_ip_ranges as $telegram_ip_range) if(!$ok){
        $lower_dec = (float) sprintf('%u', ip2long($telegram_ip_range['lower']));
        $upper_dec = (float) sprintf('%u', ip2long($telegram_ip_range['upper']));
        if ($ip_dec >= $lower_dec and $ip_dec <= $upper_dec) $ok=true; 
    } if(!$ok) die("شو خش");
}
//============== Functions =============//
function mjfunc($method,$datas=[]){
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

function getStep($FromID){
	global $db;
	$res = $db->query("SELECT step FROM users WHERE user_id={$FromID}")->fetch_assoc();
	return $res['step'];
 }
 
 function setStep($FromID,$step){
	global $db;
	$res = $db->query("UPDATE users SET step ='".$step."' WHERE user_id=".$FromID);
	return $res;
 }
 
 function mjsend($FromID,$text,$markup=null){
 	mjfunc('sendMessage',[
 'chat_id'=>$FromID,
 'text'=>$text,
 'reply_markup'=>$markup]);
 }
//============== KeyBoards =============//
$menu = json_encode(['keyboard'=>[
    [['text'=>"نیم بها کردن"],['text'=>"کانال ما"]]
],'resize_keyboard'=>true,]);
$back = json_encode(['keyboard'=>[
    [['text'=>"بازگشت"]]
],'resize_keyboard'=>true,]);
$panel = json_encode(['keyboard'=>[
    [['text'=>"آمار"],['text'=>"بازگشت"]]
],'resize_keyboard'=>true,]);
//============== Variable ==============//
$Message = $Update->message;
$Text = $Message->text;
$MessageId = $Message->message_id;
$FromID = $Message->from->id;
$botuser = "PT3Nimbot";
$UserName = $Message->from->username;
$FirstName = $Message->from->firstname;
$channels = [
	'id'=> [
		'-336414094',
		'-336414094'
	],
	'link'=> [
		'https://t.me/Gladiator_Net',
		'https://t.me/Gladiator_Net'
	]
]; 
// ایدی عددی و لینک کانال هارو بالا بزارید
$dev = ['1709710851']; //ایدی عددی ادمین ها بصورت ارایه
//============== Channel Lock ==========//
$tch_1 = mjfunc('getchatMember', ['chat_id'=> $channels['id'][0], 'user_id'=> $FromID])->result->status;
$tch_2 = mjfunc('getchatMember', ['chat_id'=> $channels['id'][1], 'user_id'=> $FromID])->result->status;
//============== DataBase ==============//
global $db;
$db= new mysqli('localhost','user','password','name'); //اطلاعات دیتابیس
$db->query("SET NAMES 'utf8mb4'");
$db->query("SET CHARACTER SET utf8mb4");
$db->query("SET SESSION collaction_connecting = 'utf8mb4_unicode_ci'");
//============== Bots =============//
if($tch_1== 'left' || $tch_2=='left'){
	mjfunc('sendMessage',[
			'chat_id'=>$FromID,
			'text'=>"⚠️ برای حمایت از این ربات و جبران زحمت ها و هزینه های براورده شده لطفا عضو کانال های اسپانسر شوید ⚠️  سپس بر روی «تایید عضویت» کلیک کنید ✅",'reply_markup'=>json_encode(['inline_keyboard'=> [
				[['text'=> 'چنل اول', 'url'=> $channels['link'][0]], ['text'=> 'چنل دوم', 'url'=> $channels['link'][1]]],
				[['text'=>'تایید عضویت', 'url'=> "https://t.me/{$botuser}?start="]]
			]])]);
	die;
}
if($Text == "/start"){
	$num = $db->query("SELECT * FROM users WHERE user_id={$FromID}")->num_rows;
	if($num == 0){
		$db->query("INSERT INTO users (user_id, step) VALUES ('{$FromID}', 'home')");
			}
			mjsend($FromID,"سلام عزیزم خوشومدی یکی از گزینه های زیر رو انتخاب کن .",$menu);
			setStep($FromID,'home');
			
}

elseif($Text =='بازگشت'){
	mjsend($FromID,"به منوی اصلی برگشتی",$menu);
	setStep($FromID,'home');
}

if($Text == "نیم بها کردن"){
	mjsend($FromID,"لینک دانلودتو برای نیم بها شدن بفرست",$back);
	setStep($FromID, "nim");
	}
$step = getStep($FromID);
if($step == 'nim' && $Text != 'نیم بها کردن' && $Text != 'بازگشت'){
    $link1 = json_decode(file_get_contents("https://pejvaksource.nitro-cpanel.xyz/API/nim.php?link={$Text}"))->ok;
	if($link1 == false){
        
        mjsend($FromID, "لینک اشتباه است !\n\nمجدد ارسال کنید :");
        
    }else{
        mjsend($FromID, "لطفا کمی صبر کنید...\n\nتا پایان عملیات دستوری برای ربات ارسال نکنید !");
        
        $link = json_decode(file_get_contents("https://pejvaksource.nitro-cpanel.xyz/API/nim.php?link={$Text}"))->result->link;
       
        mjsend($FromID, "لینک شما نیم بها شد !\n\nLink :\n\n $link",$menu);
        setStep($FromID,'home');
        }
}
	
if($Text == "کانال ما" && $step != 'nim'){
	mjsend($FromID,"@Porteqal3 / @ZxWeb
	
سفارش انواع سورس ربات تلگرامی از : @MojtabaDark");
	}
	
if(in_array($FromID,$dev)){
	if($Text == 'پنل'){
		mjsend($FromID,"یکی از گزینه های زیرو انتخاب کن",$panel);
}
elseif ($Text == "آمار"){
		$num = $db->query("SELECT * FROM users")->num_rows;
		mjsend($FromID,"تعداد کاربران شما برابر با $num است");
	}
}