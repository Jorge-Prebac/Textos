<?php
/**
 * This file is part of Textos plugin for FacturaScripts
 * Copyright (C) 2026 Carlos Garcia Gomez <carlos@facturascripts.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace FacturaScripts\Plugins\Textos\Mod;

use FacturaScripts\Core\Contract\SalesModInterface;
use FacturaScripts\Core\Model\Base\SalesDocument;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Lib\AssetManager;
use FacturaScripts\Dinamic\Model\GrupoTexto;
use FacturaScripts\Dinamic\Model\Texto;
use FacturaScripts\Plugins\Textos\Lib\TextosHtmlModal;

/**
 * Description of SalesHeaderHTMLModTextos
 *
 * @author Jorge-Prebac <info@smartcuines.com>
 */
class SalesHeaderHTMLModTextos implements SalesModInterface
{
    public function apply(SalesDocument &$model, array $formData): void
	{
	}

    public function applyBefore(SalesDocument &$model, array $formData): void
	{
	}

    public function assets(): void
    {
		AssetManager::addCss(FS_ROUTE . '/Plugins/Textos/Assets/CSS/ModalTextos.css');
		AssetManager::addJs(FS_ROUTE . '/Plugins/Textos/Assets/JS/ModalTextos.js');
    }

	public function newBtnFields(): array
	{
		return ['texto'];
	}

	public function newFields(): array
	{
		return [];
	}

	public function newModalFields(): array
	{
		return [];
	}

    public function renderField(SalesDocument $model, string $field): ?string
    {
		if ($field === 'texto') {
			return TextosHtmlModal::renderTextGroupModal($model);
		}
        return null;
    }
}