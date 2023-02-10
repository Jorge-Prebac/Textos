<?php
namespace FacturaScripts\Plugins\Textos\Model;

use FacturaScripts\Core\Model\Base\ModelClass;
use FacturaScripts\Core\Model\Base\ModelTrait;

class GrupoTexto extends ModelClass
{
    use ModelTrait;

    public $idgrupotexto;

    public $nombregrupo;

    public $fecha;

    public function clear()
	{
        parent::clear();
        $this->fecha = date(ModelClass::DATE_STYLE);
    }

    public static function primaryColumn(): string
	{
        return "idgrupotexto";
    }

    public static function tableName(): string
	{
        return "grupostextos";
    }
}
