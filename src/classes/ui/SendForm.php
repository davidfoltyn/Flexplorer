<?php
/**
 * Flexplorer - formulář pro odeslání požadavku.
 *
 * @author     Vítězslav Dvořák <vitex@arachne.cz>
 * @copyright  2016 Vitex Software
 */

namespace Flexplorer\ui;

/**
 * Description of SendForm
 *
 * @author vitex
 */
class SendForm extends \Ease\TWB\Form
{

    /**
     * Formulář pro odeslání uživatelského požadavku
     *
     * @param string $url
     * @param string $method
     * @param string $body
     */
    public function __construct($url, $method = 'GET', $body = '')
    {
        parent::__construct('Req', 'query.php');

        $this->addInput(new \Ease\Html\InputTextTag('url', $url), _('URL'),
            $url,
            new \Ease\Html\ATag('https://www.flexibee.eu/api/dokumentace/ref/urls',
            _('URL Compositon')));
        $this->addInput(new JsonTextarea('body', $body,
            ['id' => 'editor', 'class' => 'animated']), _('Query body'));
        $this->addInput(new \Ease\Html\Select('method',
            ['GET' => 'GET', 'POST' => 'POST', 'PUT' => 'PUT', 'PATCH' => 'PATCH',
            'DELETE' => 'DELETE'], $method), _('Method'), null,
            new \Ease\Html\ATag('https://www.flexibee.eu/api/dokumentace/ref/http-operations',
            _('Supported HTTP Operations')));
        $this->addItem(new \Ease\TWB\SubmitButton(_('Send'), 'success'));
    }
}