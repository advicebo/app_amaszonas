<?php
$primer_dia = mktime();
$ultimo_dia = mktime();
while(date("w",$primer_dia)!=1){
$primer_dia -= 3600;
}
while(date("w",$ultimo_dia)!=0){
$ultimo_dia += 3600;
}
echo "Primer día ".date("D Y-m-d",$primer_dia)."<br>";
echo "Hoy ".date("D Y-m-d",mktime())."<br>";
echo "Ultimo día ".date("D Y-m-d",$ultimo_dia)."<br>";
?>