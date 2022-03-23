<?php
$url = $_SERVER['QUERY_STRING'];

// take off the c=
$url = substr($url, 2);

if ($url != '' && substr($url, 0, 1) == '0-') {

$data = file_get_contents("https://catalogapi.zee5.com/v1/channel/${url}");
if ($data != false) {
    $z5 = json_decode($data, true);
    $stream = $z5['stream_url_hls'];
} else echo "Catalog API either does not answer, or channel isn't available.";


$tdata = file_get_contents("https://useraction.zee5.com/token/live.php");
if ($tdata != false) {
    $tok = json_decode($tdata, true);
    $vid_token = $tok['video_token'];
    $m3u8 = $stream.$vid_token;

    header("Location: $m3u8");
} else echo "Token couldn't be given, cannot redirect you to link. Try to access manually into the token site, and add it to url" . $url;

} else echo "Either no channel ID has been given, or an error has occurred while getting the channel.";
?>
