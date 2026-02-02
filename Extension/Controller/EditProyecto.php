<?php
/**
 * This file is part of Anticipos plugin for FacturaScripts
 * Copyright (C) 2025 Carlos Garcia Gomez <carlos@facturascripts.com>
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

namespace FacturaScripts\Plugins\Textos\Extension\Controller;

use Closure;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Lib\AssetManager;
use FacturaScripts\Dinamic\Model\Texto;

/**
 * Description of EditProyecto
 *
 * @author Jorge-Prebac <info@smartcuines.com>
 */
 
class EditProyecto
{
    public function createViews(): Closure
    {
        return function () {
            parent::createViews();

            AssetManager::addCss(FS_ROUTE . '/Plugins/Textos/Assets/CSS/ModalTextos.css');
            AssetManager::addJs(FS_ROUTE . '/Plugins/Textos/Assets/JS/ModalTextos.js');

            // --- INICIO DE GENERACIÓN DEL MODAL HTML COMPLETO EN PHP ---
            // 1. Cargamos los datos para la tabla dentro del modal
            $textoModel = new Texto();
            $orderBy = ['nombretexto' => 'ASC'];
            $allTexts = $textoModel->all([], $orderBy, 0, 0);

            // 2. Construir el HTML completo del modal directamente en PHP.
            // El ID 'modalTextGroups' coincide exactamente con data-bs-target del botón.
            $modalHtml = '<div class="modal fade" id="modalTextGroups" tabindex="-1" aria-labelledby="modalTextGroupsLabel" aria-hidden="true">'
                . '<div class="modal-dialog modal-dialog-centered modal-lg">'
                . '<div class="modal-content">'
                // --- modal-header ---
                . '<div class="modal-header">'
                . '<i class="fa-solid fa-layer-group fa-2x me-2"></i>'
                . '<h5 class="modal-title me-auto" id="modalTextGroupsLabel">' . Tools::trans('texts') . '</h5>'
                . '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="' . Tools::trans('close') . '"></button>'
                . '</div>'
                // --- modal-body ---
                . '<div class="modal-body">';

            // Contenido de búsqueda
            $modalHtml .= '<div class="row mb-3">'
                . '<div class="col-md-6"><input type="text" id="searchInputName" onkeyup="FS_Textos.filterTextosTable()" placeholder="' . Tools::trans('search-by-name') . '..." class="form-control" tabindex="-1"></div>'
                . '<div class="col-md-6"><input type="text" id="searchInputNote" onkeyup="FS_Textos.filterTextosTable()" placeholder="' . Tools::trans('search-by-notes') . '..." class="form-control" tabindex="-1"></div>'
                . '</div>';

            // Contenido de la tabla de textos
            if (count($allTexts) > 0) {
                $modalHtml .= '<div class="table-responsive">'
                    . '<table class="table table-striped table-hover table-sm" id="textosTable">'
                    . '<thead><tr>'
                    . '<th>' . Tools::trans('text-name') . '</th>'
                    . '<th>' . Tools::trans('notes') . '</th>'
                    . '<th>' . Tools::trans('action') . '</th>'
                    . '</tr></thead><tbody>';

                foreach ($allTexts as $texto) {
                    $editorUrl = $texto->url();
                    $noteAttrValue = htmlspecialchars($texto->note, ENT_QUOTES | ENT_HTML5);

                    $modalHtml .= '<tr>'
                        . '<td>' . htmlspecialchars($texto->nombretexto) . '</td>'
                        . '<td><div class="truncate-lines">' . htmlspecialchars($texto->note) . '</div></td>'
                        . '<td>'
                        . '<button type="button" class="btn btn-sm btn-light-grey me-1" onclick="event.stopPropagation(); FS_Textos.copyToClipboard(this)" data-note="' . $noteAttrValue . '" title="' . Tools::trans('copy-to-clipboard') . '" tabindex="-1"><i class="fas fa-copy"></i></button>'
                        . '<a href="' . $editorUrl . '" target="_blank" class="btn btn-sm btn-light-grey" title="' . Tools::trans('edit-text') . '" tabindex="-1"><i class="fas fa-edit"></i></a>'
                        . '</td>'
                        . '</tr>';
                }
                $modalHtml .= '</tbody></table></div>';
            } else {
                $modalHtml .= '<p>' . Tools::trans('no-texts-found') . '</p>';
            }

            $modalHtml .= '</div>' // Cierre de modal-body
                . '</div>' // Cierre de modal-content
                . '</div>' // Cierre de modal-dialog
                . '</div>'; // Cierre de modal fade
            // --- FIN DE GENERACIÓN DEL MODAL HTML COMPLETO ---

            // 3. Inyectar este HTML en el DOM usando JavaScript.
            // Codificamos el HTML para que sea una cadena JSON segura en JS.
            $encodedModalHtml = json_encode($modalHtml);

            // Creamos un script que se añadirá al final del body y que inyectará el modal.
            $script = <<<JS
			document.addEventListener('DOMContentLoaded', function() {
				var modalContainer = document.createElement('div');
				modalContainer.innerHTML = {$encodedModalHtml};
				document.body.appendChild(modalContainer.firstChild); // Añadir el modal al final del body
			});
			JS;
            // Utilizamos AssetManager::addJs para añadir scripts inline (data-uri)
            AssetManager::addJs('data:text/javascript;base64,' . base64_encode($script));
        };
    }
}