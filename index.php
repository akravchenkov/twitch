<?php
/**
 * Готовая функция для работы с Twitch v5 API
 * @param $url
 * @param $post
 * @return bool|mixed
 */
class Twitch {

    public $channel_id = 'delicioustoxin'; // название канала
    
    function cURL($url, $post) {
        $url_self = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $url_self .= "s";
        }
        $url_self .= "://".$_SERVER["SERVER_NAME"];
        if ($_SERVER["SERVER_PORT"] != "80") {
            $url_self .= ":".$_SERVER["SERVER_PORT"];
        }

        if (substr($url_self, -1) != '/') {
            $url_self = $url_self.'/';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Client-ID: b3rudj39b54n6mdai2hndi84fets2tm'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_REFERER, $url_self);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        if ($post) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        $result = curl_exec($ch);
        $error = curl_error($ch);
        if ($error) {
            $result['curl_error'] = $error;
            return $result;
        }

        curl_close($ch);
        if ($result) {
            return $result;
        } else {
            return false;
        }
        
    }

    // Возвращает превью заданного стрима
    
	public function GetPreview()
	{
        $url = 'https://api.twitch.tv/kraken/streams/';
        $url .= $this->channel_id;
        
		$result =  $this->cURL("$url" ,null);
        $result = json_decode($result);
        
        return $preview = $result->stream->preview->large;


	}
    
    // Возвращает HTML проигрывателя для заданного стрима
    public function GetIframe() {
        
        $url = 'https://player.twitch.tv/?channel=';
        $url .= $this->channel_id;
        $url .= '&autoplay=false';
        
        return "<iframe class='stream' src='". $url ."' frameborder='0' allowfullscreen='true' scrolling='on' height='378' width='620'></iframe>";
        
    }
    
}

// Создаем экземпляр объекта класса Twitch
$strim = new Twitch();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, maximum-scale=1">
    <title>Twitch</title>
    <link rel="stylesheet" type="text/css" href="font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
   <div class="wrapper">
        
        <div class="box">
            <img class="img" src="<?php echo $strim->GetPreview(); ?>" alt="preview">

            <?php echo $strim->GetIframe(); ?>

            <span class="icon-play">
                <i class="fa fa-play-circle fa-4x" aria-hidden="true"></i>
            </span>
        </div>
        
    </div>
       
    <script src="https://embed.twitch.tv/embed/v1.js"></script>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/custom.js"></script>
</body>
</html>
