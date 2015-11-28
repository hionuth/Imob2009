<?php 
require_once(".././include/initialize.php");
$request = new RestRequest('http://api.magazinuldecase.ro');
$request->setPath('/imobile.json');
$request->setVerb('put');
$data = array (
    'key' => '2HVO01c20rHj0lB60jI50dwB',
    'tip_oferta' => 'vanzare',
    'categorie_imobil' => 'apartament',
    'zone_id' => '145',
    'orase_id' => '1',
    'strada_imobil' => 'Basarabia',
    'camere_imobil' => '2',
    'bai_imobil' => '1',
    'suprafata_imobil' => '56.00',
    'pret_imobil' => '60000',
    'pret_tva' => 'cu_tva',
    'pret_negociabil' => '1',
    'afiseaza_pmp' => '1',
    'incalzire_imobil' => 'centrala_zona',
    'etaj_imobil' => '8',
    'etajDin_imobil' => 'P+10',
    'an_constructie_imobil' => '1984',
    'terase_balcoane' => '1',
    'compartimentare' => 'decomandat',
    'info_imobil' => 'Confort 1, decomandat, , apometre, boxa la subsol, debara, interfon, lift, curent, apa curenta, canalizare, gaze, telefon; Vecinatati: magazine, RATB, parc, lac, supermarket, spital; cod SP01049',
    'Ylat' => '44.43383274527434',
    'Ylong' => '26.155072202682515',
    'telefon_proprietar' => '44932',
    'email' => 'igor.postovanu@simsparkman.ro',
    'id_intern' => 'SP01049',
);
$request->buildPostBody($data);
$request->execute();
$response = $request->getResponseBody();
print_r($response);
?>