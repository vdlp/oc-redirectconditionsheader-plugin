<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsHeader;

use System\Classes\PluginBase;
use Vdlp\Redirect\Classes\Contracts\RedirectManagerInterface;
use Vdlp\RedirectConditionsHeader\Classes\HeaderCondition;

class Plugin extends PluginBase
{
    public $require = [
        'Vdlp.Redirect',
        'Vdlp.RedirectConditions',
    ];

    public function pluginDetails(): array
    {
        return [
            'name' => 'Redirect Conditions: Header',
            'description' => 'Adds Header conditions to the Redirect plugin.',
            'author' => 'Van der Let & Partners <octobercms@vdlp.nl>',
            'icon' => 'icon-link',
            'homepage' => 'https://octobercms.com/plugin/vdlp-redirectconditionsheader',
        ];
    }

    public function boot()
    {
        /** @var RedirectManagerInterface $manager */
        $manager = resolve(RedirectManagerInterface::class);
        $manager->addCondition(HeaderCondition::class, 100);
    }
}
