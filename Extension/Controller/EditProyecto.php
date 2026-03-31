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
use FacturaScripts\Dinamic\Lib\TextosHtmlModal;

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

            // Usamos el método de la librería común
            $modalHtml = TextosHtmlModal::groupsTextModal();
            $encodedModalHtml = json_encode($modalHtml);

            // Inyectamos el modal vía JS
            $script = "document.addEventListener('DOMContentLoaded', function() {
                var div = document.createElement('div');
                div.innerHTML = $encodedModalHtml;
                document.body.appendChild(div.firstChild);
            });";

            AssetManager::addJs('data:text/javascript;base64,' . base64_encode($script));
        };
    }
}