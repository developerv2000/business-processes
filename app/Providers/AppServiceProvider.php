<?php

namespace App\Providers;

use App\Models\Blacklist;
use App\Models\Country;
use App\Models\ExpirationDate;
use App\Models\Manufacturer;
use App\Models\ManufacturerCategory;
use App\Models\Meeting;
use App\Models\Mnn;
use App\Models\ProductCategory;
use App\Models\ProductForm;
use App\Models\Role;
use App\Models\User;
use App\Models\Zone;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Manufacturers
        View::composer(['filters.manufacturers', 'manufacturers.create', 'manufacturers.edit'], function ($view) {
            $view->with([
                'categories' => ManufacturerCategory::getAll(),
                'bdmUsers' => User::getBdmsMinifed(),
                'analystUsers' => User::getAnalystsMinified(),
                'countries' => Country::getAll(),
                'zones' => Zone::getAll(),
            ])
                ->with([
                    'productCategories' => ProductCategory::getAll(),
                    'blacklists' => Blacklist::getAll(),
                    'statusOptions' => Manufacturer::getStatusOptions(),
                ]);
        });

        // Meetings
        View::composer(['filters.meetings', 'meetings.create', 'meetings.edit'], function ($view) {
            $view->with([
                'availableYears' => Meeting::getAvailableYears(),
                'analystUsers' => User::getAnalystsMinified(),
                'bdmUsers' => User::getBdmsMinifed(),
                'manufacturers' => Manufacturer::getAllUMinifed(),
                'countries' => Country::getAll(),
            ]);
        });

        // Generics
        View::composer(['filters.generics', 'generics.create', 'generics.edit'], function ($view) {
            $view->with([
                'manufacturers' => Manufacturer::getAllUMinifed(),
                'analystUsers' => User::getAnalystsMinified(),
                'bdmUsers' => User::getBdmsMinifed(),
                'categories' => ProductCategory::getAll(),
                'productForms' => ProductForm::getAll(),
                'expirationDates' => ExpirationDate::getAll(),
                'zones' => Zone::getAll(),
                'mnns' => Mnn::getAll(),
            ]);
        });

        // Users
        View::composer(['users.create', 'users.edit'], function ($view) {
            $view->with([
                'roles' => Role::getAll(),
            ]);
        });
    }
}
