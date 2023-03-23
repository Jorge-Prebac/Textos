<?php
namespace FacturaScripts\Plugins\Textos\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class Texto extends ModelClass
{
    use ModelTrait;

    public $idtexto;

    public $nombretexto;

    public $idgrupotexto;

    public $fecha;
	
	public $note;
	
    public function clear()
	{
        parent::clear();
        $this->fecha = date(ModelClass::DATE_STYLE);
    }

    public static function primaryColumn(): string
	{
        return "idtexto";
    }

    public static function tableName(): string
	{
        return "textos";
    }
	
	public function save(): bool
    {
		// add audit log
			self::toolBox()::i18nLog(self::AUDIT_CHANNEL)->info('updated-model', [
				'%model%' => $this->modelClassName(),
				'%key%' => $this->primaryColumnValue(),
				'%desc%' => $this->primaryDescription(),
				'model-class' => $this->modelClassName(),
				'model-code' => $this->primaryColumnValue(),
				'model-data' => $this->toArray()
			]);

		return parent::save();
    }
}
