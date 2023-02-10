<?php
namespace FacturaScripts\Plugins\Textos\Controller;

class ListTexto extends \FacturaScripts\Core\Lib\ExtendedController\ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
		$data["menu"] = "texts";
        $data["title"] = "texts";
        $data["icon"] = "fas fa-spell-check";
        return $data;
    }

    protected function createViews()
    {
        $this->createViewsTexto();
    }

    protected function createViewsTexto(string $viewName = "ListTexto")
    {
        $this->addView($viewName, "Texto", "texts");
		$this->addOrderBy($viewName, ['nombretexto'], 'text-name', 1);
		$this->addSearchFields($viewName, ['nombretexto', 'note']);
    }
}
