<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Traits\ApiResponser;
use Exception;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class ApiController extends BaseController
{
    use ApiResponser;

    public function __construct()
    {
    }

    /**
     * Healthcheck
     *
     * Check that the service is up. If everything is okay, you'll get a 200 OK response.
     *
     * Otherwise, the request will fail with a 400 error, and a response listing the failed services.
     *
     * @response 400 scenario="Service is unhealthy" {"status": "down", "services": {"database": "up", "redis": "down"}}
     *
     * @responseField status The status of this API (`up` or `down`).
     * @responseField services Map of each downstream service and their status (`up` or `down`).
     */
    public function health()
    {
        // Test database connection
        try {
            if (DB::connection()->getPdo()) {
                return $this->showMessage(['meesage' => 'Health ms_posts check ok'], 200);
            } else {
                return $this->errorResponse(['message' => 'Health check ko db'], 520);
            }
        } catch (Exception $e) {
            return $this->errorResponse(['message' => 'Health check ko: '.$e], 525);
        }
    }
}
