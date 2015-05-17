<?php


	function verifyChecksumCOD($MerchantId , $OrderId, $Amount, $AuthDesc, $WorkingKey,  $CheckSum)
	{	
		$str = "";
		$str = "$MerchantId|$OrderId|$Amount|$AuthDesc|$WorkingKey";
		$adler = 1;
		$adler = adler32COD($adler,$str);
		if($adler==$CheckSum) return true;
		else return false;		
	}

	function getChecksumCOD($MerchantId, $OrderId, $Amount, $redirectUrl, $WorkingKey)  {
		$str = "$MerchantId|$OrderId|$Amount|$redirectUrl|$WorkingKey";
		$adler = 1;
		$adler = adler32COD($adler,$str);
		return $adler;
	}

	function adler32COD($adler , $str)
	{
		$BASE =  65521 ;

		$s1 = $adler & 0xffff ;
		$s2 = ($adler >> 16) & 0xffff;
		for($i = 0 ; $i < strlen($str) ; $i++)
		{
			$s1 = ($s1 + Ord($str[$i])) % $BASE ;
			$s2 = ($s2 + $s1) % $BASE ;
		}
		return leftshiftCOD($s2 , 16) + $s1;
	}

	function leftshiftCOD($str , $num)
	{

		$str = DecBin($str);

		for( $i = 0 ; $i < (64 - strlen($str)) ; $i++)
			$str = "0".$str ;

		for($i = 0 ; $i < $num ; $i++) 
		{
			$str = $str."0";
			$str = substr($str , 1 ) ;
			//echo "str : $str <BR>";
		}
		return cdecCOD($str) ;
	}

	function cdecCOD($num)
	{
		$dec=0;
		for ($n = 0 ; $n < strlen($num) ; $n++)
		{
		   $temp = $num[$n] ;
		   $dec =  $dec + $temp*pow(2 , strlen($num) - $n - 1);
		}

		return $dec;
	}

?>
