<?php

class ActionController
{
    protected $app;

    public function __construct()
    {
        global $APPLICATION;
        $this->app = $APPLICATION;
    }

    public function menuAction(&$menu)
    {
        $dialog = new DialogMenu();
        $menu[] = array(
            "ICON" => "btn_new",
            "MENU" => [
                $dialog->createMenu(),
            ],
        );
    }

    public function createAction($request)
    {
        if($IBLOCK_ID = intval($request['ID'])){
            $this->app->RestartBuffer();

            $iblock = new IBlockComponent($IBLOCK_ID, $_REQUEST["TYPE"]);

            if($_REQUEST["IBLOCKCOPIES"] === 'SECTIONS')
                $iblock = new SectionDecorator($iblock);

            if($_REQUEST["IBLOCKCOPIES"] === 'ELEMENTS'){
                $iblock = new SectionDecorator($iblock);
                $iblock = new ElementDecorator($iblock);
            }

            $iblock->create();

            echo '<div style="text-align:center;"><p style="font-size: 16px">'. GetMessage('THEBRAINSE_COPYIBLOCK_MODULE_LIB_COPY_END') .'</p><a style="font-size: 20px" href="iblock_edit.php?type=&lang='.LANG.'&ID=&admin=Y">'. GetMessage('THEBRAINSE_COPYIBLOCK_MODULE_LIB_GO_TO_IB') .'</a></div>';
        }

        die();
    }
}
