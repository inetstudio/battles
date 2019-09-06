<?php

namespace InetStudio\BattlesPackage\Console\Commands;

use InetStudio\AdminPanel\Base\Console\Commands\BaseSetupCommand;

/**
 * Class SetupCommand.
 */
class SetupCommand extends BaseSetupCommand
{
    /**
     * Имя команды.
     *
     * @var string
     */
    protected $name = 'inetstudio:battles-package:setup';

    /**
     * Описание команды.
     *
     * @var string
     */
    protected $description = 'Setup battles package';

    /**
     * Инициализация команд.
     */
    protected function initCommands(): void
    {
        $this->calls = [
            [
                'type' => 'artisan',
                'description' => 'Battles setup',
                'command' => 'inetstudio:battles-package:battles:setup',
            ],
            [
                'type' => 'artisan',
                'description' => 'Battles votes setup',
                'command' => 'inetstudio:battles-package:votes:setup',
            ],
        ];
    }
}
