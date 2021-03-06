<?php
/**
 * Flexplorer - Hlavní strana.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016-2017 Vitex Software
 */

namespace Flexplorer;

require_once 'includes/Init.php';

$delete = $oPage->getRequestValue('delete');

$oPage->onlyForLogged();

$chages = [];

$d     = dir(sys_get_temp_dir());
while (false !== ($entry = $d->read())) {
    if (strstr($entry, 'flexplorer-change')) {
        if ($delete === 'all') {
            unlink(sys_get_temp_dir().'/'.$entry);
        } else {
            $chages[] = $entry;
        }
    }
}
$d->close();


$oPage->addItem(new ui\PageTop(_('FlexiBee WebHook income')));

$oPage->container->addItem(new ui\ChangesLister($chages));

if (count($chages)) {
    $oPage->container->addItem(new \Ease\TWB\LinkButton('?delete=all',
        _('Delete All'), 'danger'));
} else {

    $webHookUrl = str_replace(basename(__FILE__), 'webhook.php',
        \Ease\Page::phpSelf());

    $oPage->container->addItem(new \Ease\TWB\LinkButton("changesapi.php?hookurl=".urlencode($webHookUrl),
        _('Target to FlexPlorer'), 'success', ['class' => 'button button-xs']));


    $oPage->addStatusMessage('WebHook not triggered yet');
}
$oPage->addItem(new ui\PageBottom());

$oPage->draw();
