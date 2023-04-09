<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE FUNCTION `current_time_in_timezone`(tz VARCHAR(255))
        RETURNS DATETIME
        DETERMINISTIC
        BEGIN
            DECLARE local_time DATETIME;
            DECLARE valid_timezone INT;
            DECLARE fallback_timezone VARCHAR(255) DEFAULT "UTC";

            SET valid_timezone = (SELECT COUNT(*) FROM mysql.time_zone_name WHERE Name = tz);

            IF valid_timezone = 0 THEN
                SET tz = fallback_timezone;
            END IF;

            SET local_time = CONVERT_TZ(NOW(), "UTC", tz);
            RETURN local_time;
        END;
    ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('current_time_in_timezone_function');
    }
};
