<?php

declare(strict_types=1);

namespace Vdlp\RedirectConditionsHeader\Tests;

use Illuminate\Http\Request;
use PluginTestCase;
use Vdlp\RedirectConditions\Models\ConditionParameter;
use Vdlp\RedirectConditions\Tests\Factories\RedirectRuleFactory;
use Vdlp\RedirectConditionsHeader\Classes\HeaderCondition;

class HeaderConditionTest extends PluginTestCase
{
    public function testHeaderWithRegex()
    {
        /** @var Request $request */
        $request = resolve(Request::class);
        $request->headers->set('Accept-Language', 'nl-nl,nl;q=0.5');

        /** @var HeaderCondition $condition */
        $condition = resolve(HeaderCondition::class);

        ConditionParameter::create([
            'redirect_id' => 1,
            'condition_code' => $condition->getCode(),
            'is_enabled' => date('Y-m-d H:i:s'),
            'parameters' => [
                'header' => 'Accept-Language',
                'value' => '/(en-US|nl-NL|de-DE)/i',
                'use_regex' => '1',
            ],
        ]);

        $rule = RedirectRuleFactory::testCreateRedirectRule();

        $this->assertTrue($condition->passes($rule, '/from/url'));
    }

    public function testHeaderWithoutRegex()
    {
        /** @var Request $request */
        $request = resolve(Request::class);
        $request->headers->set(
            'User-Agent',
            'Mozilla/5.0 (iPhone; CPU iPhone OS 11_1_2 like Mac OS X)'
        );

        /** @var HeaderCondition $condition */
        $condition = resolve(HeaderCondition::class);

        ConditionParameter::create([
            'redirect_id' => 1,
            'condition_code' => $condition->getCode(),
            'is_enabled' => date('Y-m-d H:i:s'),
            'parameters' => [
                'header' => 'User-Agent',
                'value' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_1_2 like Mac OS X)',
                'use_regex' => '0',
            ],
        ]);

        $rule = RedirectRuleFactory::testCreateRedirectRule();

        $this->assertTrue($condition->passes($rule, '/from/url'));
    }
}
