<?php
namespace FacturaScripts\Plugins\Textos\Controller;
use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

class EditTexto extends EditController
{
    public function getModelClassName(): string
	{
        return "Texto";
    }

    public function getPageData(): array 
	{
        $data = parent::getPageData();
		$data["menu"] = "texts";
        $data["title"] = "texts";
        $data["icon"] = "fas fa-spell-check";
        return $data;
    }
}
