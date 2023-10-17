<?php
AddEventHandler("iblock", "OnBeforeIBlockElementUpdate", ["myClass", "MyFunction"]);

class myClass
{
  public function MyFunction($arFields)
  {
    logFile($arFields, "arFields");

    $strActiveFrom = explode(".", $arFields["ACTIVE_FROM"]);
    $strFormattedActiveFrom = $strActiveFrom[2] . $strActiveFrom[1] . $strActiveFrom[0];

    $active_from = new DateTime($strFormattedActiveFrom);
    $difference = date_diff(new DateTime(), $active_from)->days;

    if ($difference < 7) {
      global $APPLICATION;
      $APPLICATION->ThrowException('Товар ' . $arFields["NAME"] . ' был создан менее одной недели назад и не может быть изменен.');
      return false;
    }
  }
}