<?php
/**
 * This file is part of the AdmReportico plugin, with the Reportico engine, for FacturaScripts
 * Copyright (C) 2020 Carlos Garcia Gomez <carlos@facturascripts.com>
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
namespace FacturaScripts\Plugins\Textos;

use FacturaScripts\Core\Base\AjaxForms\PurchasesHeaderHTML;
use FacturaScripts\Core\Base\AjaxForms\SalesHeaderHTML;
use FacturaScripts\Core\Base\DataBase;
use FacturaScripts\Core\Template\InitClass;

/**
 * Description of Init of Textos
 *
 * @author Jorge-Prebac <info@prebac.com>
 */
final class Init extends InitClass
{

    public function init(): void
    {
		PurchasesHeaderHTML::addMod(new Mod\PurchasesHeaderHTMLModTextos());
		SalesHeaderHTML::addMod(new Mod\SalesHeaderHTMLModTextos());
    }
	
    public function uninstall(): void
    {
    }

	public function update(): void
    {
    }
}
