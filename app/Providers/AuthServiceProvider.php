<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\UserPolicy;
use App\Policies\ItemPolicy;
use App\Policies\BuyItemPolicy;
use App\Policies\ItemTagPolicy;
use App\Models\User;
use App\Models\Item;
use App\Models\BuyItem;
use App\Models\ItemTag;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Item::class => ItemPolicy::class,
        BuyItem::class => BuyItemPolicy::class,
        ItemTag::class => ItemTagPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
