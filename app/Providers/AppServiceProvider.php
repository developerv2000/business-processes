<?php

namespace App\Providers;

use App\Models\Blacklist;
use App\Models\Country;
use App\Models\CountryCode;
use App\Models\Currency;
use App\Models\ExpirationDate;
use App\Models\Generic;
use App\Models\KvppPriority;
use App\Models\KvppSource;
use App\Models\KvppStatus;
use App\Models\Manufacturer;
use App\Models\ManufacturerCategory;
use App\Models\Meeting;
use App\Models\Mnn;
use App\Models\PortfolioManager;
use App\Models\Process;
use App\Models\ProcessOwner;
use App\Models\ProcessStatus;
use App\Models\ProductCategory;
use App\Models\ProductForm;
use App\Models\PromoCompany;
use App\Models\Role;
use App\Models\User;
use App\Models\Zone;
use Carbon\Carbon;
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
                'manufacturers' => Manufacturer::getAllMinifed(),
                'categories' => ManufacturerCategory::getAll(),
                'bdmUsers' => User::getBdmsMinifed(),
                'analystUsers' => User::getAnalystsMinified(),
                'countries' => Country::getAll(),
                'zones' => Zone::getAll(),
                'productCategories' => ProductCategory::getAll(),
                'blacklists' => Blacklist::getAll(),
                'statusOptions' => Manufacturer::getStatusOptions(),
            ]);
        });

        // Generics
        View::composer(['filters.generics', 'generics.create', 'generics.edit'], function ($view) {
            $view->with([
                'manufacturers' => Manufacturer::getAllMinifed(),
                'analystUsers' => User::getAnalystsMinified(),
                'bdmUsers' => User::getBdmsMinifed(),
                'categories' => ProductCategory::getAll(),
                'productForms' => ProductForm::getAll(),
                'expirationDates' => ExpirationDate::getAll(),
                'zones' => Zone::getAll(),
                'mnns' => Mnn::getAll(),
                'countries' => Country::getAll(),
                'manufacturerCategories' => ManufacturerCategory::getAll(),
            ]);
        });

        // Processes
        View::composer('filters.processes', function ($view) {
            $view->with([
                'countryCodes' => CountryCode::getAll(),
                'statuses' => ProcessStatus::getAllChilds(),
                'manufacturers' => Manufacturer::getAllMinifed(),
                'analystUsers' => User::getAnalystsMinified(),
                'bdmUsers' => User::getBdmsMinifed(),
                'productCategories' => ProductCategory::getAll(),
                'productForms' => ProductForm::getAll(),
                'mnns' => Mnn::getAll(),
                'owners' => ProcessOwner::getAll(),
                'countries' => Country::getAll(),
                'promoCompanies' => PromoCompany::getAll(),
                'manufacturerCategories' => ManufacturerCategory::getAll(),
            ]);
        });

        View::composer(['processes.create.index', 'processes.edit.index'], function ($view) {
            $view->with([
                'countries' => Country::getAll(),
                'countryCodes' => CountryCode::getAll(),
                'statuses' => ProcessStatus::getAllChilds(),
                'owners' => ProcessOwner::getAll(),
            ]);
        });

        // Shared via ViewComposer because views are also returned via ajax
        View::composer(['processes.create.stage-inputs', 'processes.edit.stage-inputs'], function ($view) {
            $view->with([
                'countries' => Country::getAll(),
                'expirationDates' => ExpirationDate::getAll(),
                'currencies' => Currency::getAll(),
                'promoCompanies' => PromoCompany::getAll(),
            ]);
        });

        // KVPP
        View::composer(['filters.kvpp', 'kvpp.create', 'kvpp.edit'], function ($view) {
            $view->with([
                'statuses' => KvppStatus::getAll(),
                'countryCodes' => CountryCode::getAll(),
                'priorities' => KvppPriority::getAll(),
                'sources' => KvppSource::getAll(),
                'mnns' => Mnn::getAll(),
                'forms' => ProductForm::getAll(),
                'promoCompanies' => PromoCompany::getAll(),
                'portfolioManagers' => PortfolioManager::getAll(),
            ]);
        });

        // Meetings
        View::composer(['filters.meetings', 'meetings.create', 'meetings.edit'], function ($view) {
            $view->with([
                'availableYears' => Meeting::getAvailableYears(),
                'analystUsers' => User::getAnalystsMinified(),
                'bdmUsers' => User::getBdmsMinifed(),
                'manufacturers' => Manufacturer::getAllMinifed(),
                'countries' => Country::getAll(),
            ]);
        });

        // Users
        View::composer(['users.create', 'users.edit'], function ($view) {
            $view->with([
                'roles' => Role::getAll(),
            ]);
        });

        // Temporary statistics
        View::composer('layouts.leftbar', function ($view) {
            $today = today();
            $analysts = User::getAnalystsMinified();

            $analysts->each(function ($analyst) use ($today) {
                $analyst->today_created_epps = Manufacturer::whereDate('created_at', $today)
                    ->where('analyst_user_id', $analyst->id)
                    ->count();

                $analyst->today_created_ivps = Generic::whereDate('created_at', $today)
                    ->whereHas('manufacturer', function ($manufacturer) use ($analyst) {
                        $manufacturer->where('analyst_user_id', $analyst->id);
                    })
                    ->count();

                $analyst->today_created_vpses = Process::whereDate('created_at', $today)
                    ->whereHas('manufacturer', function ($manufacturer) use ($analyst) {
                        $manufacturer->where('analyst_user_id', $analyst->id);
                    })
                    ->count();

                $tomorrow = Carbon::tomorrow();
                $formattedTomorrow = $tomorrow->format('d/m/Y');
                $urlFilterParams = '?created_at=' . date('d/m/Y - ') . $formattedTomorrow . '&analyst_user_id=' . $analyst->id;

                $analyst->statistics_epp_link = route('manufacturers.index') . $urlFilterParams;
                $analyst->statistics_ivp_link = route('generics.index') . $urlFilterParams;
                $analyst->statistics_vps_link = route('processes.index') . $urlFilterParams;
            });

            $view->with([
                'analysts' => $analysts,
            ]);
        });
    }
}
