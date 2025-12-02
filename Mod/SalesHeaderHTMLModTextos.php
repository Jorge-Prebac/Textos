<?php
/**
 * This file is part of Textos plugin for FacturaScripts
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
 
namespace FacturaScripts\Plugins\Textos\Mod;

use FacturaScripts\Core\Contract\SalesModInterface;
use FacturaScripts\Core\Model\Base\SalesDocument;
use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Model\GrupoTexto;
use FacturaScripts\Dinamic\Model\Texto;

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
        $btnCopyText = Tools::trans('copy');
        echo <<<JS
<script>
    function copyToClipboard(buttonElement) {
        const text = buttonElement.getAttribute('data-note');
        navigator.clipboard.writeText(text).then(function() {
            const originalIconHTML = buttonElement.innerHTML;
            const originalTitle = buttonElement.title;
            buttonElement.classList.remove('btn-light-grey');
            buttonElement.classList.add('btn-success');
            buttonElement.innerHTML = '<i class="fas fa-check"></i>';
            buttonElement.title = 'Copiado';

            setTimeout(() => {
                buttonElement.innerHTML = originalIconHTML;
                buttonElement.classList.remove('btn-success');
                buttonElement.classList.add('btn-light-grey');
                buttonElement.title = originalTitle;
            }, 3000); // 3 segundos
        }, function(err) {
            console.error('No se pudo copiar el texto: ', err);
            alert("Error al copiar texto."); 
        });
        buttonElement.blur();
    }
    function filterTextosTable() {
        var inputName, filterName, inputNote, filterNote, table, tr, tdName, tdNote, i, txtValueName, txtValueNote;
        
        inputName = document.getElementById("searchInputName");
        filterName = inputName.value.toUpperCase();
        inputNote = document.getElementById("searchInputNote");
        filterNote = inputNote.value.toUpperCase();
        table = document.getElementById("textosTable");
        var tbody = table.getElementsByTagName("tbody")[0];
        if (!tbody) return;
        tr = tbody.getElementsByTagName("tr"); 
        for (i = 0; i < tr.length; i++) {
            tdName = tr[i].getElementsByTagName("td")[0]; 
            tdNote = tr[i].getElementsByTagName("td")[1]; 
            if (tdName && tdNote) {
                txtValueName = tdName.textContent || tdName.innerText;
                txtValueNote = tdNote.textContent || tdNote.innerText;
                if (txtValueName.toUpperCase().indexOf(filterName) > -1 && txtValueNote.toUpperCase().indexOf(filterNote) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
    document.addEventListener('DOMContentLoaded', (event) => {
        const modalElement = document.getElementById('ModalTextGroups');
        if (modalElement) {
            modalElement.addEventListener('hide.bs.modal', function () {
                this.blur();
            });
        }
    });
</script>
<style>
    .btn-light-grey {
        background-color: #e2e6ea; /* Gris claro */
        border-color: #dae0e5;
        color: #383d41;
    }
    .btn-light-grey:hover {
        background-color: #d3dbe2;
    }
    #ModalTextGroups .modal-body { min-height: 300px; overflow-y: auto; }
    .truncate-lines {
        display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
        overflow: hidden; text-overflow: ellipsis; max-width: 200px;
    }
