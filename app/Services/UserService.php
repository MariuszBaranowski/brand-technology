<?php

namespace App\Services;

use App\Models\Estate;
use App\Models\UsersShift;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class UserService implements Contracts\UserService
{
    public function checkUserShifts(): void
    {
        foreach (UsersShift::with(['user', 'substitute'])->get() as $shift) {
            /** @var $shift UsersShift */
            $shiftPeriod = CarbonPeriod::create($shift->date_from, $shift->date_to);

            if ($this->userAtHoliday($shiftPeriod, $shift)) {
                $this->setSubstituteUserAtEstates($shift);

            } elseif ($this->userBackFromHoliday($shiftPeriod, $shift)) {
                $this->backAssigmentUserAtEstates($shift);
            }
        }
    }

    private function userAtHoliday(CarbonPeriod $shiftPeriod, UsersShift $shift): bool
    {
        return $shiftPeriod->isStarted()
            && !$shiftPeriod->isEnded()
            && ($shift->temp_changes?->isEmpty() || empty($shift->temp_changes));
    }

    private function userBackFromHoliday(CarbonPeriod $shiftPeriod, UsersShift $shift): bool
    {
        return $shiftPeriod->isStarted()
            && $shiftPeriod->isEnded()
            && !$shift->temp_changes?->isEmpty();
    }

    private function setSubstituteUserAtEstates(UsersShift $shift): bool
    {
        $collection = new Collection();
        /** @var $estate Estate */
        foreach ($shift->user->estates as $estate) {
            $collection->add($estate->getKey());
            $estate->supervisor_user_id = $shift->substitute->getKey();
            $estate->save();
        }

        $shift->temp_changes = $collection;
        return $shift->save();
    }

    private function backAssigmentUserAtEstates(UsersShift $shift): bool
    {
        $estates = Estate::query()
            ->whereIn('id', $shift->temp_changes)
            ->get();

        foreach ($estates as $estate) {
            $estate->supervisor_user_id = $shift->user->getKey();
            $estate->save();
        }

        $shift->temp_changes = new Collection();
        return $shift->save();
    }
}
