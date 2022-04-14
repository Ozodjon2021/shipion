<?php



$API_KEY = '5022785971:AAFwwuIxhTo6k9PI1hE1jmD5i0tHP1TP_F4'; 


define('API_KEY',$API_KEY);
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

$pin = "M2006";
$ega = "2057107939";

$update = json_decode(file_get_contents('php://input'));
$message_id = $update->message->message_id;
$message = $update->message;
$from_id = $message->from->id;
$chat_id = $message->chat->id;
$text = $message->text;
$data = $update->callback_query->data;
$message_id2 = $update->callback_query->message->message_id;
$chat_id2 = $update->callback_query->message->chat->id;


if ($text == '/start' and $chat_id == $ega) {

	bot('sendMessage',[
		'text'=>"Assalomu aleykum!",
		'chat_id'=>$ega
	]);
	# code...
}

if ($message and $text !== '/start' and $chat_id !== $ega) {


    $ttt = "/for_".$chat_id."_".$message_id;
	bot('sendMessage',[
		'text'=>$ttt,
		'chat_id'=>$ega
	]);

	bot('deleteMessage',[
		'message_id'=>$message_id,
		'chat_id'=>$chat_id
	]);
	bot('deleteMessage',[
		'message_id'=>$message_id-1,
		'chat_id'=>$chat_id
	]);	
	# code...
}

if (mb_stripos($text, '/for_') !== false and  $chat_id == $ega) {

    bot('deleteMessage',[
    	'message_id'=>$message_id,
    	'chat_id'=>$chat_id
    ]);
	$piin = explode(" ", $text)['1'];
	$from = explode("_", explode(" ", $text)[0])[1];
	$id = explode("_", explode(" ", $text)[0])[2];

	if ($piin == $pin) {

        bot('forwardMessage',[
        	'message_id'=>$id,
        	'chat_id'=>$ega,
        	'from_chat_id'=>$from
        ]);
        bot('sendMessage',[
        	'text'=>"Tepadagini o'chirish!",
        	'chat_id'=>$ega,
        	'reply_markup'=>json_encode([
        		'inline_keyboard'=>[
        			[['text'=>"!!O'chirish!!",'callback_data'=>"del"]]
        		]
        	])
        ]);
		# code...
	}



	# code...
}
if ($data == 'del' and $chat_id2 == $ega) {

	bot('deleteMessage',[
		'message_id'=>$message_id2,
		'chat_id'=>$chat_id2
	]);
	bot('deleteMessage',[
		'message_id'=>$message_id2-1,
		'chat_id'=>$chat_id2
	]);	
	# code...
}







?>
