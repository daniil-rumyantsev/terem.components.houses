<?php

//Собираем ID и NAME категорий
$IBLOCK_ID = 13;

$F = Array(
    'IBLOCK_ID' => $IBLOCK_ID,
    'ACTIVE' => 'Y'
);

$S = CIBlockSection::GetList(Array("SORT" => "ASC"), $F, true);
$arResult["categories"] = Array();
$cnt = 0;

while ($Section = $S->Fetch()) 
{
    $arResult["categories"][$cnt]['ID'] = $Section['ID'];
    $arResult["categories"][$cnt]['NAME'] = $Section['NAME'];
    $cnt++;
}

//Собираем все дома в массив с категориями

foreach ($arResult["categories"] as $key => $Category) 
{
    $Select = Array(
        "ID",
        "NAME",
        "PROPERTY_SIZER",
        "PROPERTY_KARKAS_VARIANTS_HOUSE",
        "PROPERTY_BRUS_VARIANTS_HOUSE",
        "PROPERTY_KIRPICH_VARIANTS_HOUSE",
    );
    
    $Filter = Array("IBLOCK_ID" => 13, "SECTION_ID" => $Category["ID"], "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
    $res = CIBlockElement::GetList(Array("SORT" => "ASC"), $Filter, false, Array("nPageSize" => 500), $Select);
    $counter = 0;

    while ($ob = $res->Fetch()) 
    {
        $arResult["categories"][$key]["HOUSES"][$counter] = $ob;

		if(count($ob["PROPERTY_KARKAS_VARIANTS_HOUSE_VALUE"]) > 0)
		{
            foreach($ob["PROPERTY_KARKAS_VARIANTS_HOUSE_VALUE"] as $val)
            {
                $arSelects = Array(
                    "ID",
                    "NAME",
                    "PROPERTY_TEHNOLOGY_HOUSE",
                    "PROPERTY_PRICE_HOUSE",
                    "PROPERTY_ID_CALCULATOR",
                    "PROPERTY_LINK",
                );

                $arFilters = Array(
                    "IBLOCK_ID" => 21,
                    "ID" => $val,
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y"
                );

                $ress = CIBlockElement::GetList(
                    Array("SORT" => "ASC"),
                    $arFilters,
                    false,
                    Array(),
                    $arSelects
                );

                while ($obs = $ress->Fetch()) 
                {
                    $Sel = Array(
                        "ID",
                        "PROPERTY_PRICE_1",
                        "PROPERTY_DISCONT1",
                        "PROPERTY_LINK",
                    );

                    $Filt = Array(
                        "IBLOCK_ID" => 22,
                        "ID" => $obs['PROPERTY_PRICE_HOUSE_VALUE'],
                        "ACTIVE" => "Y"
                    );

                    $r = CIBlockElement::GetList(
                        Array("SORT" => "ASC"),
                        $Filt,
                        false,
                        Array(),
                        $Sel
                    );

                    while ($o = $r->Fetch())
                    {
                        $price = $o['PROPERTY_PRICE_1_VALUE'];
                        $arResult["categories"][$key]["HOUSES"][$counter]['LINK'] = $o['PROPERTY_LINK_VALUE'];
                        $discount1 = 30;
                        if($o['PROPERTY_DISCONT1_VALUE'] != NULL && $o['PROPERTY_DISCONT1_VALUE'] > 0)
                        {
                            $discount1 =  $o['PROPERTY_DISCONT1_VALUE'];
                        }
                    }
																// echo "<pre>";var_dump($arResult["categories"][$key]["HOUSES"][$counter]['LINK']);die();
                    if($obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'] == 'Каркасный 200')
                    {
                        $arResult["categories"][$key]["HOUSES"][$counter]['KARKAS']['POST'] = $price; //$obs['PROPERTY_PRICE_HOUSE_VALUE'].'- '.$val.' '.$obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'].' '.$price;
                    } 
                    else 
                    {
                        $arResult["categories"][$key]["HOUSES"][$counter]['KARKAS']['LETO'] = $price; //$obs['PROPERTY_PRICE_HOUSE_VALUE'].'- '.$val.' '.$obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'].' '.$price;

                        $file = '/var/www/zolotarev/data/www/terem-pro.ru/upload/calcs/' . $obs["PROPERTY_ID_CALCULATOR_VALUE"] . '/calc_' .$obs["PROPERTY_ID_CALCULATOR_VALUE"] . '.data';
                        $f = fopen($file, 'r');
                        $file_data = fread($f, filesize($file));
                        fclose($f);

                        $result = unserialize($file_data);
                        if ($result[0]["NAME"] == 'Пакет Оптимальный' || $result[0]["NAME"] == 'Пакет  Оптимальный')
                        {

                            $price_opt = 0;
                            $test = 0;

                            foreach ($result[0]["ITEMS"] as $i) {
                                $p = (int) $i['PRICE'];
                                $test = $test + $p;
                                $price_opt = $price_opt + ($p - (($p * $discount1) / 100));
                            }

                            $str = $arResult["categories"][$key]["HOUSES"][$counter]['KARKAS']['LETO'].'000';
                            $arResult["categories"][$key]["HOUSES"][$counter]['KARKAS']['ZIMA'] =  $str + $price_opt;

                    	}
                    }
                }
            }
        }

        if(count($ob["PROPERTY_BRUS_VARIANTS_HOUSE_VALUE"]) > 0)
        {
            foreach($ob["PROPERTY_BRUS_VARIANTS_HOUSE_VALUE"] as $val){

                $arSelects = Array(
                    "ID",
                    "NAME",
                    "PROPERTY_TEHNOLOGY_HOUSE",
                    "PROPERTY_PRICE_HOUSE",
                    "PROPERTY_ID_CALCULATOR",
                );

                $arFilters = Array(
                    "IBLOCK_ID" => 21,
                    "ID" => $val,
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y"
                );

                $ress = CIBlockElement::GetList(
                    Array("SORT" => "ASC"),
                    $arFilters,
                    false,
                    Array(),
                    $arSelects
                );

                while ($obs = $ress->Fetch()) 
                {
                    $Sel = Array(
                        "ID",
                        "PROPERTY_PRICE_1",
                        "PROPERTY_DISCONT1",
                        "PROPERTY_LINK",
                    );

                    $Filt = Array(
                        "IBLOCK_ID" => 22,
                        "ID" => $obs['PROPERTY_PRICE_HOUSE_VALUE'],
                        "ACTIVE" => "Y"
                    );

                    $r = CIBlockElement::GetList(
                        Array("SORT" => "ASC"),
                        $Filt,
                        false,
                        Array(),
                        $Sel
                    );

                    while ($o = $r->Fetch())
                    {
                        $price = $o['PROPERTY_PRICE_1_VALUE'];

                        $discount1 = 30;
                        if($o['PROPERTY_DISCONT1_VALUE'] != NULL && $o['PROPERTY_DISCONT1_VALUE'] > 0){
                            $discount1 =  $o['PROPERTY_DISCONT1_VALUE'];
                        }
                    }

                    if($obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'] == 'Брус клееный 180')
                    {
                        $arResult["categories"][$key]["HOUSES"][$counter]['BRUS']['POST'] = $price;//$obs['PROPERTY_PRICE_HOUSE_VALUE'].'- '.$val.' '.$obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'].' '.$price;

                    }
                    else
                    {
                        $arResult["categories"][$key]["HOUSES"][$counter]['BRUS']['LETO'] = $price;//$obs['PROPERTY_PRICE_HOUSE_VALUE'].'- '.$val.' '.$obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'].' '.$price;

                        $file = '/var/www/zolotarev/data/www/terem-pro.ru/upload/calcs/' . $obs["PROPERTY_ID_CALCULATOR_VALUE"] . '/calc_' .$obs["PROPERTY_ID_CALCULATOR_VALUE"] . '.data';
                        $f = fopen($file, 'r');
                        $file_data = fread($f, filesize($file));
                        fclose($f);

                        $result = unserialize($file_data);
                        if ($result[0]["NAME"] == 'Пакет Оптимальный' || $result[0]["NAME"] == 'Пакет  Оптимальный'){

                            $price_opt = 0;
                            $test = 0;
							
                            foreach ($result[0]["ITEMS"] as $i)
							{
                                $p = (int) $i['PRICE'];
                                $test = $test + $p;
                                $price_opt = $price_opt + ($p - (($p * $discount1) / 100));
                            }

                            $str = $arResult["categories"][$key]["HOUSES"][$counter]['BRUS']['LETO'].'000';
                            $arResult["categories"][$key]["HOUSES"][$counter]['BRUS']['ZIMA'] =  $str + $price_opt;

                        }
                    }
                }
            }
        }

        if(count($ob["PROPERTY_KIRPICH_VARIANTS_HOUSE_VALUE"]) > 0)
        {
            foreach($ob["PROPERTY_KIRPICH_VARIANTS_HOUSE_VALUE"] as $val)
            {
                $arSelects = Array(
                    "ID",
                    "NAME",
                    "PROPERTY_TEHNOLOGY_HOUSE",
                    "PROPERTY_PRICE_HOUSE",
                    "PROPERTY_ID_CALCULATOR",
                );

                $arFilters = Array(
                    "IBLOCK_ID" => 21,
                    "ID" => $val,
                    "ACTIVE_DATE" => "Y",
                    "ACTIVE" => "Y"
                );

                $ress = CIBlockElement::GetList(
                    Array("SORT" => "ASC"),
                    $arFilters,
                    false,
                    Array(),
                    $arSelects
                );

                while ($obs = $ress->Fetch()) 
                {
                    $Sel = Array(
                        "ID",
                        "PROPERTY_PRICE_1",
                        "PROPERTY_DISCONT1",
                        "PROPERTY_LINK",
                    );

                    $Filt = Array(
                        "IBLOCK_ID" => 22,
                        "ID" => $obs['PROPERTY_PRICE_HOUSE_VALUE'],
                        "ACTIVE" => "Y"
                    );

                    $r = CIBlockElement::GetList(
                        Array("SORT" => "ASC"),
                        $Filt,
                        false,
                        Array(),
                        $Sel
                    );

                    while ($o = $r->Fetch())
                    {
                        $price = $o['PROPERTY_PRICE_1_VALUE'];
                        $discount1 = 30;
                        if($o['PROPERTY_DISCONT1_VALUE'] != NULL && $o['PROPERTY_DISCONT1_VALUE'] > 0)
                        {
                            $discount1 =  $o['PROPERTY_DISCONT1_VALUE'];
                        }
                    }


                    if($obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'] == 'Кирпичный')
                    {
                        $arResult["categories"][$key]["HOUSES"][$counter]['KIRP']['POST'] = $price;//$obs['PROPERTY_PRICE_HOUSE_VALUE'].'- '.$val.' '.$obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'].' '.$price;
                    }
                    else
                    {
                        $arResult["categories"][$key]["HOUSES"][$counter]['KIRP']['LETO'] = $price;//$obs['PROPERTY_PRICE_HOUSE_VALUE'].'- '.$val.' '.$obs['PROPERTY_TEHNOLOGY_HOUSE_VALUE'].' '.$price;

                        $file = '/var/www/zolotarev/data/www/terem-pro.ru/upload/calcs/' . $obs["PROPERTY_ID_CALCULATOR_VALUE"] . '/calc_' .$obs["PROPERTY_ID_CALCULATOR_VALUE"] . '.data';
                        $f = fopen($file, 'r');
                        $file_data = fread($f, filesize($file));
                        fclose($f);

                        $result = unserialize($file_data);
                        if ($result[0]["NAME"] == 'Пакет Оптимальный' || $result[0]["NAME"] == 'Пакет  Оптимальный')
                        {
                            $price_opt = 0;
                            $test = 0;

                            foreach ($result[0]["ITEMS"] as $i) 
                            {
                                $p = (int) $i['PRICE'];
                                $test = $test + $p;
                                $price_opt = $price_opt + ($p - (($p * $discount1) / 100));
                            }

                            $str = $arResult["categories"][$key]["HOUSES"][$counter]['KIRP']['LETO'].'000';
                            $arResult["categories"][$key]["HOUSES"][$counter]['KIRP']['ZIMA'] =  $str + $price_opt;
                        }
                    }
                }
            }
        }
        $counter++;
    }
}

$this->IncludeComponentTemplate();
      
?>