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

	public function primaryDescriptionColumn(): string
	{
		return 'nombregrupo';
	}

    public static function tableName(): string
	{
        return "grupostextos";
    }
	
	public function save(): bool
    {

        // Save audit log
        $this->saveAuditMessage('updated-model');

        if (false === parent::save()) {
            return false;
        }

		return true;
    }

	public function delete(): bool
    {
        if (false === parent::delete()) {
            return false;
        }

        // Save audit log
        $this->saveAuditMessage('deleted-model');

        return true;
    }

	protected function saveAuditMessage(string $message)
    {
        self::toolBox()::i18nLog(self::AUDIT_CHANNEL)->info($message, [
            '%model%' => $this->modelClassName(),
            '%key%' => $this->primaryColumnValue(),
            '%desc%' => $this->primaryDescription(),
            'model-class' => $this->modelClassName(),
            'model-code' => $this->primaryColumnValue(),
            'model-data' => $this->toArray()
        ]);
    }
}
