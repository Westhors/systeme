<?php

namespace App\Providers;

use App\Interfaces\AdminRepositoryInterface;
use App\Interfaces\AttendanceRepositoryInterface;
use App\Interfaces\BranchRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ColorRepositoryInterface;
use App\Interfaces\CurrencyRepositoryInterface;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\DeleveryManRepositoryInterface;
use App\Interfaces\EmployeeRepositoryInterface;
use App\Interfaces\InventoryRepositoryInterface;
use App\Interfaces\LoyaltySettingRepositoryInterface;
use App\Interfaces\OfferRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Interfaces\SalesRepresentativeRepositoryInterface;
use App\Interfaces\TaxRepositoryInterface;
use App\Interfaces\UnitRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\WarehouseRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\AttendanceRepository;
use App\Repositories\BranchRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\ColorRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\DeleveryManRepository;
use App\Repositories\EmployeeRepository;
use App\Repositories\InventoryRepository;
use App\Repositories\LoyaltySettingRepository;
use App\Repositories\OfferRepository;
use App\Repositories\ProductRepository;
use App\Repositories\SalesRepresentativeRepository;
use App\Repositories\TaxRepository;
use App\Repositories\UnitRepository;
use App\Repositories\UserRepository;
use App\Repositories\WarehouseRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(BranchRepositoryInterface::class, BranchRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(WarehouseRepositoryInterface::class, WarehouseRepository::class);
        $this->app->bind(UnitRepositoryInterface::class, UnitRepository::class);
        $this->app->bind(ColorRepositoryInterface::class, ColorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OfferRepositoryInterface::class, OfferRepository::class);
        $this->app->bind(InventoryRepositoryInterface::class, InventoryRepository::class);
        $this->app->bind(CustomerRepositoryInterface::class, CustomerRepository::class);
        $this->app->bind(EmployeeRepositoryInterface::class, EmployeeRepository::class);
        $this->app->bind(SalesRepresentativeRepositoryInterface::class, SalesRepresentativeRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(DeleveryManRepositoryInterface::class, DeleveryManRepository::class);
        $this->app->bind(LoyaltySettingRepositoryInterface::class, LoyaltySettingRepository::class);
        $this->app->bind(TaxRepositoryInterface::class, TaxRepository::class);
        $this->app->bind(CurrencyRepositoryInterface::class, CurrencyRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

