<?php

namespace App\Events;

use App\Entities\Company;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class CompanyCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Company Eloquent model instance.
     *
     * @var Company
     **/
    public $company;

    /**
     * Create a new event instance.
     */
    public function __construct(Company $company)
    {
        $this->company = $company;
    }
}
