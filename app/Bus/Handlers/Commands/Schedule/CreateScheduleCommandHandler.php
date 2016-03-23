<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Bus\Handlers\Commands\Schedule;

use CachetHQ\Cachet\Bus\Commands\Schedule\CreateScheduleCommand;
use CachetHQ\Cachet\Bus\Events\Schedule\ScheduleWasCreatedEvent;
use CachetHQ\Cachet\Models\Schedule;

/**
 * This is the create schedule command handler.
 *
 * @author James Brooks <james@alt-three.com>
 */
class CreateScheduleCommandHandler
{
    /**
     * Handle the create schedule command.
     *
     * @param \CachetHQ\Cachet\Bus\Commands\Schedule\CreateScheduleCommand $command
     *
     * @return \CachetHQ\Cachet\Models\Schedule
     */
    public function handle(CreateScheduleCommand $command)
    {
        $schedule = Schedule::create([
            'name'         => $command->name,
            'message'      => $command->message,
            'status'       => $command->status,
            'scheduled_at' => $command->scheduledAt,
        ]);

        event(new ScheduleWasCreatedEvent($schedule));

        return $schedule;
    }
}
