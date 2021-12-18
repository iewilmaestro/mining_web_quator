<?php
/*Menghapus error*/
error_reporting(0);

//Privat(terhubung dengan server
$master=array("iewil","quator","1.1");
//Lain-lain $n=enter $t=tab $r=
$n = "\n";$n2 = "\n\n";$t = "\t";$r="\r                              \r";

//Garis pemisah
$line=col(str_repeat('═',56),'u').$n;

//Memanggil fungsi banner
$bn=bn();c();
echo $bn;

/* Data yang di perlukan */
cookie:
$user_agent=Save('UserAgent');
$cookie=Save('Cookie');
//bn();

/*--------------------Bot--------------------*/

$ua=array();
$ua[]="cookie: ".$cookie;
$ua[]="user-agent: ".$user_agent;

$url="https://quator.io/";
$dash=$url."dashboard/";
$getB=$url."ajax/getBonus.php";
$Dist=$url."ajax/Distribution.php";

dash:
$r1=Run($dash,$ua);
if(preg_match('/has exceeded/',$r1)){
	goto dash;
	}
if(preg_match('/503 Service Unavailable/',$r1)){
	goto dash;
	}
$user=trim(strip_tags(explode('</h1>',explode('<div class="col-auto mt-2">',$r1)[1])[0]));

if($user <= null){
	unlink('Cookie');
	goto cookie;
	}

mining:
$r2=Run($dash,$ua);
if(preg_match('/has exceeded/',$r2)){
	goto mining;
	}
if(preg_match('/503 Service Unavailable/',$r2)){
	goto mining;
	}
$power=explode(';',explode('var allPower = ',$r2)[1])[0];//184;

preg_match_all('#<p class="mb-0 text-white">(.*?)</p>(.*?)<h4 class="my-1 text-white"><span id="(.*?)">(.*?)</span></h4>(.*?)<p class="mb-0 font-13 text-white">(.*?)<span id="(.*?)">(.*?)</span>(.*?)</p>#is',$r2,$coin);

c();
print $bn;
echo col($user,5)."\n\n";

for($i=0;$i<count($coin[1]);$i++){
	echo col($coin[1][$i],'h')." ".col($coin[4][$i],'p')."\n";
	echo col($coin[6][$i],'b').col("~> ",'m').col($coin[8][$i]." ".$coin[9][$i],'k')."\n";
	echo $line;
	}
$upower=$coin[8][0]+$coin[8][1]+$coin[8][2]+$coin[8][3];
$upower=$power-$upower;
echo col("All power ","h").col("~> ",'k').col($power,'p').col(" | ",'m').col('Free power ','h').col("~> ","k").col($upower,'p')."\n".$line;

bonus:
$r3=Run($dash."bonuses",$ua);
if(preg_match('/has exceeded/',$r3)){
	goto bonus;
	}
if(preg_match('/503 Service Unavailable/',$r3)){
	goto bonus;
	}
$tmr=explode(';',explode('var timeSeconds = ',$r3)[1])[0];//17229
if($tmr){tmr(10);goto mining;
	}else{
		$r4=json_decode(Run($getB,$ua,$data=1));
		$status=$r4->status;
		$ghs=$r4->ghs;
		if($tatus=='ok'){
			ket('Succes','Claim '.$ghs.' ghs');echo $line;
			}
	}

/*--------------------FUNGSI/RUMUS--------------------*/

//menghapus
function c(){system('clear');}

//Color/warna
function col($str,$color){
	if($color==5){$color=['h','k','b','u','m'][array_rand(['h','k','b','u','m'])];}
	$war=array('rw'=>"\033[107m\033[1;31m",'rt'=>"\033[106m\033[1;31m",'ht'=>"\033[0;30m",'p'=>"\033[1;37m",'a'=>"\033[1;30m",'m'=>"\033[1;31m",'h'=>"\033[1;32m",'k'=>"\033[1;33m",'b'=>"\033[1;34m",'u'=>"\033[1;35m",'c'=>"\033[1;36m",'rr'=>"\033[101m\033[1;37m",'rg'=>"\033[102m\033[1;34m",'ry'=>"\033[103m\033[1;30m",'rp1'=>"\033[104m\033[1;37m",'rp2'=>"\033[105m\033[1;37m");return $war[$color].$str."\033[0m";}

//Menyimpan data tanpa extensi
function Save($namadata){
	if(file_exists($namadata)){$datauser=file_get_contents($namadata);}else{$datauser=readline(col("Input ".$namadata,"rp1").col(' ≽','m')."\n");file_put_contents($namadata,$datauser);}
	return $datauser;}

//Keterangan/info
function ket($msg1,$msg2){echo col($msg1,'k').col(" ~> ",'h').col($msg2,'p')."\n";}

//Server iewil
function _iewil(){
	$url="https://iewilkey.000webhostapp.com/";
	return $url;}

//Fungsi get & post
function Run($url, $ua= 0, $data = 0) {while (True){
		$ch = curl_init();curl_setopt_array($ch, array(CURLOPT_URL => $url, CURLOPT_FOLLOWLOCATION => 1,));
        if($data){curl_setopt_array($ch, array(CURLOPT_POST => 1,CURLOPT_POSTFIELDS => $data,));}
        if($ua){curl_setopt_array($ch, array(CURLOPT_HTTPHEADER => $ua,));}
		curl_setopt_array($ch, array(CURLOPT_SSL_VERIFYPEER => 1,CURLOPT_RETURNTRANSFER => 1,CURLOPT_ENCODING => 'gzip',CURLOPT_COOKIEJAR => 'cookie.txt',CURLOPT_COOKIEFILE => 'cookie.txt',));
        $run = curl_exec($ch);curl_close($ch);
        if($run){return $run;}else{echo col("Check your connection!","rr");sleep(2);echo "\r                              \r";continue;}}}

//Data perangkat
function Apijs(){
	return json_decode(file_get_contents("http://ip-api.com/json"),1);}

//Banner
function bn(){global $master;iewil:if(!$master[0]=='iewil'){exit;}
	$data="ttl=$master[1]&ver=$master[2]&tz=".Apijs()["timezone"];
	$ban=Run(_iewil().'Data/ban.php','',$data);
	if(preg_match('/Server Error/',$ban)){sleep(2);goto iewil;}else{return $ban;}}

//Timer/waktu
function tmr($tmr){$timr=time()+$tmr;while(true):
	echo "\r                       \r";$res=$timr-time(); 
	if($res < 1){break;}
	echo col(date('H:i:s',$res),5);sleep(1);endwhile;}
