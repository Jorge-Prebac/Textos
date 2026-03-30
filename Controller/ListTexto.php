<?php
namespace FacturaScripts\Plugins\Textos\Controller;

use FacturaScripts\Core\Session;
use FacturaScripts\Core\Tools;
use FacturaScripts\Core\Lib\ExtendedController\ListController;

class ListTexto extends ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
		$data["menu"] = "texts";
        $data["title"] = "texts";
        $data["icon"] = "fa-solid fa-spell-check";
        return $data;
    }

    protected function createViews()
    {
		$user = Session::get('user');
		if (!false == $user->can('ListTexto')) {
			//el usuario tiene acceso
			$this->createViewsTexto();
		};
    }

    protected function createViewsTexto(string $viewName = "ListTexto")
    {
        $this->addView($viewName, "Texto", "texts");
		$this->addOrderBy($viewName, ['nombretexto'], 'text-name', 1);
		$this->addSearchFields($viewName, ['nombretexto', 'note']);
    }
}
