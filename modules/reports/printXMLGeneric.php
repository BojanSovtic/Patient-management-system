<?php

$dom = new DOMDocument('1.0', 'utf-8');
$root = $dom->createElement('bolesti');

$query = $_SESSION['reportP'];

$i = 0;
foreach ($query AS $key => $niz) {
    $bolest = $dom->createElement('bolest');
    $bolest->setAttribute('name', $key);


    $ispod18 = $niz['ispod18'];
    $izmedju18 = $niz['izmedju18i45'];
    $izmedju45 = $niz['izmedju45i65'];
    $iznad65 = $niz['iznad65'];

    $bolestIspod18 = $dom->createElement('ispod18', $ispod18);
    $bolest->appendChild($bolestIspod18);

    $bolestIzmedju18 = $dom->createElement('izmedju18i45', $izmedju18);
    $bolest->appendChild($bolestIzmedju18);

    $bolestIzmedju45 = $dom->createElement('izmedju45i65', $izmedju45);
    $bolest->appendChild($bolestIzmedju45);

    $bolestIznad65 = $dom->createElement('iznad65', $iznad65);
    $bolest->appendChild($bolestIznad65);

    $root->appendChild($bolest);

}
$dom->appendChild($root);

$file_name = "report.xml";
header('Content-Disposition: attachment;filename=' . $file_name);
header('Content-Type: text/xml');

ob_clean();
flush();
echo $dom->saveXML();
exit;
?>