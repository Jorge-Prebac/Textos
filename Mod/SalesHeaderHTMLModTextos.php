<?php
/**
 * This file is part of Proyectos plugin for FacturaScripts
 * Copyright (C) 2023 Carlos Garcia Gomez <carlos@facturascripts.com>
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

use FacturaScripts\Core\Base\Contract\SalesModInterface;
use FacturaScripts\Core\Base\Translator;
use FacturaScripts\Core\Model\Base\SalesDocument;
use FacturaScripts\Core\Model\User;
use FacturaScripts\Dinamic\Model\GrupoTexto;

/**
 * Description of SalesHeaderHTMLModTextos
 *
 * @author Jorge-Prebac <info@prebac.com>
 */
class SalesHeaderHTMLModTextos implements SalesModInterface
{
    public function apply(SalesDocument &$model, array $formData, User $user)
    {
    }

    public function applyBefore(SalesDocument &$model, array $formData, User $user)
    {
    }

    public function assets(): void
    {
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

    public function renderField(Translator $i18n, SalesDocument $model, string $field): ?string
    {
		if ($field === 'texto') {
			return self::textGroup($i18n, $model);
		}
        return null;
    }

	private static function textGroup(Translator $i18n, SalesDocument $model): string
    {
        $html = '<div class="col-sm-auto">'
            . '<div class="form-group">'
			. '<button class="btn btn-primary" type="button" data-toggle="modal" data-target="#ModalTextGroups">'
            . '<i class="fas fa-spell-check"></i> ' . $i18n->trans('texts') . '</button>'
            . '</div>'
            . '</div>'
            . self::groupsTextModal($i18n, $model);
		return $html;
	}

	private static function groupsTextModal(Translator $i18n, SalesDocument $model): string
    {
        $gruposTextoModel = new GrupoTexto();
		$grupostextos = $gruposTextoModel->all([], ['nombregrupo' => 'ASC'], 0, 0);
		$html = '<div class="modal fade" id="ModalTextGroups" tabindex="-1" aria-labelledby="ModalTextGroupsLabel" aria-hidden="true">'
						. '<div class="modal-dialog modal-dialog-centered">'
						. '<div class="modal-content">'
						. '<div class="modal-header">'
						. '<i class="fas fa-layer-group fa-2x"></i>'
						. '<h5 class="modal-title">' . $i18n->trans('text-groups') . '</h5>'
						. '<button type="button" class="close" data-dismiss="modal" aria-label="Close">'
						. '<span aria-hidden="true">&times;</span>'
						. '</button>'
						. '</div>'
						. '<div class="modal-body">'
						. '<div class="form-row">'
						. '<ul>';
		if (count($grupostextos) > 0) {
			foreach ($grupostextos as $grupotexto) {
				$html .= '<li><a href= "' . $grupotexto->url() . '" target=_blank>' . $grupotexto->nombregrupo . '</a></li>';
			}
		} else {
			$html .= '<li><a href= "' . $gruposTextoModel->url() . '" target=_blank>' . $i18n->trans('create-new-record') . '</a></li>';
		}
		$html .= '</ul>'
						. '</div>'
						. '</div>'
						. '<div class="modal-footer">'
						. '<button type="button" class="btn btn-secondary" data-dismiss="modal">' . $i18n->trans('close') . '</button>'
						. '<button type="button" class="btn btn-primary" data-dismiss="modal">' . $i18n->trans('accept') . '</button>'
						. '</div>'
						. '</div>'
						. '</div>'
						. '</div>';
		return $html;
	}
}