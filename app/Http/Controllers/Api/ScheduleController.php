<?php

/*
 * This file is part of Cachet.
 *
 * (c) Alt Three Services Limited
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace CachetHQ\Cachet\Http\Controllers\Api;

use CachetHQ\Cachet\Bus\Commands\Schedule\CreateScheduleCommand;
use CachetHQ\Cachet\Bus\Commands\Schedule\DeleteScheduleCommand;
use CachetHQ\Cachet\Bus\Commands\Schedule\UpdateScheduleCommand;
use CachetHQ\Cachet\Models\Schedule;
use GrahamCampbell\Binput\Facades\Binput;
use Illuminate\Support\Facades\Request;

/**
 * This is the schedule controller.
 *
 * @author James Brooks <james@alt-three.com>
 */
class ScheduleController extends AbstractApiController
{
    /**
     * Return all schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchedules()
    {
        $schedule = Schedule::whereRaw('1 = 1');

        if ($sortBy = Binput::get('sort')) {
            $direction = Binput::has('order') && Binput::get('order') == 'desc';

            $schedule->sort($sortBy, $direction);
        }

        $schedule = $schedule->paginate(Binput::get('per_page', 20));

        return $this->paginator($schedule, Request::instance());
    }

    /**
     * Return a single schedule.
     *
     * @param \CachetHQ\Cachet\Models\Schedule $schedule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSchedule(Schedule $schedule)
    {
        return $this->item($schedule);
    }

    /**
     * Create a new schedule.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postSchedule()
    {
        //
    }

    /**
     * Update a schedule.
     *
     * @param \CachetHQ\Cachet\Models\Schedule $schedule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function putSchedule(Schedule $schedule)
    {
        //
    }

    /**
     * Delete a schedule.
     *
     * @param \CachetHQ\Cachet\Models\Schedule $schedule
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteSchedule(Schedule $schedule)
    {
        //
    }
}
