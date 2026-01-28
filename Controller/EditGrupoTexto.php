<?php
namespace FacturaScripts\Plugins\Textos\Controller;

use FacturaScripts\Core\Session;
use FacturaScripts\Core\Tools;
use FacturaScripts\Core\Where;
use FacturaScripts\Core\Lib\ExtendedController\EditController;

class EditGrupoTexto extends EditController

{
    public function getPageData(): array 
	{
	 
        $data = parent::getPageData();
		$data['menu'] = 'texts';
        $data["title"] = "text-groups";
        $data["icon"] = "fa-solid fa-layer-group";
        return $data;
    }

	public function createViews()
    {
		parent::createViews();

		$user = Session::get('user');
		if (!false == $user->can('ListTexto')) {
			//el usuario tiene acceso
			$this->createViewsListTextos();
			$this->setTabsPosition('start-bottom');
		};
    }

    public function createViewsListTextos(string $viewName = "ListTexto")
    {
 		$this->addListView($viewName, "Texto", "texts","fa-solid fa-spell-check");
		$this->views[$viewName]->addOrderBy(['nombretexto'], 'text-name', 1);
		$this->views[$viewName]->addSearchFields(['nombretexto', 'note']);
    }

    protected function loadData($viewName, $view)
	{
        switch ($viewName) {
            case 'ListTexto':
				$where = [Where::eq('idgrupotexto',$this->getModel()->id())];
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
