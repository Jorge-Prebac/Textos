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

	public function primaryDescriptionColumn(): string
	{
		return 'nombretexto';
	}

    public static function tableName(): string
	{
        return "textos";
    }
	
	public function save(): bool
    {
        if (false === parent::save()) {
            return false;
        }

        // Save audit log
        $this->saveAuditMessage('updated-model');


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
