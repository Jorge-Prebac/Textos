<?php
namespace FacturaScripts\Plugins\Textos\Controller;
use FacturaScripts\Core\Lib\ExtendedController\EditController;
use FacturaScripts\Core\Base\DataBase\DataBaseWhere;

class EditGrupoTexto extends EditController

{
    public function getPageData(): array 
	{
	 
        $data = parent::getPageData();
		$data['menu'] = 'texts';
        $data["title"] = "text-groups";
        $data["icon"] = "fas fa-layer-group";
        return $data;
    }

	public function createViews()
    {
		parent::createViews();
		if ($this->user->can('ListTexto')) {
			//el usuario tiene acceso
			$this->createViewsListTextos();
			$this->setTabsPosition('left-bottom');
		};
    }

    public function createViewsListTextos(string $viewName = "ListTexto")
    {
 		$this->addListView($viewName, "Texto", "texts","fas fa-spell-check");
		$this->views[$viewName]->addOrderBy(['nombretexto'], 'text-name', 1);
		$this->views[$viewName]->addSearchFields(['nombretexto', 'note']);
    }

    protected function loadData($viewName, $view)
	{
        switch ($viewName) {
            case 'ListTexto':
                $where=[new DataBaseWhere('idgrupotexto',$this->getModel()->primaryColumnValue())];
                $view->loadData('', $where);

            break;

            default:
                parent::loadData($viewName, $view);
                break;
        }
	}

	public function getModelClassName(): string
	{
        return "GrupoTexto";
    }
}
