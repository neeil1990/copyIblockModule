<?php


class ElementDecorator extends IBlockCreatorDecorator
{
    public function __construct(IBlockCreator $creator)
    {
        $this->IBlockComponent = $creator;
    }

    public function create()
    {
        $this->IBlockComponent->create();
        $this->createElement();
    }

    private function createElement()
    {
        $newIBlockID = $this->IBlockComponent->IBlockID;
        $oldIBlockID = $this->IBlockComponent->mainIBlock['ID'];

        $arElements = CIBlockMain::getElementsWithProperties($oldIBlockID);
        foreach ($arElements as $element){

            $element['IBLOCK_ID'] = $newIBlockID;
            $element['IBLOCK_SECTION_ID'] = null;

            $strGroups = [];
            $groups = CIBlockElement::GetElementGroups($element['ID'], true);
            while($group = $groups->Fetch())
                $strGroups[] = $group["ID"];

            $element['EXTERNAL_ID'] = implode(',', $strGroups) ?: "0";

            $el = new CIBlockElement;
            $ID = $el->Add($element);

            $this->setElementSection($newIBlockID, $ID);
        }
    }

    private function setElementSection($IBlockID, $ID)
    {
        if($arElement = CIBlockMain::getElement($ID)){
            $oldSections = explode(',', $arElement['EXTERNAL_ID']);

            $arSectionIDs = [];
            $sections = CIBlockSection::GetList([], ['IBLOCK_ID' => $IBlockID, 'EXTERNAL_ID' => $oldSections], true);
            while($section = $sections->GetNext())
                $arSectionIDs[] = $section['ID'];

            CIBlockElement::SetElementSection($arElement['ID'], $arSectionIDs);
        }
    }
}
