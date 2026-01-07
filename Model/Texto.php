<?php
namespace FacturaScripts\Plugins\Textos\Model;

use FacturaScripts\Core\Tools;
use FacturaScripts\Core\Template\ModelClass;
use FacturaScripts\Core\Template\ModelTrait;

class Texto extends ModelClass
{
    use ModelTrait;

    public $idtexto;

    public $nombretexto;

    public $idgrupotexto;

    public $fecha;
	
	public $note;
	
    public function clear(): void
	{
        parent::clear();
		$this->fecha = Tools::date();
    }

    public static function primaryColumn(): string
	{
        return "idtexto";
    }

	public function primaryDescriptionColumn(): string
	{
		return 'nombretexto';
	}

    public static function tableName(): string
	{
        return "textos";
    }

	protected function onInsert(): void
    {
		// Save audit log
		$this->saveAuditMessage('inserted-model');
		parent::onInsert();
    }
	
    protected function onUpdate(): void
    {
		// Save audit log
		$this->saveAuditMessage('updated-model');
        parent::onUpdate();
    }

	protected function onDelete(): void
    {
		// Save audit log
		$this->saveAuditMessage('deleted-model');
		parent::onDelete();
    }

	protected function saveAuditMessage(string $message)
    {
		Tools::log('any_plg')->info($message, [
            '%model%' => $this->modelClassName(),
            '%key%' => $this->id(),
            '%desc%' => $this->primaryDescription(),
            'model-class' => $this->modelClassName(),
            'model-code' => $this->id(),
            'model-data' => $this->getDirty()
        ]);
    }
}
