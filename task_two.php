<?php
AddEventHandler("iblock", "OnBeforeIBlockElementDelete", ["myClass", "MyFunction"]);

class myClass
{
  public function MyFunction($arFields)
  {
    if ($arFields["SHOW_COUNTER"] > 10000) {
      global $USER;
      $event = ""; //идентификатор почтового события
      $lid = ""; //идентификатор сайта

      // массив с данными, которые передаются в почтовый шаблон, привязанный к почтовому событию
      // текст сообщения будет располагаться в шаблоне, переменные будут подставляться в текст вместо #VARIABLE_NAME#
      // таким образом администратор сможет изменить сообщение, редактируя почтовый шаблон
      $arMessage = [
        "USER_LOGIN" => $USER->GetLogin(),
        "USER_ID" => $USER->GetID(),
        "CATALOG_ITEM_NAME" => $arFields["NAME"],
        "SHOW_COUNTER" => $arFields["SHOW_COUNTER"]
      ];

      CEvent::SendImmediate
      (
        $event,
        $lid,
        $arMessage
      );

      global $APPLICATION;
      $APPLICATION->ThrowException('Нельзя удалить данный товар, так как он очень популярный на сайте');
      return false;
    }
  }
}