</style>
JS;
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
			return self::textGroup($model);
		}
        return null;
    }

	private static function textGroup(SalesDocument $model): string
	{
		// Llama a Tools::trans() para obtener el texto del tooltip
		$tooltipText = Tools::trans('click-for-modal'); 

		$html = '<div class="col-sm-auto">'
			. '<div class="mb-2">'
			// El tooltip nativo de Bootstrap sigue funcionando perfectamente
			. '<button class="btn btn-primary" type="button" data-bs-toggle="modal" '
			. 'title="' . htmlspecialchars($tooltipText) . '" ' 
			. 'data-bs-target="#ModalTextGroups">'
			. '<i class="fa-solid fa-spell-check"></i> ' . Tools::trans('texts') .  '</button>'
			. '</div>'
			. '</div>'
			. self::groupsTextModal($model);
			
		return $html;
	}

	private static function groupsTextModal(SalesDocument $model): string
	{
		$html = '<div class="modal fade" id="ModalTextGroups" tabindex="-1" aria-labelledby="ModalTextGroupsLabel" aria-hidden="true">'
						. '<div class="modal-dialog modal-dialog-centered modal-lg">'
						. '<div class="modal-content">'
						. '<div class="modal-header">'
						. '<i class="fa-solid fa-layer-group fa-2x me-2"></i>'
						. '<h5 class="modal-title me-auto">' . Tools::trans('texts') . '</h5>'
						. '</div>'
						. '<div class="modal-body">';
		$html .= '<div class="row mb-3">';
		$html .= '<div class="col-md-6">';
		$html .= '<input type="text" id="searchInputName" onkeyup="filterTextosTable()" placeholder="' . Tools::trans('search-by-name') . '..." class="form-control">';
		$html .= '</div>';
		$html .= '<div class="col-md-6">';
		$html .= '<input type="text" id="searchInputNote" onkeyup="filterTextosTable()" placeholder="' . Tools::trans('search-by-notes') . '..." class="form-control">';
		$html .= '</div>';
		$html .= '</div>';

		$textoModel = new Texto();
		$orderBy = ['nombretexto' => 'ASC']; 
		$allTexts = $textoModel->all([], $orderBy, 0, 0);
		if (count($allTexts) > 0) {
			$html .= '<div class="table-responsive">';
			$html .= '<table class="table table-striped table-hover table-sm" id="textosTable">';
			$html .= '<thead><tr>';
			$html .= '<th>' . Tools::trans('text-name') . '</th>';
			$html .= '<th>' . Tools::trans('notes') . '</th>';
			$html .= '<th>' . Tools::trans('action') . '</th>'; // Columna de Acción
			$html .= '</tr></thead><tbody>';
			
			foreach ($allTexts as $texto) {
				// Asumo que el objeto Texto tiene un método 'url()' como en tu ejemplo antiguo
				$editorUrl = $texto->url(); 

				// Fila de la tabla normal (ya no es clicable entera)
				$html .= '<tr>';
				$html .= '<td>' . htmlspecialchars($texto->nombretexto) . '</td>'; 
				$html .= '<td><div class="truncate-lines">' . htmlspecialchars($texto->note) . '</div></td>';
				
				$noteAttrValue = htmlspecialchars($texto->note, ENT_QUOTES | ENT_HTML5);
				$titleTextCopy = Tools::trans('copy-to-clipboard');
				$titleTextEdit = Tools::trans('edit-text'); // Nueva clave de traducción para "Editar texto"

				// Columna de Acción con el botón de Copiar Y el botón/enlace de Editar
				$html .= "<td>";
				
				// Botón Copiar (usa JS y stopPropagation para no interferir si se añade onclick a la fila en el futuro)
				$html .= "<button type=\"button\" class=\"btn btn-sm btn-light-grey me-1\" onclick=\"event.stopPropagation(); copyToClipboard(this)\" data-note=\"{$noteAttrValue}\" title=\"{$titleTextCopy}\"><i class=\"fas fa-copy\"></i></button>";
				
				// Enlace de Editar (usa <a> como botón de Bootstrap)
				$html .= "<a href=\"{$editorUrl}\" target=\"_blank\" class=\"btn btn-sm btn-light-grey\" title=\"{$titleTextEdit}\">";
				$html .= "<i class=\"fas fa-edit\"></i>"; // Icono de edición (FontAwesome)
				$html .= "</a>";

				$html .= "</td>";
				
				$html .= '</tr>';
			}
			$html .= '</tbody></table></div>';
		} else {
			$html .= '<p>' . Tools::trans('no-texts-found') . '</p>';
		}
		// El resto del modal (footer)
		$html .= '</div>'
						. '</div>'
						. '</div>'
						. '</div>';
		return $html;
	}
}