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
        $this->idgrupotexto = 0;
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
}
