<?php
namespace FacturaScripts\Plugins\Textos\Lib;

use FacturaScripts\Core\Tools;
use FacturaScripts\Dinamic\Model\Texto;

class TextosHtmlModal
{
    public static function renderTextGroupModal($model): string
    {
        $tooltipText = Tools::trans('click-for-modal');

        $html = '<div class="col-sm-auto">'
            . '<div class="mb-2">'
            . '<button class="btn btn-primary" type="button" data-bs-toggle="modal" '
            . 'title="' . htmlspecialchars($tooltipText) . '" '
            . 'data-bs-target="#ModalTextGroups">'
            . '<i class="fa-solid fa-spell-check"></i> ' . Tools::trans('texts') . '</button>'
            . '</div>'
            . '</div>'
            . self::groupsTextModal();

        return $html;
    }

    private static function groupsTextModal(): string
    {
        $html = '<div class="modal fade" id="ModalTextGroups" aria-labelledby="ModalTextGroupsLabel" aria-hidden="true">'
            . '<div class="modal-dialog modal-dialog-centered modal-lg">'
            . '<div class="modal-content">'
            . '<div class="modal-header">'
            . '<i class="fa-solid fa-layer-group fa-2x me-2"></i>'
            . '<h5 class="modal-title me-auto">' . Tools::trans('texts') . '</h5>'
            . '<button type="button" class="btn-close" data-bs-dismiss="modal" title="' . Tools::trans('close') . '"></button>'
            . '&nbsp' . Tools::trans('close')
            . '</div>'
            . '<div class="modal-body">';
        
        $html .= '<div class="row mb-3">'
            . '<div class="col-md-6"><input type="text" id="searchInputName" onkeyup="FS_Textos.filterTextosTable()" placeholder="' . Tools::trans('search-by-name') . '..." class="form-control" tabindex="-1"></div>'
            . '<div class="col-md-6"><input type="text" id="searchInputNote" onkeyup="FS_Textos.filterTextosTable()" placeholder="' . Tools::trans('search-by-notes') . '..." class="form-control" tabindex="-1"></div>'
            . '</div>';

        $textoModel = new Texto();
        $allTexts = $textoModel->all([], ['nombretexto' => 'ASC'], 0, 0);
        
        if (count($allTexts) > 0) {
            $html .= '<div class="table-responsive"><table class="table table-striped table-hover table-sm" id="textosTable"><thead><tr>'
                . '<th>' . Tools::trans('text-name') . '</th>'
                . '<th>' . Tools::trans('notes') . '</th>'
                . '<th>' . Tools::trans('action') . '</th>'
                . '</tr></thead><tbody>';

            foreach ($allTexts as $texto) {
                $noteAttrValue = htmlspecialchars($texto->note, ENT_QUOTES | ENT_HTML5);
                $html .= '<tr>'
                    . '<td>' . htmlspecialchars($texto->nombretexto) . '</td>'
                    . '<td><div class="truncate-lines">' . htmlspecialchars($texto->note) . '</div></td>'
                    . '<td>'
                    . '<button type="button" class="btn btn-sm btn-light-grey me-1" onclick="event.stopPropagation(); FS_Textos.copyToClipboard(this)" data-note="' . $noteAttrValue . '" title="' . Tools::trans('copy-to-clipboard') . '" tabindex="-1"><i class="fas fa-copy"></i></button>'
                    . '<a href="' . $texto->url() . '" target="_blank" class="btn btn-sm btn-light-grey" title="' . Tools::trans('edit-text') . '" tabindex="-1"><i class="fas fa-edit"></i></a>'
                    . '</td></tr>';
            }
            $html .= '</tbody></table></div>';
        } else {
            $html .= '<p>' . Tools::trans('no-texts-found') . '</p>';
        }

        return $html . '</div></div></div></div>';
    }
}
