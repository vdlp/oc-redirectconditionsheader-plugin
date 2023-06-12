<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsHeader;

use System\Classes\PluginBase;
use Vdlp\Redirect\Classes\Contracts\RedirectManagerInterface;
use Vdlp\RedirectConditionsHeader\Classes\HeaderCondition;

final class Plugin extends PluginBase
{
    /**
     * @inheritdoc
     */
    public $require = [
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

    public function boot(): void
    {
        /** @var RedirectManagerInterface $manager */
        $manager = resolve(RedirectManagerInterface::class);
        $manager->addCondition(HeaderCondition::class, 100);
    }
}
