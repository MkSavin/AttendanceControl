<?php

namespace Tests\Unit;

use App\Models\Session;
use Tests\TestCase;

class SessionTest extends TestCase
{
    public function test_time_left_is_rounded_to_two_parts(): void
    {
        $session = new Session();
        $session->activetime = ((2 * 4 * 7) + (3 * 7) + 5) * 86400;
        $session->active_at = now()->addHour();

        $this->assertSame('2 мес. 4 нед.', $session->timeLeft);
    }
}
