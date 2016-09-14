<?php

namespace Flexplorer;

/**
 * Flexplorer - Odhlašovací stránka.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016 Vitex Software
 */

namespace Flexplorer;

require_once 'includes/Init.php';

unset($_SESSION['user']);
unset($_SESSION['password']);
unset($_SESSION['url']);
unset($_SESSION['company']);


if ($oUser->getUserID()) {
    $oUser->logout();
    $messagesBackup = $oUser->getStatusMessages(true);
    \Ease\Shared::user(new \Ease\Anonym());
    $oUser->addStatusMessages($messagesBackup);
}

$oPage->addItem(new ui\PageTop(_('Sign out')));

$oPage->container->addItem('<br/><br/><br/><br/>');
$oPage->container->addItem(new \Ease\Html\Div(new \Ease\Html\ATag('login.php',
    _('Thank you for your patronage and look forward to another visit'),
    ['class' => 'jumbotron'])));
$oPage->container->addItem('<br/><br/><br/><br/>');

$oPage->addItem(new ui\PageBottom());

$oPage->draw();
