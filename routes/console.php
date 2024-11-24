<?php


use Illuminate\Support\Facades\Schedule;

Schedule::command('app:clear-expired-sales')->daily();
