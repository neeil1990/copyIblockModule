<?php
IncludeModuleLangFile(__FILE__);

class thebrainstech_copyiblock extends CModule {
    public $MODULE_ID = "thebrainstech.copyiblock";

    function __construct(){

        $arModuleVersion = array();
        include(__DIR__.'/version.php');

        $this->MODULE_VERSION = $arModuleVersion['VERSION'];
        $this->MODULE_VERSION_DATE = $arModuleVersion['VERSION_DATE'];

        $this->MODULE_NAME = GetMessage('THEBRAINSE_COPYIBLOCK_MODULE_NAME');
        $this->MODULE_DESCRIPTION = GetMessage('THEBRAINSE_COPYIBLOCK_MODULE_DESC');
        $this->PARTNER_NAME = GetMessage('THEBRAINSE_COPYIBLOCK_PARTNER_NAME');
        $this->PARTNER_URI = GetMessage('THEBRAINSE_COPYIBLOCK_PARTNER_URL');
    }

    function DoInstall(){
        global $APPLICATION;
        $this->InstallFiles();
        RegisterModule($this->MODULE_ID);
        RegisterModuleDependences('main', 'OnAdminContextMenuShow', $this->MODULE_ID, 'Events','index');
        $APPLICATION->IncludeAdminFile(GetMessage('THEBRAINSE_COPYIBLOCK_MODULE_INSTALL'),$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/thebrainstech.copyiblock/install/step.php");
    }

    function DoUninstall(){
        global $APPLICATION;
        $this->UnInstallFiles();
        UnRegisterModule($this->MODULE_ID);
        UnRegisterModuleDependences('main', 'OnAdminContextMenuShow', $this->MODULE_ID, 'Events','index');
        $APPLICATION->IncludeAdminFile(GetMessage('THEBRAINSE_COPYIBLOCK_MODULE_UNINSTALL'),$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/thebrainstech.copyiblock/install/unstep.php");
    }

}
