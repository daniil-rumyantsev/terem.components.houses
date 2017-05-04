<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die(); 
$arComponentDescription = array(
   "NAME" => "Прайс-лист компании",
   "DESCRIPTION" => "Выводит список цен на все дома",
   "PATH" => array(
      "ID" => "content",
      "CHILD" => array(
         "ID" => "catalog",
         "NAME" => "Прайс-лист"
      )
   ),
   "CACHE_PATH" => "Y",
   "COMPLEX" => "N"
);
?>