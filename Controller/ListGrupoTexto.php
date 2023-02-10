<?php
namespace FacturaScripts\Plugins\Textos\Controller;

class ListGrupoTexto extends \FacturaScripts\Core\Lib\ExtendedController\ListController
{
    public function getPageData(): array
    {
        $data = parent::getPageData();
        $data["menu"] = "texts";
        $data["title"] = "text-groups";
        $data["icon"] = "fas fa-layer-group";
        return $data;
    }

    protected function createViews()
    {
        $this->createViewsGrupoTexto();
    }

    protected function createViewsGrupoTexto(string $viewName = "ListGrupoTexto")
    {
        $this->addView($viewName, "GrupoTexto", "text-groups");
		$this->addOrderBy($viewName, ['nombregrupo'], 'group-name', 2);
		$this->addSearchFields($viewName, ['nombregrupo']);
     }
}
