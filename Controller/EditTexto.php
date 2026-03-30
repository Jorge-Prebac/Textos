<?php
namespace FacturaScripts\Plugins\Textos\Controller;

use FacturaScripts\Core\Tools;
use FacturaScripts\Core\Lib\ExtendedController\EditController;

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
        $data["icon"] = "fa-solid fa-spell-check";
        return $data;
    }
}
